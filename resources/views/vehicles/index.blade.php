@extends('layouts.drivvo')

@section('title', __('vehicle.title'))

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .page-title i {
        font-size: 28px;
        color: #007bff;
    }
    .page-subtitle {
        font-size: 15px;
        color: #7f8c8d;
        margin: 0;
        font-weight: 400;
    }
    .search-icon {
        color: #3498db;
        font-size: 24px;
    }
    .btn-add-vehicle {
        background: white;
        border: 2px solid #3498db;
        color: #3498db;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .btn-add-vehicle:hover {
        background: #3498db;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .vehicle-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .vehicle-table {
        width: 100%;
        margin: 0;
    }
    .vehicle-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .vehicle-table thead th {
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    .sortable-header {
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .sortable-header:hover {
        color: #3498db;
    }
    .sort-icon {
        font-size: 10px;
        transition: transform 0.2s ease;
    }
    .sort-icon.desc {
        transform: rotate(180deg);
    }
    .vehicle-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    .vehicle-table tbody tr:last-child td {
        border-bottom: none;
    }
    .vehicle-table tbody tr:hover {
        background: #f8f9fa;
    }
    .vehicle-icon-cell {
        width: 60px;
        text-align: center;
    }
    .vehicle-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    .vehicle-name {
        font-weight: 600;
        color: #3498db;
        text-decoration: none;
        font-size: 15px;
        cursor: pointer;
    }
    .vehicle-name:hover {
        text-decoration: underline;
    }
    .brand-logo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
    }
    .brand-logo img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }
    .brand-name {
        font-weight: 500;
        color: #333;
    }
    .model-text {
        color: #666;
        font-size: 14px;
    }
    .last-update {
        color: #999;
        font-size: 13px;
    }
    .Status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .Status-Active {
        background: #d4edda;
        color: #155724;
    }
    .Status-nonActive {
        background: #f8d7da;
        color: #721c24;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .info-row {
        padding: 14px 20px;
        border-bottom: 1px solid #f8f9fa;
        background: white;
    }
    .info-row:last-of-type {
        border-bottom: none;
    }
    .info-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .info-value {
        font-size: 17px;
        font-weight: 700;
        color: #212529;
        line-height: 1.2;
    }
    .action-btn {
        flex: 1;
        padding: 14px 8px;
        border: none;
        background: #f8f9fa;
        color: #495057;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .action-btn:hover {
        background: #e9ecef;
        color: #212529;
        text-decoration: none;
    }
    .action-btn.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 700;
    }
    .action-btn.primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a8a 100%);
        color: white;
        transform: scale(1.02);
    }
    .action-btn i {
        font-size: 16px;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        max-width: 700px;
        margin: 0 auto;
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        top: -40px;
    }
    .empty-icon {
        width: 160px;
        height: 160px;
        margin: 0 auto 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.3);
    }
    .empty-title {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }
    .empty-description {
        font-size: 17px;
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 40px;
        max-width: 500px;
    }
    .inactive-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 193, 7, 0.95);
        color: #000;
        padding: 6px 14px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        letter-spacing: 0.3px;
    }
    .menu-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        border: 1px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.2);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 18px;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    .action-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
        background: #3498db;
        color: white;
    }
    .action-icon-btn:hover {
        background: #2980b9;
        transform: translateY(-1px);
    }
    .action-icon-btn.btn-assign {
        background: #9b59b6;
    }
    .action-icon-btn.btn-assign:hover {
        background: #8e44ad;
    }
    .action-icon-btn.btn-download {
        background: #27ae60;
    }
    .action-icon-btn.btn-download:hover {
        background: #229954;
    }
    .action-icon-btn.btn-view {
        background: #9b59b6;
    }
    .action-icon-btn.btn-view:hover {
        background: #8e44ad;
    }
    .action-icon-btn.btn-edit {
        background: #3498db;
    }
    .action-icon-btn.btn-edit:hover {
        background: #2980b9;
    }
    .action-icon-btn.btn-delete {
        background: #e74c3c;
    }
    .action-icon-btn.btn-delete:hover {
        background: #c0392b;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .empty-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }
    .empty-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }
    .empty-description {
        font-size: 15px;
        color: #999;
        margin-bottom: 24px;
    }
    .search-form {
        margin-bottom: 20px;
    }
    .search-input-wrapper {
        position: relative;
        max-width: 400px;
    }
    .search-input {
        width: 100%;
        padding: 10px 40px 10px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .search-input:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    .search-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: #3498db;
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .search-btn:hover {
        background: #2980b9;
    }
    .pagination-wrapper {
        margin-top: 24px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .pagination-info {
        color: #666;
        font-size: 14px;
    }
    .pagination-controls {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .pagination-btn {
        padding: 8px 16px;
        border: 1px solid #e9ecef;
        background: white;
        color: #3498db;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .pagination-btn:hover:not(.disabled) {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }
    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        color: #999;
    }
    .pagination-numbers {
        display: flex;
        gap: 4px;
    }
    .pagination-number {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        background: white;
    }
    .pagination-number:hover {
        border-color: #3498db;
        color: #3498db;
        background: #f8f9fa;
    }
    .pagination-number.active {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px 15px;
            gap: 16px;
        }

        .page-title {
            font-size: 24px;
        }

        .page-title i {
            font-size: 22px;
        }

        .page-subtitle {
            font-size: 13px;
        }

        .btn-add-vehicle {
            width: 100%;
            justify-content: center;
            display: flex;
        }

        .filters-section {
            flex-direction: column;
            gap: 12px;
        }

        .search-container {
            width: 100%;
        }

        /* Hide table, show card view */
        .vehicle-table-container table {
            display: none;
        }

        /* Card view for mobile */
        .vehicle-mobile-cards {
            display: block;
        }

        .vehicle-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .vehicle-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .vehicle-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .vehicle-card-subtitle {
            font-size: 13px;
            color: #7f8c8d;
        }

        .vehicle-card-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .vehicle-card-field {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .vehicle-card-label {
            font-size: 11px;
            color: #95a5a6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .vehicle-card-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 500;
        }

        .vehicle-card-actions {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
        }

        .vehicle-card-actions .btn {
            flex: 1;
            font-size: 13px;
            padding: 8px 12px;
            justify-content: center;
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: 16px;
            padding: 15px;
        }

        .pagination-controls {
            width: 100%;
            justify-content: space-between;
        }

        .pagination-numbers {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 20px;
        }

        .vehicle-card {
            padding: 12px;
        }

        .vehicle-card-title {
            font-size: 15px;
        }

        .vehicle-card-body {
            grid-template-columns: 1fr;
        }

        .vehicle-card-actions {
            flex-direction: column;
        }
    }

    /* Desktop: hide mobile cards */
    @media (min-width: 769px) {
        .vehicle-mobile-cards {
            display: none;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-car"></i>
            {{ __('common.vehicles') }}
        </h1>
        <p class="page-subtitle">{{ __('common.manage_fleet_vehicles') }}</p>
    </div>
    @if(auth()->user()->canManageVehicles())
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> {{ __('common.add_new_vehicle') }}
    </a>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Search Form -->
<form action="{{ route('vehicles.index') }}" method="GET" class="search-form">
    <div class="search-input-wrapper">
        <input type="text" 
               name="search" 
               class="search-input" 
               placeholder="{{ __('common.search_vehicles') }}" 
               value="{{ request('search') }}">
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

@if($vehicles->count() > 0)
<div class="vehicle-table-container">
    <table class="vehicle-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('common.type') }}</th>
                <th>
                    <a href="{{ route('vehicles.index', array_merge(request()->except(['sort_by', 'sort_order', 'page']), [
                        'sort_by' => 'name',
                        'sort_order' => (request('sort_by') == 'name' && request('sort_order') == 'asc') ? 'desc' : 'asc'
                    ])) }}" class="sortable-header">
                        {{ __('common.nickname') }}
                        @if(request('sort_by') == 'name' || !request('sort_by'))
                            <i class="fas fa-arrow-up sort-icon {{ request('sort_order') == 'desc' ? 'desc' : '' }}"></i>
                        @else
                            <i class="fas fa-sort sort-icon" style="opacity: 0.3;"></i>
                        @endif
                    </a>
                </th>
                <th>{{ __('common.license_plate') }}</th>
                <th>{{ __('common.year') }}</th>
                <th>{{ __('common.brand') }}</th>
                <th>{{ __('common.model') }}</th>
                <th>{{ __('common.status') }}</th>
                <th>{{ __('common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $index => $vehicle)
            <tr>
                <td class="vehicle-icon-cell">{{ ($vehicles->currentPage() - 1) * $vehicles->perPage() + $index + 1 }}</td>
                <td>
                    <span style="font-weight: 500; color: #333;">{{ $vehicle->vehicle_type ?: '-' }}</span>
                </td>
                <td>
                    <a href="{{ route('vehicles.show', $vehicle) }}" class="vehicle-name">
                        {{ $vehicle->name }}
                    </a>
                </td>
                <td>
                    <span style="font-weight: 500; color: #333; text-transform: uppercase;">{{ $vehicle->license_plate ?: '-' }}</span>
                </td>
                <td>
                    <span style="color: #666;">{{ $vehicle->year ?: '-' }}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="brand-logo">
                            @php
                                $brandLower = strtolower(str_replace(' ', '-', $vehicle->brand));
                                $logoPath = "assets/logos/brands/{$brandLower}.svg";
                                $logoExists = file_exists(public_path($logoPath));
                            @endphp
                            
                            @if($logoExists)
                                <img src="{{ asset($logoPath) }}" alt="{{ $vehicle->brand }}" style="width: 28px; height: 28px; object-fit: contain;">
                            @else
                                <i class="fas fa-car" style="font-size: 16px; color: #999;"></i>
                            @endif
                        </div>
                        <span class="brand-name">{{ $vehicle->brand }}</span>
                    </div>
                </td>
                <td class="model-text">{{ $vehicle->model }}</td>
                <td>
                    <span class="Status-badge {{ $vehicle->is_active ? 'Status-Active' : 'Status-nonActive' }}">
                        {{ $vehicle->is_active ? __('common.active') : __('common.inactive') }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('vehicles.export-pdf', $vehicle) }}" class="action-icon-btn btn-download" title="{{ __('common.export_pdf') }}" target="_blank">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="action-icon-btn btn-view" title="{{ __('common.view_details') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->canManageVehicles())
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="action-icon-btn btn-edit" title="{{ __('common.edit_vehicle') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @endif
                        @if(auth()->user()->canDeleteRecords())
                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, '{{ $vehicle->name }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-icon-btn btn-delete" title="{{ __('common.delete_vehicle') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Mobile Card View -->
    <div class="vehicle-mobile-cards">
        @foreach($vehicles as $index => $vehicle)
        <div class="vehicle-card">
            <div class="vehicle-card-header">
                <div>
                    <div class="vehicle-card-title">
                        <a href="{{ route('vehicles.show', $vehicle) }}" style="color: inherit; text-decoration: none;">
                            {{ $vehicle->name }}
                        </a>
                    </div>
                    <div class="vehicle-card-subtitle">{{ $vehicle->license_plate }}</div>
                </div>
                <span class="Status-badge {{ $vehicle->is_active ? 'Status-Active' : 'Status-nonActive' }}">
                    {{ $vehicle->is_active ? __('common.active') : __('common.inactive') }}
                </span>
            </div>

            <div class="vehicle-card-body">
                <div class="vehicle-card-field">
                    <div class="vehicle-card-label">{{ __('common.type') }}</div>
                    <div class="vehicle-card-value">{{ $vehicle->vehicle_type ?: '-' }}</div>
                </div>
                <div class="vehicle-card-field">
                    <div class="vehicle-card-label">{{ __('common.year') }}</div>
                    <div class="vehicle-card-value">{{ $vehicle->year ?: '-' }}</div>
                </div>
                <div class="vehicle-card-field">
                    <div class="vehicle-card-label">{{ __('common.brand') }}</div>
                    <div class="vehicle-card-value">{{ $vehicle->brand }}</div>
                </div>
                <div class="vehicle-card-field">
                    <div class="vehicle-card-label">{{ __('common.model') }}</div>
                    <div class="vehicle-card-value">{{ $vehicle->model }}</div>
                </div>
            </div>

            <div class="vehicle-card-actions">
                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye me-1"></i> {{ __('common.view_details') }}
                </a>
                @if(auth()->user()->canManageVehicles())
                <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-pencil-alt me-1"></i> {{ __('common.edit') }}
                </a>
                @endif
                @if(auth()->user()->canDeleteRecords())
                <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline" style="flex: 1;" onsubmit="return confirmDelete(event, '{{ $vehicle->name }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" style="width: 100%;">
                        <i class="fas fa-trash me-1"></i> {{ __('common.delete') }}
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Custom Pagination -->
@if($vehicles->hasPages())
<div class="pagination-wrapper">
    <div class="pagination-info">
        {{ __('common.showing') }} {{ $vehicles->firstItem() }} {{ __('common.to') }} {{ $vehicles->lastItem() }} {{ __('common.of') }} {{ $vehicles->total() }} {{ __('common.results') }}
    </div>
    
    <div class="pagination-controls">
        <!-- Previous Button -->
        @if($vehicles->onFirstPage())
            <span class="pagination-btn disabled">
                <i class="fas fa-chevron-left"></i> {{ __('common.previous') }}
            </span>
        @else
            <a href="{{ $vehicles->previousPageUrl() }}" class="pagination-btn">
                <i class="fas fa-chevron-left"></i> {{ __('common.previous') }}
            </a>
        @endif
        
        <!-- Page Numbers -->
        <div class="pagination-numbers">
            @foreach(range(1, $vehicles->lastPage()) as $page)
                @if($page == $vehicles->currentPage())
                    <span class="pagination-number active">{{ $page }}</span>
                @else
                    <a href="{{ $vehicles->url($page) }}" class="pagination-number">{{ $page }}</a>
                @endif
            @endforeach
        </div>
        
        <!-- Next Button -->
        @if($vehicles->hasMorePages())
            <a href="{{ $vehicles->nextPageUrl() }}" class="pagination-btn">
                {{ __('common.next') }} <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span class="pagination-btn disabled">
                {{ __('common.next') }} <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </div>
</div>
@endif

@else
<div class="empty-state">
    <div class="empty-icon">🚗</div>
    <h3 class="empty-title">
        @if(request('search'))
            {{ __('common.no_results') }}
        @else
            {{ __('common.no_vehicles') }}
        @endif
    </h3>
    <p class="empty-description">
        @if(request('search'))
            {{ __('common.no_results_message', ['keyword' => request('search')]) }}
        @else
            {{ __('common.no_vehicles_message') }}
        @endif
    </p>
    @if(request('search'))
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary px-4">
            <i class="fas fa-arrow-left me-2"></i>{{ __('common.back_to_all') }}
        </a>
    @else
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-plus-circle me-2"></i>{{ __('common.add_first_vehicle') }}
        </a>
    @endif
</div>
@endif

@push('scripts')
<script>
function confirmDelete(event, vehicleName) {
    event.preventDefault();
    
    if (confirm('{{ __("common.confirm_delete_vehicle") }}'.replace(':name', vehicleName))) {
        event.target.submit();
    }
    
    return false;
}
</script>
@endpush
@endsection



























