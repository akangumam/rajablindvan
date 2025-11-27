@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2">
                <i class="fas fa-users-cog text-primary"></i>
                Manage Drivers - {{ $vehicle->name }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}"><i class="fas fa-car"></i> Vehicle</a></li>
                    <li class="breadcrumb-item active">Manage Drivers</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Vehicle Info Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div class="vehicle-icon-large">
                        <i class="fas fa-car fa-4x text-primary"></i>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="mb-1 text-primary">{{ $vehicle->name }}</h5>
                            <p class="mb-0 text-muted">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Plat Nomor</small>
                            <strong class="text-dark">{{ $vehicle->license_plate }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Year</small>
                            <strong class="text-dark">{{ $vehicle->year }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Assigned Drivers Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-check"></i>
                        driver assigned
                        <span class="badge bg-light text-success ms-2">{{ $assignedDrivers->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($assignedDrivers->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No driver assigned</p>
                            <small class="text-muted">Select driver from the list to assign</small>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($assignedDrivers as $driver)
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="avatar-circle bg-success text-white me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $driver->name }}</h6>
                                                <div class="small text-muted">
                                                    <i class="fas fa-envelope me-1"></i> {{ $driver->Email }}
                                                </div>
                                                @if($driver->phone)
                                                    <div class="small text-muted">
                                                        <i class="fas fa-phone me-1"></i> {{ $driver->phone }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('vehicles.remove-driver-assignment', [$vehicle->id, $driver->id]) }}"  
                                              method="POST" 
                                              onsubmit="return confirm('Yakin want to delete penugasan driver ini?');"
                                              class="ms-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Penugasan">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Available Drivers Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i>
                        driver Available
                        <span class="badge bg-light text-primary ms-2">{{ $availableDrivers->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($availableDrivers->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-muted mb-0">All drivers already assigned</p>
                            <small class="text-muted">Atau No data yet driver di sistem</small>
                        </div>
                    @else
                        <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                            @foreach($availableDrivers as $driver)
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="avatar-circle bg-secondary text-white me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $driver->name }}</h6>
                                                <div class="small text-muted">
                                                    <i class="fas fa-envelope me-1"></i> {{ $driver->Email }}
                                                </div>
                                                @if($driver->phone)
                                                    <div class="small text-muted">
                                                        <i class="fas fa-phone me-1"></i> {{ $driver->phone }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('vehicles.store-driver-assignment', $vehicle->id) }}" 
                                              method="POST"
                                              class="ms-3">
                                            @csrf
                                            <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary" title="Tugaskan driver">
                                                <i class="fas fa-user-plus"></i> Tugaskan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .vehicle-icon-large {
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        display: inline-block;
    }

    .vehicle-icon-large i {
        color: white !important;
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .list-group-item {
        border-left: 3px solid transparent;
        transition: all 0.2s;
    }

    .list-group-item:hover {
        border-left-color: #667eea;
        background-color: #f8f9fa;
    }

    .card-header {
        font-weight: 500;
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.5rem;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
</style>
@endsection




























