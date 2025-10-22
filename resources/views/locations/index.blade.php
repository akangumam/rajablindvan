@extends('layouts.drivvo')

@section('title', 'Manajemen Lokasi')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                    Manajemen Lokasi
                </h2>
                <div>
                    <a href="{{ route('multi-location.dashboard') }}" class="btn btn-success me-2">
                        <i class="fas fa-chart-bar me-1"></i>Dashboard Multi-Lokasi
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Dashboard Utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Locations Grid -->
    <div class="row">
        @foreach($locations as $location)
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-building me-2"></i>
                                {{ $location->name }}
                            </h5>
                            <span class="badge bg-white text-primary">{{ $location->code }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Location Info -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>Alamat
                            </h6>
                            <p class="mb-0">{{ $location->address }}</p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-phone me-1"></i>Telepon
                                </h6>
                                <p class="mb-0">{{ $location->phone ?? '-' }}</p>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-user me-1"></i>Manager
                                </h6>
                                <p class="mb-0">{{ $location->manager_name ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Stats -->
                        <hr>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kendaraan</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $location->vehicles_count }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tersedia</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $location->available_vehicles }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sewa Aktif</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $location->rentals_count }}</div>
                            </div>
                        </div>

                        <!-- Financial Performance -->
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Bulan Ini</div>
                                <div class="h6 mb-0 text-success">Rp {{ number_format($location->monthly_revenue, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengeluaran Bulan Ini</div>
                                <div class="h6 mb-0 text-danger">Rp {{ number_format($location->monthly_expenses, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="text-center mt-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Keuntungan Bersih</div>
                            <div class="h5 mb-0 font-weight-bold text-{{ $location->monthly_profit >= 0 ? 'success' : 'danger' }}">
                                Rp {{ number_format($location->monthly_profit, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('locations.show', $location) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </div>
                            <div class="col-6">
                                <div class="dropdown w-100">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-cog me-1"></i>Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('locations.edit', $location) }}">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('vehicles.index') }}?location={{ $location->id }}">
                                            <i class="fas fa-car me-1"></i>Lihat Kendaraan
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('rentals.index') }}?location={{ $location->id }}">
                                            <i class="fas fa-calendar me-1"></i>Lihat Sewa
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($locations->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Lokasi</h4>
                        <p class="text-muted mb-4">Mulai dengan menambahkan lokasi bisnis pertama Anda.</p>
                        <a href="{{ route('locations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Lokasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Team Management Section -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users me-2"></i>Team Management
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Lokasi</th>
                                    <th>Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $users = \App\Models\User::with('location')->get();
                                @endphp
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'manager' ? 'warning' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->location ? $user->location->name : 'All Locations' }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
</div>
@endsection