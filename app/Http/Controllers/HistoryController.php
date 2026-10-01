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
        $performance = null;

        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $selectedVehicle = Vehicle::findOrFail($request->vehicle_id);

            $groupedHistory = $this->getVehicleHistory($selectedVehicle->id);

            $performance = $this->getPerformance(
                $selectedVehicle->id,
                $request->get('period', 'last_month'),
                $request->get('start_date'),
                $request->get('end_date')
            );
        }

        return view('history.index', compact(
            'vehicles',
            'selectedVehicle',
            'groupedHistory',
            'performance'
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

    private function getPerformance($vehicleId, $period = 'last_month', $customStart = null, $customEnd = null)
    {
        $now = Carbon::now();

        if ($period === 'all') {
            $records = HistoryRecord::where('vehicle_id', $vehicleId)->get();
            $label = 'Semua Waktu';
        } elseif ($period === 'custom' && $customStart && $customEnd) {
            $start = Carbon::parse($customStart)->startOfDay();
            $end   = Carbon::parse($customEnd)->endOfDay();
            $label = $start->format('d M Y') . ' – ' . $end->format('d M Y');
            $records = HistoryRecord::where('vehicle_id', $vehicleId)
                ->whereBetween('date', [$start, $end])
                ->get();
        } elseif ($period === 'this_month') {
            $start = $now->copy()->startOfMonth();
            $end   = $now->copy();
            $label = 'Bulan Ini (' . $start->format('F Y') . ')';
            $records = HistoryRecord::where('vehicle_id', $vehicleId)
                ->whereBetween('date', [$start, $end])
                ->get();
        } else {
            // default: last_month
            $start = $now->copy()->subMonth()->startOfMonth();
            $end   = $now->copy()->subMonth()->endOfMonth();
            $label = 'Bulan Lalu (' . $start->format('F Y') . ')';
            $records = HistoryRecord::where('vehicle_id', $vehicleId)
                ->whereBetween('date', [$start, $end])
                ->get();
        }

        $totalCost         = $records->sum('cost');
        $totalTransactions = $records->count();

        return [
            'label'              => $label,
            'total_cost'         => $totalCost,
            'total_transactions' => $totalTransactions,
            'avg_cost'           => $totalTransactions > 0 ? $totalCost / $totalTransactions : 0,
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
