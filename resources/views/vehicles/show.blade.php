@extends('layouts.drivvo')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-car text-primary me-2"></i>
                        Detail Kendaraan - {{ $vehicle->name }}
                    </h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-1"></i>Tambah Data
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('fuel-fills.create-for-vehicle', $vehicle) }}">
                                    <i class="fas fa-gas-pump me-2"></i>Isi Bensin
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('maintenances.create-for-vehicle', $vehicle) }}">
                                    <i class="fas fa-wrench me-2"></i>Service
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('expenses.create-for-vehicle', $vehicle) }}">
                                    <i class="fas fa-receipt me-2"></i>Pengeluaran
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm ms-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm ms-1">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informasi Kendaraan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Kendaraan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="fw-bold">Nama:</td>
                                            <td>{{ $vehicle->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Merek:</td>
                                            <td>{{ $vehicle->brand }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Model:</td>
                                            <td>{{ $vehicle->model }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tahun:</td>
                                            <td>{{ $vehicle->year }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Plat Nomor:</td>
                                            <td><span class="badge bg-dark">{{ $vehicle->license_plate }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Jenis Mesin:</td>
                                            <td>{{ $vehicle->engine_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Transmisi:</td>
                                            <td>{{ $vehicle->transmission }}</td>
                                        </tr>
                                        @if($vehicle->tank_capacity)
                                        <tr>
                                            <td class="fw-bold">Kapasitas Tangki:</td>
                                            <td>{{ $vehicle->tank_capacity }} Liter</td>
                                        </tr>
                                        @endif
                                        @if($vehicle->color)
                                        <tr>
                                            <td class="fw-bold">Warna:</td>
                                            <td>{{ $vehicle->color }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="fw-bold">Status:</td>
                                            <td>
                                                <span class="badge {{ $vehicle->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $vehicle->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Kendaraan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-primary mb-0">{{ number_format($stats['latest_odometer']) }}</h5>
                                                    <small class="text-muted">Odometer Terakhir (km)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-success mb-0">{{ $stats['avg_fuel_efficiency'] ? number_format($stats['avg_fuel_efficiency'], 1) : '-' }}</h5>
                                                    <small class="text-muted">Efisiensi BBM (km/L)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-warning mb-0">{{ $stats['total_fuel_fills'] }}</h5>
                                                    <small class="text-muted">Total Isi BBM</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-danger mb-0">Rp {{ number_format($stats['total_expenses']) }}</h5>
                                                    <small class="text-muted">Total Biaya</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($vehicle->notes)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Catatan</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $vehicle->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Tabs untuk Riwayat -->
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="vehicleTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="fuel-tab" data-bs-toggle="tab" data-bs-target="#fuel" type="button" role="tab">
                                        <i class="fas fa-gas-pump me-1"></i>Riwayat BBM ({{ $vehicle->fuelFills->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab">
                                        <i class="fas fa-wrench me-1"></i>Riwayat Service ({{ $vehicle->maintenances->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="expenses-tab" data-bs-toggle="tab" data-bs-target="#expenses" type="button" role="tab">
                                        <i class="fas fa-receipt me-1"></i>Riwayat Pengeluaran ({{ $vehicle->expenses->count() }})
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="vehicleTabsContent">
                                <!-- Tab BBM -->
                                <div class="tab-pane fade show active" id="fuel" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->fuelFills->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Odometer</th>
                                                                <th>Liter</th>
                                                                <th>Harga/L</th>
                                                                <th>Total</th>
                                                                <th>Efisiensi</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->fuelFills->sortByDesc('fill_date')->take(10) as $fuel)
                                                            <tr>
                                                                <td>{{ $fuel->fill_date->format('d/m/Y') }}</td>
                                                                <td>{{ number_format($fuel->odometer) }} km</td>
                                                                <td>{{ $fuel->liters }} L</td>
                                                                <td>Rp {{ number_format($fuel->price_per_liter) }}</td>
                                                                <td class="fw-bold">Rp {{ number_format($fuel->total_cost) }}</td>
                                                                <td>
                                                                    @if($fuel->fuel_efficiency)
                                                                        <span class="badge bg-success">{{ number_format($fuel->fuel_efficiency, 1) }} km/L</span>
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('fuel-fills.show', $fuel) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->fuelFills->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('fuel-fills.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            Lihat Semua Riwayat BBM
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-gas-pump display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">Belum Ada Data BBM</h5>
                                                    <a href="{{ route('fuel-fills.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Data BBM
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Service -->
                                <div class="tab-pane fade" id="maintenance" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->maintenances->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Jenis</th>
                                                                <th>Kategori</th>
                                                                <th>Odometer</th>
                                                                <th>Biaya</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->maintenances->sortByDesc('maintenance_date')->take(10) as $maintenance)
                                                            <tr>
                                                                <td>{{ $maintenance->maintenance_date->format('d/m/Y') }}</td>
                                                                <td>{{ $maintenance->type }}</td>
                                                                <td>
                                                                    @php
                                                                        $categoryClass = match($maintenance->category) {
                                                                            'Routine' => 'primary',
                                                                            'Repair' => 'warning',
                                                                            'Emergency' => 'danger',
                                                                            default => 'secondary'
                                                                        };
                                                                    @endphp
                                                                    <span class="badge bg-{{ $categoryClass }}">{{ $maintenance->category }}</span>
                                                                </td>
                                                                <td>{{ number_format($maintenance->odometer) }} km</td>
                                                                <td class="fw-bold">Rp {{ number_format($maintenance->cost) }}</td>
                                                                <td>
                                                                    @php
                                                                        $statusClass = match($maintenance->status) {
                                                                            'Completed' => 'success',
                                                                            'Scheduled' => 'warning',
                                                                            'Overdue' => 'danger',
                                                                            default => 'secondary'
                                                                        };
                                                                    @endphp
                                                                    <span class="badge bg-{{ $statusClass }}">{{ $maintenance->status }}</span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->maintenances->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('maintenances.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            Lihat Semua Riwayat Service
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-wrench display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">Belum Ada Data Service</h5>
                                                    <a href="{{ route('maintenances.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Data Service
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Pengeluaran -->
                                <div class="tab-pane fade" id="expenses" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->expenses->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Kategori</th>
                                                                <th>Deskripsi</th>
                                                                <th>Jumlah</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->expenses->sortByDesc('expense_date')->take(10) as $expense)
                                                            <tr>
                                                                <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                                                <td>
                                                                    <span class="badge bg-info">{{ $expense->getCategoryLabelAttribute() }}</span>
                                                                </td>
                                                                <td>{{ Str::limit($expense->description, 50) }}</td>
                                                                <td class="fw-bold">Rp {{ number_format($expense->amount) }}</td>
                                                                <td>
                                                                    <a href="{{ route('expenses.show', $expense) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->expenses->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('expenses.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            Lihat Semua Riwayat Pengeluaran
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-receipt display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">Belum Ada Data Pengeluaran</h5>
                                                    <a href="{{ route('expenses.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Data Pengeluaran
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection