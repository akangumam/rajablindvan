<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Temporarily allow access without login for testing
        $user = auth()->user();
        
        // Get current month data
        $currentMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        
        // Get selected vehicle from request parameter
        $selectedVehicleId = $request->get('vehicle_id');
        
        // Get all active vehicles for dropdown (filtered by user type if logged in)
        if ($user && $user->isPengelola()) {
            $allVehicles = Vehicle::where('is_active', true)
                ->orderBy('brand')
                ->orderBy('model')
                ->get();
        } elseif ($user && $user->isSopir()) {
            $allVehicles = $user->vehicles()
                ->where('is_active', true)
                ->orderBy('brand')
                ->orderBy('model')
                ->get();
        } else {
            // Not logged in or no user_type - show all vehicles
            $allVehicles = Vehicle::where('is_active', true)
                ->orderBy('brand')
                ->orderBy('model')
                ->get();
        }
        
        // Get vehicle IDs accessible to current user
        $accessibleVehicleIds = [];
        if ($user && $user->isSopir()) {
            $accessibleVehicleIds = $user->vehicles()->pluck('vehicles.id')->toArray();
        }
            
        // Get active/selected vehicle first to determine filter
        if ($selectedVehicleId) {
            $vehicleQuery = Vehicle::where('is_active', true)
                ->where('id', $selectedVehicleId);
            
            // Sopir can only access their assigned vehicles
            if ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
                $vehicleQuery->whereIn('id', $accessibleVehicleIds);
            }
            
            $activeVehicle = $vehicleQuery->first();
        }
        
        // If no specific vehicle selected, get most used vehicle
        if (!isset($activeVehicle) || !$activeVehicle) {
            $vehicleQuery = Vehicle::where('is_active', true)
                ->withCount('rentals')
                ->orderByDesc('rentals_count');
            
            // Sopir can only access their assigned vehicles
            if ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
                $vehicleQuery->whereIn('id', $accessibleVehicleIds);
            }
            
            $activeVehicle = $vehicleQuery->first();
        }
            
        // If still no vehicle found, get first available
        if (!$activeVehicle) {
            $vehicleQuery = Vehicle::where('is_active', true);
            
            // Sopir can only access their assigned vehicles
            if ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
                $vehicleQuery->whereIn('id', $accessibleVehicleIds);
            }
            
            $activeVehicle = $vehicleQuery->first();
        }
        
        // Financial Summary - Current Month (filtered by selected vehicle and user access)
        $incomeQuery = \App\Models\Rental::whereBetween('start_date', [$currentMonth, $endMonth])
            ->where('status', 'completed');
        
        if ($activeVehicle) {
            $incomeQuery->where('vehicle_id', $activeVehicle->id);
        } elseif ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
            $incomeQuery->whereIn('vehicle_id', $accessibleVehicleIds);
        }
        
        $totalIncome = $incomeQuery->sum('total_cost');
        
        $expenseQuery = Expense::whereBetween('expense_date', [$currentMonth, $endMonth]);
        
        if ($activeVehicle) {
            $expenseQuery->where('vehicle_id', $activeVehicle->id);
        } elseif ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
            $expenseQuery->whereIn('vehicle_id', $accessibleVehicleIds);
        }
        
        $totalExpenses = $expenseQuery->sum('amount');
        
        $fuelQuery = FuelFill::whereBetween('fill_date', [$currentMonth, $endMonth]);
        
        if ($activeVehicle) {
            $fuelQuery->where('vehicle_id', $activeVehicle->id);
        } elseif ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
            $fuelQuery->whereIn('vehicle_id', $accessibleVehicleIds);
        }
        
        $fuelExpenses = $fuelQuery->sum('total_cost');
        
        $maintenanceQuery = \App\Models\Maintenance::whereBetween('service_date', [$currentMonth, $endMonth]);
        
        if ($activeVehicle) {
            $maintenanceQuery->where('vehicle_id', $activeVehicle->id);
        } elseif ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
            $maintenanceQuery->whereIn('vehicle_id', $accessibleVehicleIds);
        }
        
        $maintenanceExpenses = $maintenanceQuery->sum('cost');
        
        $totalCosts = $totalExpenses + $fuelExpenses + $maintenanceExpenses;
        
        // Breakdown percentages
        $fuelPercentage = $totalCosts > 0 ? round(($fuelExpenses / $totalCosts) * 100) : 0;
        $maintenancePercentage = $totalCosts > 0 ? round(($maintenanceExpenses / $totalCosts) * 100) : 0;
        $expensePercentage = $totalCosts > 0 ? round(($totalExpenses / $totalCosts) * 100) : 0;
        
        // Vehicle stats (filtered by user access)
        if ($user && $user->isPengelola()) {
            $totalVehicles = Vehicle::where('is_active', true)->count();
            
            $availableVehicles = Vehicle::where('is_active', true)
                ->whereNotIn('id', function($query) {
                    $query->select('vehicle_id')
                        ->from('rentals')
                        ->where('status', 'active');
                })->count();
        } elseif ($user && $user->isSopir()) {
            $totalVehicles = $user->vehicles()->where('is_active', true)->count();
            
            $availableVehicles = $user->vehicles()
                ->where('is_active', true)
                ->whereNotIn('vehicles.id', function($query) {
                    $query->select('vehicle_id')
                        ->from('rentals')
                        ->where('status', 'active');
                })->count();
        } else {
            $totalVehicles = Vehicle::where('is_active', true)->count();
            
            $availableVehicles = Vehicle::where('is_active', true)
                ->whereNotIn('id', function($query) {
                    $query->select('vehicle_id')
                        ->from('rentals')
                        ->where('status', 'active');
                })->count();
        }
        
        $activeRentalsQuery = \App\Models\Rental::where('status', 'active');
        
        if ($activeVehicle) {
            $activeRentalsQuery->where('vehicle_id', $activeVehicle->id);
        } elseif ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
            $activeRentalsQuery->whereIn('vehicle_id', $accessibleVehicleIds);
        }
        
        $activeRentals = $activeRentalsQuery->count();
        
        // Recent activities for selected vehicle (last 5)
        $recentRentalsQuery = \App\Models\Rental::with(['vehicle', 'customer']);
        
        if ($activeVehicle) {
            $recentRentalsQuery->where('vehicle_id', $activeVehicle->id);
        } elseif ($user && $user->isSopir() && !empty($accessibleVehicleIds)) {
            $recentRentalsQuery->whereIn('vehicle_id', $accessibleVehicleIds);
        }
        
        $recentRentals = $recentRentalsQuery->latest()
            ->take(5)
            ->get();
            
        $recentExpenses = collect()
            ->merge(Expense::with('vehicle')
                ->when($activeVehicle, function($query) use ($activeVehicle) {
                    return $query->where('vehicle_id', $activeVehicle->id);
                })
                ->when(!$activeVehicle && $user && $user->isSopir() && !empty($accessibleVehicleIds), function($query) use ($accessibleVehicleIds) {
                    return $query->whereIn('vehicle_id', $accessibleVehicleIds);
                })
                ->latest()
                ->take(3)
                ->get()
                ->map(function($item) {
                    return [
                        'type' => 'expense',
                        'description' => $item->description,
                        'amount' => $item->amount,
                        'date' => $item->expense_date,
                        'vehicle' => $item->vehicle->license_plate ?? '-'
                    ];
                }))
            ->merge(FuelFill::with('vehicle')
                ->when($activeVehicle, function($query) use ($activeVehicle) {
                    return $query->where('vehicle_id', $activeVehicle->id);
                })
                ->when(!$activeVehicle && $user && $user->isSopir() && !empty($accessibleVehicleIds), function($query) use ($accessibleVehicleIds) {
                    return $query->whereIn('vehicle_id', $accessibleVehicleIds);
                })
                ->latest()
                ->take(2)
                ->get()
                ->map(function($item) {
                    return [
                        'type' => 'fuel',
                        'description' => 'Pengisian ' . $item->fuel_type,
                        'amount' => $item->total_cost,
                        'date' => $item->fill_date,
                        'vehicle' => $item->vehicle->license_plate ?? '-'
                    ];
                }))
            ->sortByDesc('date')
            ->take(5);

        return view('dashboard.main', compact(
            'totalIncome',
            'totalCosts',
            'fuelExpenses',
            'maintenanceExpenses',
            'totalExpenses',
            'fuelPercentage',
            'maintenancePercentage',
            'expensePercentage',
            'totalVehicles',
            'availableVehicles',
            'activeRentals',
            'recentRentals',
            'recentExpenses',
            'activeVehicle',
            'allVehicles'
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
