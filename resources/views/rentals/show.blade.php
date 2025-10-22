@extends('layouts.drivvo')

@section('title', 'Detail Rental')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check text-primary me-2"></i>
                        Detail Rental - {{ $rental->rental_code }}
                    </h5>
                    <div class="btn-group">
                        @if($rental->status === 'reserved')
                            <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                        @endif
                        <a href="{{ route('rentals.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Status Alert -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-{{ $rental->status_class }} d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <i class="fas 
                                            @if($rental->status === 'reserved') fa-clock
                                            @elseif($rental->status === 'active') fa-play-circle
                                            @elseif($rental->status === 'completed') fa-check-circle
                                            @else fa-times-circle
                                            @endif
                                            me-2"></i>
                                        Status: {{ $rental->status_label }}
                                    </h6>
                                    @if($rental->isOverdue())
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Terlambat {{ $rental->getDaysOverdue() }} hari dari jadwal
                                        </small>
                                    @endif
                                </div>
                                <div>
                                    @if($rental->canBeStarted())
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#startRentalModal">
                                            <i class="fas fa-play me-1"></i>Mulai Rental
                                        </button>
                                    @elseif($rental->canBeCompleted())
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#completeRentalModal">
                                            <i class="fas fa-check me-1"></i>Selesaikan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Customer Info -->
                        <div class="col-md-6">
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Customer</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $rental->customer->name }}</h5>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Telepon:</strong></div>
                                        <div class="col-sm-8">{{ $rental->customer->phone }}</div>
                                    </div>
                                    @if($rental->customer->email)
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Email:</strong></div>
                                        <div class="col-sm-8">{{ $rental->customer->email }}</div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-4"><strong>No. Identitas:</strong></div>
                                        <div class="col-sm-8"><span class="badge bg-dark">{{ $rental->customer->id_number }}</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Alamat:</strong></div>
                                        <div class="col-sm-8">{{ $rental->customer->address }}</div>
                                    </div>
                                    @if($rental->customer->emergency_contact)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Kontak Darurat:</strong></div>
                                        <div class="col-sm-8">
                                            {{ $rental->customer->emergency_contact }}<br>
                                            <small class="text-muted">{{ $rental->customer->emergency_phone }}</small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Info -->
                        <div class="col-md-6">
                            <div class="card border-success mb-4">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-car me-2"></i>Informasi Kendaraan</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $rental->vehicle->name }}</h5>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Plat Nomor:</strong></div>
                                        <div class="col-sm-8"><span class="badge bg-dark">{{ $rental->vehicle->license_plate }}</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Merek:</strong></div>
                                        <div class="col-sm-8">{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Tahun:</strong></div>
                                        <div class="col-sm-8">{{ $rental->vehicle->year }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Transmisi:</strong></div>
                                        <div class="col-sm-8">{{ $rental->vehicle->transmission }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Jenis Mesin:</strong></div>
                                        <div class="col-sm-8">{{ $rental->vehicle->engine_type }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Rental Details -->
                        <div class="col-md-8">
                            <div class="card border-info mb-4">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Detail Rental</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-primary mb-1">Tanggal Mulai</h6>
                                                    <div class="fw-bold">{{ $rental->start_date->format('d F Y') }}</div>
                                                    @if($rental->actual_start_time)
                                                        <small class="text-muted">Dimulai: {{ $rental->actual_start_time->format('d/m/Y H:i') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-warning mb-1">Tanggal Selesai</h6>
                                                    <div class="fw-bold">{{ $rental->end_date->format('d F Y') }}</div>
                                                    @if($rental->actual_end_time)
                                                        <small class="text-muted">Selesai: {{ $rental->actual_end_time->format('d/m/Y H:i') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-success mb-1">Durasi</h6>
                                                    <div class="fw-bold">{{ $rental->duration_days }} Hari</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-info mb-1">Tipe Rental</h6>
                                                    <div class="fw-bold">{{ $rental->getRentalTypeLabel() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-warning mb-1">Tarif {{ $rental->getRentalTypeLabel() }}</h6>
                                                    <div class="fw-bold">Rp {{ number_format($rental->getEffectiveRate(), 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-primary mb-1">Odometer Awal</h6>
                                                    <div class="fw-bold">{{ number_format($rental->start_odometer, 0, ',', '.') }} km</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h6 class="text-warning mb-1">Odometer Akhir</h6>
                                                    <div class="fw-bold">
                                                        @if($rental->end_odometer)
                                                            {{ number_format($rental->end_odometer, 0, ',', '.') }} km
                                                            <small class="text-muted d-block">
                                                                Jarak: {{ number_format($rental->getTotalDistance(), 0, ',', '.') }} km
                                                            </small>
                                                        @else
                                                            <span class="text-muted">Belum selesai</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Summary -->
                        <div class="col-md-4">
                            <div class="card border-warning mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="fas fa-money-bill me-2"></i>Ringkasan Biaya</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal Rental:</span>
                                        <span class="fw-bold">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Deposit:</span>
                                        <span class="fw-bold text-success">Rp {{ number_format($rental->deposit, 0, ',', '.') }}</span>
                                    </div>
                                    @if($rental->additional_charges > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Biaya Tambahan:</span>
                                        <span class="fw-bold text-danger">Rp {{ number_format($rental->additional_charges, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total Akhir:</span>
                                        <span class="fw-bold h5 text-primary">Rp {{ number_format($rental->getFinalAmount(), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($rental->additional_charges > 0 && $rental->additional_charges_notes)
                            <div class="card border-danger mb-4">
                                <div class="card-header bg-danger text-white">
                                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Biaya Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $rental->additional_charges_notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Locations -->
                    @if($rental->pickup_location || $rental->return_location)
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-secondary mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Lokasi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if($rental->pickup_location)
                                        <div class="col-md-6">
                                            <h6 class="text-success">Pengambilan</h6>
                                            <p class="mb-0">{{ $rental->pickup_location }}</p>
                                        </div>
                                        @endif
                                        @if($rental->return_location)
                                        <div class="col-md-6">
                                            <h6 class="text-warning">Pengembalian</h6>
                                            <p class="mb-0">{{ $rental->return_location }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($rental->notes)
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Catatan</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $rental->notes }}</p>
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

<!-- Start Rental Modal -->
@if($rental->canBeStarted())
<div class="modal fade" id="startRentalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('rentals.start', $rental) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Mulai Rental - {{ $rental->rental_code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="actual_start_odometer" class="form-label">Odometer Saat Ini (km) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               id="actual_start_odometer"
                               name="actual_start_odometer" 
                               min="{{ $rental->start_odometer }}" 
                               value="{{ $rental->start_odometer }}" 
                               step="0.1" 
                               required>
                        <small class="text-muted">Minimum: {{ number_format($rental->start_odometer) }} km</small>
                    </div>
                    <div class="alert alert-info">
                        <strong>Perhatian:</strong> Pastikan kondisi kendaraan sudah dicek dan siap untuk disewakan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Mulai Rental</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Complete Rental Modal -->
@if($rental->canBeCompleted())
<div class="modal fade" id="completeRentalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('rentals.complete', $rental) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Selesaikan Rental - {{ $rental->rental_code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="end_odometer" class="form-label">Odometer Akhir (km) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               id="end_odometer"
                               name="end_odometer" 
                               min="{{ $rental->start_odometer }}" 
                               step="0.1" 
                               required>
                        <small class="text-muted">Minimum: {{ number_format($rental->start_odometer) }} km</small>
                    </div>
                    <div class="mb-3">
                        <label for="additional_charges" class="form-label">Biaya Tambahan (Rp)</label>
                        <input type="number" 
                               class="form-control" 
                               id="additional_charges"
                               name="additional_charges" 
                               min="0" 
                               step="1000"
                               placeholder="0">
                        <small class="text-muted">Denda, bahan bakar, kerusakan, dll.</small>
                    </div>
                    <div class="mb-3">
                        <label for="additional_charges_notes" class="form-label">Catatan Biaya Tambahan</label>
                        <textarea class="form-control" 
                                  id="additional_charges_notes"
                                  name="additional_charges_notes" 
                                  rows="2" 
                                  placeholder="Jelaskan alasan biaya tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Selesaikan Rental</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection