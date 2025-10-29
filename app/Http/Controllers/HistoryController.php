<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Income;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
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
        $historyData = [];
        $lastMonthPerformance = null;
        
        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $selectedVehicle = Vehicle::findOrFail($request->vehicle_id);
            
            // Get all history data for selected vehicle
            $historyData = $this->getVehicleHistory($selectedVehicle->id);
            
            // Get last month performance
            $lastMonthPerformance = $this->getLastMonthPerformance($selectedVehicle->id);
        }
        
        return view('history.index', compact(
            'vehicles',
            'selectedVehicle',
            'historyData',
            'lastMonthPerformance'
        ));
    }
    
    private function getVehicleHistory($vehicleId)
    {
        $income = Income::where('vehicle_id', $vehicleId)
            ->orderBy('income_date', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'date' => Carbon::parse($item->income_date)->format('d M Y'),
                    'type' => 'Income',
                    'category' => $item->type ?? 'N/A',
                    'amount' => $item->amount,
                    'notes' => $item->notes ?? '-',
                    'created_at' => $item->created_at
                ];
            });
        
        $service = Maintenance::where('vehicle_id', $vehicleId)
            ->orderBy('service_date', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'date' => Carbon::parse($item->service_date)->format('d M Y'),
                    'type' => 'Service',
                    'category' => $item->service_type ?? 'Maintenance',
                    'amount' => $item->total_cost,
                    'notes' => $item->notes ?? '-',
                    'created_at' => $item->created_at
                ];
            });
        
        $expense = Expense::where('vehicle_id', $vehicleId)
            ->orderBy('expense_date', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'date' => Carbon::parse($item->expense_date)->format('d M Y'),
                    'type' => 'Expense',
                    'category' => $item->category ?? 'Other',
                    'amount' => $item->amount,
                    'notes' => $item->notes ?? '-',
                    'created_at' => $item->created_at
                ];
            });
        
        // Merge and sort by date
        $allHistory = collect()
            ->merge($income)
            ->merge($service)
            ->merge($expense)
            ->sortByDesc('created_at')
            ->values();
        
        return $allHistory;
    }
    
    private function getLastMonthPerformance($vehicleId)
    {
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now()->subMonth()->endOfMonth();
        
        $income = Income::where('vehicle_id', $vehicleId)
            ->whereBetween('income_date', [$startDate, $endDate])
            ->sum('amount');
        
        $service = Maintenance::where('vehicle_id', $vehicleId)
            ->whereBetween('service_date', [$startDate, $endDate])
            ->sum('total_cost');
        
        $expense = Expense::where('vehicle_id', $vehicleId)
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');
        
        $balance = $income - ($service + $expense);
        
        return [
            'month' => $startDate->format('F Y'),
            'income' => $income,
            'service' => $service,
            'expense' => $expense,
            'balance' => $balance
        ];
    }
    
    public function downloadDetail(Request $request)
    {
        if (!$request->has('vehicle_id') || !$request->vehicle_id) {
            return back()->with('error', 'Please select a vehicle first');
        }
        
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $historyData = $this->getVehicleHistory($vehicle->id);
        $lastMonthPerformance = $this->getLastMonthPerformance($vehicle->id);
        
        // Generate PDF
        $pdf = PDF::loadView('history.pdf', compact('vehicle', 'historyData', 'lastMonthPerformance'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Vehicle_History_' . str_replace(' ', '_', $vehicle->license_plate) . '_' . date('YmdHis') . '.pdf';
        
        return $pdf->download($filename);
    }
}
