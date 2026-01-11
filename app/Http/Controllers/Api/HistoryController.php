<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryRecord;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Get history records with filters
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = HistoryRecord::with('vehicle:id,brand,model,license_plate')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        // Filter by vehicle
        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $query->forVehicle($request->vehicle_id);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->ofType($request->type);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        $perPage = $request->get('per_page', 20);
        $history = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $history->map(function ($record) {
                return [
                    'id' => $record->id,
                    'vehicle_id' => $record->vehicle_id,
                    'vehicle_name' => $record->vehicle
                        ? "{$record->vehicle->brand} {$record->vehicle->model} {$record->vehicle->license_plate}"
                        : null,
                    'type' => $record->type,
                    'title' => $record->title,
                    'description' => $record->description,
                    'location' => $record->location,
                    'cost' => $record->cost,
                    'odometer' => $record->odometer,
                    'date' => $record->date->format('Y-m-d'),
                    'extra_data' => $record->extra_data,
                    'created_at' => $record->created_at->toIso8601String(),
                ];
            }),
            'meta' => [
                'current_page' => $history->currentPage(),
                'per_page' => $history->perPage(),
                'total' => $history->total(),
                'last_page' => $history->lastPage(),
            ],
        ]);
    }

    /**
     * Get history statistics
     */
    public function stats(Request $request)
    {
        $user = $request->user();

        $query = HistoryRecord::query();

        // Apply location filter for non-admin users
        if (!$user->isAdmin() && $user->location_id) {
            $query->whereHas('vehicle', function ($q) use ($user) {
                $q->where('location_id', $user->location_id);
            });
        }

        // Filter by vehicle
        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $query->forVehicle($request->vehicle_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        $totalCost = $query->sum('cost');
        $totalTransactions = $query->count();

        // Group by type
        $byType = $query->select('type')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('SUM(cost) as total_cost')
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->type => [
                        'count' => $item->count,
                        'total_cost' => $item->total_cost,
                    ]
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'total_cost' => $totalCost,
                'total_transactions' => $totalTransactions,
                'by_type' => $byType,
            ],
        ]);
    }

    /**
     * Get next refueling prediction for a vehicle
     */
    public function nextRefueling(Request $request, $vehicleId)
    {
        // Get last 3 refueling records
        $recentFills = HistoryRecord::forVehicle($vehicleId)
            ->ofType('refueling')
            ->orderBy('date', 'desc')
            ->limit(3)
            ->get();

        if ($recentFills->count() < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak cukup data untuk prediksi',
            ]);
        }

        // Calculate average distance between refueling
        $distances = [];
        for ($i = 0; $i < $recentFills->count() - 1; $i++) {
            $current = $recentFills[$i];
            $previous = $recentFills[$i + 1];

            if ($current->odometer && $previous->odometer) {
                $distances[] = $current->odometer - $previous->odometer;
            }
        }

        if (empty($distances)) {
            return response()->json([
                'success' => false,
                'message' => 'Data odometer tidak lengkap',
            ]);
        }

        $avgDistance = array_sum($distances) / count($distances);
        $lastOdometer = $recentFills->first()->odometer;
        $estimatedOdometer = $lastOdometer + $avgDistance;

        // Calculate average days between refueling
        $daysBetween = [];
        for ($i = 0; $i < $recentFills->count() - 1; $i++) {
            $current = $recentFills[$i];
            $previous = $recentFills[$i + 1];

            $daysBetween[] = $current->date->diffInDays($previous->date);
        }

        $avgDays = array_sum($daysBetween) / count($daysBetween);
        $estimatedDate = now()->addDays($avgDays);

        return response()->json([
            'success' => true,
            'data' => [
                'vehicle_id' => $vehicleId,
                'vehicle_name' => $recentFills->first()->vehicle
                    ? "{$recentFills->first()->vehicle->brand} {$recentFills->first()->vehicle->model}"
                    : null,
                'estimated_odometer' => round($estimatedOdometer),
                'days_until' => round($avgDays),
                'estimated_date' => $estimatedDate->format('Y-m-d'),
            ],
        ]);
    }
}
