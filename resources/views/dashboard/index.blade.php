@extends('layouts.drivvo')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ __('common.dashboard') }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-plus-circle me-1"></i>
                {{ __('common.add_data') }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('vehicles.create') }}">
                    <i class="bi bi-car-front me-2"></i>{{ __('common.new_vehicle') }}
                </a></li>
                <li><a class="dropdown-item" href="{{ route('fuel-fills.create') }}">
                    <i class="bi bi-fuel-pump me-2"></i>{{ __('common.fuel_refill') }}
                </a></li>
                <li><a class="dropdown-item" href="{{ route('maintenances.create') }}">
                    <i class="bi bi-tools me-2"></i>{{ __('common.service_maintenance') }}
                </a></li>
                <li><a class="dropdown-item" href="{{ route('expenses.create') }}">
                    <i class="bi bi-wallet2 me-2"></i>{{ __('common.expense') }}
                </a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-uppercase fw-bold small mb-1">{{ __('common.total_vehicles') }}</div>
                        <div class="h5 mb-0 fw-bold">{{ $totalVehicles }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-car-front fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card fuel h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-uppercase fw-bold small mb-1">{{ __('common.cost_this_month') }}</div>
                        <div class="h5 mb-0 fw-bold">Rp {{ number_format($totalExpensesThisMonth, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-wallet2 fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card maintenance h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-uppercase fw-bold small mb-1">{{ __('common.cost_this_year') }}</div>
                        <div class="h5 mb-0 fw-bold">Rp {{ number_format($totalExpensesThisYear, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-graph-up fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card expenses h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-uppercase fw-bold small mb-1">{{ __('common.pending_service') }}</div>
                        <div class="h5 mb-0 fw-bold">
                            {{ $overdueMaintenances + $upcomingMaintenances }}
                            @if($overdueMaintenances > 0)
                                <small class="text-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </small>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tools fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h6 class="m-0 fw-bold">{{ __('common.fuel_cost_6_months') }}</h6>
            </div>
            <div class="card-body">
                <canvas id="fuelExpensesChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming Maintenances -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold">{{ __('common.upcoming_service') }}</h6>
                <a href="{{ route('maintenances.index') }}" class="btn btn-sm btn-outline-primary">
                    {{ __('common.view_all') }}
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingMaintenancesList as $maintenance)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div class="badge bg-warning text-dark">
                                {{ $maintenance->daysUntilDue() }} {{ __('common.days') }}
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold small">{{ $maintenance->vehicle->name }}</div>
                            <div class="text-muted small">{{ $maintenance->type }}</div>
                            <div class="text-muted small">
                                {{ $maintenance->next_maintenance_date->format($appDateFormat) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        <i class="bi bi-check-circle display-6"></i>
                        <p class="mt-2 mb-0">{{ __('common.no_upcoming_service') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <!-- Recent Fuel Fills -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold">{{ __('common.last_fuel_fill') }}</h6>
                <a href="{{ route('fuel-fills.index') }}" class="btn btn-sm btn-outline-primary">
                    {{ __('common.view_all') }}
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($recentFuelFills as $fuel)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="flex-shrink-0">
                            <i class="bi bi-fuel-pump text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold small">{{ $fuel->vehicle->name }}</div>
                            <div class="text-muted small">
                                {{ $fuel->liters }}L - Rp {{ number_format($fuel->total_cost, 0, ',', '.') }}
                            </div>
                            <div class="text-muted small">{{ $fuel->fill_date->format($appDateFormat) }}</div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        <p class="mb-0">{{ __('common.no_fuel_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Maintenances -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold">{{ __('common.last_service') }}</h6>
                <a href="{{ route('maintenances.index') }}" class="btn btn-sm btn-outline-primary">
                    {{ __('common.view_all') }}
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($recentMaintenances as $maintenance)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="flex-shrink-0">
                            <i class="bi bi-tools text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold small">{{ $maintenance->vehicle->name }}</div>
                            <div class="text-muted small">
                                {{ $maintenance->type }} - Rp {{ number_format($maintenance->cost, 0, ',', '.') }}
                            </div>
                            <div class="text-muted small">{{ $maintenance->maintenance_date->format($appDateFormat) }}</div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        <p class="mb-0">{{ __('common.no_service_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold">{{ __('common.last_expense') }}</h6>
                <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-outline-primary">
                    {{ __('common.view_all') }}
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($recentExpenses as $expense)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div class="flex-shrink-0">
                            <i class="bi bi-wallet2 text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold small">{{ $expense->vehicle->name }}</div>
                            <div class="text-muted small">
                                {{ $expense->category_label }} - Rp {{ number_format($expense->amount, 0, ',', '.') }}
                            </div>
                            <div class="text-muted small">{{ $expense->expense_date->format($appDateFormat) }}</div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        <p class="mb-0">{{ __('common.no_expense_data') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Summary -->
@if($vehicleSummary->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="m-0 fw-bold">Ringkasan Vehicle</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Latest Odometer</th>
                                <th>{{ __('common.total_expense') }}</th>
                                <th>Average Consumption</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicleSummary as $summary)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $summary['vehicle']->name }}</div>
                                        <small class="text-muted">{{ $summary['vehicle']->full_name }}</small>
                                    </td>
                                    <td>{{ number_format($summary['latest_odometer'], 0, ',', '.') }} km</td>
                                    <td>Rp {{ number_format($summary['total_expenses'], 0, ',', '.') }}</td>
                                    <td>
                                        @if($summary['avg_fuel_efficiency'] > 0)
                                            {{ number_format($summary['avg_fuel_efficiency'], 1) }} km/L
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('vehicles.show', $summary['vehicle']) }}"
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('fuel-fills.create-for-vehicle', $summary['vehicle']) }}"
                                               class="btn btn-outline-success">
                                                <i class="bi bi-fuel-pump"></i>
                                            </a>
                                            <a href="{{ route('maintenances.create-for-vehicle', $summary['vehicle']) }}"
                                               class="btn btn-outline-warning">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fuel Expenses Chart
    const ctx = document.getElementById('fuelExpensesChart').getContext('2d');
    const fuelExpensesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($fuelExpensesChart['labels']),
            datasets: [{
                label: '{{ __('common.fuel_cost') }}',
                data: @json($fuelExpensesChart['data']),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush































