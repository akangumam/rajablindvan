<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Get all vehicles (with location filter for non-admin)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Vehicle::with(['location:id,name']);

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->where('location_id', $user->location_id);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by location if provided (for admin)
        if ($request->has('location_id') && $user->isAdmin()) {
            $query->where('location_id', $request->location_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('license_plate', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $vehicles = $query->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $vehicles->map(function ($vehicle) {
                return [
                    'id' => $vehicle->id,
                    'brand' => $vehicle->brand,
                    'model' => $vehicle->model,
                    'license_plate' => $vehicle->license_plate,
                    'year' => $vehicle->year,
                    'color' => $vehicle->color,
                    'status' => $vehicle->status,
                    'capacity' => $vehicle->capacity,
                    'daily_rate' => (float) $vehicle->daily_rate,
                    'hourly_rate' => (float) $vehicle->hourly_rate,
                    'location' => $vehicle->location ? [
                        'id' => $vehicle->location->id,
                        'name' => $vehicle->location->name,
                    ] : null,
                    'fuel_type' => $vehicle->fuel_type,
                    'transmission' => $vehicle->transmission,
                    'odometer' => $vehicle->odometer,
                    'last_maintenance' => $vehicle->last_maintenance?->format('Y-m-d'),
                    'next_maintenance' => $vehicle->next_maintenance?->format('Y-m-d'),
                    'image_url' => $vehicle->image ? asset('storage/' . $vehicle->image) : null,
                ];
            }),
            'meta' => [
                'current_page' => $vehicles->currentPage(),
                'last_page' => $vehicles->lastPage(),
                'per_page' => $vehicles->perPage(),
                'total' => $vehicles->total(),
            ],
        ], 200);
    }

    /**
     * Get single vehicle details
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $vehicle = Vehicle::with(['location:id,name'])->find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found',
            ], 404);
        }

        // Check location access
        if (!$user->isAdmin() && $vehicle->location_id != $user->location_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this vehicle',
            ], 403);
        }

        // Get vehicle statistics
        $totalRentals = $vehicle->rentals()->count();
        $activeRentals = $vehicle->rentals()->whereIn('status', ['active', 'ongoing'])->count();
        $totalRevenue = $vehicle->rentals()->where('status', 'completed')->sum('total_price');
        $totalMaintenance = $vehicle->maintenances()->sum('cost');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $vehicle->id,
                'brand' => $vehicle->brand,
                'model' => $vehicle->model,
                'license_plate' => $vehicle->license_plate,
                'year' => $vehicle->year,
                'color' => $vehicle->color,
                'status' => $vehicle->status,
                'capacity' => $vehicle->capacity,
                'daily_rate' => (float) $vehicle->daily_rate,
                'hourly_rate' => (float) $vehicle->hourly_rate,
                'location' => $vehicle->location ? [
                    'id' => $vehicle->location->id,
                    'name' => $vehicle->location->name,
                ] : null,
                'fuel_type' => $vehicle->fuel_type,
                'transmission' => $vehicle->transmission,
                'odometer' => $vehicle->odometer,
                'last_maintenance' => $vehicle->last_maintenance?->format('Y-m-d'),
                'next_maintenance' => $vehicle->next_maintenance?->format('Y-m-d'),
                'insurance_expiry' => $vehicle->insurance_expiry?->format('Y-m-d'),
                'registration_expiry' => $vehicle->registration_expiry?->format('Y-m-d'),
                'image_url' => $vehicle->image ? asset('storage/' . $vehicle->image) : null,
                'description' => $vehicle->description,
                'features' => $vehicle->features,
                'statistics' => [
                    'total_rentals' => $totalRentals,
                    'active_rentals' => $activeRentals,
                    'total_revenue' => (float) $totalRevenue,
                    'total_maintenance_cost' => (float) $totalMaintenance,
                ],
                'created_at' => $vehicle->created_at->toIso8601String(),
                'updated_at' => $vehicle->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * Get vehicle rental history
     */
    public function rentals(Request $request, $id)
    {
        $user = $request->user();
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found',
            ], 404);
        }

        // Check location access
        if (!$user->isAdmin() && $vehicle->location_id != $user->location_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this vehicle',
            ], 403);
        }

        $rentals = $vehicle->rentals()
            ->with('customer:id,name,phone')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $rentals->map(function ($rental) {
                return [
                    'id' => $rental->id,
                    'customer' => [
                        'name' => $rental->customer->name,
                        'phone' => $rental->customer->phone,
                    ],
                    'start_date' => $rental->start_date->format('Y-m-d H:i'),
                    'end_date' => $rental->end_date->format('Y-m-d H:i'),
                    'status' => $rental->status,
                    'rental_type' => $rental->rental_type,
                    'total_days' => $rental->total_days,
                    'total_price' => (float) $rental->total_price,
                    'created_at' => $rental->created_at->diffForHumans(),
                ];
            }),
            'meta' => [
                'current_page' => $rentals->currentPage(),
                'last_page' => $rentals->lastPage(),
                'total' => $rentals->total(),
            ],
        ], 200);
    }

    /**
     * Get vehicle maintenance history
     */
    public function maintenances(Request $request, $id)
    {
        $user = $request->user();
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found',
            ], 404);
        }

        // Check location access
        if (!$user->isAdmin() && $vehicle->location_id != $user->location_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this vehicle',
            ], 403);
        }

        $maintenances = $vehicle->maintenances()
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $maintenances->map(function ($maintenance) {
                return [
                    'id' => $maintenance->id,
                    'type' => $maintenance->type,
                    'description' => $maintenance->description,
                    'cost' => (float) $maintenance->cost,
                    'date' => $maintenance->date?->format('Y-m-d'),
                    'due_date' => $maintenance->due_date?->format('Y-m-d'),
                    'status' => $maintenance->status,
                    'odometer_reading' => $maintenance->odometer_reading,
                    'service_provider' => $maintenance->service_provider,
                    'created_at' => $maintenance->created_at->diffForHumans(),
                ];
            }),
            'meta' => [
                'current_page' => $maintenances->currentPage(),
                'last_page' => $maintenances->lastPage(),
                'total' => $maintenances->total(),
            ],
        ], 200);
    }
}
