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
</style>

<div class="dashboard-header">
    <h1 class="dashboard-title">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard Monitoring
    </h1>
    <p class="dashboard-subtitle">Real-time fleet monitoring and expiry alerts</p>
</div>

<div class="row">
    <!-- Section 1: STNK Monitoring -->
    <div class="col-lg-6 col-md-12">
        <div class="monitoring-card">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <span>Monitoring STNK Journey Time</span>
                </div>
            </div>
            
            <div class="vehicle-list">
                @forelse($stnkMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} days {{ $item['status'] == 'red' ? 'overdue' : 'remaining' }}</span>
                            <span class="text-muted">•</span>
                            <span>Expired: {{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'Kuning' : 'Merah' }}
                        </span>
                        <a href="{{ route('vehicles.edit', ['vehicle' => $item['license_plate']]) }}" class="action-link">
                            Vehicle Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p>All STNK documents are up to date</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Section 2: KIR Monitoring -->
    <div class="col-lg-6 col-md-12">
        <div class="monitoring-card">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-green">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <span>Monitoring KIR Journey Time</span>
                </div>
            </div>
            
            <div class="vehicle-list">
                @forelse($kirMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} days {{ $item['status'] == 'red' ? 'overdue' : 'remaining' }}</span>
                            <span class="text-muted">•</span>
                            <span>Expired: {{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'Kuning' : 'Merah' }}
                        </span>
                        <a href="{{ route('vehicles.edit', ['vehicle' => $item['license_plate']]) }}" class="action-link">
                            Vehicle Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p>All KIR documents are up to date</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Section 3: Fleet Status -->
    <div class="col-12">
        <div class="monitoring-card">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-orange">
                        <i class="fas fa-cars"></i>
                    </div>
                    <span>Monitoring Vehicle BOOKED and AVAILABLE</span>
                </div>
            </div>
            
            <div class="fleet-summary">
                <div class="fleet-stat">
                    <div class="fleet-number booked-number">{{ $bookedVehicles }}</div>
                    <div class="fleet-label">Booked</div>
                </div>
                <div class="fleet-stat">
                    <div class="fleet-number available-number">{{ $availableVehicles }}</div>
                    <div class="fleet-label">Available</div>
                </div>
                <div class="fleet-stat">
                    <div class="fleet-number total-number">{{ $totalFleet }}</div>
                    <div class="fleet-label">Total Fleet (Booked + Available)</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



























