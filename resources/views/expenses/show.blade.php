@extends('layouts.drivvo')

@section('title', 'Detail Pengeluaran')

@section('content')
<style>
    .page-header {
        background: white;
        padding: 24px 30px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #e74c3c;
        font-size: 22px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }

    .detail-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .detail-header {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        padding: 24px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .detail-title {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .info-section {
        padding: 24px 32px;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #e74c3c;
    }

    .info-row {
        display: flex;
        margin-bottom: 12px;
        align-items: flex-start;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        width: 190px;
        flex-shrink: 0;
        font-size: 14px;
    }

    .info-value {
        color: #2c3e50;
        font-size: 14px;
        flex: 1;
    }

    .vehicle-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: #e3f2fd;
        border-radius: 6px;
        font-weight: 500;
        color: #1976d2;
        font-size: 14px;
    }

    .cost-amount {
        font-size: 22px;
        font-weight: 700;
        color: #e74c3c;
    }

    .btn-group-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .empty-value {
        color: #adb5bd;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .info-row {
            flex-direction: column;
            gap: 4px;
        }
        .info-label {
            width: auto;
            font-weight: 600;
        }
    }
</style>

<div class="container-fluid py-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-eye"></i>
                Detail Pengeluaran
            </h1>
            <p class="page-subtitle">Informasi lengkap catatan pengeluaran kendaraan</p>
        </div>
        <div class="btn-group-actions">
            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning px-3">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ $expense->vehicle_id ? route('vehicles.show', $expense->vehicle_id) : route('expenses.index') }}" class="btn btn-secondary px-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Detail Container -->
    <div class="detail-container">
        <div class="detail-header">
            <div>
                <h2 class="detail-title">
                    <i class="fas fa-receipt"></i>
                    {{ $expense->category ?? $expense->expense_type ?? 'Pengeluaran' }}
                </h2>
                <div class="mt-2">
                    <small>{{ $expense->expense_date ? $expense->expense_date->format('d M Y') : '-' }}
                        @if($expense->expense_time)
                            • {{ substr((string) $expense->expense_time, 0, 5) }}
                        @endif
                    </small>
                </div>
            </div>
            <div>
                <div class="status-badge">Pengeluaran</div>
            </div>
        </div>

        <div class="detail-body">
            <!-- Vehicle Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-car"></i>
                    Informasi Kendaraan
                </h3>

                <div class="info-row">
                    <div class="info-label">Kendaraan:</div>
                    <div class="info-value">
                        @if($expense->vehicle)
                            <a href="{{ route('vehicles.show', $expense->vehicle) }}" class="vehicle-badge text-decoration-none">
                                <i class="fas fa-car"></i>
                                <strong>{{ $expense->vehicle->name }}</strong>
                            </a>
                        @else
                            <span class="empty-value">Tidak ada data</span>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Nomor Plat:</div>
                    <div class="info-value">
                        <strong>{{ $expense->vehicle->license_plate ?? '-' }}</strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Odometer:</div>
                    <div class="info-value">
                        @if($expense->odometer)
                            <strong>{{ number_format($expense->odometer, 0, ',', '.') }} KM</strong>
                        @else
                            <span class="empty-value">Tidak dicatat</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Expense Details -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-receipt"></i>
                    Detail Pengeluaran
                </h3>

                <div class="info-row">
                    <div class="info-label">Tanggal &amp; Waktu:</div>
                    <div class="info-value">
                        <strong>{{ $expense->expense_date ? $expense->expense_date->format('d F Y') : '-' }}</strong>
                        @if($expense->expense_time)
                            <span class="ms-1">pukul {{ substr((string) $expense->expense_time, 0, 5) }}</span>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Jenis Pengeluaran:</div>
                    <div class="info-value">
                        <span class="badge bg-info">{{ $expense->category ?? $expense->expense_type ?? '-' }}</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tempat / Lokasi:</div>
                    <div class="info-value">
                        @if($expense->place)
                            <strong>{{ $expense->place }}</strong>
                        @else
                            <span class="empty-value">Tidak ada data</span>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Penanggung Jawab:</div>
                    <div class="info-value">
                        @if($expense->user)
                            <strong>{{ $expense->user->name }}</strong>
                        @else
                            <span class="empty-value">Tidak ada data</span>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Metode Pembayaran:</div>
                    <div class="info-value">
                        @if($expense->payment_method)
                            <strong>{{ $expense->payment_method }}</strong>
                        @else
                            <span class="empty-value">Tidak ada data</span>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Catatan / Deskripsi:</div>
                    <div class="info-value">
                        @if($expense->notes || $expense->description)
                            {{ $expense->notes ?? $expense->description }}
                        @else
                            <span class="empty-value">Tidak ada catatan</span>
                        @endif
                    </div>
                </div>

                @if($expense->attachment)
                <div class="info-row">
                    <div class="info-label">Lampiran:</div>
                    <div class="info-value">
                        <a href="{{ asset('storage/' . $expense->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-paperclip me-1"></i>Lihat Lampiran
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Cost Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Informasi Biaya
                </h3>

                <div class="info-row">
                    <div class="info-label">Total Biaya:</div>
                    <div class="info-value">
                        <div class="cost-amount">Rp {{ number_format($expense->amount ?? $expense->total_cost ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions Section -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    Aksi
                </h3>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Pengeluaran
                    </a>

                    @if(auth()->user() && auth()->user()->canDeleteRecords())
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus data pengeluaran ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Pengeluaran
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
