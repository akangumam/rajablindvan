@extends('layouts.drivvo')

@section('title', 'Investor Report: ' . $investor->name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-user-tie"></i> {{ $investor->name }}
        </h1>
        <p class="page-subtitle">Investor Financial Report</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('settings.investors.report', $investor) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
           class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        <a href="{{ route('settings.investors.edit', $investor) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('settings.investors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Investor Info Card -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Investor Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold" style="width: 150px;">Name:</td>
                        <td>{{ $investor->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Email:</td>
                        <td>{{ $investor->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Phone:</td>
                        <td>{{ $investor->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">ID Number:</td>
                        <td>{{ $investor->id_number ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold" style="width: 180px;">Profit Share:</td>
                        <td><span class="badge bg-success fs-6">{{ $investor->investment_percentage }}%</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status:</td>
                        <td>
                            @if($investor->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Total Vehicles:</td>
                        <td><span class="badge bg-info">{{ $investor->vehicles->count() }} Units</span></td>
                    </tr>
                </table>
            </div>
        </div>
        @if($investor->address)
            <div class="mt-2">
                <strong>Address:</strong> {{ $investor->address }}
            </div>
        @endif
        @if($investor->notes)
            <div class="mt-2">
                <strong>Notes:</strong> {{ $investor->notes }}
            </div>
        @endif
    </div>
</div>

<!-- Filter Date Range -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('settings.investors.show', $investor) }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('settings.investors.show', $investor) }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Financial Summary -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Total Income</h6>
                <h3>Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                <small>From {{ $rentals->count() }} rentals</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-title">Total Expenses</h6>
                <h3>Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h3>
                <small>Fuel, Service, Others</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Net Profit</h6>
                <h3>Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
                <small>Income - Expenses</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-title">Investor Share ({{ $investor->investment_percentage }}%)</h6>
                <h3>Rp {{ number_format($investorShare, 0, ',', '.') }}</h3>
                <small>From net profit</small>
            </div>
        </div>
    </div>
</div>

<!-- Vehicles List -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-car"></i> Vehicles List</h5>
    </div>
    <div class="card-body">
        @if($investor->vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Vehicle Name</th>
                            <th>License Plate</th>
                            <th>Brand</th>
                            <th>Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investor->vehicles as $vehicle)
                            <tr>
                                <td>
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="text-decoration-none">
                                        {{ $vehicle->name }}
                                    </a>
                                </td>
                                <td><strong>{{ $vehicle->license_plate }}</strong></td>
                                <td>{{ $vehicle->brand }}</td>
                                <td>{{ $vehicle->year }}</td>
                                <td>
                                    @if($vehicle->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center py-4">No vehicles for this investor yet</p>
        @endif
    </div>
</div>

<!-- Rentals Table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Rental History ({{ $rentals->count() }})</h5>
    </div>
    <div class="card-body">
        @if($rentals->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vehicle</th>
                            <th>Customer</th>
                            <th>Duration</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $rental)
                            <tr>
                                <td>{{ $rental->start_date->format('d/m/Y') }}</td>
                                <td>{{ $rental->vehicle->name }} - {{ $rental->vehicle->license_plate }}</td>
                                <td>{{ $rental->customer->name }}</td>
                                <td>{{ $rental->duration }} days</td>
                                <td class="text-end">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold bg-light">
                            <td colspan="4" class="text-end">TOTAL INCOME:</td>
                            <td class="text-end">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <p class="text-muted text-center py-4">No rentals in this period</p>
        @endif
    </div>
</div>

<!-- Expenses Breakdown -->
<div class="row mb-4">
    <!-- Fuel Fills -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning">
                <h6 class="mb-0"><i class="fas fa-gas-pump"></i> Fuel Fills ({{ $fuelFills->count() }})</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($fuelFills->count() > 0)
                    @foreach($fuelFills as $fuel)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between">
                                <small>{{ $fuel->vehicle->license_plate }} - {{ $fuel->fill_date->format('d/m/Y') }}</small>
                                <strong>Rp {{ number_format($fuel->total_price, 0, ',', '.') }}</strong>
                            </div>
                            <small class="text-muted">{{ $fuel->volume }}L @ Rp {{ number_format($fuel->price_per_liter, 0, ',', '.') }}/L</small>
                        </div>
                    @endforeach
                    <div class="pt-2 border-top fw-bold">
                        Total: Rp {{ number_format($fuelFills->sum('total_price'), 0, ',', '.') }}
                    </div>
                @else
                    <p class="text-muted text-center">No data</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Maintenances -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-wrench"></i> Maintenances ({{ $maintenances->count() }})</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($maintenances->count() > 0)
                    @foreach($maintenances as $maintenance)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between">
                                <small>{{ $maintenance->vehicle->license_plate }} - {{ $maintenance->maintenance_date->format('d/m/Y') }}</small>
                                <strong>Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</strong>
                            </div>
                            <small class="text-muted">{{ $maintenance->description }}</small>
                        </div>
                    @endforeach
                    <div class="pt-2 border-top fw-bold">
                        Total: Rp {{ number_format($maintenances->sum('cost'), 0, ',', '.') }}
                    </div>
                @else
                    <p class="text-muted text-center">No data</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Other Expenses -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="fas fa-receipt"></i> Other Expenses ({{ $expenses->count() }})</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($expenses->count() > 0)
                    @foreach($expenses as $expense)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between">
                                <small>{{ $expense->vehicle->license_plate ?? 'General' }} - {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</small>
                                <strong>Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong>
                            </div>
                            <small class="text-muted">{{ $expense->description }}</small>
                        </div>
                    @endforeach
                    <div class="pt-2 border-top fw-bold">
                        Total: Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}
                    </div>
                @else
                    <p class="text-muted text-center">No data</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
