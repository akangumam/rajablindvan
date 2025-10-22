<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Expense;
use Carbon\Carbon;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::active()->withCount([
            'vehicles',
            'rentals' => function($query) {
                $query->where('status', 'active');
            }
        ])->get();

        // Add performance metrics for each location
        $locations->each(function($location) {
            $location->monthly_revenue = $location->getMonthlyRevenue(date('n'), date('Y'));
            $location->monthly_expenses = $location->getMonthlyExpenses(date('n'), date('Y'));
            $location->monthly_profit = $location->monthly_revenue - $location->monthly_expenses;
            $location->available_vehicles = $location->getAvailableVehiclesCount();
        });

        return view('locations.index', compact('locations'));
    }

    public function show(Location $location)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();

        // Location specific statistics
        $stats = [
            'total_vehicles' => $location->vehicles()->count(),
            'available_vehicles' => $location->getAvailableVehiclesCount(),
            'active_rentals' => $location->rentals()->where('status', 'active')->count(),
            'monthly_revenue' => $location->getMonthlyRevenue(date('n'), date('Y')),
            'monthly_expenses' => $location->getMonthlyExpenses(date('n'), date('Y')),
        ];

        $stats['monthly_profit'] = $stats['monthly_revenue'] - $stats['monthly_expenses'];
        $stats['utilization_rate'] = $stats['total_vehicles'] > 0 
            ? round((($stats['total_vehicles'] - $stats['available_vehicles']) / $stats['total_vehicles']) * 100, 1)
            : 0;

        // Recent activities
        $recentRentals = $location->rentals()
            ->with(['vehicle', 'customer'])
            ->latest()
            ->take(10)
            ->get();

        $recentExpenses = $location->expenses()
            ->with('vehicle')
            ->latest()
            ->take(10)
            ->get();

        // Charts data
        $dailyRevenue = $location->rentals()
            ->where('status', 'completed')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->selectRaw('DATE(start_date) as date, SUM(total_cost) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('locations.show', compact(
            'location', 'stats', 'recentRentals', 'recentExpenses', 'dailyRevenue'
        ));
    }

    public function compare()
    {
        $locations = Location::active()->get();
        $currentMonth = date('n');
        $currentYear = date('Y');

        $comparison = $locations->map(function($location) use ($currentMonth, $currentYear) {
            return [
                'location' => $location,
                'vehicles_count' => $location->vehicles()->count(),
                'available_vehicles' => $location->getAvailableVehiclesCount(),
                'active_rentals' => $location->rentals()->where('status', 'active')->count(),
                'monthly_revenue' => $location->getMonthlyRevenue($currentMonth, $currentYear),
                'monthly_expenses' => $location->getMonthlyExpenses($currentMonth, $currentYear),
                'monthly_profit' => $location->getMonthlyRevenue($currentMonth, $currentYear) - 
                                 $location->getMonthlyExpenses($currentMonth, $currentYear),
                'utilization_rate' => $location->vehicles()->count() > 0 
                    ? round((($location->vehicles()->count() - $location->getAvailableVehiclesCount()) / $location->vehicles()->count()) * 100, 1)
                    : 0,
            ];
        });

        return view('locations.compare', compact('comparison'));
    }
}