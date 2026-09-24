<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Order;
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
        
        $this->autoCompleteOrders();
        
        if ($request->has('vehicle_id')) {
            session(['selected_vehicle_id' => $request->vehicle_id]);
        }
        
        $vehicles = $this->getVehicles($locationId);
        
        $locationStats = $this->getLocationStats($locationId);
        
        $stnkMonitoring = $this->getStnkMonitoring($vehicles);
        $kirMonitoring = $this->getKirMonitoring($vehicles);
        $gpsMonitoring = $this->getGpsMonitoring($vehicles);
        
        $fleetStats = $this->getFleetStats($locationId);
        
        $financialSummary = $this->getFinancialSummary($locationId);
        
        $fuelChartData = $this->getFuelExpensesChartData($locationId);
        
        $locations = Location::active()->get();
        $selectedLocation = $locationId;
        
        $rentalExpiryMonitoring = $this->getRentalExpiryMonitoring($locationId);

        return view('dashboard.main', array_merge([
            'stnkMonitoring' => $stnkMonitoring,
            'kirMonitoring' => $kirMonitoring,
            'gpsMonitoring' => $gpsMonitoring,
            'locationStats' => $locationStats,
            'locations' => $locations,
            'selectedLocation' => $selectedLocation,
            'fuelChartData' => $fuelChartData,
            'rentalExpiryMonitoring' => $rentalExpiryMonitoring
        ], $fleetStats, $financialSummary));
    }
    
    private function autoCompleteOrders()
    {
        try {
            Order::whereIn('status', ['active', 'Active', 'ACTIVE'])
                ->where('end_date', '<', Carbon::today())
                ->update(['status' => 'completed', 'completed_at' => now()]);
        } catch (\Exception $e) {
            // Silently fail - completed_at column may not exist yet
        }
    }
    
    private function getVehicles($locationId)
    {
        $vehiclesQuery = Vehicle::with(['maintenances' => function($query) {
            $query->where('service_date', '>=', Carbon::now())
                  ->orderBy('service_date', 'asc');
        }])->where('is_active', true);
        
        if ($locationId) {
            $vehiclesQuery->where('location_id', $locationId);
        }
        
        return $vehiclesQuery->get();
    }
    
    private function getLocationStats($locationId)
    {
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
        return $locationStats;
    }
    
    private function getStnkMonitoring($vehicles)
    {
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
                        'expiry_date' => Carbon::parse($vehicle->stnk_expiry_date)->format('d M Y'),
                        'sort_key' => $daysUntilExpiry,
                    ];
                }
            }
        }
        usort($stnkMonitoring, fn($a, $b) => $a['sort_key'] - $b['sort_key']);
        return array_map(function($item) { unset($item['sort_key']); return $item; }, $stnkMonitoring);
    }
    
    private function getKirMonitoring($vehicles)
    {
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
                        'expiry_date' => Carbon::parse($vehicle->kir_expiry_date)->format('d M Y'),
                        'sort_key' => $daysUntilExpiry,
                    ];
                }
            }
        }
        usort($kirMonitoring, fn($a, $b) => $a['sort_key'] - $b['sort_key']);
        return array_map(function($item) { unset($item['sort_key']); return $item; }, $kirMonitoring);
    }
    
    private function getGpsMonitoring($vehicles)
    {
        $gpsMonitoring = [];
        foreach($vehicles as $vehicle) {
            if($vehicle->gps_expiry_date) {
                $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($vehicle->gps_expiry_date), false);
                
                if ($daysUntilExpiry <= 7) {
                    $status = $daysUntilExpiry < 0 ? 'red' : 'yellow';
                    
                    $gpsMonitoring[] = [
                        'id' => $vehicle->id,
                        'vehicle_name' => $vehicle->name,
                        'license_plate' => $vehicle->license_plate,
                        'location' => $vehicle->location ? $vehicle->location->name : '-',
                        'days_until_expiry' => abs(round($daysUntilExpiry)),
                        'status' => $status,
                        'expiry_date' => Carbon::parse($vehicle->gps_expiry_date)->format('d M Y'),
                        'sort_key' => $daysUntilExpiry,
                    ];
                }
            }
        }
        usort($gpsMonitoring, fn($a, $b) => $a['sort_key'] - $b['sort_key']);
        return array_map(function($item) { unset($item['sort_key']); return $item; }, $gpsMonitoring);
    }
    
    private function getFleetStats($locationId)
    {
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
        
        return [
            'bookedVehicles' => $bookedVehicles,
            'availableVehicles' => $availableVehicles,
            'totalFleet' => $bookedVehicles + $availableVehicles,
        ];
    }
    
    private function getFinancialSummary($locationId)
    {
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
        
        return [
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpense' => $monthlyExpense,
            'monthlyProfit' => $monthlyIncome - $monthlyExpense,
        ];
    }
    
    private function getRentalExpiryMonitoring($locationId)
    {
        $rentalExpiryMonitoring = [];
        try {
            $rentalExpiryQuery = Order::with(['vehicle', 'customer'])
                ->whereIn('status', ['active', 'Active', 'ACTIVE']);
            
            if ($locationId) {
                $rentalExpiryQuery->whereHas('vehicle', fn($q) => $q->where('location_id', $locationId));
            }
            
            $activeOrders = $rentalExpiryQuery->get();
            foreach ($activeOrders as $order) {
                $daysUntilEnd = Carbon::today()->diffInDays($order->end_date, false);
                
                if ($daysUntilEnd <= 7) {
                    $status = $daysUntilEnd < 0 ? 'red' : ($daysUntilEnd <= 3 ? 'yellow' : 'green');
                    $rentalExpiryMonitoring[] = [
                        'id' => $order->id,
                        'vehicle_name' => $order->vehicle->name ?? '-',
                        'license_plate' => $order->vehicle->license_plate ?? '-',
                        'customer' => $order->customer->name ?? '-',
                        'rental_type' => $order->rental_type,
                        'end_date' => $order->end_date->format('d M Y'),
                        'days_remaining' => abs(round($daysUntilEnd)),
                        'status' => $status,
                        'is_overdue' => $daysUntilEnd < 0,
                    ];
                }
            }

            usort($rentalExpiryMonitoring, function ($a, $b) {
                if ($a['is_overdue'] !== $b['is_overdue']) {
                    return $a['is_overdue'] ? -1 : 1;
                }
                return $a['days_remaining'] - $b['days_remaining'];
            });
        } catch (\Exception $e) {
            // Silently fail
        }
        return $rentalExpiryMonitoring;
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
