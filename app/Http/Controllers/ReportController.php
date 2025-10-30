<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;
use App\Exports\VehiclesExport;
use App\Exports\CustomersExport;
use App\Exports\RentalsExport;

class ReportController extends Controller
{
    private const TOTAL_AMOUNT_CHARGES = 'total_amount + additional_charges';
    
    /**
     * Show main report page with filters
     */
    public function index()
    {
        $vehicles = Vehicle::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('reports.index', compact('vehicles'));
    }
    
    /**
     * Generate report based on filters (AJAX)
     */
    public function generate(Request $request)
    {
        // Get filter parameters
        $vehicleFilter = $request->input('vehicle_filter', 'all');
        $vehicleIds = $request->input('vehicle_ids', []);
        $periodFilter = $request->input('period', 'last_month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $includeIncome = $request->input('income_toggle', false);
        $includeService = $request->input('service_toggle', false);
        $includeExpense = $request->input('expense_toggle', false);
        
        // Determine date range
        [$startDate, $endDate] = $this->getDateRange($periodFilter, $startDate, $endDate);
        
        // Get vehicles based on filter
        $vehicles = $this->getFilteredVehicles($vehicleFilter, $vehicleIds);
        
        // Initialize totals
        $totalIncome = 0;
        $totalServiceCost = 0;
        $totalExpenseCost = 0;
        
        $vehicleData = [];
        $incomeDetails = [];
        $serviceDetails = [];
        $expenseDetails = [];
        
        foreach ($vehicles as $vehicle) {
            $vehicleIncome = 0;
            $vehicleService = 0;
            $vehicleExpense = 0;
            
            // Calculate Income (from rentals)
            if ($includeIncome) {
                $rentals = Rental::where('vehicle_id', $vehicle->id)
                    ->where('status', 'completed')
                    ->whereBetween('actual_end_time', [$startDate, $endDate])
                    ->with('customer')
                    ->get();
                
                $vehicleIncome = $rentals->sum(function($rental) {
                    return $rental->total_amount + ($rental->additional_charges ?? 0);
                });
                
                foreach ($rentals as $rental) {
                    $incomeDetails[] = [
                        'date' => $rental->actual_end_time->format('Y-m-d'),
                        'vehicle' => $vehicle->name,
                        'customer' => $rental->customer->name ?? '-',
                        'type' => ucfirst($rental->rental_type ?? 'Rental'),
                        'amount' => $rental->total_amount + ($rental->additional_charges ?? 0)
                    ];
                }
            }
            
            // Calculate Service Cost (from maintenances)
            if ($includeService) {
                $maintenances = Maintenance::where('vehicle_id', $vehicle->id)
                    ->whereBetween('maintenance_date', [$startDate, $endDate])
                    ->get();
                
                $vehicleService = $maintenances->sum('cost');
                
                foreach ($maintenances as $maintenance) {
                    $serviceDetails[] = [
                        'date' => $maintenance->maintenance_date,
                        'vehicle' => $vehicle->name,
                        'type' => ucfirst($maintenance->type ?? 'Maintenance'),
                        'description' => $maintenance->description ?? '-',
                        'cost' => $maintenance->cost
                    ];
                }
            }
            
            // Calculate Expense Cost (from expenses and fuel fills)
            if ($includeExpense) {
                $expenses = Expense::where('vehicle_id', $vehicle->id)
                    ->whereBetween('expense_date', [$startDate, $endDate])
                    ->get();
                
                $vehicleExpense = $expenses->sum('amount');
                
                foreach ($expenses as $expense) {
                    $expenseDetails[] = [
                        'date' => $expense->expense_date,
                        'vehicle' => $vehicle->name,
                        'category' => ucfirst($expense->category ?? 'Other'),
                        'description' => $expense->description ?? '-',
                        'amount' => $expense->amount
                    ];
                }
                
                // Include fuel costs
                $fuelFills = FuelFill::where('vehicle_id', $vehicle->id)
                    ->whereBetween('fill_date', [$startDate, $endDate])
                    ->get();
                $vehicleExpense += $fuelFills->sum('total_cost');
                
                foreach ($fuelFills as $fuel) {
                    $expenseDetails[] = [
                        'date' => $fuel->fill_date,
                        'vehicle' => $vehicle->name,
                        'category' => 'Fuel',
                        'description' => $fuel->quantity . 'L @ Rp' . number_format($fuel->price_per_liter),
                        'amount' => $fuel->total_cost
                    ];
                }
            }
            
            $vehicleCost = $vehicleService + $vehicleExpense;
            $vehicleBalance = $vehicleIncome - $vehicleCost;
            
            $vehicleData[] = [
                'name' => $vehicle->name,
                'income' => $vehicleIncome,
                'service' => $vehicleService,
                'expense' => $vehicleExpense,
                'cost' => $vehicleCost,
                'balance' => $vehicleBalance
            ];
            
            $totalIncome += $vehicleIncome;
            $totalServiceCost += $vehicleService;
            $totalExpenseCost += $vehicleExpense;
        }
        
        $totalCost = $totalServiceCost + $totalExpenseCost;
        $totalBalance = $totalIncome - $totalCost;
        
        // Store in session for download
        session([
            'report_data' => [
                'filters' => $request->all(),
                'date_range' => compact('startDate', 'endDate'),
                'totals' => compact('totalIncome', 'totalServiceCost', 'totalExpenseCost', 'totalCost', 'totalBalance'),
                'vehicles' => $vehicleData,
                'details' => compact('incomeDetails', 'serviceDetails', 'expenseDetails')
            ]
        ]);
        
        return response()->json([
            'totalIncome' => $totalIncome,
            'serviceCost' => $totalServiceCost,
            'expenseCost' => $totalExpenseCost,
            'totalCost' => $totalCost,
            'totalBalance' => $totalBalance,
            'vehicles' => $vehicleData,
            'incomeDetails' => $incomeDetails,
            'serviceDetails' => $serviceDetails,
            'expenseDetails' => $expenseDetails
        ]);
    }
    
    /**
     * Download General Report PDF
     */
    public function downloadGeneral()
    {
        $reportData = session('report_data');
        
        if (!$reportData) {
            return redirect()->route('reports.index')->with('error', 'No report data available. Please generate a report first.');
        }
        
        $pdf = Pdf::loadView('reports.pdf.general', ['data' => $reportData]);
        return $pdf->download('general-report-' . date('Y-m-d') . '.pdf');
    }
    
    /**
     * Download Detail Report PDF
     */
    public function downloadDetail()
    {
        $reportData = session('report_data');
        
        if (!$reportData) {
            return redirect()->route('reports.index')->with('error', 'No report data available. Please generate a report first.');
        }
        
        $pdf = Pdf::loadView('reports.pdf.detail', ['data' => $reportData]);
        return $pdf->download('detail-report-' . date('Y-m-d') . '.pdf');
    }
    
    /**
     * Helper: Get date range based on period filter
     */
    private function getDateRange($period, $customStart = null, $customEnd = null)
    {
        if ($period === 'custom' && $customStart && $customEnd) {
            return [$customStart, $customEnd];
        }
        
        $endDate = Carbon::now()->format('Y-m-d');
        
        $startDate = match($period) {
            'last_month' => Carbon::now()->subMonth()->format('Y-m-d'),
            'last_3_months' => Carbon::now()->subMonths(3)->format('Y-m-d'),
            'last_6_months' => Carbon::now()->subMonths(6)->format('Y-m-d'),
            'last_year' => Carbon::now()->subYear()->format('Y-m-d'),
            default => Carbon::now()->subMonth()->format('Y-m-d')
        };
        
        return [$startDate, $endDate];
    }
    
    /**
     * Helper: Get filtered vehicles
     */
    private function getFilteredVehicles($filter, $ids = [])
    {
        $query = Vehicle::query();
        
        if ($filter === 'active') {
            $query->where('is_active', true);
        } elseif ($filter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($filter === 'custom' && !empty($ids)) {
            $query->whereIn('id', $ids);
        }
        
        return $query->orderBy('name')->get();
    }
    
    /**
     * OLD ROUTES - Redirect to new page
     */
    public function dashboard() {
        return redirect()->route('reports.index');
    }
    
    public function rentals() {
        return redirect()->route('reports.index');
    }
    
    public function vehicles() {
        return redirect()->route('reports.index');
    }
    
    public function financial() {
        return redirect()->route('reports.index');
    }
    
    public function customers() {
        return redirect()->route('reports.index');
    }
    
    /**
     * Export methods (keep for backward compatibility)
     */
    public function exportFinancialExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $vehicleId = $request->input('vehicle_id');

        $filename = 'laporan-keuangan-' . ($startDate ? $startDate : 'all') . '-to-' . ($endDate ? $endDate : 'now') . '.xlsx';
        
        return Excel::download(new FinancialReportExport($startDate, $endDate, $vehicleId), $filename);
    }

    public function exportVehiclesExcel()
    {
        $filename = 'data-kendaraan-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new VehiclesExport(), $filename);
    }

    public function exportCustomersExcel()
    {
        $filename = 'data-pelanggan-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new CustomersExport(), $filename);
    }

    public function exportRentalsExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $filename = 'data-sewa-' . ($startDate ? $startDate : 'all') . '-to-' . ($endDate ? $endDate : 'now') . '.xlsx';
        
        return Excel::download(new RentalsExport($startDate, $endDate, $status), $filename);
    }
}
