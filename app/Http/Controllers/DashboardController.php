<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Location;
use App\Http\Middleware\LocationFilter;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $locationId = LocationFilter::getLocationId();
        
        // Persist selected vehicle to session
        if ($request->has('vehicle_id')) {
            session(['selected_vehicle_id' => $request->vehicle_id]);
        }
        
        // Get vehicles based on location filter
        $vehiclesQuery = Vehicle::with(['maintenances' => function($query) {
            $query->where('service_date', '>=', Carbon::now())
                  ->orderBy('service_date', 'asc');
        }])->where('is_active', true);
        
        if ($locationId) {
            $vehiclesQuery->where('location_id', $locationId);
        }
        
        $vehicles = $vehiclesQuery->get();
        
        // Get location statistics for super admin
        $locationStats = [];
        if (LocationFilter::canAccessAllLocations() && !$locationId) {
            $locations = Location::active()->get();
            foreach ($locations as $location) {
                $locationVehicles = Vehicle::where('location_id', $location->id)
                    ->where('is_active', true)
                    ->count();
                
                $locationBooked = Vehicle::where('location_id', $location->id)
                    ->where('is_active', true)
                    ->where(function($query) {
                        $query->whereHas('rentals', function($q) {
                            $q->whereIn('status', ['active', 'Active', 'ACTIVE'])
                              ->orWhereIn('status', ['booked', 'Booked', 'BOOKED']);
                        })
                        ->orWhereHas('orders', function($q) {
                            $q->whereIn('status', ['active', 'Active', 'ACTIVE']);
                        });
                    })->count();
                
                $locationAvailable = $locationVehicles - $locationBooked;
                
                $locationStats[] = [
                    'name' => $location->name,
                    'code' => $location->code,
                    'total' => $locationVehicles,
                    'booked' => $locationBooked,
                    'available' => $locationAvailable
                ];
            }
        }
        
        // Section 1: Monitoring STNK Journey Time
        $stnkMonitoring = [];
        foreach($vehicles as $vehicle) {
            if($vehicle->stnk_expiry_date) {
                $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($vehicle->stnk_expiry_date), false);
                
                if ($daysUntilExpiry <= 30) {
                    $status = $daysUntilExpiry < 0 ? 'red' : 'yellow';
                    
                    $stnkMonitoring[] = [
                        'id' => $vehicle->id,
                        'vehicle_name' => $vehicle->name,
                        'license_plate' => $vehicle->license_plate,
                        'location' => $vehicle->location ? $vehicle->location->name : '-',
                        'days_until_expiry' => abs(round($daysUntilExpiry)),
                        'status' => $status,
                        'expiry_date' => Carbon::parse($vehicle->stnk_expiry_date)->format('d M Y')
                    ];
                }
            }
        }
        
        // Section 2: Monitoring KIR Journey Time
        $kirMonitoring = [];
        foreach($vehicles as $vehicle) {
            if($vehicle->kir_expiry_date) {
                $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($vehicle->kir_expiry_date), false);
                
                if ($daysUntilExpiry <= 30) {
                    $status = $daysUntilExpiry < 0 ? 'red' : 'yellow';
                    
                    $kirMonitoring[] = [
                        'id' => $vehicle->id,
                        'vehicle_name' => $vehicle->name,
                        'license_plate' => $vehicle->license_plate,
                        'location' => $vehicle->location ? $vehicle->location->name : '-',
                        'days_until_expiry' => abs(round($daysUntilExpiry)),
                        'status' => $status,
                        'expiry_date' => Carbon::parse($vehicle->kir_expiry_date)->format('d M Y')
                    ];
                }
            }
        }

        // Section 3: Monitoring GPS Journey Time
        $gpsMonitoring = [];
        foreach($vehicles as $vehicle) {
            if($vehicle->gps_expiry_date) {
                $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($vehicle->gps_expiry_date), false);
                
                // GPS warning 7 days before
                if ($daysUntilExpiry <= 7) {
                    $status = $daysUntilExpiry < 0 ? 'red' : 'yellow';
                    
                    $gpsMonitoring[] = [
                        'id' => $vehicle->id,
                        'vehicle_name' => $vehicle->name,
                        'license_plate' => $vehicle->license_plate,
                        'location' => $vehicle->location ? $vehicle->location->name : '-',
                        'days_until_expiry' => abs(round($daysUntilExpiry)),
                        'status' => $status,
                        'expiry_date' => Carbon::parse($vehicle->gps_expiry_date)->format('d M Y')
                    ];
                }
            }
        }
        
        // Section 4: Monitoring Vehicle BOOKED and AVAILABLE
        $bookedQuery = Vehicle::where('is_active', true)->where(function($query) {
            $query->whereHas('rentals', function($q) {
                $q->whereIn('status', ['active', 'Active', 'ACTIVE'])
                  ->orWhereIn('status', ['booked', 'Booked', 'BOOKED']);
            })
            ->orWhereHas('orders', function($q) {
                $q->whereIn('status', ['active', 'Active', 'ACTIVE']);
            });
        });
        
        $availableQuery = Vehicle::where('is_active', true)
            ->whereDoesntHave('rentals', function($query) {
                $query->whereIn('status', ['active', 'Active', 'ACTIVE'])
                      ->orWhereIn('status', ['booked', 'Booked', 'BOOKED']);
            })
            ->whereDoesntHave('orders', function($query) {
                $query->whereIn('status', ['active', 'Active', 'ACTIVE']);
            });
        
        if ($locationId) {
            $bookedQuery->where('location_id', $locationId);
            $availableQuery->where('location_id', $locationId);
        }
        
        $bookedVehicles = $bookedQuery->count();
        $availableVehicles = $availableQuery->count();
        $totalFleet = $bookedVehicles + $availableVehicles;
        
        // Section 5: Financial Summary - This Month
        $incomeQuery = Income::whereYear('income_date', Carbon::now()->year)
            ->whereMonth('income_date', Carbon::now()->month);
        $expenseQuery = Expense::whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month);

        if ($locationId) {
            $incomeQuery->whereHas('vehicle', fn($q) => $q->where('location_id', $locationId));
            $expenseQuery->where('location_id', $locationId);
        }

        $monthlyIncome  = (float) $incomeQuery->sum('amount');
        $monthlyExpense = (float) $expenseQuery->sum('amount');
        $monthlyProfit  = $monthlyIncome - $monthlyExpense;

        // Section 6: Fuel/Expense chart data (6 months)
        $fuelChartData = $this->getFuelExpensesChartData($locationId);

        // Get locations for filter dropdown
        $locations = Location::active()->get();
        $selectedLocation = $locationId;

        return view('dashboard.main', compact(
            'stnkMonitoring',
            'kirMonitoring',
            'gpsMonitoring',
            'bookedVehicles',
            'availableVehicles',
            'totalFleet',
            'locationStats',
            'locations',
            'selectedLocation',
            'monthlyIncome',
            'monthlyExpense',
            'monthlyProfit',
            'fuelChartData'
        ));
    }

    private function getFuelExpensesChartData($locationId = null)
    {
        $months  = [];
        $income  = [];
        $expense = [];

        for ($i = 5; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $incomeQuery = Income::whereYear('income_date', $date->year)
                ->whereMonth('income_date', $date->month);
            $expenseQuery = Expense::whereYear('expense_date', $date->year)
                ->whereMonth('expense_date', $date->month);

            if ($locationId) {
                $incomeQuery->whereHas('vehicle', fn($q) => $q->where('location_id', $locationId));
                $expenseQuery->where('location_id', $locationId);
            }

            $income[]  = (float) $incomeQuery->sum('amount');
            $expense[] = (float) $expenseQuery->sum('amount');
        }

        return [
            'labels'  => $months,
            'income'  => $income,
            'expense' => $expense,
        ];
    }
}
