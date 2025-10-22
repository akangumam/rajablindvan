@extends('layouts.drivvo')

@section('title', 'Multi-Location Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                    Multi-Location Dashboard
                </h2>
                <div>
                    <a href="{{ route('locations.index') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-cog me-1"></i>Kelola Lokasi
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Dashboard Utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Comparison Cards -->
    <div class="row">
        @foreach($comparison as $data)
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow border-left-primary">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-building me-2"></i>
                                {{ $data['location']->name }}
                            </h5>
                            <span class="badge bg-white text-primary">{{ $data['location']->code }}</span>
                        </div>
                        <small>{{ $data['location']->address }}</small>
                    </div>
                    <div class="card-body">
                        <!-- Location Stats -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kendaraan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['vehicles_count'] }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tersedia</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['available_vehicles'] }}</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sewa Aktif</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['active_rentals'] }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Utilisasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['utilization_rate'] }}%</div>
                            </div>
                        </div>

                        <!-- Financial Performance -->
                        <hr>
                        <h6 class="text-primary mb-3">Performa Bulan Ini</h6>
                        
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Pendapatan</div>
                                <div class="h6 mb-0 text-success">Rp {{ number_format($data['monthly_revenue'], 0, ',', '.') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Pengeluaran</div>
                                <div class="h6 mb-0 text-danger">Rp {{ number_format($data['monthly_expenses'], 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Keuntungan Bersih</div>
                                <div class="h5 mb-0 font-weight-bold text-{{ $data['monthly_profit'] >= 0 ? 'success' : 'danger' }}">
                                    Rp {{ number_format($data['monthly_profit'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar for Utilization -->
                        <div class="mt-3">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tingkat Utilisasi</div>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $data['utilization_rate'] > 70 ? 'success' : ($data['utilization_rate'] > 40 ? 'warning' : 'danger') }}" 
                                     role="progressbar" 
                                     style="width: {{ $data['utilization_rate'] }}%" 
                                     aria-valuenow="{{ $data['utilization_rate'] }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $data['utilization_rate'] }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('locations.show', $data['location']) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $data['location']->manager_name }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Summary Comparison Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Perbandingan Performa Lokasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Lokasi</th>
                                    <th>Total Kendaraan</th>
                                    <th>Utilisasi (%)</th>
                                    <th>Pendapatan Bulan Ini</th>
                                    <th>Pengeluaran Bulan Ini</th>
                                    <th>Keuntungan Bersih</th>
                                    <th>Manager</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comparison as $data)
                                <tr>
                                    <td>
                                        <strong>{{ $data['location']->name }}</strong><br>
                                        <small class="text-muted">{{ $data['location']->code }}</small>
                                    </td>
                                    <td class="text-center">{{ $data['vehicles_count'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $data['utilization_rate'] > 70 ? 'success' : ($data['utilization_rate'] > 40 ? 'warning' : 'danger') }}">
                                            {{ $data['utilization_rate'] }}%
                                        </span>
                                    </td>
                                    <td class="text-end text-success">Rp {{ number_format($data['monthly_revenue'], 0, ',', '.') }}</td>
                                    <td class="text-end text-danger">Rp {{ number_format($data['monthly_expenses'], 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        <span class="text-{{ $data['monthly_profit'] >= 0 ? 'success' : 'danger' }}">
                                            Rp {{ number_format($data['monthly_profit'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>{{ $data['location']->manager_name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
</style>
@endsection