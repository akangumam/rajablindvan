<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\HistoryRecord;
use Carbon\Carbon;
use PDF;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedVehicle = null;
        $groupedHistory = [];
        $lastMonthPerformance = null;

        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $selectedVehicle = Vehicle::findOrFail($request->vehicle_id);

            // Get all history data for selected vehicle
            $groupedHistory = $this->getVehicleHistory($selectedVehicle->id);

            // Get last month performance
            $lastMonthPerformance = $this->getLastMonthPerformance($selectedVehicle->id);
        }

        return view('history.index', compact(
            'vehicles',
            'selectedVehicle',
            'groupedHistory',
            'lastMonthPerformance'
        ));
    }

    private function getVehicleHistory($vehicleId)
    {
        $records = HistoryRecord::where('vehicle_id', $vehicleId)
            ->with('vehicle')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by month
        $grouped = $records->groupBy(function($record) {
            return Carbon::parse($record->date)->format('F Y');
        });

        return $grouped;
    }

    private function getLastMonthPerformance($vehicleId)
    {
        // Get the most recent month that has transactions
        $latestRecord = HistoryRecord::where('vehicle_id', $vehicleId)
            ->orderBy('date', 'desc')
            ->first();

        if (!$latestRecord) {
            return null;
        }

        $latestDate = Carbon::parse($latestRecord->date);
        $startDate = $latestDate->copy()->startOfMonth();
        $endDate = $latestDate->copy()->endOfMonth();

        $records = HistoryRecord::where('vehicle_id', $vehicleId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalCost = $records->sum('cost');
        $totalTransactions = $records->count();
        $avgCost = $totalTransactions > 0 ? $totalCost / $totalTransactions : 0;

        return [
            'month' => $startDate->format('F Y'),
            'total_cost' => $totalCost,
            'total_transactions' => $totalTransactions,
            'avg_cost' => $avgCost,
        ];
    }

        public function downloadPdf(Request $request)
        {
            $vehicleId = $request->vehicle_id;
            $vehicle = Vehicle::findOrFail($vehicleId);
            $groupedHistory = $this->getVehicleHistory($vehicleId);

            $pdf = PDF::loadView('history.pdf', compact('vehicle', 'groupedHistory'));
            return $pdf->download('vehicle-history-' . $vehicle->name . '.pdf');
        }
    }
