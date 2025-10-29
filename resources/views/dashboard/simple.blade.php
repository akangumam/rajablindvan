@extends('layouts.drivvo')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Vehicle Tracking</h1>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-uppercase fw-bold small mb-1">Total Vehicle</div>
                        <div class="h5 mb-0 fw-bold">{{ \App\Models\Vehicle::count() }}</div>
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
                        <div class="text-uppercase fw-bold small mb-1">Data Isi Bensin</div>
                        <div class="h5 mb-0 fw-bold">{{ \App\Models\FuelFill::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-fuel-pump fa-2x"></i>
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
                        <div class="text-uppercase fw-bold small mb-1">Data Maintenance</div>
                        <div class="h5 mb-0 fw-bold">{{ \App\Models\Maintenance::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-wrench fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card rental h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-uppercase fw-bold small mb-1">Rental Active</div>
                        <div class="h5 mb-0 fw-bold">{{ \App\Models\Rental::whereIn('Status', ['reserved', 'active'])->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check fa-2x"></i>
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
                        <div class="text-uppercase fw-bold small mb-1">Dashboard</div>
                        <div class="h5 mb-0 fw-bold">Ready</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-speedometer2 fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="m-0 fw-bold">Welcome to Vehicle Dashboard</h6>
            </div>
            <div class="card-body">
                <p>Dashboard untuk tracking Vehicle you is ready to use!</p>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary d-block">
                            <i class="bi bi-car-front me-2"></i>
                            Manage Vehicle
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('fuel-fills.index') }}" class="btn btn-outline-success d-block">
                            <i class="bi bi-fuel-pump me-2"></i>
                            Data Isi Bensin
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('vehicles.create') }}" class="btn btn-outline-warning d-block">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add Vehicle
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('fuel-fills.create') }}" class="btn btn-outline-info d-block">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add Fuel Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(\App\Models\Vehicle::count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="m-0 fw-bold">List Vehicle</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Vehicle</th>
                                <th>Plat Nomor</th>
                                <th>Odometer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Vehicle::with('fuelFills')->get() as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->name }}</td>
                                    <td>{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</td>
                                    <td><span class="badge bg-primary">{{ $vehicle->license_plate }}</span></td>
                                    <td>{{ number_format($vehicle->odometer, 0, ',', '.') }} km</td>
                                    <td>
                                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
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
@else
<div class="row mt-4">
    <div class="col-12">
        <div class="text-center py-5">
            <i class="bi bi-car-front display-1 text-muted"></i>
            <h3 class="mt-3">No Vehicle</h3>
            <p class="text-muted">Start dengan menambahkan Vehicle pertama you.</p>
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Add Vehicle Pertama
            </a>
        </div>
    </div>
</div>
@endif
@endsection



























