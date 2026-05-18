@extends('layouts.drivvo')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-header {
        background: white;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .dashboard-title {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .dashboard-title i {
        font-size: 28px;
        color: #007bff;
    }
    .dashboard-subtitle {
        color: #7f8c8d;
        font-size: 15px;
        margin: 0;
    }
    
    .monitoring-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    
    .monitoring-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    
    .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .card-title-custom {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    
    .icon-blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .icon-green {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .icon-orange {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .icon-purple {
        background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        color: white;
    }
    
    .vehicle-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .vehicle-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    
    .vehicle-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
    
    .vehicle-info {
        flex: 1;
    }
    
    .vehicle-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }
    
    .countdown-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #7f8c8d;
    }
    
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .status-yellow {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-red {
        background: #f8d7da;
        color: #721c24;
    }
    
    .status-expired {
        background: #f8d7da;
        color: #721c24;
    }
    
    .action-link {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }
    
    .action-link:hover {
        color: #2980b9;
        gap: 8px;
    }
    
    .fleet-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .fleet-stat {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }
    
    .fleet-number {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .fleet-label {
        font-size: 14px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .booked-number {
        color: #e74c3c;
    }
    
    .available-number {
        color: #27ae60;
    }
    
    .total-number {
        color: #3498db;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #95a5a6;
    }
    
    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    /* ===== PREMIUM FLEET STAT CARDS ===== */
    .fleet-stat-card {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 24px 28px;
        border-radius: 16px;
        color: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        height: 100%;
        min-height: 100px;
    }

    .fleet-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    .booked-card {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .available-card {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
    }

    .total-card {
        background: linear-gradient(135deg, #2980b9 0%, #1a5276 100%);
    }

    .fleet-stat-icon {
        font-size: 44px;
        opacity: 0.85;
        flex-shrink: 0;
    }

    .fleet-stat-content {
        flex: 1;
    }

    .fleet-stat-number {
        font-size: 48px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 4px;
    }

    .fleet-stat-label {
        font-size: 15px;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 2px;
    }

    .fleet-stat-sub {
        font-size: 11px;
        font-weight: 700;
        opacity: 0.7;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    /* ===== SECTION LABEL ===== */
    .section-label {
        font-size: 13px;
        font-weight: 700;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: flex;
        align-items: center;
        padding: 0 4px;
        border-left: 3px solid #e74c3c;
        padding-left: 12px;
    }

    /* ===== BADGE COUNT ===== */
    .badge-count {
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        min-width: 28px;
        text-align: center;
    }


    @media (max-width: 768px) {
        .dashboard-header {
            padding: 20px 15px;
        }

        .fleet-stat-card {
            padding: 18px 20px;
            gap: 16px;
        }

        .fleet-stat-icon {
            font-size: 32px;
        }

        .fleet-stat-number {
            font-size: 36px;
        }

        .fleet-stat-label {
            font-size: 13px;
        }

        .dashboard-title {
            font-size: 24px;
        }

        .dashboard-title i {
            font-size: 22px;
        }

        .dashboard-subtitle {
            font-size: 13px;
        }

        .monitoring-card {
            padding: 16px;
            margin-bottom: 16px;
        }

        .card-header-custom {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .card-title-custom {
            font-size: 16px;
        }

        .card-icon {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }

        .vehicle-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
        }

        .vehicle-info {
            width: 100%;
        }

        .vehicle-name {
            font-size: 15px;
            margin-bottom: 4px;
        }

        .vehicle-status {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            width: 100%;
        }

        .status-info {
            font-size: 12px;
            white-space: normal;
            word-wrap: break-word;
        }

        .status-info small {
            display: block;
            margin-top: 2px;
        }

        .status-badge {
            font-size: 11px;
            padding: 4px 10px;
            white-space: nowrap;
        }

        .vehicle-action {
            width: 100%;
        }

        .vehicle-action .btn {
            width: 100%;
            font-size: 13px;
            padding: 8px 12px;
        }

        .fleet-overview {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .fleet-stat {
            padding: 16px;
        }

        .fleet-number {
            font-size: 28px;
        }

        .fleet-label {
            font-size: 12px;
        }

        .empty-state {
            padding: 30px 15px;
        }

        .empty-icon {
            font-size: 36px;
        }
    }

    @media (max-width: 480px) {
        .dashboard-title {
            font-size: 20px;
        }

        .monitoring-card {
            padding: 12px;
        }

        .card-title-custom {
            font-size: 14px;
        }

        .vehicle-name {
            font-size: 14px;
        }

        .status-info {
            font-size: 11px;
        }

        .status-badge {
            font-size: 10px;
            padding: 3px 8px;
        }

        .fleet-number {
            font-size: 24px;
        }
    }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" style="background: #d4edda; border: none; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;" role="alert">
    <i class="fas fa-check-circle" style="font-size: 20px; color: #155724;"></i>
    <div style="flex: 1; color: #155724; font-weight: 500;">{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="dashboard-header">
    <h1 class="dashboard-title">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard Monitoring
    </h1>
    <p class="dashboard-subtitle">Real-time fleet monitoring and expiry alerts</p>
</div>

{{-- ===== FLEET STATUS: BOOKED & AVAILABLE (PALING ATAS) ===== --}}
<div class="row mb-4">
    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
        <div class="fleet-stat-card booked-card">
            <div class="fleet-stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ $bookedVehicles }}</div>
                <div class="fleet-stat-label">Kendaraan Dipesan</div>
                <div class="fleet-stat-sub">BOOKED</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
        <div class="fleet-stat-card available-card">
            <div class="fleet-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ $availableVehicles }}</div>
                <div class="fleet-stat-label">Kendaraan Tersedia</div>
                <div class="fleet-stat-sub">AVAILABLE</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="fleet-stat-card total-card">
            <div class="fleet-stat-icon">
                <i class="fas fa-car-side"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ $totalFleet }}</div>
                <div class="fleet-stat-label">Total Armada</div>
                <div class="fleet-stat-sub">TOTAL FLEET</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SECTION LABEL ===== --}}
<div class="section-label mb-3">
    <i class="fas fa-exclamation-triangle me-2"></i>
    Monitoring Masa Berlaku Dokumen
</div>

{{-- ===== MONITORING CARDS GRID ===== --}}
<div class="row">
    {{-- STNK --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="monitoring-card h-100">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <span>Monitoring STNK</span>
                </div>
                <span class="badge-count bg-danger text-white">{{ count($stnkMonitoring) }}</span>
            </div>
            <div class="vehicle-list">
                @forelse($stnkMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} hari {{ $item['status'] == 'red' ? 'terlewat' : 'tersisa' }}</span>
                            <span class="text-muted">•</span>
                            <span>{{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'WARNING' : 'URGENT' }}
                        </span>
                        <a href="{{ route('vehicles.show', ['vehicle' => $item['id']]) }}" class="action-link">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p>Semua STNK masih berlaku</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- KIR --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="monitoring-card h-100">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-green">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <span>Monitoring KIR</span>
                </div>
                <span class="badge-count bg-danger text-white">{{ count($kirMonitoring) }}</span>
            </div>
            <div class="vehicle-list">
                @forelse($kirMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} hari {{ $item['status'] == 'red' ? 'terlewat' : 'tersisa' }}</span>
                            <span class="text-muted">•</span>
                            <span>{{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'WARNING' : 'URGENT' }}
                        </span>
                        <a href="{{ route('vehicles.show', ['vehicle' => $item['id']]) }}" class="action-link">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p>Semua KIR masih berlaku</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- GPS --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="monitoring-card h-100">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-purple">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <span>Monitoring GPS</span>
                </div>
                <span class="badge-count bg-danger text-white">{{ count($gpsMonitoring) }}</span>
            </div>
            <div class="vehicle-list">
                @forelse($gpsMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} hari {{ $item['status'] == 'red' ? 'terlewat' : 'tersisa' }}</span>
                            <span class="text-muted">•</span>
                            <span>{{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'WARNING' : 'URGENT' }}
                        </span>
                        <a href="{{ route('vehicles.show', ['vehicle' => $item['id']]) }}" class="action-link">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p>Semua GPS masih berlaku</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection



























