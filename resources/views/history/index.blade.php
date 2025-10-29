@extends('layouts.drivvo')

@section('title', 'Vehicle History')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-history"></i>
        Vehicle History
    </h1>
    <p class="page-subtitle">View and download comprehensive vehicle maintenance records and history</p>
</div>

<style>
    
    .section-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    
    .section-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    
    .icon-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .icon-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        color: white;
    }
    
    .icon-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    /* Vehicle Selection Button */
    .vehicle-select-btn {
        width: 100%;
        padding: 16px 20px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        color: #7f8c8d;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .vehicle-select-btn:hover {
        border-color: #667eea;
        background: #f8f9fa;
    }
    
    .vehicle-select-btn.has-selection {
        color: #2c3e50;
        border-color: #667eea;
    }
    
    /* Vehicle Modal */
    .vehicle-modal .modal-dialog {
        max-width: 600px;
    }
    
    .vehicle-modal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }
    
    .vehicle-modal .modal-header {
        border-bottom: 2px solid #f0f0f0;
        padding: 20px 24px;
    }
    
    .vehicle-modal .modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
    }
    
    .vehicle-modal .btn-close {
        box-shadow: none;
    }
    
    .vehicle-search-box {
        position: relative;
        margin-bottom: 20px;
    }
    
    .vehicle-search-box input {
        width: 100%;
        padding: 12px 16px 12px 45px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .vehicle-search-box input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .vehicle-search-box i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #7f8c8d;
    }
    
    .vehicle-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .vehicle-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 8px;
    }
    
    .vehicle-item:hover {
        background: #f8f9fa;
    }
    
    .vehicle-item.selected {
        background: #e8eaf6;
    }
    
    .vehicle-brand-logo {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 2px solid #e0e0e0;
        flex-shrink: 0;
        padding: 8px;
    }
    
    .vehicle-brand-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .vehicle-info {
        flex: 1;
    }
    
    .vehicle-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 15px;
        margin-bottom: 4px;
    }
    
    .vehicle-plate {
        color: #7f8c8d;
        font-size: 13px;
    }
    
    .vehicle-status-icon {
        color: #7f8c8d;
        font-size: 20px;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .btn-manage {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .btn-manage:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }
    
    .btn-download {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }
    
    .history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    
    .history-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        color: #7f8c8d;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .history-table tbody tr {
        background: #f8f9fa;
        transition: all 0.2s ease;
    }
    
    .history-table tbody tr:hover {
        background: #e9ecef;
        transform: scale(1.01);
    }
    
    .history-table tbody td {
        padding: 16px;
        border: none;
    }
    
    .history-table tbody tr td:first-child {
        border-radius: 12px 0 0 12px;
    }
    
    .history-table tbody tr td:last-child {
        border-radius: 0 12px 12px 0;
    }
    
    .type-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-income {
        background: #d4edda;
        color: #155724;
    }
    
    .badge-service {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .badge-expense {
        background: #f8d7da;
        color: #721c24;
    }
    
    .amount-positive {
        color: #27ae60;
        font-weight: 600;
    }
    
    .amount-negative {
        color: #e74c3c;
        font-weight: 600;
    }
    
    .performance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .performance-item {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        text-align: center;
    }
    
    .performance-label {
        font-size: 13px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .performance-value {
        font-size: 24px;
        font-weight: 700;
    }
    
    .value-income {
        color: #27ae60;
    }
    
    .value-service {
        color: #3498db;
    }
    
    .value-expense {
        color: #e67e22;
    }
    
    .value-balance {
        color: #9b59b6;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #95a5a6;
    }
    
    .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .empty-message {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .empty-hint {
        font-size: 14px;
        color: #bdc3c7;
    }
</style>

<div class="row">
    <!-- Section 1: Vehicle Selection -->
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon icon-primary">
                        <i class="fas fa-car"></i>
                    </div>
                    <span>Vehicle Selection</span>
                </div>
            </div>
            
            <!-- Vehicle Selection Button -->
            <button type="button" class="vehicle-select-btn {{ $selectedVehicle ? 'has-selection' : '' }}" 
                    data-bs-toggle="modal" data-bs-target="#vehicleSelectModal">
                @if($selectedVehicle)
                    <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        @php
                            $brandLower = strtolower($selectedVehicle->brand ?? 'default');
                            $logoPath = 'assets/logos/brands/' . $brandLower . '.svg';
                            $logoExists = file_exists(public_path($logoPath));
                        @endphp
                        @if($logoExists)
                            <img src="{{ asset($logoPath) }}" alt="{{ $selectedVehicle->brand }}" style="width: 32px; height: 32px; object-fit: contain;">
                        @else
                            <i class="fas fa-car" style="font-size: 20px; color: #667eea;"></i>
                        @endif
                        <div style="text-align: left;">
                            <div style="font-weight: 600; color: #2c3e50; margin-bottom: 2px;">{{ $selectedVehicle->name }}</div>
                            <div style="font-size: 13px; color: #667eea;">Vehicle <i class="fas fa-chevron-right" style="font-size: 10px;"></i> {{ $selectedVehicle->license_plate }}</div>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                @else
                    <span>
                        <i class="fas fa-search me-2"></i>
                        Select Vehicle to View History
                    </span>
                    <i class="fas fa-chevron-down"></i>
                @endif
            </button>
            
            @if($selectedVehicle)
            <div class="action-buttons mt-3">
                <button class="btn-action btn-add" onclick="window.location.href='{{ route('vehicles.create') }}'">
                    <i class="fas fa-plus"></i>
                    Add New Vehicle
                </button>
                <button class="btn-action btn-manage" onclick="window.location.href='{{ route('vehicles.edit', $selectedVehicle->license_plate) }}'">
                    <i class="fas fa-cog"></i>
                    Manage Vehicle
                </button>
            </div>
            @endif
        </div>
    </div>
    
    @if($selectedVehicle)
    <!-- Section 2: History View -->
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon icon-success">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <span>History View - {{ $selectedVehicle->name }}</span>
                </div>
                <form method="GET" action="{{ route('history.download') }}" style="display: inline;">
                    <input type="hidden" name="vehicle_id" value="{{ $selectedVehicle->id }}">
                    <button type="submit" class="btn-action btn-download">
                        <i class="fas fa-download"></i>
                        Download Detail
                    </button>
                </form>
            </div>
            
            @if($historyData && count($historyData) > 0)
            <div class="table-responsive">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyData as $item)
                        <tr>
                            <td>{{ $item['date'] }}</td>
                            <td>
                                <span class="type-badge badge-{{ strtolower($item['type']) }}">
                                    {{ $item['type'] }}
                                </span>
                            </td>
                            <td>{{ $item['category'] }}</td>
                            <td>
                                <span class="{{ $item['type'] == 'Income' ? 'amount-positive' : 'amount-negative' }}">
                                    {{ $item['type'] == 'Income' ? '+' : '-' }} Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td>{{ $item['notes'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="empty-message">No transaction history yet</div>
                <div class="empty-hint">Start adding income, service, or expense records</div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Section 3: Last Month Performance Capture -->
    @if($lastMonthPerformance)
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon icon-info">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Last Month Performance - {{ $lastMonthPerformance['month'] }}</span>
                </div>
            </div>
            
            <div class="performance-grid">
                <div class="performance-item">
                    <div class="performance-label">Income</div>
                    <div class="performance-value value-income">
                        Rp {{ number_format($lastMonthPerformance['income'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Service</div>
                    <div class="performance-value value-service">
                        Rp {{ number_format($lastMonthPerformance['service'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Expense</div>
                    <div class="performance-value value-expense">
                        Rp {{ number_format($lastMonthPerformance['expense'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Balance</div>
                    <div class="performance-value value-balance">
                        Rp {{ number_format($lastMonthPerformance['balance'], 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @else
    <!-- Empty State: No Vehicle Selected -->
    <div class="col-12">
        <div class="section-card">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-mouse-pointer"></i>
                </div>
                <div class="empty-message">Please select a vehicle to view history</div>
                <div class="empty-hint">Choose a vehicle from the dropdown above</div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Vehicle Selection Modal -->
<div class="modal fade vehicle-modal" id="vehicleSelectModal" tabindex="-1" aria-labelledby="vehicleSelectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleSelectModalLabel">Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Search Box -->
                <div class="vehicle-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="vehicleSearch" placeholder="Search Vehicle..." class="form-control">
                </div>
                
                <!-- Vehicle List -->
                <div class="vehicle-list" id="vehicleList">
                    @foreach($vehicles as $vehicle)
                    <div class="vehicle-item" data-vehicle-id="{{ $vehicle->id }}" 
                         data-vehicle-name="{{ strtolower($vehicle->name . ' ' . $vehicle->license_plate) }}"
                         onclick="selectVehicle({{ $vehicle->id }})">
                        <div class="vehicle-brand-logo">
                            @php
                                // Logo path berdasarkan brand
                                $brandLower = strtolower($vehicle->brand ?? 'default');
                                $logoPath = asset('assets/logos/brands/' . $brandLower . '.svg');
                                
                                // Check if logo file exists, fallback to default icon
                                $logoExists = file_exists(public_path('assets/logos/brands/' . $brandLower . '.svg'));
                            @endphp
                            @if($logoExists)
                                <img src="{{ $logoPath }}" alt="{{ $vehicle->brand }}">
                            @else
                                <i class="fas fa-car" style="font-size: 24px; color: #7f8c8d;"></i>
                            @endif
                        </div>
                        <div class="vehicle-info">
                            <div class="vehicle-name">{{ $vehicle->name }}</div>
                            <div class="vehicle-plate">{{ $vehicle->license_plate }}</div>
                        </div>
                        <i class="fas fa-truck vehicle-status-icon"></i>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vehicle Search Filter
document.getElementById('vehicleSearch')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const vehicleItems = document.querySelectorAll('.vehicle-item');
    
    vehicleItems.forEach(item => {
        const vehicleName = item.getAttribute('data-vehicle-name');
        if (vehicleName.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});

// Select Vehicle Function
function selectVehicle(vehicleId) {
    window.location.href = '{{ route("history.index") }}?vehicle_id=' + vehicleId;
}
</script>
@endsection
