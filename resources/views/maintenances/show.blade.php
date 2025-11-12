@extends('layouts.drivvo')

@section('title', 'Detail Service')

@section('content')
<style>
    .page-header {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #17a2b8;
        font-size: 24px;
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
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        padding: 24px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    }

    .status-completed {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .detail-body {
        padding: 0;
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
        color: #17a2b8;
    }

    .info-row {
        display: flex;
        margin-bottom: 12px;
        align-items: flex-start;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        width: 180px;
        flex-shrink: 0;
        font-size: 14px;
    }

    .info-value {
        color: #2c3e50;
        font-size: 14px;
        flex: 1;
    }

    .info-value strong {
        font-weight: 600;
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
        font-size: 18px;
        font-weight: 700;
        color: #28a745;
    }

    .btn-group-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-warning {
        background: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background: #ffb30f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        text-decoration: none;
        color: #212529;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .empty-value {
        color: #adb5bd;
        font-style: italic;
    }

    .divider {
        height: 1px;
        background: #e9ecef;
        margin: 16px 0;
    }

    @media (max-width: 768px) {
        .detail-header {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }

        .btn-group-actions {
            flex-direction: column;
            width: 100%;
        }

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

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-eye"></i>
                Detail Service
            </h1>
            <p class="page-subtitle">Informasi lengkap data service kendaraan</p>
        </div>
        <div class="btn-group-actions">
            <a href="{{ route('maintenances.edit', $maintenance) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Detail Container -->
    <div class="detail-container">
        <!-- Header Section -->
        <div class="detail-header">
            <div>
                <h2 class="detail-title">
                    <i class="fas fa-wrench"></i>
                    {{ $maintenance->type ?? 'Service' }}
                </h2>
                <div class="mt-2">
                    <small>{{ $maintenance->maintenance_date->format('d M Y') }} • {{ $maintenance->maintenance_date->diffForHumans() }}</small>
                </div>
            </div>
            <div>
                @php
                    $statusMap = [
                        'Completed' => 'Selesai',
                        'Scheduled' => 'Terjadwal',
                        'Overdue' => 'Terlambat'
                    ];
                    $statusText = $statusMap[$maintenance->status] ?? $maintenance->status ?? 'Selesai';
                @endphp
                <div class="status-badge status-completed">{{ $statusText }}</div>
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
                        <div class="vehicle-badge">
                            <i class="fas fa-car"></i>
                            <strong>{{ $maintenance->vehicle->name ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Nomor Plat:</div>
                    <div class="info-value">
                        <strong>{{ $maintenance->vehicle->license_plate ?? 'N/A' }}</strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Odometer:</div>
                    <div class="info-value">
                        <strong>{{ number_format($maintenance->odometer, 0, ',', '.') }} KM</strong>
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-wrench"></i>
                    Detail Service
                </h3>

                <div class="info-row">
                    <div class="info-label">Tanggal Service:</div>
                    <div class="info-value">
                        <strong>{{ $maintenance->maintenance_date->format('d F Y') }}</strong>
                        <small class="text-muted">({{ $maintenance->maintenance_date->diffForHumans() }})</small>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Jenis Service:</div>
                    <div class="info-value">
                        <strong>{{ $maintenance->type ?? 'Service' }}</strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Kategori:</div>
                    <div class="info-value">
                        @php
                            $categoryColors = [
                                'Service' => 'success',
                                'Repair' => 'warning',
                                'Routine' => 'info',
                                'Emergency' => 'danger'
                            ];
                            $badgeColor = $categoryColors[$maintenance->category ?? 'Service'] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ $maintenance->category ?? 'Service' }}</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tempat Service:</div>
                    <div class="info-value">
                        @if($maintenance->workshop || $maintenance->place)
                            <strong>{{ $maintenance->workshop ?? $maintenance->place }}</strong>
                        @else
                            <span class="empty-value">Tidak ada data</span>
                        @endif
                    </div>
                </div>

                @if($maintenance->description && $maintenance->description !== '-')
                <div class="divider"></div>
                <div class="info-row">
                    <div class="info-label">Keterangan:</div>
                    <div class="info-value">{{ $maintenance->description }}</div>
                </div>
                @endif
            </div>

            <!-- Cost Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-money-bill"></i>
                    Informasi Biaya
                </h3>

                <div class="info-row">
                    <div class="info-label">Total Biaya:</div>
                    <div class="info-value">
                        @php
                            $cost = $maintenance->cost ?? $maintenance->total_cost ?? 0;
                        @endphp
                        @if($cost > 0)
                            <div class="cost-amount">Rp {{ number_format($cost, 0, ',', '.') }}</div>
                        @else
                            <span class="empty-value">Tidak ada data biaya</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Next Maintenance -->
            @if($maintenance->next_maintenance_date || $maintenance->next_maintenance_odometer)
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-plus"></i>
                    Service Berikutnya
                </h3>

                @if($maintenance->next_maintenance_date)
                <div class="info-row">
                    <div class="info-label">Tanggal:</div>
                    <div class="info-value">
                        <strong>{{ $maintenance->next_maintenance_date->format('d F Y') }}</strong>
                        @if($maintenance->next_maintenance_date->isPast())
                            <span class="badge bg-danger ms-2">Terlambat</span>
                        @elseif($maintenance->next_maintenance_date->isToday())
                            <span class="badge bg-warning ms-2">Hari Ini</span>
                        @elseif($maintenance->next_maintenance_date->isTomorrow())
                            <span class="badge bg-info ms-2">Besok</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($maintenance->next_maintenance_odometer)
                <div class="info-row">
                    <div class="info-label">Odometer:</div>
                    <div class="info-value">
                        <strong>{{ number_format($maintenance->next_maintenance_odometer, 0, ',', '.') }} KM</strong>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Actions Section -->
            @if(auth()->user()->hasRole('Administrator'))
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    Aksi
                </h3>

                <div class="d-flex gap-3">
                    <a href="{{ route('maintenances.edit', $maintenance) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Service
                    </a>

                    <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus data service ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Service
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show success message if exists
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session("success") }}'
        });
    });
</script>
@endif
@endsection
