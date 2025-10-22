@extends('layouts.drivvo')

@section('title', 'Laporan Kendaraan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-car text-primary me-2"></i>
                    Laporan Kendaraan
                </h2>
                <div>
                    <a href="{{ route('reports.vehicles.excel') }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel me-1"></i>Export Excel
                    </a>
                    <a href="{{ route('reports.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
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
                    <form method="GET" action="{{ route('reports.vehicles') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Performance Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance Kendaraan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kendaraan</th>
                                    <th>Total Rental</th>
                                    <th>Rental Selesai</th>
                                    <th>Revenue</th>
                                    <th>Utilisasi</th>
                                    <th>Rata-rata Durasi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicleStats as $stat)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $stat['vehicle']->name }}</div>
                                        <small class="text-muted">{{ $stat['vehicle']->license_plate }}</small><br>
                                        <small class="text-muted">{{ $stat['vehicle']->brand }} {{ $stat['vehicle']->model }} ({{ $stat['vehicle']->year }})</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $stat['total_rentals'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $stat['completed_rentals'] }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">
                                            Rp {{ number_format($stat['total_revenue'], 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $stat['utilization_rate'] > 70 ? 'success' : ($stat['utilization_rate'] > 40 ? 'warning' : 'danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $stat['utilization_rate'] }}%">
                                                {{ $stat['utilization_rate'] }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($stat['average_rental_duration'], 1) }} hari</span>
                                    </td>
                                    <td>
                                        @php
                                            $currentRental = $stat['vehicle']->getCurrentRental();
                                        @endphp
                                        @if($currentRental)
                                            <span class="badge bg-warning">Sedang Disewa</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-car fa-3x mb-3"></i><br>
                                        Tidak ada data kendaraan ditemukan
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

    <!-- Summary Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Kendaraan</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $vehicleStats->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-white-50"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Kendaraan Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $vehicleStats->filter(function($stat) { return !$stat['vehicle']->getCurrentRental(); })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-white-50"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Sedang Disewa</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $vehicleStats->filter(function($stat) { return $stat['vehicle']->getCurrentRental(); })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play-circle fa-2x text-white-50"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-rata Utilisasi</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ number_format($vehicleStats->avg('utilization_rate'), 1) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection