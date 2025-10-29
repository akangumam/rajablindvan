@extends('layouts.drivvo')

@section('title', 'Customer Report')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-users text-primary me-2"></i>
                    Report Customer
                </h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.customers.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>Export Excel
                    </a>
                    <a href="{{ route('reports.customers.pdf', request()->query()) }}" 
                       class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
                    </a>
                    <a href="{{ route('reports.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.customers') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Date Start</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Date End</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-4">
                            <label for="filter-btn" class="form-label">&nbsp;</label>
                            <button type="submit" id="filter-btn" class="btn btn-primary d-block">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Performance Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance Customer</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Customer</th>
                                    <th>Total Rental</th>
                                    <th>Rental End</th>
                                    <th>Total Spent</th>
                                    <th>Average Rental Value</th>
                                    <th>Total Rental Days</th>
                                    <th>Last Rental</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customerStats as $stat)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $stat['customer']->name }}</div>
                                        <small class="text-muted">{{ $stat['customer']->phone }}</small><br>
                                        @if($stat['customer']->Email)
                                            <small class="text-muted">{{ $stat['customer']->Email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $stat['total_rentals'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $stat['completed_rentals'] }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">
                                            Rp {{ number_format($stat['total_spent'], 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-info">
                                            Rp {{ number_format($stat['average_rental_value'], 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $stat['total_days_rented'] }} days</span>
                                    </td>
                                    <td>
                                        @if($stat['last_rental_date'])
                                            {{ \Carbon\Carbon::parse($stat['last_rental_date'])->format('d M Y') }}
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($stat['last_rental_date'])->diffForHumans() }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-users fa-3x mb-3"></i><br>
                                        No data available customer ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Summary -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Customer</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $customerStats->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Customer Active</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $customerStats->filter(function($stat) { return $stat['total_rentals'] > 0; })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold">
                                Rp {{ number_format($customerStats->sum('total_spent'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Average Spent</div>
                            <div class="h5 mb-0 font-weight-bold">
                                Rp {{ number_format($customerStats->where('total_spent', '>', 0)->avg('total_spent'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 Customer</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($customerStats->take(10) as $index => $stat)
                        <div class="col-xl-6 col-lg-6 mb-3">
                            <div class="card border-left-{{ $index < 3 ? 'success' : 'primary' }} shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="fw-bold">
                                                #{{ $index + 1 }} {{ $stat['customer']->name }}
                                            </div>
                                            <div class="text-muted small">{{ $stat['customer']->phone }}</div>
                                            <div class="text-success fw-bold">
                                                Rp {{ number_format($stat['total_spent'], 0, ',', '.') }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $stat['total_rentals'] }} rental • {{ $stat['total_days_rented'] }} hari
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            @if($index == 0)
                                                <i class="fas fa-trophy fa-2x text-warning"></i>
                                            @elseif($index == 1)
                                                <i class="fas fa-medal fa-2x text-muted"></i>
                                            @elseif($index == 2)
                                                <i class="fas fa-award fa-2x text-warning"></i>
                                            @else
                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
</style>
@endsection



























