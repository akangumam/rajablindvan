<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Get all rentals (with location filter)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Rental::with(['vehicle:id,brand,model,license_plate', 'customer:id,name,phone']);

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by location (for admin)
        if ($request->has('location_id') && $user->isAdmin()) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('location_id', $request->location_id);
            });
        }

        $rentals = $query->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => collect($rentals->items())->map(function ($rental) {
                return [
                    'id' => $rental->id,
                    'vehicle' => [
                        'brand' => $rental->vehicle->brand,
                        'model' => $rental->vehicle->model,
                        'license_plate' => $rental->vehicle->license_plate,
                    ],
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
                    'is_overdue' => $rental->end_date->isPast() && in_array($rental->status, ['active', 'ongoing']),
                    'created_at' => $rental->created_at->diffForHumans(),
                ];
            }),
            'meta' => [
                'current_page' => $rentals->currentPage(),
                'last_page' => $rentals->lastPage(),
                'per_page' => $rentals->perPage(),
                'total' => $rentals->total(),
            ],
        ], 200);
    }

    /**
     * Get active rentals only
     */
    public function active(Request $request)
    {
        $user = $request->user();
        $query = Rental::with(['vehicle:id,brand,model,license_plate', 'customer:id,name,phone'])
            ->whereIn('status', ['active', 'ongoing']);

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        $rentals = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $rentals->map(function ($rental) {
                return [
                    'id' => $rental->id,
                    'vehicle' => [
                        'brand' => $rental->vehicle->brand,
                        'model' => $rental->vehicle->model,
                        'license_plate' => $rental->vehicle->license_plate,
                    ],
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
                    'days_remaining' => $rental->end_date->diffInDays(now(), false),
                    'is_overdue' => $rental->end_date->isPast(),
                    'created_at' => $rental->created_at->diffForHumans(),
                ];
            }),
        ], 200);
    }

    /**
     * Get single rental details
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $rental = Rental::with(['vehicle.location', 'customer'])->find($id);

        if (!$rental) {
            return response()->json([
                'success' => false,
                'message' => 'Rental not found',
            ], 404);
        }

        // Check location access
        if (!$user->isAdmin() && $rental->vehicle->location_id != $user->location_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this rental',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $rental->id,
                'vehicle' => [
                    'id' => $rental->vehicle->id,
                    'brand' => $rental->vehicle->brand,
                    'model' => $rental->vehicle->model,
                    'license_plate' => $rental->vehicle->license_plate,
                    'color' => $rental->vehicle->color,
                    'location' => $rental->vehicle->location ? $rental->vehicle->location->name : null,
                ],
                'customer' => [
                    'id' => $rental->customer->id,
                    'name' => $rental->customer->name,
                    'phone' => $rental->customer->phone,
                    'email' => $rental->customer->email,
                    'address' => $rental->customer->address,
                ],
                'start_date' => $rental->start_date->format('Y-m-d H:i'),
                'end_date' => $rental->end_date->format('Y-m-d H:i'),
                'status' => $rental->status,
                'rental_type' => $rental->rental_type,
                'total_days' => $rental->total_days,
                'rate' => (float) $rental->rate,
                'total_price' => (float) $rental->total_price,
                'deposit' => (float) $rental->deposit,
                'pickup_location' => $rental->pickup_location,
                'dropoff_location' => $rental->dropoff_location,
                'notes' => $rental->notes,
                'is_overdue' => $rental->end_date->isPast() && in_array($rental->status, ['active', 'ongoing']),
                'days_remaining' => $rental->end_date->diffInDays(now(), false),
                'created_at' => $rental->created_at->toIso8601String(),
                'updated_at' => $rental->updated_at->toIso8601String(),
            ],
        ], 200);
    }
}
