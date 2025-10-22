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
     * Dashboard Report
     */
    public function dashboard(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, year
        
        $startDate = match($period) {
            'week' => Carbon::now()->startOfWeek(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth()
        };
        
        $endDate = Carbon::now();
        
        // Rental Statistics
        $totalRentals = Rental::whereBetween('created_at', [$startDate, $endDate])->count();
        $activeRentals = Rental::where('status', 'active')->count();
        $completedRentals = Rental::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Revenue Statistics
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
        $maintenanceCosts = Maintenance::whereBetween('date', [$startDate, $endDate])
            ->sum('cost');
            
        // Fuel Costs
        $fuelCosts = FuelFill::whereBetween('date', [$startDate, $endDate])
            ->sum('total_cost');
            
        $totalOperationalCosts = $totalExpenses + $maintenanceCosts + $fuelCosts;
        $netProfit = $rentalRevenue - $totalOperationalCosts;
        $profitMargin = $rentalRevenue > 0 ? ($netProfit / $rentalRevenue) * 100 : 0;
        
        // Monthly Trends
        $monthlyData = $this->getMonthlyFinancialTrends($startDate, $endDate);
        
        return view('reports.financial', compact(
            'startDate', 'endDate', 'rentalRevenue', 'depositReceived',
            'expenses', 'totalExpenses', 'maintenanceCosts', 'fuelCosts',
            'totalOperationalCosts', 'netProfit', 'profitMargin', 'monthlyData'
        ));
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
