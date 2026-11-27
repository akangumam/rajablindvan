{{-- cspell:disable --}}
@extends('layouts.drivvo')

@section('title', 'Vehicle History')

@section('content')
<link rel="stylesheet" href="{{ asset('css/timeline-history.css') }}">

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-history"></i>
        Vehicle History
    </h1>
    <p class="page-subtitle">View and download comprehensive vehicle maintenance records and history</p>
</div>

<!-- Session Alerts -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(46, 204, 113, 0.15); background: #e8f8f0; color: #27ae60;">
    <i class="fas fa-check-circle me-2" style="font-size: 18px;"></i>
    <div style="flex: 1; font-weight: 500;">{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-3" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(231, 76, 60, 0.15); background: #fdeeee; color: #e74c3c;">
    <i class="fas fa-exclamation-circle me-2" style="font-size: 18px;"></i>
    <div style="flex: 1; font-weight: 500;">{{ session('error') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<style>
    /* Timeline Action Buttons */
    .btn-timeline-edit {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0f4ff;
        color: #4361ee;
        border: 1px solid #d0dbff;
        padding: 4px 10px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-timeline-edit:hover {
        background: #4361ee;
        color: white;
        border-color: #4361ee;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(67, 97, 238, 0.25);
    }

    .btn-timeline-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: #fff0f0;
        color: #e63946;
        border: 1px solid #ffd6d9;
        border-radius: 7px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-timeline-delete:hover {
        background: #e63946;
        color: white;
        border-color: #e63946;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(230, 57, 70, 0.25);
    }

    .section-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 16px 20px;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .section-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title {
        font-size: 15px;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
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
        padding: 10px 14px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
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

    .value-primary {
        color: #0d6efd;
    }

    .value-income {
        color: #27ae60;
    }

    .value-service {
        color: #3498db;
    }

    .value-expense {
        color: #e74c3c;
    }

    .value-balance {
        color: #27ae60;
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

    /* Period Filter */
    .period-filter-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 0;
    }

    .period-select {
        height: 36px;
        padding: 0 12px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }

    .period-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }

    .custom-date-row {
        display: none;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 2px 4px 2px 6px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .custom-date-row.show {
        display: inline-flex;
        flex-wrap: nowrap;
    }

    /* Target all inputs inside custom-date-row including Flatpickr-injected inputs */
    .custom-date-row input,
    .custom-date-row .form-control,
    .custom-date-row .flatpickr-input {
        width: 125px !important;
        min-width: 110px !important;
        max-width: 135px !important;
        height: 30px !important;
        padding: 4px 8px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #1e293b !important;
        background-color: #ffffff !important;
        display: inline-block !important;
        box-shadow: none !important;
        line-height: normal !important;
        text-align: center;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-date-row input:focus,
    .custom-date-row .form-control:focus,
    .custom-date-row .flatpickr-input:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2) !important;
        outline: none !important;
    }

    .custom-date-sep {
        color: #94a3b8;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
        user-select: none;
        flex-shrink: 0;
    }

    .btn-apply-period {
        height: 30px;
        padding: 0 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(102, 126, 234, 0.25);
    }

    .btn-apply-period:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.35);
        color: #ffffff;
    }

    .btn-apply-period:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .period-filter-wrap {
            width: 100%;
            justify-content: flex-start;
        }

        .custom-date-row.show {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            padding: 8px;
            gap: 8px;
        }

        .custom-date-row input,
        .custom-date-row .form-control,
        .custom-date-row .flatpickr-input {
            width: calc(50% - 15px) !important;
            min-width: 100px !important;
            max-width: none !important;
            flex: 1;
        }

        .btn-apply-period {
            width: 100%;
            justify-content: center;
            margin-top: 4px;
        }
    }

    /* History Timeline Search Box */
    .history-search-wrapper {
        position: relative;
        min-width: 280px;
    }

    @media (max-width: 576px) {
        .history-search-wrapper {
            min-width: 100%;
            width: 100%;
        }
    }

    .history-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
        z-index: 2;
    }

    .history-search-input {
        padding-left: 34px !important;
        padding-right: 32px !important;
        height: 38px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .history-search-input:focus {
        background-color: #ffffff;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        outline: none;
    }

    .btn-clear-history-search {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        padding: 0;
        width: 22px;
        height: 22px;
        border: none;
        background: transparent;
        color: #94a3b8;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
    }

    .btn-clear-history-search:hover {
        color: #e74c3c;
    }

    /* Drivvo-style Service Breakdown inside Timeline Card */
    .service-breakdown-box {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #e2e8f0;
    }

    .service-breakdown-title {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 6px;
    }

    .service-breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #334155;
        padding: 3px 0;
    }

    .service-breakdown-price {
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        margin-left: 12px;
    }

    /* Drivvo-style Edit Service Item Rows in Modal */
    .edit-service-item-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        background: #ffffff;
        padding: 8px 10px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .edit-service-item-row .service-name-col {
        flex: 1 1 55%;
        min-width: 140px;
    }

    .edit-service-item-row .service-price-col {
        flex: 0 0 150px;
    }

    .btn-remove-service-row {
        width: 30px;
        height: 30px;
        border: none;
        background: #fee2e2;
        color: #dc2626;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
    }

    .btn-remove-service-row:hover {
        background: #dc2626;
        color: #ffffff;
    }

    .service-total-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        margin-top: 8px;
        border-top: 1px solid #cbd5e1;
        font-size: 14px;
    }

    @media (max-width: 576px) {
        .edit-service-item-row {
            flex-wrap: wrap;
        }
        .edit-service-item-row .service-name-col {
            flex: 1 1 100%;
        }
        .edit-service-item-row .service-price-col {
            flex: 1 1 calc(100% - 40px);
        }
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
                    <span>Select Vehicle to View History</span>
                    <i class="fas fa-chevron-down"></i>
                @endif
            </button>

            @if($selectedVehicle)
            <div class="action-buttons mt-3">
                <button class="btn-action btn-add" onclick="window.location.href='{{ route('vehicles.create') }}'">
                    <i class="fas fa-plus"></i>
                    Add New Vehicle
                </button>
                <button class="btn-action btn-manage" onclick="window.location.href='{{ route('vehicles.show', $selectedVehicle->id) }}'">
                    <i class="fas fa-cog"></i>
                    Manage Vehicle
                </button>
            </div>
            @endif
        </div>
    </div>

    @if($selectedVehicle)
    <!-- Section 2: Performance -->
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon icon-info">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Performance</span>
                    @if($performance)
                    <small class="text-muted fw-normal" style="font-size:12px;">— {{ $performance['label'] }}</small>
                    @endif
                </div>
                <!-- Period Filter -->
                <form method="GET" action="{{ route('history.index') }}" id="periodForm" class="period-filter-wrap">
                    <input type="hidden" name="vehicle_id" value="{{ $selectedVehicle->id }}">
                    <select name="period" class="period-select" onchange="handlePeriodChange(this)">
                        <option value="this_month" {{ request('period', 'last_month') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="last_month" {{ request('period', 'last_month') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                        <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    <div class="custom-date-row {{ request('period') == 'custom' ? 'show' : '' }}" id="customDateRow">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" max="{{ date('Y-m-d') }}" placeholder="Tgl Mulai">
                        <span class="custom-date-sep"><i class="fas fa-arrow-right"></i></span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" max="{{ date('Y-m-d') }}" placeholder="Tgl Akhir">
                        <button type="submit" class="btn-apply-period">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                    </div>
                </form>
            </div>

            @if($performance)
            <div class="performance-grid">
                <div class="performance-item">
                    <div class="performance-label">Total Transaksi</div>
                    <div class="performance-value value-primary">
                        {{ number_format($performance['total_transactions']) }}
                    </div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Total Pendapatan</div>
                    <div class="performance-value value-income">
                        Rp {{ number_format($performance['total_income'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Total Biaya</div>
                    <div class="performance-value value-expense">
                        Rp {{ number_format($performance['total_cost'], 0, ',', '.') }}
                    </div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">Balance (Total pendapatan - Total Biaya)</div>
                    <div class="performance-value {{ $performance['balance'] >= 0 ? 'value-income' : 'value-expense' }}">
                        Rp {{ number_format($performance['balance'], 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @else
            <p class="text-muted mb-0" style="font-size:13px;">Pilih rentang tanggal untuk melihat data.</p>
            @endif
        </div>
    </div>

    <!-- Section 3: History View -->
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon icon-success">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <span>History View - {{ $selectedVehicle->name }}</span>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- History Item Live Search Box -->
                    <div class="history-search-wrapper">
                        <i class="fas fa-search history-search-icon"></i>
                        <input type="text" 
                               id="historyItemSearch" 
                               class="form-control form-control-sm history-search-input" 
                               placeholder="Cari riwayat (misal: aki, oli, servis)..."
                               autocomplete="off">
                        <button type="button" 
                                id="clearHistoryItemSearch" 
                                class="btn-clear-history-search" 
                                title="Hapus pencarian" 
                                style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form method="GET" action="{{ route('history.download') }}" style="display: inline;">
                        <input type="hidden" name="vehicle_id" value="{{ $selectedVehicle->id }}">
                        <button type="submit" class="btn-action btn-download">
                            <i class="fas fa-download"></i>
                            Download Detail
                        </button>
                    </form>
                </div>
            </div>

            @if($groupedHistory && count($groupedHistory) > 0)
            <!-- Search Results Notice -->
            <div id="historySearchNotice" class="alert alert-light py-2 px-3 border mb-3 d-flex align-items-center justify-content-between" style="display: none; border-radius: 8px; font-size: 13px;">
                <div>
                    <i class="fas fa-filter text-primary me-2"></i>
                    Menampilkan <strong id="historyMatchCount" class="text-primary">0</strong> riwayat transaksi untuk "<strong id="historyMatchQuery"></strong>"
                </div>
                <button type="button" class="btn btn-sm btn-link text-muted p-0 text-decoration-none" onclick="document.getElementById('clearHistoryItemSearch').click()">
                    <i class="fas fa-times me-1"></i>Hapus Filter
                </button>
            </div>

            <!-- Empty Search Results State -->
            <div id="historySearchEmpty" class="empty-state" style="display: none; padding: 40px 20px; text-align: center;">
                <div class="empty-icon" style="font-size: 36px; color: #cbd5e1; margin-bottom: 12px;">
                    <i class="fas fa-search"></i>
                </div>
                <div class="empty-message" style="font-weight: 600; color: #475569; font-size: 15px;">
                    Tidak ditemukan riwayat untuk kata kunci "<span id="historySearchKeyword" class="text-primary"></span>"
                </div>
                <div class="empty-hint" style="color: #94a3b8; font-size: 13px; margin-top: 6px;">
                    Coba gunakan kata kunci lain seperti: oli, aki, ban, bbm, servis, dsb.
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="document.getElementById('clearHistoryItemSearch').click()">
                    <i class="fas fa-undo me-1"></i> Reset Pencarian
                </button>
            </div>

            <div class="history-timeline" id="historyTimelineContainer">
                @foreach($groupedHistory as $month => $records)
                <div class="timeline-month">
                    <div class="month-header">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $month }}</span>
                    </div>

                    @foreach($records as $index => $record)
                    @php
                        $recordDetails = $record->enriched_extra ?? (is_string($record->extra_data) ? json_decode($record->extra_data, true) : $record->extra_data);
                        if (!is_array($recordDetails)) {
                            $recordDetails = [];
                        }
                        $serviceItems = is_array($recordDetails['service_items'] ?? null) ? $recordDetails['service_items'] : [];
                        $serviceItemNames = collect($serviceItems)->pluck('name')->filter()->implode(' ');
                        $searchTokens = [
                            $record->title,
                            $record->type,
                            str_replace('_', ' ', $record->type),
                            $record->description,
                            $record->location,
                            \Carbon\Carbon::parse($record->date)->format('d M Y'),
                            \Carbon\Carbon::parse($record->date)->format('d F Y'),
                            \Carbon\Carbon::parse($record->date)->format('d-m-Y'),
                            $record->odometer ? $record->odometer . ' km' : null,
                            $record->cost ? 'rp ' . number_format($record->cost, 0, ',', '.') : null,
                            $recordDetails['service_type'] ?? null,
                            $serviceItemNames ?: null,
                            $recordDetails['workshop'] ?? null,
                            $recordDetails['driver_name'] ?? null,
                            $recordDetails['payment_method'] ?? null,
                            $recordDetails['category'] ?? null,
                            $recordDetails['income_type'] ?? null,
                            $recordDetails['fuel_type'] ?? null,
                            isset($recordDetails['liters']) ? $recordDetails['liters'] . ' liter' : null,
                        ];
                        $searchKeywords = strtolower(implode(' ', array_filter($searchTokens)));
                    @endphp
                    <div class="timeline-item" data-search-text="{{ $searchKeywords }}">
                        <div class="timeline-indicator">
                            @if($index > 0)
                            <div class="timeline-line-top"></div>
                            @endif
                            <div class="timeline-icon {{ strtolower($record->type) }}">
                                @switch($record->type)
                                    @case('refueling')
                                        <i class="fas fa-gas-pump"></i>
                                        @break
                                    @case('oil_change')
                                        <i class="fas fa-oil-can"></i>
                                        @break
                                    @case('service')
                                        <i class="fas fa-tools"></i>
                                        @break
                                    @case('income')
                                        <i class="fas fa-wallet"></i>
                                        @break
                                    @case('registration')
                                        <i class="fas fa-file-alt"></i>
                                        @break
                                    @case('labor_cost')
                                        <i class="fas fa-user-tie"></i>
                                        @break
                                    @case('transport_application')
                                        <i class="fas fa-truck"></i>
                                        @break
                                    @case('work')
                                        <i class="fas fa-briefcase"></i>
                                        @break
                                    @case('checklist')
                                        <i class="fas fa-check-square"></i>
                                        @break
                                    @case('wash')
                                        <i class="fas fa-shower"></i>
                                        @break
                                    @case('parking')
                                        <i class="fas fa-parking"></i>
                                        @break
                                    @case('toll')
                                        <i class="fas fa-road"></i>
                                        @break
                                    @case('other')
                                        <i class="fas fa-receipt"></i>
                                        @break
                                    @default
                                        <i class="fas fa-circle"></i>
                                @endswitch
                            </div>
                            @if($index < count($records) - 1)
                            <div class="timeline-line-bottom"></div>
                            @endif
                        </div>

                        <div class="timeline-content">
                            <div class="timeline-header">
                                <div>
                                    <h4 class="mb-1">
                                        {{ $record->title ?: ucwords(str_replace('_', ' ', $record->type)) }}
                                        @if(count($serviceItems) > 1)
                                            <span class="badge bg-primary bg-opacity-10 text-primary ms-1" style="font-size: 11px; font-weight: 600;">+{{ count($serviceItems) - 1 }}</span>
                                        @endif
                                    </h4>
                                    <span class="timeline-date">
                                        <i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                                        @if(!empty($recordDetails['time']))
                                            <span class="ms-1 text-muted">· {{ $recordDetails['time'] }}</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="timeline-actions d-flex align-items-center gap-1">
                                    <button type="button" 
                                            class="btn-timeline-edit" 
                                            data-id="{{ $record->id }}"
                                            data-type="{{ $record->type }}"
                                            data-related-type="{{ $record->related_type ?? '' }}"
                                            data-title="{{ $record->title ?: ucwords(str_replace('_', ' ', $record->type)) }}"
                                            data-date="{{ \Carbon\Carbon::parse($record->date)->format('Y-m-d') }}"
                                            data-time="{{ $recordDetails['time'] ?? '' }}"
                                            data-odometer="{{ $record->odometer ?? '' }}"
                                            data-cost="{{ (float) $record->cost }}"
                                            data-location="{{ $record->location ?? '' }}"
                                            data-description="{{ $record->description ?? '' }}"
                                            data-extra="{{ json_encode($recordDetails) }}"
                                            title="Edit Catatan Riwayat">
                                        <i class="fas fa-pencil-alt"></i>
                                        <span>Edit</span>
                                    </button>
                                    @if(auth()->user() && auth()->user()->canDeleteRecords())
                                    <button type="button" 
                                            class="btn-timeline-delete" 
                                            data-id="{{ $record->id }}"
                                            data-title="{{ $record->title ?: ucwords(str_replace('_', ' ', $record->type)) }}"
                                            data-date="{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}"
                                            title="Hapus Catatan Riwayat">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>

                            <div class="timeline-details">
                                @php $details = $recordDetails; @endphp

                                @if(!empty($details['liters']))
                                <div class="detail-item">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>{{ $details['liters'] }} Liter @if(!empty($details['fuel_type']))({{ $details['fuel_type'] }})@endif</span>
                                </div>
                                @endif

                                @if($record->odometer)
                                <div class="detail-item">
                                    <i class="fas fa-road"></i>
                                    <span>{{ number_format($record->odometer) }} km</span>
                                </div>
                                @endif

                                @if($record->location)
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $record->location }}</span>
                                </div>
                                @endif

                                @if(!empty($details['driver_name']))
                                <div class="detail-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $details['driver_name'] }}</span>
                                </div>
                                @endif

                                @if(!empty($details['payment_method']))
                                <div class="detail-item">
                                    <i class="fas fa-credit-card"></i>
                                    <span>{{ $details['payment_method'] }}</span>
                                </div>
                                @endif

                                @if($record->description)
                                <div class="detail-item">
                                    <i class="fas fa-comment"></i>
                                    <span>{{ $record->description }}</span>
                                </div>
                                @endif
                            </div>

                            @if(count($serviceItems) > 0)
                            <div class="service-breakdown-box">
                                <div class="service-breakdown-title">Jenis Servis</div>
                                @foreach($serviceItems as $sItem)
                                <div class="service-breakdown-row">
                                    <span>{{ $sItem['name'] ?? '-' }}</span>
                                    <span class="service-breakdown-price">
                                        @if(isset($sItem['price']) && $sItem['price'] !== null && $sItem['price'] !== '')
                                            Rp {{ number_format((float)$sItem['price'], 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @elseif(!empty($details['service_type']))
                            <div class="service-breakdown-box">
                                <div class="service-breakdown-title">Jenis Servis</div>
                                <div class="service-breakdown-row">
                                    <span>{{ $details['service_type'] }}</span>
                                    <span class="service-breakdown-price">Rp {{ number_format($record->cost, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endif

                            <div class="timeline-cost {{ $record->type === 'income' ? 'text-success' : '' }}">
                                {{ $record->type === 'income' ? '+' : '' }}Rp {{ number_format($record->cost, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="empty-message">No transaction history yet</div>
                <div class="empty-hint">Start adding fuel fills, maintenance, or expense records</div>
            </div>
            @endif
        </div>
    </div>
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
                <div class="vehicle-search-box" style="padding: 0 20px;">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                        <input type="text" id="vehicleSearch" placeholder="Search Vehicle..." class="form-control" style="padding-left: 40px; padding-right: 40px;" autofocus>
                        <button type="button"
                                class="btn btn-sm position-absolute clear-vehicle-search"
                                style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none;"
                                onclick="document.getElementById('vehicleSearch').value=''; filterVehicles();">
                            <i class="fas fa-times text-muted"></i>
                        </button>
                    </div>
                </div>

                <!-- Vehicle List -->
                <div class="vehicle-list" id="vehicleList">
                    @foreach($vehicles as $vehicle)
                    <div class="vehicle-item {{ $selectedVehicle && $selectedVehicle->id == $vehicle->id ? 'selected' : '' }}" data-vehicle-id="{{ $vehicle->id }}"
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

@if($selectedVehicle)
<!-- Modal Edit History -->
<div class="modal fade" id="editHistoryModal" tabindex="-1" aria-labelledby="editHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 45px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 18px 24px; border: none;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-edit" style="font-size: 16px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="editHistoryModalLabel" style="font-weight: 700; font-size: 18px;">Edit Catatan Riwayat</h5>
                        <small style="opacity: 0.85; font-size: 12px;">{{ $selectedVehicle->name }} ({{ $selectedVehicle->license_plate }})</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editHistoryForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_record_id">
                <input type="hidden" name="service_items_json" id="edit_service_items_json">
                <div class="modal-body" style="padding: 24px; background: #fafbfe; max-height: 75vh; overflow-y: auto;">
                    <div class="row g-3">
                        <!-- Tanggal & Waktu (Drivvo Style) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="far fa-calendar-alt me-1 text-primary"></i>Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="date" id="edit_date" class="form-control" required style="border-radius: 10px; padding: 10px 14px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="far fa-clock me-1 text-primary"></i>Waktu
                            </label>
                            <input type="time" name="time" id="edit_time" class="form-control" style="border-radius: 10px; padding: 10px 14px;">
                        </div>

                        <!-- Odometer & Judul -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="fas fa-tachometer-alt me-1 text-primary"></i>Odometer (km)
                            </label>
                            <div class="input-group">
                                <input type="number" name="odometer" id="edit_odometer" class="form-control" min="0" placeholder="Contoh: 77300" style="border-radius: 10px 0 0 10px; padding: 10px 14px;">
                                <span class="input-group-text" style="border-radius: 0 10px 10px 0; background: #f0f2f5;">km</span>
                            </div>
                            <small class="text-muted" style="font-size: 11.5px;">Odometer terakhir kendaraan: <strong>{{ number_format($selectedVehicle->getLatestOdometer(), 0, ',', '.') }} km</strong></small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="fas fa-heading me-1 text-primary"></i>Judul Transaksi
                            </label>
                            <input type="text" name="title" id="edit_title" class="form-control" placeholder="Otomatis dari jenis transaksi / isi manual" style="border-radius: 10px; padding: 10px 14px;">
                        </div>

                        <!-- Extra: Service Fields (Drivvo Style Multi-Item + Individual Prices) -->
                        <div id="serviceExtraSection" class="col-12" style="display: none;">
                            <div style="background: #f0f7ff; border: 1px solid #dbeafe; border-radius: 12px; padding: 16px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0" style="color: #2563eb; font-size: 14px;">
                                        <i class="fas fa-wrench me-1"></i> Rincian Jenis Servis
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddServiceItem" style="border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-plus me-1"></i> Tambah Jenis Servis
                                    </button>
                                </div>

                                <div id="editServiceItemsList" class="mt-2">
                                    <!-- Dynamic service rows rendered by JS -->
                                </div>

                                <div class="service-total-bar">
                                    <span class="text-muted fw-semibold">Total Biaya Servis</span>
                                    <span class="fw-bold text-primary" id="editServiceTotalDisplay" style="font-size: 16px;">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Extra: Fuel Fields -->
                        <div id="fuelExtraSection" class="col-12" style="display: none;">
                            <div style="background: #fff8eb; border: 1px solid #ffe8cc; border-radius: 12px; padding: 16px;">
                                <h6 class="fw-bold mb-3" style="color: #d97706; font-size: 14px;">
                                    <i class="fas fa-gas-pump me-1"></i> Rincian Pengisian BBM
                                </h6>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size: 12px;">Jenis BBM</label>
                                        <input type="text" name="fuel_type" id="edit_fuel_type" class="form-control form-control-sm" placeholder="Pertamax, Solar, dll" style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size: 12px;">Jumlah Liter</label>
                                        <input type="number" step="0.01" name="liters" id="edit_liters" class="form-control form-control-sm" placeholder="0.00" style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size: 12px;">Harga per Liter (Rp)</label>
                                        <input type="number" step="any" name="price_per_liter" id="edit_price_per_liter" class="form-control form-control-sm" placeholder="0" style="border-radius: 8px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Extra: Income Type -->
                        <div id="incomeExtraSection" class="col-12" style="display: none;">
                            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 16px;">
                                <label class="form-label fw-semibold mb-1" style="font-size: 13px; color: #059669;">
                                    <i class="fas fa-wallet me-1"></i> Jenis Pendapatan
                                </label>
                                <select name="income_type" id="edit_income_type" class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option value="">-- Pilih Jenis Pendapatan --</option>
                                    @foreach($incomeTypes ?? [] as $it)
                                        <option value="{{ $it->name }}">{{ $it->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Extra: Expense Type -->
                        <div id="expenseExtraSection" class="col-12" style="display: none;">
                            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px;">
                                <label class="form-label fw-semibold mb-1" style="font-size: 13px; color: #dc2626;">
                                    <i class="fas fa-receipt me-1"></i> Jenis Pengeluaran
                                </label>
                                <select name="expense_type" id="edit_expense_type" class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option value="">-- Pilih Jenis Pengeluaran --</option>
                                    @foreach($expenseTypes ?? [] as $et)
                                        <option value="{{ $et->name }}">{{ $et->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Total Biaya & Tempat -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;" id="label_cost">
                                <i class="fas fa-money-bill-wave me-1 text-primary"></i>Total Biaya (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #f0f2f5; font-weight: 600;">Rp</span>
                                <input type="number" step="any" name="cost" id="edit_cost" class="form-control" required min="0" placeholder="0" style="border-radius: 0 10px 10px 0; padding: 10px 14px;">
                            </div>
                        </div>
                        <div class="col-md-6" id="locationWrapper">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;" id="label_location">
                                <i class="fas fa-map-marker-alt me-1 text-primary"></i>Tempat / Lokasi
                            </label>
                            <select id="edit_location_select" class="form-select" style="border-radius: 10px; padding: 10px 14px;">
                                <option value="">-- Pilih Tempat --</option>
                                @foreach($places ?? [] as $pl)
                                    <option value="{{ $pl->name }}">{{ $pl->name }}</option>
                                @endforeach
                                <option value="__custom__">+ Ketik Nama Tempat Manual...</option>
                            </select>
                            <input type="text" id="edit_location_manual" class="form-control mt-2" placeholder="Ketik nama tempat / bengkel..." style="display: none; border-radius: 10px; padding: 10px 14px;">
                            <input type="hidden" name="location" id="edit_location">
                        </div>

                        <!-- Pengemudi / Penanggung Jawab & Metode Pembayaran -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="fas fa-user me-1 text-primary"></i>Pengemudi / Penanggung Jawab
                            </label>
                            <select name="user_id" id="edit_user_id" class="form-select" style="border-radius: 10px; padding: 10px 14px;">
                                <option value="">-- Pilih Pengemudi / Pengguna --</option>
                                @foreach($users ?? [] as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} @if($u->user_type)({{ $u->user_type }})@endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6" id="paymentMethodWrapper">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="fas fa-credit-card me-1 text-primary"></i>Metode Pembayaran
                            </label>
                            <select name="payment_method" id="edit_payment_method" class="form-select" style="border-radius: 10px; padding: 10px 14px;">
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                @foreach($paymentMethods ?? [] as $pm)
                                    <option value="{{ $pm->name }}">{{ $pm->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Catatan / Deskripsi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size: 13px; color: #2c3e50;">
                                <i class="fas fa-sticky-note me-1 text-primary"></i>Catatan / Deskripsi
                            </label>
                            <textarea name="description" id="edit_description" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)..." style="border-radius: 10px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #eef0f5; background: white;">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete History -->
<div class="modal fade" id="deleteHistoryModal" tabindex="-1" aria-labelledby="deleteHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 45px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 18px 24px; border: none;">
                <h5 class="modal-title mb-0" id="deleteHistoryModalLabel" style="font-weight: 700; font-size: 18px;">
                    <i class="fas fa-trash-alt me-2"></i> Konfirmasi Hapus Riwayat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteHistoryForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center" style="padding: 30px 24px;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5 style="color: #1f2937; font-weight: 600; margin-bottom: 8px;">Hapus Catatan Ini?</h5>
                    <p style="color: #6b7280; font-size: 14px; margin-bottom: 0;">
                        Apakah Anda yakin ingin menghapus catatan <strong id="delete_record_title" style="color:#1f2937;"></strong> (<span id="delete_record_date"></span>)? Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="modal-footer justify-content-center" style="padding: 16px 24px; border: none; background: #f9fafb;">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-danger px-4" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-trash-alt me-1"></i> Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
// Vehicle Search Filter
function filterVehicles() {
    const vehicleSearchInput = document.getElementById('vehicleSearch');
    const clearBtn = document.querySelector('.clear-vehicle-search');

    if (!vehicleSearchInput) return;

    const searchTerm = vehicleSearchInput.value.toLowerCase();
    const vehicleItems = document.querySelectorAll('.vehicle-item');

    // Show/hide clear button
    if (clearBtn) {
        clearBtn.style.display = searchTerm ? 'block' : 'none';
    }

    vehicleItems.forEach(item => {
        const vehicleName = item.getAttribute('data-vehicle-name');
        if (vehicleName.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const vehicleSearchInput = document.getElementById('vehicleSearch');

    // Add live search event listener
    if (vehicleSearchInput) {
        vehicleSearchInput.addEventListener('input', filterVehicles);
    }

    // Auto-focus when modal opens
    const vehicleModal = document.getElementById('vehicleSelectModal');
    if (vehicleModal) {
        vehicleModal.addEventListener('shown.bs.modal', function() {
            const searchInput = document.getElementById('vehicleSearch');
            if (searchInput) {
                searchInput.focus();
            }
        });
    }

    // Auto calculate fuel cost when liters or price_per_liter change
    const litersInput = document.getElementById('edit_liters');
    const priceInput = document.getElementById('edit_price_per_liter');
    const costInput = document.getElementById('edit_cost');

    function calcFuelCost() {
        const l = parseFloat(litersInput.value) || 0;
        const p = parseFloat(priceInput.value) || 0;
        if (l > 0 && p > 0) {
            costInput.value = Math.round(l * p);
        }
    }
    if (litersInput && priceInput) {
        litersInput.addEventListener('input', calcFuelCost);
        priceInput.addEventListener('input', calcFuelCost);
    }

    // Master service types for dynamic Drivvo-style edit rows
    const masterServiceTypes = @json($serviceTypes ?? []);
    let editServiceItems = [];

    function syncEditServiceItems() {
        const listEl = document.getElementById('editServiceItemsList');
        const hiddenJson = document.getElementById('edit_service_items_json');
        const totalDisplay = document.getElementById('editServiceTotalDisplay');
        const costInput = document.getElementById('edit_cost');

        if (!listEl) return;

        let total = 0;
        let hasAnyPrice = false;
        editServiceItems.forEach(item => {
            const p = parseFloat(item.price);
            if (!isNaN(p) && p >= 0 && item.price !== '' && item.price !== null) {
                total += p;
                hasAnyPrice = true;
            }
        });

        if (totalDisplay) {
            totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        if (hasAnyPrice && costInput && document.getElementById('serviceExtraSection').style.display !== 'none') {
            costInput.value = Math.round(total);
        }
        if (hiddenJson) {
            hiddenJson.value = JSON.stringify(editServiceItems);
        }
    }

    function renderEditServiceRows() {
        const listEl = document.getElementById('editServiceItemsList');
        if (!listEl) return;

        listEl.innerHTML = '';

        if (editServiceItems.length === 0) {
            editServiceItems.push({ name: '', price: '' });
        }

        editServiceItems.forEach((item, idx) => {
            const row = document.createElement('div');
            row.className = 'edit-service-item-row';

            const nameCol = document.createElement('div');
            nameCol.className = 'service-name-col';

            const select = document.createElement('select');
            select.className = 'form-select form-select-sm';
            select.style.borderRadius = '8px';

            const emptyOpt = document.createElement('option');
            emptyOpt.value = '';
            emptyOpt.textContent = '-- Pilih Jenis Servis --';
            select.appendChild(emptyOpt);

            let matchedMaster = false;
            masterServiceTypes.forEach(st => {
                const opt = document.createElement('option');
                opt.value = st.name;
                opt.textContent = st.name;
                opt.dataset.price = st.price || '';
                if (item.name && st.name.toLowerCase() === item.name.toLowerCase()) {
                    opt.selected = true;
                    matchedMaster = true;
                }
                select.appendChild(opt);
            });

            const customOpt = document.createElement('option');
            customOpt.value = '__custom__';
            customOpt.textContent = '+ Ketik Nama Servis Manual...';
            if (item.name && !matchedMaster) {
                customOpt.selected = true;
            }
            select.appendChild(customOpt);

            const customInput = document.createElement('input');
            customInput.type = 'text';
            customInput.className = 'form-control form-control-sm mt-1';
            customInput.placeholder = 'Nama servis...';
            customInput.style.borderRadius = '8px';
            customInput.value = (!matchedMaster && item.name) ? item.name : '';
            customInput.style.display = (item.name && !matchedMaster) ? 'block' : 'none';

            select.addEventListener('change', function() {
                if (this.value === '__custom__') {
                    customInput.style.display = 'block';
                    customInput.focus();
                    editServiceItems[idx].name = customInput.value.trim();
                } else {
                    customInput.style.display = 'none';
                    editServiceItems[idx].name = this.value;
                    const selectedOption = this.options[this.selectedIndex];
                    const refPrice = selectedOption ? selectedOption.dataset.price : '';
                    if ((editServiceItems[idx].price === '' || editServiceItems[idx].price === null) && refPrice) {
                        editServiceItems[idx].price = refPrice;
                        priceInput.value = refPrice;
                    }
                }
                syncEditServiceItems();
            });

            customInput.addEventListener('input', function() {
                editServiceItems[idx].name = this.value;
                syncEditServiceItems();
            });

            nameCol.appendChild(select);
            nameCol.appendChild(customInput);

            const priceCol = document.createElement('div');
            priceCol.className = 'service-price-col input-group input-group-sm';

            const rpSpan = document.createElement('span');
            rpSpan.className = 'input-group-text';
            rpSpan.textContent = 'Rp';

            const priceInput = document.createElement('input');
            priceInput.type = 'number';
            priceInput.step = 'any';
            priceInput.min = '0';
            priceInput.className = 'form-control';
            priceInput.placeholder = '0';
            priceInput.value = (item.price !== null && item.price !== undefined) ? item.price : '';
            priceInput.addEventListener('input', function() {
                editServiceItems[idx].price = this.value;
                syncEditServiceItems();
            });

            priceCol.appendChild(rpSpan);
            priceCol.appendChild(priceInput);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-service-row';
            removeBtn.title = 'Hapus item';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.addEventListener('click', function() {
                editServiceItems.splice(idx, 1);
                renderEditServiceRows();
                syncEditServiceItems();
            });

            row.appendChild(nameCol);
            row.appendChild(priceCol);
            row.appendChild(removeBtn);
            listEl.appendChild(row);
        });

        syncEditServiceItems();
    }

    document.getElementById('btnAddServiceItem')?.addEventListener('click', function() {
        editServiceItems.push({ name: '', price: '' });
        renderEditServiceRows();
    });

    // Location Select <-> Manual sync
    const locSelect = document.getElementById('edit_location_select');
    const locManual = document.getElementById('edit_location_manual');
    const locHidden = document.getElementById('edit_location');

    function setModalLocationValue(val) {
        if (!locSelect || !locManual || !locHidden) return;
        const cleanVal = (val || '').trim();
        locHidden.value = cleanVal;

        if (!cleanVal) {
            locSelect.value = '';
            locManual.style.display = 'none';
            locManual.value = '';
            return;
        }

        let found = false;
        Array.from(locSelect.options).forEach(opt => {
            if (opt.value && opt.value !== '__custom__' && opt.value.toLowerCase() === cleanVal.toLowerCase()) {
                locSelect.value = opt.value;
                found = true;
            }
        });

        if (found) {
            locManual.style.display = 'none';
            locManual.value = '';
        } else {
            locSelect.value = '__custom__';
            locManual.style.display = 'block';
            locManual.value = cleanVal;
        }
    }

    if (locSelect && locManual && locHidden) {
        locSelect.addEventListener('change', function() {
            if (this.value === '__custom__') {
                locManual.style.display = 'block';
                locManual.focus();
                locHidden.value = locManual.value.trim();
            } else {
                locManual.style.display = 'none';
                locHidden.value = this.value;
            }
        });
        locManual.addEventListener('input', function() {
            locHidden.value = this.value.trim();
        });
    }

    // Bind Edit Button Clicks
    document.querySelectorAll('.btn-timeline-edit').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id          = this.getAttribute('data-id');
            const type        = this.getAttribute('data-type');
            const relatedType = this.getAttribute('data-related-type') || '';
            const title       = this.getAttribute('data-title');
            const date        = this.getAttribute('data-date');
            const time        = this.getAttribute('data-time');
            const odometer    = this.getAttribute('data-odometer');
            const cost        = this.getAttribute('data-cost');
            const location    = this.getAttribute('data-location');
            const description = this.getAttribute('data-description');
            let extra = {};
            try {
                extra = JSON.parse(this.getAttribute('data-extra')) || {};
            } catch(err) {
                extra = {};
            }

            // Set Form Action
            const form = document.getElementById('editHistoryForm');
            form.action = '{{ url("history") }}/' + id;

            // Fill Common Form Inputs
            document.getElementById('edit_record_id').value = id;
            document.getElementById('edit_title').value = title || '';

            const dateInput = document.getElementById('edit_date');
            dateInput.value = date || '';
            if (dateInput._flatpickr) {
                dateInput._flatpickr.setDate(date, true);
            }

            document.getElementById('edit_time').value = time || extra.time || '';
            document.getElementById('edit_odometer').value = odometer || '';
            document.getElementById('edit_cost').value = cost || '';
            document.getElementById('edit_description').value = description || '';

            // Set Location (Place)
            setModalLocationValue(location || extra.workshop || '');

            // Set Driver / User
            const userSelect = document.getElementById('edit_user_id');
            if (userSelect) {
                userSelect.value = extra.user_id || '';
            }

            // Set Payment Method (preserve custom option if missing from master list)
            const pmSelect = document.getElementById('edit_payment_method');
            if (pmSelect) {
                const pmVal = (extra.payment_method || '').trim();
                if (pmVal) {
                    let matchedPm = Array.from(pmSelect.options).find(o => o.value.toLowerCase() === pmVal.toLowerCase());
                    if (!matchedPm) {
                        const tmpOpt = document.createElement('option');
                        tmpOpt.value = pmVal;
                        tmpOpt.textContent = pmVal;
                        pmSelect.appendChild(tmpOpt);
                        matchedPm = tmpOpt;
                    }
                    pmSelect.value = matchedPm.value;
                } else {
                    pmSelect.value = '';
                }
            }

            // Toggle Type-Specific Sections
            const fuelSection    = document.getElementById('fuelExtraSection');
            const serviceSection = document.getElementById('serviceExtraSection');
            const incomeSection  = document.getElementById('incomeExtraSection');
            const expenseSection = document.getElementById('expenseExtraSection');
            const locWrapper     = document.getElementById('locationWrapper');
            const pmWrapper      = document.getElementById('paymentMethodWrapper');
            const labelCost      = document.getElementById('label_cost');
            const labelLocation  = document.getElementById('label_location');

            fuelSection.style.display    = 'none';
            serviceSection.style.display = 'none';
            incomeSection.style.display  = 'none';
            expenseSection.style.display = 'none';
            document.getElementById('edit_service_items_json').value = '';

            if (type === 'refueling') {
                fuelSection.style.display = 'block';
                locWrapper.style.display  = 'block';
                pmWrapper.style.display   = 'block';
                document.getElementById('edit_fuel_type').value = extra.fuel_type || '';
                document.getElementById('edit_liters').value = extra.liters || '';
                document.getElementById('edit_price_per_liter').value = extra.price_per_liter || '';
                labelLocation.innerHTML = '<i class="fas fa-gas-pump me-1 text-primary"></i>Nama SPBU / Tempat';
                labelCost.innerHTML     = '<i class="fas fa-money-bill-wave me-1 text-primary"></i>Total Biaya (Rp) <span class="text-danger">*</span>';
            } else if (type === 'service' || type === 'oil_change' || relatedType.endsWith('Maintenance')) {
                serviceSection.style.display = 'block';
                locWrapper.style.display     = 'block';
                pmWrapper.style.display      = 'block';
                labelLocation.innerHTML = '<i class="fas fa-map-marker-alt me-1 text-primary"></i>Tempat / Bengkel';
                labelCost.innerHTML     = '<i class="fas fa-money-bill-wave me-1 text-primary"></i>Total Biaya (Rp) <span class="text-danger">*</span>';

                // Populate itemized services
                if (Array.isArray(extra.service_items) && extra.service_items.length > 0) {
                    editServiceItems = extra.service_items.map(s => ({
                        name: s.name || '',
                        price: (s.price !== null && s.price !== undefined) ? s.price : ''
                    }));
                } else if (extra.service_type) {
                    const parts = extra.service_type.split(',').map(p => p.trim()).filter(Boolean);
                    editServiceItems = parts.map((p, i) => ({
                        name: p,
                        price: (parts.length === 1 && cost) ? cost : ''
                    }));
                } else {
                    editServiceItems = [];
                }
                renderEditServiceRows();
            } else if (type === 'income' || relatedType.endsWith('Income')) {
                incomeSection.style.display = 'block';
                locWrapper.style.display    = 'none';
                pmWrapper.style.display     = 'none';
                labelCost.innerHTML = '<i class="fas fa-money-bill-wave me-1 text-success"></i>Nilai Pendapatan (Rp) <span class="text-danger">*</span>';

                const incSelect = document.getElementById('edit_income_type');
                const incVal = (extra.income_type || title || '').trim();
                if (incSelect) {
                    if (incVal && !Array.from(incSelect.options).some(o => o.value.toLowerCase() === incVal.toLowerCase())) {
                        const opt = document.createElement('option');
                        opt.value = incVal;
                        opt.textContent = incVal;
                        incSelect.appendChild(opt);
                    }
                    const matched = Array.from(incSelect.options).find(o => o.value.toLowerCase() === incVal.toLowerCase());
                    incSelect.value = matched ? matched.value : '';
                }
            } else {
                expenseSection.style.display = 'block';
                locWrapper.style.display     = 'block';
                pmWrapper.style.display      = 'block';
                labelLocation.innerHTML = '<i class="fas fa-map-marker-alt me-1 text-primary"></i>Tempat / Lokasi';
                labelCost.innerHTML     = '<i class="fas fa-money-bill-wave me-1 text-primary"></i>Total Biaya (Rp) <span class="text-danger">*</span>';

                const expSelect = document.getElementById('edit_expense_type');
                const expVal = (extra.category || '').trim();
                if (expSelect) {
                    if (expVal && !Array.from(expSelect.options).some(o => o.value.toLowerCase() === expVal.toLowerCase())) {
                        const opt = document.createElement('option');
                        opt.value = expVal;
                        opt.textContent = expVal;
                        expSelect.appendChild(opt);
                    }
                    const matched = Array.from(expSelect.options).find(o => o.value.toLowerCase() === expVal.toLowerCase());
                    expSelect.value = matched ? matched.value : '';
                }
            }

            const editModal = new bootstrap.Modal(document.getElementById('editHistoryModal'));
            editModal.show();
        });
    });

    // Bind Delete Button Clicks
    document.querySelectorAll('.btn-timeline-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const date = this.getAttribute('data-date');

            const form = document.getElementById('deleteHistoryForm');
            form.action = '{{ url("history") }}/' + id;

            document.getElementById('delete_record_title').innerText = title;
            document.getElementById('delete_record_date').innerText = date;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteHistoryModal'));
            deleteModal.show();
        });
    });
});

// Select Vehicle Function
function selectVehicle(vehicleId) {
    window.location.href = '{{ route("history.index") }}?vehicle_id=' + vehicleId;
}

// Period Filter
function handlePeriodChange(select) {
    const customRow = document.getElementById('customDateRow');
    if (select.value === 'custom') {
        customRow.classList.add('show');
    } else {
        customRow.classList.remove('show');
        select.form.submit();
    }
}

document.getElementById('periodForm')?.addEventListener('submit', function(e) {
    const period = this.querySelector('select[name="period"]').value;
    if (period === 'custom') {
        const start = this.querySelector('input[name="start_date"]').value;
        const end = this.querySelector('input[name="end_date"]').value;
        if (!start || !end) {
            e.preventDefault();
            alert('Silakan tentukan tanggal mulai dan tanggal akhir terlebih dahulu.');
        }
    }
});

// History Item Live Search (Instant Filter without reload)
const historyItemSearch = document.getElementById('historyItemSearch');
const clearHistorySearchBtn = document.getElementById('clearHistoryItemSearch');
const historyNotice = document.getElementById('historySearchNotice');
const historyEmpty = document.getElementById('historySearchEmpty');
const historyTimelineContainer = document.getElementById('historyTimelineContainer');

if (historyItemSearch) {
    historyItemSearch.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const words = query ? query.split(/\s+/).filter(Boolean) : [];
        let totalMatches = 0;

        if (clearHistorySearchBtn) {
            clearHistorySearchBtn.style.display = query ? 'flex' : 'none';
        }

        const months = document.querySelectorAll('.timeline-month');
        months.forEach(function(month) {
            const items = month.querySelectorAll('.timeline-item');
            let monthMatches = 0;

            items.forEach(function(item) {
                const searchText = item.getAttribute('data-search-text') || item.innerText.toLowerCase();
                const matches = words.length === 0 || words.every(word => searchText.includes(word));

                if (matches) {
                    item.style.display = 'flex';
                    monthMatches++;
                    totalMatches++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (words.length === 0 || monthMatches > 0) {
                month.style.display = 'block';
            } else {
                month.style.display = 'none';
            }
        });

        // Handle notices & empty states
        if (words.length > 0) {
            if (totalMatches > 0) {
                if (historyNotice) {
                    historyNotice.style.removeProperty('display');
                    historyNotice.style.display = 'flex';
                    const countEl = document.getElementById('historyMatchCount');
                    const queryEl = document.getElementById('historyMatchQuery');
                    if (countEl) countEl.textContent = totalMatches;
                    if (queryEl) queryEl.textContent = query;
                }
                if (historyEmpty) historyEmpty.style.display = 'none';
                if (historyTimelineContainer) historyTimelineContainer.style.display = 'block';
            } else {
                if (historyNotice) historyNotice.style.display = 'none';
                if (historyEmpty) {
                    historyEmpty.style.display = 'block';
                    const keywordEl = document.getElementById('historySearchKeyword');
                    if (keywordEl) keywordEl.textContent = query;
                }
                if (historyTimelineContainer) historyTimelineContainer.style.display = 'none';
            }
        } else {
            if (historyNotice) historyNotice.style.display = 'none';
            if (historyEmpty) historyEmpty.style.display = 'none';
            if (historyTimelineContainer) historyTimelineContainer.style.display = 'block';
        }
    });

    if (clearHistorySearchBtn) {
        clearHistorySearchBtn.addEventListener('click', function() {
            historyItemSearch.value = '';
            historyItemSearch.dispatchEvent(new Event('input'));
            historyItemSearch.focus();
        });
    }
}
</script>
@endsection
