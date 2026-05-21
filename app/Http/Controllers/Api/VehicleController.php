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
        $query = Vehicle::with(['location:id,name'])
            ->withExists(['rentals as is_rented' => function($q) {
                $q->where('status', 'active')->orWhere('status', 'booked');
            }])
            ->withExists(['orders as is_ordered' => function($q) {
                $q->where('status', 'active');
            }]);

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->where('location_id', $user->location_id);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $status = $request->status;
            if ($status === 'rented' || $status === 'booked') {
                $query->where(function($q) {
                    $q->whereHas('rentals', function($r) {
                        $r->where('status', 'active')->orWhere('status', 'booked');
                    })
                    ->orWhereHas('orders', function($o) {
                        $o->where('status', 'active');
                    });
                });
            } elseif ($status === 'available') {
                $query->whereDoesntHave('rentals', function($r) {
                        $r->where('status', 'active')->orWhere('status', 'booked');
                    })
                    ->whereDoesntHave('orders', function($o) {
                        $o->where('status', 'active');
                    })
                    ->where('status', '!=', 'maintenance');
            } else {
                $query->where('status', $status);
            }
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
                    'status' => ($vehicle->is_rented || $vehicle->is_ordered) ? 'rented' : ($vehicle->is_active ? 'available' : 'inactive'),
                    'daily_rate' => (float) $vehicle->daily_rental_rate,
                    'monthly_rate' => (float) $vehicle->monthly_rental_rate,
                    'location' => $vehicle->location ? [
                        'id' => $vehicle->location->id,
                        'name' => $vehicle->location->name,
                    ] : null,
                    'transmission' => $vehicle->transmission,
                    'odometer' => $vehicle->odometer,
                    'vehicle_type' => $vehicle->vehicle_type,
                    'engine_type' => $vehicle->engine_type,
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
        $vehicle = Vehicle::with(['location:id,name'])
            ->withExists(['rentals as is_rented' => function($q) {
                $q->where('status', 'active')->orWhere('status', 'booked');
            }])
            ->withExists(['orders as is_ordered' => function($q) {
                $q->where('status', 'active');
            }])
            ->find($id);

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
                'status' => ($vehicle->is_rented || $vehicle->is_ordered) ? 'rented' : ($vehicle->is_active ? 'available' : 'inactive'),
                'daily_rate' => (float) $vehicle->daily_rate,
                'monthly_rate' => (float) $vehicle->monthly_rate,
                'location' => $vehicle->location ? [
                    'id' => $vehicle->location->id,
                    'name' => $vehicle->location->name,
                ] : null,
                'transmission' => $vehicle->transmission,
                'odometer' => $vehicle->odometer,
                'vehicle_type' => $vehicle->vehicle_type,
                'engine_type' => $vehicle->engine_type,
                'chassis_number' => $vehicle->chassis_number,
                'engine_number' => $vehicle->engine_number,
                'stnk_number' => $vehicle->stnk_number,
                'stnk_expiry_date' => $vehicle->stnk_expiry_date ? $vehicle->stnk_expiry_date->format('Y-m-d') : null,
                'kir_expiry_date' => $vehicle->kir_expiry_date ? $vehicle->kir_expiry_date->format('Y-m-d') : null,
                'gps_expiry_date' => $vehicle->gps_expiry_date ? $vehicle->gps_expiry_date->format('Y-m-d') : null,
                'notes' => $vehicle->notes,
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
