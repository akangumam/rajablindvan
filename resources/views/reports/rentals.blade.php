@extends('layouts.drivvo')

@section('title', 'Laporan Rental')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    Laporan Rental
                </h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.rentals.excel') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>Export Excel
                    </a>
                    <a href="{{ route('reports.rentals.pdf', request()->query()) }}" 
                       class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
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
                    <form method="GET" action="{{ route('reports.rentals') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="reserved" {{ $status == 'reserved' ? 'selected' : '' }}>Reservasi</option>
                                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="rental_type" class="form-label">Tipe Rental</label>
                            <select class="form-select" id="rental_type" name="rental_type">
                                <option value="all" {{ $rentalType == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                <option value="daily" {{ $rentalType == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ $rentalType == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ $rentalType == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
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

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Rental</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalRentals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-white-50"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-rata Durasi</div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($averageDuration, 1) }} hari</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-white-50"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-rata Revenue</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($averageRevenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rental Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Rental</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode Rental</th>
                                    <th>Customer</th>
                                    <th>Kendaraan</th>
                                    <th>Periode</th>
                                    <th>Tipe</th>
                                    <th>Durasi</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rentals as $rental)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $rental->rental_code }}</div>
                                        <small class="text-muted">{{ $rental->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $rental->customer->name }}</div>
                                        <small class="text-muted">{{ $rental->customer->phone }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $rental->vehicle->name }}</div>
                                        <small class="text-muted">{{ $rental->vehicle->license_plate }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $rental->start_date->format('d M Y') }}</div>
                                        <div>{{ $rental->end_date->format('d M Y') }}</div>
                                        @if($rental->isOverdue())
                                            <small class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Terlambat {{ $rental->getDaysOverdue() }} hari
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $rental->getRentalTypeLabel() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $rental->duration_days }} hari</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Rp {{ number_format($rental->getFinalAmount(), 0, ',', '.') }}</div>
                                        @if($rental->additional_charges > 0)
                                            <small class="text-muted">
                                                +{{ number_format($rental->additional_charges, 0, ',', '.') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $rental->status_class }}">
                                            {{ $rental->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('rentals.show', $rental) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($rental->status === 'reserved')
                                                <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                        Tidak ada data rental ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($rentals->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $rentals->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection