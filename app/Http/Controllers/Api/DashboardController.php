<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Order;
use App\Models\Rental;
use App\Models\Maintenance;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics - fully defensive, never crashes
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $locationId = $user->isAdmin() ? null : $user->location_id;

            // ── Vehicle counts ──────────────────────────────────────────
            $totalVehicles     = $this->safeCount(fn() => $this->vehicleBase($locationId)->count());
            $rentedVehicles    = $this->safeCount(fn() => $this->vehicleBase($locationId)
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereHas('rentals', fn($r) => $r->whereIn('status', ['active', 'Active', 'ACTIVE', 'booked', 'Booked', 'BOOKED']))
                      ->orWhereHas('orders',  fn($o) => $o->whereIn('status', ['active', 'Active', 'ACTIVE']));
                })->count());

            $availableVehicles = $this->safeCount(fn() => $this->vehicleBase($locationId)
                ->where('is_active', true)
                ->whereDoesntHave('rentals', fn($r) => $r->whereIn('status', ['active', 'Active', 'ACTIVE', 'booked', 'Booked', 'BOOKED']))
                ->whereDoesntHave('orders',  fn($o) => $o->whereIn('status', ['active', 'Active', 'ACTIVE']))
                ->count());

            $maintenanceVehicles = $this->safeCount(fn() => $this->vehicleBase($locationId)
                ->where('status', 'maintenance')->count());

            // ── Rental counts ───────────────────────────────────────────
            $activeRentals = $this->safeCount(fn() => $this->rentalBase($locationId)
                ->whereIn('status', ['active', 'Active', 'ACTIVE'])->count());

            $overdueRentals = $this->safeCount(fn() => $this->rentalBase($locationId)
                ->whereIn('status', ['active', 'Active', 'ACTIVE'])
                ->whereDate('end_date', '<', Carbon::now())
                ->count());

            // ── Financial ───────────────────────────────────────────────
            // Rental revenue uses 'total_amount' column (verified from Rental model)
            $monthlyRevenue = $this->safeSum(fn() => $this->rentalBase($locationId)
                ->whereIn('status', ['completed', 'Completed', 'COMPLETED'])
                ->whereYear('start_date',  Carbon::now()->year)
                ->whereMonth('start_date', Carbon::now()->month)
                ->sum('total_amount'));

            // Expense uses 'expense_date' + 'amount' columns (verified from Expense model)
            $monthlyExpenses = $this->safeSum(fn() => $this->expenseBase($locationId)
                ->whereYear('expense_date',  Carbon::now()->year)
                ->whereMonth('expense_date', Carbon::now()->month)
                ->sum('amount'));

            $netIncome = $monthlyRevenue - $monthlyExpenses;

            // ── Upcoming maintenance ────────────────────────────────────
            // Maintenance uses 'service_date' + 'status' columns (verified from Maintenance model)
            $upcomingMaintenance = $this->safeCount(fn() => Maintenance::query()
                ->when($locationId, fn($q) => $q->whereHas('vehicle', fn($v) => $v->where('location_id', $locationId)))
                ->whereIn('status', ['pending', 'Pending', 'Scheduled', 'scheduled'])
                ->whereNotNull('service_date')
                ->whereDate('service_date', '>=', Carbon::now())
                ->whereDate('service_date', '<=', Carbon::now()->addDays(7))
                ->count());

            // ── STNK / KIR / GPS overdue ────────────────────────────────
            $stnkOverdue = $this->safeCount(fn() => $this->freshVehicleBase($locationId)
                ->whereNotNull('stnk_expiry_date')
                ->whereDate('stnk_expiry_date', '<=', Carbon::now()->addDays(30))
                ->count());

            $kirOverdue = $this->safeCount(fn() => $this->freshVehicleBase($locationId)
                ->whereNotNull('kir_expiry_date')
                ->whereDate('kir_expiry_date', '<=', Carbon::now()->addDays(30))
                ->count());

            $gpsOverdue = $this->safeCount(fn() => $this->freshVehicleBase($locationId)
                ->whereNotNull('gps_expiry_date')
                ->whereDate('gps_expiry_date', '<=', Carbon::now()->addDays(7))
                ->count());

            // ── Recent activities ───────────────────────────────────────
            $recentActivities = $this->safeActivities($locationId);

            // ── Location stats (admin only) ─────────────────────────────
            $locationStats = null;
            if ($user->isAdmin()) {
                try {
                    $locationStats = Vehicle::select('location_id', DB::raw('count(*) as total'))
                        ->with('location:id,name')
                        ->groupBy('location_id')
                        ->get()
                        ->map(fn($item) => [
                            'location'       => $item->location?->name ?? 'N/A',
                            'total_vehicles' => $item->total,
                        ]);
                } catch (\Throwable $e) {
                    Log::error('Dashboard locationStats error: ' . $e->getMessage());
                    $locationStats = [];
                }
            }

            return response()->json([
                'success' => true,
                'data'    => [
                    'vehicles' => [
                        'total'       => $totalVehicles,
                        'available'   => $availableVehicles,
                        'rented'      => $rentedVehicles,
                        'maintenance' => $maintenanceVehicles,
                    ],
                    'rentals' => [
                        'active'  => $activeRentals,
                        'overdue' => $overdueRentals,
                    ],
                    'financial' => [
                        'monthly_revenue'  => (float) $monthlyRevenue,
                        'monthly_expenses' => (float) $monthlyExpenses,
                        'net_income'       => (float) $netIncome,
                    ],
                    'alerts' => [
                        'upcoming_maintenance' => $upcomingMaintenance,
                        'overdue_rentals'      => $overdueRentals,
                        'stnk_overdue'         => $stnkOverdue,
                        'kir_overdue'          => $kirOverdue,
                        'gps_overdue'          => $gpsOverdue,
                    ],
                    'location_stats'    => $locationStats,
                    'recent_activities' => $recentActivities,
                ],
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Dashboard index fatal error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Dashboard error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Monthly revenue chart (last 6 months)
     */
    public function monthlyRevenue(Request $request)
    {
        try {
            $user       = $request->user();
            $locationId = $user->isAdmin() ? null : $user->location_id;

            $months   = [];
            $revenues = [];

            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);

                $revenue = $this->safeSum(fn() => Rental::query()
                    ->when($locationId, fn($q) => $q->whereHas('vehicle', fn($v) => $v->where('location_id', $locationId)))
                    ->whereIn('status', ['completed', 'Completed', 'COMPLETED'])
                    ->whereYear('start_date',  $date->year)
                    ->whereMonth('start_date', $date->month)
                    ->sum('total_amount'));

                $months[]   = $date->format('M Y');
                $revenues[] = (float) $revenue;
            }

            return response()->json([
                'success' => true,
                'data'    => [
                    'labels' => $months,
                    'values' => $revenues,
                ],
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Dashboard monthlyRevenue error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ── Private helpers ──────────────────────────────────────────────────

    private function vehicleBase($locationId)
    {
        $q = Vehicle::query();
        if ($locationId) {
            $q->where('location_id', $locationId);
        }
        return $q;
    }

    private function freshVehicleBase($locationId)
    {
        return $this->vehicleBase($locationId);
    }

    private function rentalBase($locationId)
    {
        $q = Rental::query();
        if ($locationId) {
            $q->whereHas('vehicle', fn($v) => $v->where('location_id', $locationId));
        }
        return $q;
    }

    private function expenseBase($locationId)
    {
        $q = Expense::query();
        if ($locationId) {
            $q->where('location_id', $locationId);
        }
        return $q;
    }

    private function safeCount(callable $fn): int
    {
        try {
            return (int) $fn();
        } catch (\Throwable $e) {
            Log::warning('Dashboard safeCount error: ' . $e->getMessage());
            return 0;
        }
    }

    private function safeSum(callable $fn): float
    {
        try {
            return (float) $fn();
        } catch (\Throwable $e) {
            Log::warning('Dashboard safeSum error: ' . $e->getMessage());
            return 0.0;
        }
    }

    private function safeActivities($locationId): array
    {
        try {
            $activities = collect();

            $recentRentals = Rental::query()
                ->with(['vehicle:id,brand,model,license_plate', 'customer:id,name'])
                ->when($locationId, fn($q) => $q->whereHas('vehicle', fn($v) => $v->where('location_id', $locationId)))
                ->latest()
                ->take(5)
                ->get()
                ->map(fn($r) => [
                    'type'        => 'rental',
                    'title'       => 'Rental Created',
                    'description' => trim("{$r->customer?->name} rented {$r->vehicle?->brand} {$r->vehicle?->model}"),
                    'vehicle'     => $r->vehicle?->license_plate ?? '-',
                    'time'        => $r->created_at->diffForHumans(),
                    'timestamp'   => $r->created_at->toIso8601String(),
                ]);

            $recentMaintenance = Maintenance::query()
                ->with(['vehicle:id,brand,model,license_plate'])
                ->when($locationId, fn($q) => $q->whereHas('vehicle', fn($v) => $v->where('location_id', $locationId)))
                ->latest()
                ->take(5)
                ->get()
                ->map(fn($m) => [
                    'type'        => 'maintenance',
                    'title'       => 'Maintenance Scheduled',
                    'description' => trim("{$m->vehicle?->brand} {$m->vehicle?->model} - {$m->type}"),
                    'vehicle'     => $m->vehicle?->license_plate ?? '-',
                    'time'        => $m->created_at->diffForHumans(),
                    'timestamp'   => $m->created_at->toIso8601String(),
                ]);

            return $activities
                ->merge($recentRentals)
                ->merge($recentMaintenance)
                ->sortByDesc('timestamp')
                ->take(10)
                ->values()
                ->toArray();

        } catch (\Throwable $e) {
            Log::warning('Dashboard safeActivities error: ' . $e->getMessage());
            return [];
        }
    }
}
