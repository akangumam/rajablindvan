<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use App\Models\Location;
use App\Http\Middleware\LocationFilter;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $locationId = LocationFilter::getLocationId();
        
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
                    ->where(function($query) {
                        $query->whereHas('rentals', function($q) {
                            $q->where('status', 'active')
                              ->orWhere('status', 'booked');
                        })
                        ->orWhereHas('orders', function($q) {
                            $q->where('status', 'Active');
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
                $status = 'red'; // Expired
                
                if($daysUntilExpiry > 30) {
                    $status = 'yellow'; // Kuning (akan jatuh tempo)
                } elseif($daysUntilExpiry > 0) {
                    $status = 'red'; // Merah (telah jatuh tempo)
                }
                
                $stnkMonitoring[] = [
                    'id' => $vehicle->id,
                    'vehicle_name' => $vehicle->name,
                    'license_plate' => $vehicle->license_plate,
                    'location' => $vehicle->location ? $vehicle->location->name : '-',
                    'days_until_expiry' => abs($daysUntilExpiry),
                    'status' => $status,
                    'expiry_date' => Carbon::parse($vehicle->stnk_expiry_date)->format('d M Y')
                ];
            }
        }
        
        // Section 2: Monitoring KIR Journey Time
        $kirMonitoring = [];
        foreach($vehicles as $vehicle) {
            if($vehicle->kir_expiry_date) {
                $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($vehicle->kir_expiry_date), false);
                $status = 'red';
                
                if($daysUntilExpiry > 30) {
                    $status = 'yellow';
                } elseif($daysUntilExpiry > 0) {
                    $status = 'red';
                }
                
                $kirMonitoring[] = [
                    'id' => $vehicle->id,
                    'vehicle_name' => $vehicle->name,
                    'license_plate' => $vehicle->license_plate,
                    'location' => $vehicle->location ? $vehicle->location->name : '-',
                    'days_until_expiry' => abs($daysUntilExpiry),
                    'status' => $status,
                    'expiry_date' => Carbon::parse($vehicle->kir_expiry_date)->format('d M Y')
                ];
            }
        }
        
        // Section 3: Monitoring Vehicle BOOKED and AVAILABLE
        $bookedQuery = Vehicle::where(function($query) {
            $query->whereHas('rentals', function($q) {
                $q->where('status', 'active')
                  ->orWhere('status', 'booked');
            })
            ->orWhereHas('orders', function($q) {
                $q->where('status', 'Active');
            });
        });
        
        $availableQuery = Vehicle::where('is_active', true)
            ->whereDoesntHave('rentals', function($query) {
                $query->where('status', 'active')
                      ->orWhere('status', 'booked');
            })
            ->whereDoesntHave('orders', function($query) {
                $query->where('status', 'Active');
            });
        
        if ($locationId) {
            $bookedQuery->where('location_id', $locationId);
            $availableQuery->where('location_id', $locationId);
        }
        
        $bookedVehicles = $bookedQuery->count();
        $availableVehicles = $availableQuery->count();
        $totalFleet = $bookedVehicles + $availableVehicles;
        
        // Get locations for filter dropdown
        $locations = Location::active()->get();
        $selectedLocation = $locationId;
        
        return view('dashboard.main', compact(
            'stnkMonitoring',
            'kirMonitoring',
            'bookedVehicles',
            'availableVehicles',
            'totalFleet',
            'locationStats',
            'locations',
            'selectedLocation'
        ));
    }

    private function getFuelExpensesChartData()
    {
        $months = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $monthlyExpense = FuelFill::whereYear('fill_date', $date->year)
                ->whereMonth('fill_date', $date->month)
                ->sum('total_cost');
                
            $data[] = $monthlyExpense;
        }

        return [
            'labels' => $months,
            'data' => $data
        ];
    }
}
