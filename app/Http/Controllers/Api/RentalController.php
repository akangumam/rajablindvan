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
        $query = \App\Models\Order::with(['vehicle:id,brand,model,license_plate', 'customer:id,name,phone']);

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $statusStr = $request->status;
            if ($statusStr === 'aktif' || $statusStr === 'active') {
                $query->where('status', 'Active');
            } elseif ($statusStr === 'selesai' || $statusStr === 'completed') {
                $query->where('status', 'Inactive');
            } else {
                $query->where('status', $statusStr);
            }
        }

        // Filter by location (for admin)
        if ($request->has('location_id') && $user->isAdmin()) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('location_id', $request->location_id);
            });
        }

        $orders = $query->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => collect($orders->items())->map(function ($order) {
                return [
                    'id' => $order->id,
                    'vehicle' => [
                        'brand' => $order->vehicle->brand,
                        'model' => $order->vehicle->model,
                        'license_plate' => $order->vehicle->license_plate,
                    ],
                    'customer' => [
                        'name' => $order->customer->name,
                        'phone' => $order->customer->phone ?? '-',
                    ],
                    'start_date' => $order->start_date->format('Y-m-d H:i'),
                    'end_date' => $order->end_date->format('Y-m-d H:i'),
                    'status' => $order->status === 'Active' ? 'aktif' : 'selesai',
                    'rental_type' => $order->rental_type,
                    'total_days' => max(1, $order->start_date->diffInDays($order->end_date)),
                    'total_price' => 0,
                    'is_overdue' => $order->end_date->isPast() && $order->status === 'Active',
                    'created_at' => $order->created_at->diffForHumans(),
                ];
            }),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ], 200);
    }

    /**
     * Get active rentals only
     */
    public function active(Request $request)
    {
        $user = $request->user();
        $query = \App\Models\Order::with(['vehicle:id,brand,model,license_plate', 'customer:id,name,phone'])
            ->where('status', 'Active');

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        $orders = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'vehicle' => [
                        'brand' => $order->vehicle->brand,
                        'model' => $order->vehicle->model,
                        'license_plate' => $order->vehicle->license_plate,
                    ],
                    'customer' => [
                        'name' => $order->customer->name,
                        'phone' => $order->customer->phone ?? '-',
                    ],
                    'start_date' => $order->start_date->format('Y-m-d H:i'),
                    'end_date' => $order->end_date->format('Y-m-d H:i'),
                    'status' => 'aktif',
                    'rental_type' => $order->rental_type,
                    'total_days' => max(1, $order->start_date->diffInDays($order->end_date)),
                    'total_price' => 0,
                    'days_remaining' => $order->end_date->diffInDays(now(), false),
                    'is_overdue' => $order->end_date->isPast(),
                    'created_at' => $order->created_at->diffForHumans(),
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
