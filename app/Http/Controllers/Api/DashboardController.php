<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\FuelFill;
use App\Models\Maintenance;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $locationId = $user->isAdmin() ? null : $user->location_id;

        // Base queries with location filter
        $vehiclesQuery = Vehicle::query();
        $rentalsQuery = Rental::query();
        $expensesQuery = Expense::query();

        if ($locationId) {
            $vehiclesQuery->where('location_id', $locationId);
            $rentalsQuery->whereHas('vehicle', function ($q) use ($locationId) {
                $q->where('location_id', $locationId);
            });
            $expensesQuery->where('location_id', $locationId);
        }

        // Get statistics
        $totalVehicles = $vehiclesQuery->count();
        $availableVehicles = $vehiclesQuery->where('status', 'available')->count();
        $rentedVehicles = $vehiclesQuery->where('status', 'rented')->count();
        $maintenanceVehicles = $vehiclesQuery->where('status', 'maintenance')->count();

        // Active rentals
        $activeRentals = $rentalsQuery->whereIn('status', ['active', 'ongoing'])->count();

        // Monthly revenue (current month)
        $currentMonth = Carbon::now()->format('Y-m');
        $monthlyRevenue = $rentalsQuery
            ->where('status', 'completed')
            ->whereRaw("DATE_FORMAT(start_date, '%Y-%m') = ?", [$currentMonth])
            ->sum('total_price');

        // Monthly expenses
        $monthlyExpenses = $expensesQuery
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount');

        // Net income
        $netIncome = $monthlyRevenue - $monthlyExpenses;

        // Upcoming maintenance
        $upcomingMaintenance = Maintenance::query()
            ->whereHas('vehicle', function ($q) use ($locationId) {
                if ($locationId) {
                    $q->where('location_id', $locationId);
                }
            })
            ->where('status', 'pending')
            ->whereDate('due_date', '>=', Carbon::now())
            ->whereDate('due_date', '<=', Carbon::now()->addDays(7))
            ->count();

        // Overdue rentals
        $overdueRentals = $rentalsQuery
            ->where('status', 'active')
            ->whereDate('end_date', '<', Carbon::now())
            ->count();

        // Recent activities (last 10)
        $recentActivities = $this->getRecentActivities($user, $locationId);

        // Location breakdown (for admin only)
        $locationStats = null;
        if ($user->isAdmin()) {
            $locationStats = Vehicle::select('location_id', DB::raw('count(*) as total'))
                ->with('location:id,name')
                ->groupBy('location_id')
                ->get()
                ->map(function ($item) {
                    return [
                        'location' => $item->location ? $item->location->name : 'N/A',
                        'total_vehicles' => $item->total,
                    ];
                });
        }

        return response()->json([
            'success' => true,
            'data' => [
                'vehicles' => [
                    'total' => $totalVehicles,
                    'available' => $availableVehicles,
                    'rented' => $rentedVehicles,
                    'maintenance' => $maintenanceVehicles,
                ],
                'rentals' => [
                    'active' => $activeRentals,
                    'overdue' => $overdueRentals,
                ],
                'financial' => [
                    'monthly_revenue' => (float) $monthlyRevenue,
                    'monthly_expenses' => (float) $monthlyExpenses,
                    'net_income' => (float) $netIncome,
                ],
                'alerts' => [
                    'upcoming_maintenance' => $upcomingMaintenance,
                    'overdue_rentals' => $overdueRentals,
                ],
                'location_stats' => $locationStats,
                'recent_activities' => $recentActivities,
            ],
        ], 200);
    }

    /**
     * Get monthly revenue chart data (last 6 months)
     */
    public function monthlyRevenue(Request $request)
    {
        $user = $request->user();
        $locationId = $user->isAdmin() ? null : $user->location_id;

        $months = [];
        $revenues = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('Y-m');
            
            $query = Rental::where('status', 'completed')
                ->whereRaw("DATE_FORMAT(start_date, '%Y-%m') = ?", [$monthYear]);

            if ($locationId) {
                $query->whereHas('vehicle', function ($q) use ($locationId) {
                    $q->where('location_id', $locationId);
                });
            }

            $revenue = $query->sum('total_price');

            $months[] = $date->format('M Y');
            $revenues[] = (float) $revenue;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $months,
                'values' => $revenues,
            ],
        ], 200);
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities($user, $locationId)
    {
        $activities = collect();

        // Recent rentals
        $recentRentals = Rental::query()
            ->with(['vehicle:id,brand,model,license_plate', 'customer:id,name'])
            ->when($locationId, function ($q) use ($locationId) {
                $q->whereHas('vehicle', function ($query) use ($locationId) {
                    $query->where('location_id', $locationId);
                });
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($rental) {
                return [
                    'type' => 'rental',
                    'title' => 'Rental Created',
                    'description' => "{$rental->customer->name} rented {$rental->vehicle->brand} {$rental->vehicle->model}",
                    'vehicle' => $rental->vehicle->license_plate,
                    'time' => $rental->created_at->diffForHumans(),
                    'timestamp' => $rental->created_at->toIso8601String(),
                ];
            });

        // Recent maintenance
        $recentMaintenance = Maintenance::query()
            ->with(['vehicle:id,brand,model,license_plate'])
            ->when($locationId, function ($q) use ($locationId) {
                $q->whereHas('vehicle', function ($query) use ($locationId) {
                    $query->where('location_id', $locationId);
                });
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($maintenance) {
                return [
                    'type' => 'maintenance',
                    'title' => 'Maintenance Scheduled',
                    'description' => "{$maintenance->vehicle->brand} {$maintenance->vehicle->model} - {$maintenance->type}",
                    'vehicle' => $maintenance->vehicle->license_plate,
                    'time' => $maintenance->created_at->diffForHumans(),
                    'timestamp' => $maintenance->created_at->toIso8601String(),
                ];
            });

        $activities = $activities->merge($recentRentals)->merge($recentMaintenance);
        
        return $activities->sortByDesc('timestamp')->take(10)->values();
    }
}
