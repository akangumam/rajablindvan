<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Get all rentals (with location filter)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Order::with(['vehicle:id,brand,model,license_plate', 'customer:id,name,phone']);

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        // Auto-complete expired orders
        try {
            Order::whereIn('status', ['active', 'Active', 'ACTIVE'])
                ->where('end_date', '<', Carbon::today())
                ->update(['status' => 'completed', 'completed_at' => now()]);
        } catch (\Exception $e) {
            // Silently fail
        }

        if ($request->has('status')) {
            $status = strtolower($request->status);
            $query->whereIn('status', [$status, ucfirst($status), strtoupper($status)]);
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
                    'status' => $order->status,
                    'rental_type' => $order->rental_type,
                    'total_days' => $order->total_days,
                    'total_price' => $order->total_price,
                    'is_overdue' => $order->end_date->isPast() && $order->status === Order::STATUS_ACTIVE,
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
        $query = Order::with(['vehicle:id,brand,model,license_plate,daily_rental_rate,monthly_rental_rate', 'customer:id,name,phone'])
            ->whereIn('status', ['active', 'Active', 'ACTIVE']);

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
                    'status' => $order->status,
                    'rental_type' => $order->rental_type,
                    'total_days' => $order->total_days,
                    'total_price' => $order->total_price,
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
        $order = Order::with(['vehicle.location', 'customer'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Rental not found',
            ], 404);
        }

        // Check location access
        if (!$user->isAdmin() && $order->vehicle->location_id != $user->location_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this rental',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id,
                'vehicle' => [
                    'id' => $order->vehicle->id,
                    'brand' => $order->vehicle->brand,
                    'model' => $order->vehicle->model,
                    'license_plate' => $order->vehicle->license_plate,
                    'color' => $order->vehicle->color,
                    'location' => $order->vehicle->location ? $order->vehicle->location->name : null,
                ],
                'customer' => [
                    'id' => $order->customer->id,
                    'name' => $order->customer->name,
                    'phone' => $order->customer->phone ?? '-',
                    'email' => $order->customer->email ?? null,
                    'address' => $order->customer->address ?? null,
                ],
                'start_date' => $order->start_date->format('Y-m-d H:i'),
                'end_date' => $order->end_date->format('Y-m-d H:i'),
                'status' => $order->status,
                'rental_type' => $order->rental_type,
                'total_days' => $order->total_days,
                'total_price' => (float) $order->total_price,
                'is_overdue' => $order->end_date->isPast() && $order->status === Order::STATUS_ACTIVE,
                'days_remaining' => $order->end_date->diffInDays(now(), false),
                'created_at' => $order->created_at->toIso8601String(),
                'updated_at' => $order->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * Store a newly created rental
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'rental_type' => 'required|in:Sewa Harian,Sewa Bulanan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $vehicle = \App\Models\Vehicle::find($request->vehicle_id);
        
        if ($vehicle->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak tersedia untuk disewa'
            ], 422);
        }

        $order = Order::create([
            'vehicle_id' => $request->vehicle_id,
            'customer_id' => $request->customer_id,
            'rental_type' => $request->rental_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => Order::STATUS_ACTIVE,
        ]);

        // Update vehicle status
        $vehicle->update(['status' => 'rented']);

        // Create History Record for rental start
        \App\Models\HistoryRecord::create([
            'vehicle_id' => $vehicle->id,
            'type' => 'rental',
            'title' => 'Mulai Sewa (' . $request->rental_type . ')',
            'description' => 'Disewa oleh customer ID: ' . $request->customer_id . ' sampai ' . $request->end_date,
            'date' => $request->start_date,
            'cost' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Penyewaan berhasil dibuat',
            'data' => $order
        ], 201);
    }

    /**
     * Complete an active rental
     */
    public function complete(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Rental not found'], 404);
        }

        if ($order->status !== Order::STATUS_ACTIVE) {
            return response()->json(['success' => false, 'message' => 'Rental is not active'], 422);
        }

        $order->update([
            'status' => Order::STATUS_COMPLETED,
            'completed_at' => now()
        ]);

        if ($order->vehicle) {
            $order->vehicle->update(['status' => 'available']);
            
            // Create History Record for rental complete (recording cost)
            \App\Models\HistoryRecord::create([
                'vehicle_id' => $order->vehicle->id,
                'type' => 'rental_payment',
                'title' => 'Pembayaran Sewa (' . $order->rental_type . ')',
                'description' => 'Sewa Selesai. Total Pendapatan: Rp ' . number_format($order->total_price, 0, ',', '.'),
                'date' => now(),
                'cost' => $order->total_price,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Penyewaan berhasil diselesaikan'
        ], 200);
    }
}
