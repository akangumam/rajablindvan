@extends('layouts.drivvo')

@section('title', 'Detail Perawatan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-tools text-primary me-2"></i>
                        Detail Perawatan
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('maintenances.edit', $maintenance) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('maintenances.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Kendaraan -->
                        <div class="col-md-6">
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-car me-2"></i>Informasi Kendaraan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="fw-bold" width="40%">Kendaraan:</td>
                                            <td>{{ $maintenance->vehicle->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Plat Nomor:</td>
                                            <td>{{ $maintenance->vehicle->license_plate }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tahun:</td>
                                            <td>{{ $maintenance->vehicle->year }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Status dan Tanggal -->
                        <div class="col-md-6">
                            <div class="card border-info mb-4">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-calendar me-2"></i>Status & Tanggal</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="fw-bold" width="40%">Status:</td>
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
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tanggal Perawatan:</td>
                                            <td>{{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Odometer:</td>
                                            <td>{{ number_format($maintenance->odometer) }} km</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Detail Perawatan -->
                        <div class="col-md-8">
                            <div class="card border-success mb-4">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-wrench me-2"></i>Detail Perawatan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" width="25%">Jenis:</td>
                                            <td>{{ $maintenance->type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kategori:</td>
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
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Deskripsi:</td>
                                            <td>{{ $maintenance->description }}</td>
                                        </tr>
                                        @if($maintenance->workshop)
                                        <tr>
                                            <td class="fw-bold">Bengkel:</td>
                                            <td>{{ $maintenance->workshop }}</td>
                                        </tr>
                                        @endif
                                        @if($maintenance->parts_replaced)
                                        <tr>
                                            <td class="fw-bold">Suku Cadang:</td>
                                            <td>{{ $maintenance->parts_replaced }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Biaya -->
                        <div class="col-md-4">
                            <div class="card border-warning mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="fas fa-money-bill me-2"></i>Biaya</h6>
                                </div>
                                <div class="card-body text-center">
                                    <h3 class="text-warning mb-0">Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($maintenance->next_maintenance_date || $maintenance->next_maintenance_odometer)
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Perawatan Selanjutnya</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($maintenance->next_maintenance_date)
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Tanggal:</strong></p>
                                            <p class="text-info">{{ \Carbon\Carbon::parse($maintenance->next_maintenance_date)->format('d/m/Y') }}</p>
                                        </div>
                                        @endif
                                        @if($maintenance->next_maintenance_odometer)
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Odometer:</strong></p>
                                            <p class="text-info">{{ number_format($maintenance->next_maintenance_odometer) }} km</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($maintenance->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Catatan</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $maintenance->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
