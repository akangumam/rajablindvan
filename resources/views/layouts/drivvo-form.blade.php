@extends('layouts.drivvo')

@section('title', $pageTitle ?? 'Form')

@php
    // Set default values for optional variables
    $modalRoute = $modalRoute ?? request()->url();
    $hideVehicleSelector = $hideVehicleSelector ?? false;
    $cancelRoute = $cancelRoute ?? url()->previous();
@endphp

@push('styles')
<style>
    /* ===== BASE LAYOUT STYLES - CONSISTENT FOR ALL FORMS ===== */
    body {
        background-color: #f8f9fa;
        overflow-x: auto;
    }
    
    .main-content {
        background-color: #f8f9fa;
        padding: 20px;
        overflow: visible;
    }
    
    .content-area {
        background: white;
        padding: 24px 32px;
        padding-bottom: 80px;
        margin: 0 auto 40px auto;
        max-width: 800px;
        position: relative;
    }
    
    /* ===== FORM STYLES ===== */
    .form-label {
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-control, .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
    }
    
    /* Dropdown/Select styling with arrow indicator */
    select.form-control, .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23555' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
        cursor: pointer;
    }
    
    select.form-control:hover, .form-select:hover {
        border-color: #aaa;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    
    .field-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 6px;
        font-weight: 400;
        display: block;
    }
    
    /* ===== VEHICLE MODAL POPUP ===== */
    .vehicle-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0 !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
        padding: 20px;
        margin: 0 !important;
    }
    
    .vehicle-modal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }
    
    .vehicle-modal-content {
        background-color: white;
        border-radius: 12px;
        width: 90%;
        max-width: 480px;
        max-height: 80vh;
        display: flex;
        flex-direction: column;
        animation: slideUp 0.3s;
        position: relative;
        margin: 0 auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    
    .vehicle-modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .vehicle-modal-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }
    
    .vehicle-modal-close {
        background: transparent;
        border: none;
        font-size: 24px;
        color: #6c757d;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }
    
    .vehicle-modal-close:hover {
        background: #f8f9fa;
    }
    
    .vehicle-modal-search {
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .vehicle-search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .vehicle-search-icon {
        position: absolute;
        left: 40px;
        top: 28px;
        color: #6c757d;
    }
    
    .vehicle-modal-body {
        padding: 0;
        overflow-y: auto;
        max-height: 400px;
    }
    
    .vehicle-list-item {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        transition: background-color 0.2s;
        text-decoration: none;
        color: inherit;
    }
    
    .vehicle-list-item:hover {
        background-color: #f8f9fa;
    }
    
    .vehicle-list-item.active {
        background-color: #e7f3ff;
    }
    
    .vehicle-item-logo {
        width: 40px;
        height: 40px;
        object-fit: contain;
        flex-shrink: 0;
    }
    
    .vehicle-item-placeholder {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 18px;
        flex-shrink: 0;
    }
    
    .vehicle-item-info {
        flex: 1;
    }
    
    .vehicle-item-name {
        font-size: 15px;
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 2px;
    }
    
    .vehicle-item-plate {
        font-size: 13px;
        color: #6c757d;
    }
    
    .vehicle-item-icon {
        color: #6c757d;
        font-size: 18px;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    /* ===== HEADER STYLES ===== */
    .page-title-section {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e9ecef;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    .page-title-section .title-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
    }
    
    .page-title-section .title-icon i {
        font-size: 18px;
        color: #495057;
    }
    
    .page-title-section h4 {
        margin-bottom: 0;
        font-size: 18px;
        font-weight: 600;
        color: #212529;
    }
    
    /* ===== BUTTONS ===== */
    .btn-save {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 32px;
        border-radius: 4px;
        font-weight: 500;
        text-transform: uppercase;
        transition: all 0.3s ease;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    
    .btn-save:hover {
        background: #0056b3;
        color: white;
    }
    
    .btn-cancel {
        background: transparent;
        color: #6c757d;
        border: none;
        padding: 10px 32px;
        border-radius: 4px;
        font-weight: 500;
        text-transform: uppercase;
        transition: all 0.3s ease;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        background: #f8f9fa;
        color: #495057;
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .content-area {
            padding: 16px;
            padding-bottom: 80px;
            margin-bottom: 40px;
        }
        .main-content {
            overflow: visible;
            min-height: auto;
        }
    }
    
    @yield('additional-styles')
</style>
@endpush

@section('content')
<!-- Page Header -->
<div style="background: white; padding: 20px 32px; margin: 0 auto 20px auto; max-width: 800px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; align-items: center; gap: 12px;">
        @if(isset($pageIcon))
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas {{ $pageIcon }}" style="color: white; font-size: 20px;"></i>
            </div>
        @endif
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #333; margin: 0;">{{ $pageTitle ?? 'Form' }}</h1>
            <p style="font-size: 14px; color: #999; margin: 4px 0 0 0;">{{ $pageSubtitle ?? 'Fill out the form below' }}</p>
        </div>
    </div>
</div>

<div class="content-area">
    <form action="{{ $formAction }}" method="POST" id="{{ $formId ?? 'mainForm' }}" enctype="multipart/form-data">
        @csrf
        @if(isset($formMethod) && strtoupper($formMethod) !== 'POST')
            @method($formMethod)
        @endif

        @if(!isset($hideVehicleSelector) || !$hideVehicleSelector)
        <!-- Vehicle Selector Header -->
        <div class="page-title-section" style="cursor: pointer; border-bottom: none; padding-bottom: 8px;" onclick="openVehicleModal()">
            @if(isset($vehicle))
                @php
                    $logoPath = 'assets/logos/brands/' . strtolower(str_replace(' ', '-', $vehicle->brand)) . '.svg';
                @endphp
                @if(file_exists(public_path($logoPath)))
                    <img src="{{ asset($logoPath) }}" alt="{{ $vehicle->brand }}" style="width: 32px; height: 32px; object-fit: contain; margin-right: 12px;">
                @else
                    <div style="width: 32px; height: 32px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                        <i class="fas fa-car" style="color: #3498db; font-size: 16px;"></i>
                    </div>
                @endif
                <div style="flex: 1;">
                    <h4 style="margin-bottom: 2px;">{{ $vehicle->name }}</h4>
                    <div style="font-size: 13px; color: #007bff; display: flex; align-items: center; gap: 4px;">
                        <span>Vehicle</span>
                        <i class="fas fa-chevron-right" style="font-size: 10px; color: #6c757d;"></i>
                        <span>{{ $vehicle->license_plate }}</span>
                    </div>
                </div>
                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 14px;"></i>
            @else
                <div class="title-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h4 style="flex: 1;">Select Vehicle</h4>
                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 14px;"></i>
            @endif
        </div>
        @else
        <!-- Custom Header for forms without vehicle selector -->
        <div class="page-title-section" style="border-bottom: 1px solid #e9ecef; padding-bottom: 16px; margin-bottom: 24px;">
            <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <input type="checkbox" checked disabled style="width: 20px; height: 20px; cursor: default;">
            </div>
            <h4 style="flex: 1; margin-bottom: 0;">{{ $pageTitle ?? 'Form' }}</h4>
        </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading mb-2"><i class="fas fa-exclamation-triangle me-2"></i>An Error Occurred!</h6>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Hidden Vehicle ID -->
        @if(isset($vehicle))
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
        @endif

        <!-- FORM CONTENT - TO BE FILLED BY CHILD BLADE -->
        @yield('form-fields')

        <!-- Action Buttons -->
        <div class="d-flex gap-2 justify-content-end mt-4 mb-5" style="padding-bottom: 40px;">
            <a href="{{ $cancelRoute }}" class="btn btn-cancel">
                CANCEL
            </a>
            <button type="submit" class="btn btn-save">
                SAVE
            </button>
        </div>
    </form>
</div>

<!-- Vehicle Selection Modal -->
<div id="vehicleModal" class="vehicle-modal">
    <div class="vehicle-modal-content">
        <div class="vehicle-modal-header">
            <h5 class="vehicle-modal-title">Vehicle</h5>
            <button class="vehicle-modal-close" onclick="closeVehicleModal()">&times;</button>
        </div>
        <div class="vehicle-modal-search" style="position: relative;">
            <i class="fas fa-search vehicle-search-icon"></i>
            <input type="text" id="vehicleSearch" class="vehicle-search-input" placeholder="Search Vehicle..." onkeyup="filterVehicles()">
        </div>
        <div class="vehicle-modal-body">
            @php
                $vehicles = \App\Models\Vehicle::all();
            @endphp
            @foreach($vehicles as $v)
                @php
                    $vLogoPath = 'assets/logos/brands/' . strtolower(str_replace(' ', '-', $v->brand)) . '.svg';
                @endphp
                <a href="{{ $modalRoute }}?vehicle_id={{ $v->id }}"
                   class="vehicle-list-item {{ isset($vehicle) && $vehicle->id == $v->id ? 'active' : '' }}"
                   data-vehicle-name="{{ strtolower($v->name) }}"
                   data-vehicle-plate="{{ strtolower($v->license_plate) }}">
                    @if(file_exists(public_path($vLogoPath)))
                        <img src="{{ asset($vLogoPath) }}" alt="{{ $v->brand }}" class="vehicle-item-logo">
                    @else
                        <div class="vehicle-item-placeholder">
                            <i class="fas fa-car"></i>
                        </div>
                    @endif
                    <div class="vehicle-item-info">
                        <div class="vehicle-item-name">{{ $v->name }}</div>
                        <div class="vehicle-item-plate">{{ $v->license_plate }}</div>
                    </div>
                    <i class="fas fa-truck vehicle-item-icon"></i>
                </a>
            @endforeach
            <a href="{{ route('vehicles.create') }}" class="vehicle-list-item" style="color: #007bff;">
                <div class="vehicle-item-placeholder" style="background: #e7f3ff;">
                    <i class="fas fa-plus" style="color: #007bff;"></i>
                </div>
                <div class="vehicle-item-info">
                    <div class="vehicle-item-name" style="color: #007bff;">Add New Vehicles</div>
                </div>
                <i class="fas fa-chevron-right vehicle-item-icon" style="color: #007bff;"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Modal Functions
function openVehicleModal() {
    document.getElementById('vehicleModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeVehicleModal() {
    document.getElementById('vehicleModal').classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('vehicleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVehicleModal();
    }
});

// Vehicle search filter
function filterVehicles() {
    const searchInput = document.getElementById('vehicleSearch').value.toLowerCase();
    const vehicleItems = document.querySelectorAll('.vehicle-list-item');

    vehicleItems.forEach(item => {
        const vehicleName = item.getAttribute('data-vehicle-name') || '';
        const vehiclePlate = item.getAttribute('data-vehicle-plate') || '';

        if (vehicleName.includes(searchInput) || vehiclePlate.includes(searchInput)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVehicleModal();
    }
});

@yield('additional-scripts')
</script>
@endpush

@yield('modals')
@endsection




























