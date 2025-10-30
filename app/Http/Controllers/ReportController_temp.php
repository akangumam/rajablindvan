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
     * Generate report based on filters
     */
    public function generate(Request $request)
    {
        // Get filter parameters
        $vehicleFilter = $request->input('vehicle_filter', 'all');
        $vehicleIds = $request->input('vehicle_ids', []);
        $periodFilter = $request->input('period_filter', 'last_month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $includeIncome = $request->input('income_toggle') === 'on';
        $incomeType = $request->input('income_type', 'all');
        $includeService = $request->input('service_toggle') === 'on';
        $serviceType = $request->input('service_type', 'all');
        $includeExpense = $request->input('expense_toggle') === 'on';
        $expenseType = $request->input('expense_type', 'all');
        
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
                    ->whereBetween('actual_end_time', [$startDate, $endDate]);
                
                if ($incomeType !== 'all') {
                    $rentals->where('rental_type', $incomeType);
                }
                
                $rentalData = $rentals->get();
                $vehicleIncome = $rentalData->sum(function($rental) {
                    return $rental->total_amount + $rental->additional_charges;
                });
                
                // Add to income details
                foreach ($rentalData as $rental) {
                    $incomeDetails[] = [
                        'date' => $rental->actual_end_time->format('Y-m-d'),
                        'vehicle' => $vehicle->name,
                        'customer' => $rental->customer->name ?? '-',
                        'type' => ucfirst($rental->rental_type ?? 'Rental'),
                        'amount' => $rental->total_amount + $rental->additional_charges
                    ];
                }
            }
            
            // Calculate Service Cost (from maintenances)
            if ($includeService) {
                $maintenances = Maintenance::where('vehicle_id', $vehicle->id)
                    ->whereBetween('maintenance_date', [$startDate, $endDate]);
                
                if ($serviceType === 'maintenance') {
                    $maintenances->where('type', 'maintenance');
                } elseif ($serviceType === 'repair') {
                    $maintenances->where('type', 'repair');
                }
                
                $maintenanceData = $maintenances->get();
                $vehicleService = $maintenanceData->sum('cost');
                
                // Add to service details
                foreach ($maintenanceData as $maintenance) {
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
                    ->whereBetween('expense_date', [$startDate, $endDate]);
                
                if ($expenseType === 'fuel') {
                    $fuelFills = FuelFill::where('vehicle_id', $vehicle->id)
                        ->whereBetween('fill_date', [$startDate, $endDate])
                        ->get();
                    $vehicleExpense = $fuelFills->sum('total_cost');
                    
                    // Add to expense details
                    foreach ($fuelFills as $fuel) {
                        $expenseDetails[] = [
                            'date' => $fuel->fill_date,
                            'vehicle' => $vehicle->name,
                            'category' => 'Fuel',
                            'description' => $fuel->quantity . 'L @ Rp' . number_format($fuel->price_per_liter),
                            'amount' => $fuel->total_cost
                        ];
                    }
                } else {
                    if ($expenseType !== 'all') {
                        $expenses->where('category', $expenseType);
                    }
                    
                    $expenseData = $expenses->get();
                    $vehicleExpense = $expenseData->sum('amount');
                    
                    // Add to expense details
                    foreach ($expenseData as $expense) {
                        $expenseDetails[] = [
                            'date' => $expense->expense_date,
                            'vehicle' => $vehicle->name,
                            'category' => ucfirst($expense->category ?? 'Other'),
                            'description' => $expense->description ?? '-',
                            'amount' => $expense->amount
                        ];
                    }
                    
                    // Include fuel in 'all' category
                    if ($expenseType === 'all') {
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
     * Download General Report
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
     * Download Detail Report
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
     * Dashboard Report - Redirect to new reports page
     */
    public function dashboard(Request $request)
    {
        return redirect()->route('reports.index')
            ->with('info', 'Please use the new Reports page with comprehensive filter options');
    }
    
    /**
     * Rental Reports - Redirect to new reports page
     */
    public function rentals(Request $request)
    {
        return redirect()->route('reports.index')
            ->with('info', 'Please use the new Reports page with comprehensive filter options');
    }
    
    /**
     * Vehicle Reports - Redirect to new reports page
     */
    public function vehicles(Request $request)
    {
        return redirect()->route('reports.index')
            ->with('info', 'Please use the new Reports page with comprehensive filter options');
    }
    
    /**
     * Financial Reports - Redirect to new reports page
     */
                $totalRevenue = Rental::whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum(DB::raw(self::TOTAL_AMOUNT_CHARGES));
            
        $totalExpenses = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        
        // Vehicle Statistics
        $totalVehicles = Vehicle::where('is_active', true)->count();
        $availableVehicles = Vehicle::where('is_active', true)
            ->whereDoesntHave('rentals', function($query) {
                $query->where('status', 'active');
            })->count();
            
        // Top Performing Data
        $topVehicles = $this->getTopPerformingVehicles($startDate, $endDate);
        $topCustomers = $this->getTopCustomers($startDate, $endDate);
        
        // Charts Data
        $dailyRevenue = $this->getDailyRevenue($startDate, $endDate);
        $rentalStatusChart = $this->getRentalStatusChart();
        $monthlyTrends = $this->getMonthlyTrends();
        
        return view('reports.dashboard', compact(
            'period', 'totalRentals', 'activeRentals', 'completedRentals',
            'totalRevenue', 'totalExpenses', 'totalVehicles', 'availableVehicles',
            'topVehicles', 'topCustomers', 'dailyRevenue', 'rentalStatusChart',
            'monthlyTrends'
        ));
    }
    
    /**
     * Rental Reports
     */
    public function rentals(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->get('status', 'all');
        $rentalType = $request->get('rental_type', 'all');
        
        $query = Rental::with(['customer', 'vehicle'])
            ->whereBetween('start_date', [$startDate, $endDate]);
            
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        if ($rentalType !== 'all') {
            $query->where('rental_type', $rentalType);
        }
        
        $rentals = $query->orderBy('start_date', 'desc')->paginate(20);
        
        // Summary Statistics
        $totalRentals = $query->count();
        $totalRevenue = $query->where('status', 'completed')->sum(DB::raw(self::TOTAL_AMOUNT_CHARGES));
        $averageDuration = $query->avg('duration_days');
        $averageRevenue = $totalRentals > 0 ? $totalRevenue / $totalRentals : 0;
        
        return view('reports.rentals', compact(
            'rentals', 'startDate', 'endDate', 'status', 'rentalType',
            'totalRentals', 'totalRevenue', 'averageDuration', 'averageRevenue'
        ));
    }
    
    /**
     * Vehicle Reports
     */
    public function vehicles(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $vehicles = Vehicle::with(['rentals' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate]);
        }])->get();
        
        $vehicleStats = $vehicles->map(function($vehicle) use ($startDate, $endDate) {
            $rentals = $vehicle->rentals;
            $completedRentals = $rentals->where('status', 'completed');
            
            $totalDays = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
            $rentedDays = $rentals->sum('duration_days');
            $utilization = $totalDays > 0 ? ($rentedDays / $totalDays) * 100 : 0;
            
            return [
                'vehicle' => $vehicle,
                'total_rentals' => $rentals->count(),
                'completed_rentals' => $completedRentals->count(),
                'total_revenue' => $completedRentals->sum(function($rental) {
                    return $rental->total_amount + $rental->additional_charges;
                }),
                'total_distance' => $completedRentals->sum(function($rental) {
                    return $rental->end_odometer ? ($rental->end_odometer - $rental->start_odometer) : 0;
                }),
                'utilization_rate' => round($utilization, 2),
                'average_rental_duration' => $rentals->avg('duration_days') ?? 0
            ];
        });
        
        return view('reports.vehicles', compact('vehicleStats', 'startDate', 'endDate'));
    }
    
    /**
     * Financial Reports
     */
    public function financial(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Revenue Analysis
        $rentalRevenue = Rental::where('status', 'completed')
            ->whereBetween('actual_end_time', [$startDate, $endDate])
            ->sum(DB::raw(self::TOTAL_AMOUNT_CHARGES));
            
        $depositReceived = Rental::whereBetween('start_date', [$startDate, $endDate])
            ->sum('deposit');
            
        // Expense Analysis
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
            
        $totalExpenses = $expenses->sum('total');
        
        // Maintenance Costs
        $maintenanceCosts = Maintenance::whereBetween('maintenance_date', [$startDate, $endDate])
            ->sum('cost');
            
        // Fuel Costs
        $fuelCosts = FuelFill::whereBetween('fill_date', [$startDate, $endDate])
            ->sum('total_cost');
            
        $totalOperationalCosts = $totalExpenses + $maintenanceCosts + $fuelCosts;
        $netProfit = $rentalRevenue - $totalOperationalCosts;
        $profitMargin = $rentalRevenue > 0 ? ($netProfit / $rentalRevenue) * 100 : 0;
        
        // Monthly Trends
        $monthlyData = $this->getMonthlyFinancialTrends($startDate, $endDate);
        
        // Recent transactions for detail tables
        $recentRentals = Rental::with(['customer', 'vehicle'])
            ->where('status', 'completed')
            ->whereBetween('actual_end_time', [$startDate, $endDate])
            ->orderBy('actual_end_time', 'desc')
            ->limit(20)
            ->get();
            
        $recentExpenses = Expense::with('vehicle')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->orderBy('expense_date', 'desc')
            ->limit(20)
            ->get();
        
        // Redirect to new reports page with filters
        return redirect()->route('reports.index')
            ->with('info', 'Please use the new Reports page with filter options');
    }
    
    /**
     * Customer Reports
     */
    public function customers(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $customers = Customer::with(['rentals' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate]);
        }])->get();
        
        $customerStats = $customers->map(function($customer) {
            $rentals = $customer->rentals;
            $completedRentals = $rentals->where('status', 'completed');
            
            return [
                'customer' => $customer,
                'total_rentals' => $rentals->count(),
                'completed_rentals' => $completedRentals->count(),
                'total_spent' => $completedRentals->sum(function($rental) {
                    return $rental->total_amount + $rental->additional_charges;
                }),
                'average_rental_value' => $completedRentals->count() > 0 ?
                    $completedRentals->avg(function($rental) {
                        return $rental->total_amount + $rental->additional_charges;
                    }) : 0,
                'total_days_rented' => $rentals->sum('duration_days'),
                'last_rental_date' => $rentals->max('start_date')
            ];
        })->sortByDesc('total_spent');
        
        return view('reports.customers', compact('customerStats', 'startDate', 'endDate'));
    }
    
    // Helper Methods
    private function getTopPerformingVehicles($startDate, $endDate)
    {
        return Vehicle::withSum(['rentals as total_revenue' => function($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                  ->whereBetween('actual_end_time', [$startDate, $endDate]);
        }], DB::raw(self::TOTAL_AMOUNT_CHARGES))
        ->orderByDesc('total_revenue')
        ->limit(5)
        ->get();
    }
    
    private function getTopCustomers($startDate, $endDate)
    {
        return Customer::withSum(['rentals as total_spent' => function($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                  ->whereBetween('actual_end_time', [$startDate, $endDate]);
        }], DB::raw(self::TOTAL_AMOUNT_CHARGES))
        ->orderByDesc('total_spent')
        ->limit(5)
        ->get();
    }
    
    private function getDailyRevenue($startDate, $endDate)
    {
        return Rental::where('status', 'completed')
            ->whereBetween('actual_end_time', [$startDate, $endDate])
            ->select(
                DB::raw('date(actual_end_time) as date'),
                DB::raw('SUM(' . self::TOTAL_AMOUNT_CHARGES . ') as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
    
    private function getRentalStatusChart()
    {
        return Rental::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
    }
    
    private function getMonthlyTrends()
    {
        return Rental::where('status', 'completed')
            ->where('actual_end_time', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('strftime("%Y", actual_end_time) as year'),
                DB::raw('strftime("%m", actual_end_time) as month'),
                DB::raw('COUNT(*) as total_rentals'),
                DB::raw('SUM(' . self::TOTAL_AMOUNT_CHARGES . ') as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }
    
    private function getMonthlyFinancialTrends($startDate, $endDate)
    {
        $revenue = Rental::where('status', 'completed')
            ->whereBetween('actual_end_time', [$startDate, $endDate])
            ->select(
                DB::raw('strftime("%Y", actual_end_time) as year'),
                DB::raw('strftime("%m", actual_end_time) as month'),
                DB::raw('SUM(' . self::TOTAL_AMOUNT_CHARGES . ') as amount')
            )
            ->groupBy('year', 'month')
            ->get();
            
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->select(
                DB::raw('strftime("%Y", expense_date) as year'),
                DB::raw('strftime("%m", expense_date) as month'),
                DB::raw('SUM(amount) as amount')
            )
            ->groupBy('year', 'month')
            ->get();
            
        return compact('revenue', 'expenses');
    }

    // PDF Export methods
    public function exportDashboardPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Get dashboard data
        $totalRentals = Rental::whereBetween('start_date', [$startDate, $endDate])->count();
        $completedRentals = Rental::whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'completed')->count();
        $activeRentals = Rental::where('status', 'active')->count();
        
        $totalRevenue = Rental::whereBetween('start_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum(DB::raw(self::TOTAL_AMOUNT_CHARGES));

        $data = compact('totalRentals', 'completedRentals', 'activeRentals', 'totalRevenue');
        
        $pdf = Pdf::loadView('reports.pdf.dashboard', compact('data', 'startDate', 'endDate'));
        return $pdf->download('dashboard-report-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    public function exportRentalsPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->input('status', 'all');

        $query = Rental::with(['customer', 'vehicle'])
            ->whereBetween('start_date', [$startDate, $endDate]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $rentals = $query->orderBy('start_date', 'desc')->get();
        
        $pdf = Pdf::loadView('reports.pdf.rentals', compact('rentals', 'startDate', 'endDate', 'status'));
        return $pdf->download('rentals-report-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    public function exportCustomersPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $customers = Customer::with(['rentals' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate]);
        }])->get();

        $customerStats = $customers->map(function($customer) {
            $rentals = $customer->rentals;
            $completedRentals = $rentals->where('status', 'completed');
            
            return [
                'customer' => $customer,
                'total_rentals' => $rentals->count(),
                'completed_rentals' => $completedRentals->count(),
                'total_spent' => $completedRentals->sum(DB::raw(self::TOTAL_AMOUNT_CHARGES)),
                'average_rental_value' => $completedRentals->count() > 0 ? $completedRentals->avg(DB::raw(self::TOTAL_AMOUNT_CHARGES)) : 0,
                'total_days_rented' => $rentals->sum(function($rental) {
                    return Carbon::parse($rental->end_date ?: now())->diffInDays(Carbon::parse($rental->start_date)) + 1;
                }),
                'last_rental_date' => $rentals->max('start_date')
            ];
        })->sortByDesc('total_spent');
        
        $pdf = Pdf::loadView('reports.pdf.customers', compact('customerStats', 'startDate', 'endDate'));
        return $pdf->download('customers-report-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    /**
     * Export Financial Report to Excel
     */
    public function exportFinancialExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $vehicleId = $request->input('vehicle_id');

        $filename = 'laporan-keuangan-' . ($startDate ? $startDate : 'all') . '-to-' . ($endDate ? $endDate : 'now') . '.xlsx';
        
        return Excel::download(new FinancialReportExport($startDate, $endDate, $vehicleId), $filename);
    }

    /**
     * Export Vehicles Report to Excel
     */
    public function exportVehiclesExcel()
    {
        $filename = 'data-kendaraan-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new VehiclesExport(), $filename);
    }

    /**
     * Export Customers Report to Excel
     */
    public function exportCustomersExcel()
    {
        $filename = 'data-pelanggan-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new CustomersExport(), $filename);
    }

    /**
     * Export Rentals Report to Excel
     */
    public function exportRentalsExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $filename = 'data-sewa-' . ($startDate ? $startDate : 'all') . '-to-' . ($endDate ? $endDate : 'now') . '.xlsx';
        
        return Excel::download(new RentalsExport($startDate, $endDate, $status), $filename);
    }
}
