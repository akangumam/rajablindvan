@extends('layouts.drivvo')

@section('title', 'Layanan')

@push('styles')
<style>
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
    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    
    /* Field Style - Drivvo inspired */
    .field-group {
        margin-bottom: 20px;
    }
    .field-with-icon {
        display: block;
        margin-bottom: 20px;
    }
    .field-icon {
        display: none; /* Hide individual field icons */
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
    
    /* Drivvo Style Inputs */
    .form-control,
    .form-select {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px 12px;
        font-size: 14px;
        background-color: #fff;
        transition: all 0.2s;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.1);
        outline: 0;
    }
    .form-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 6px;
        font-weight: 400;
        display: block;
    }
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
    }
    .btn-cancel:hover {
        background: #f8f9fa;
        color: #495057;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .content-area {
            padding: 16px;
            padding-bottom: 80px;
            margin-bottom: 40px;
        }
        .field-with-icon {
            margin-bottom: 16px;
        }
        .main-content {
            overflow: visible;
            min-height: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="content-area">
    <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">
        @csrf

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
                        <span>Kendaraan</span>
                        <i class="fas fa-chevron-right" style="font-size: 10px; color: #6c757d;"></i>
                        <span>{{ $vehicle->license_plate }}</span>
                    </div>
                </div>
                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 14px;"></i>
            @else
                <div class="title-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h4 style="flex: 1;">Pilih Kendaraan</h4>
                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 14px;"></i>
            @endif
        </div>
        
        <div style="border-bottom: 1px solid #e9ecef; margin-bottom: 24px;"></div>
        
        <!-- Page Title -->
        <div style="display: flex; align-items: center; margin-bottom: 24px;">
            <div class="title-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <h4 style="margin: 0;">Layanan</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</h6>
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

        <!-- Date & Time Fields -->
        <div class="field-group">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="maintenance_date">Tanggal</label>
                    <input type="date" class="form-control @error('maintenance_date') is-invalid @enderror" id="maintenance_date" name="maintenance_date" value="{{ old('maintenance_date', date('Y-m-d')) }}" required>
                    @error('maintenance_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="maintenance_time">Jam</label>
                    <input type="time" class="form-control @error('maintenance_time') is-invalid @enderror" id="maintenance_time" name="maintenance_time" value="{{ old('maintenance_time', date('H:i')) }}" required>
                    @error('maintenance_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Odometer -->
        <div class="field-group">
            <label class="form-label" for="odometer">Odometer (km)</label>
            <input type="number" class="form-control @error('odometer') is-invalid @enderror" id="odometer" name="odometer" value="{{ old('odometer', isset($vehicle) ? $vehicle->getMinimumOdometer() : '') }}" step="0.1" min="{{ isset($vehicle) ? $vehicle->getMinimumOdometer() : 0 }}" placeholder="Odometer (km)" required>
            @error('odometer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if(isset($vehicle))
                <small class="text-muted d-block mt-1" style="font-size: 11px;">
                    Odometer terakhir: {{ number_format($vehicle->getMinimumOdometer()) }} km
                </small>
            @endif
        </div>

        <!-- Service Type -->
        <div class="field-group">
            <label class="form-label" for="type">Jenis layanan</label>
            <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}" placeholder="Jenis layanan" required>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Location -->
        <div class="field-group">
            <label class="form-label" for="workshop">Lokal</label>
            <input type="text" class="form-control @error('workshop') is-invalid @enderror" id="workshop" name="workshop" value="{{ old('workshop') }}" placeholder="Lokal">
            @error('workshop')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Driver -->
        <div class="field-group">
            <label class="form-label" for="driver">Pengendara</label>
            <input type="text" class="form-control @error('driver') is-invalid @enderror" id="driver" name="driver" value="{{ old('driver', auth()->user()->name ?? '') }}" placeholder="any nomouse">
            @error('driver')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Payment Method -->
        <div class="field-group">
            <label class="form-label" for="payment_method">Cara Pembayaran (Optional)</label>
            <input type="text" class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" value="{{ old('payment_method') }}" placeholder="Cara Pembayaran (Optional)">
            @error('payment_method')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- File Attachment -->
        <div class="field-group">
            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('attachment').click()">
                <i class="fas fa-paperclip me-2"></i>LAMPIRKAN FILE
            </button>
            <input type="file" class="d-none" id="attachment" name="attachment" accept="image/*,.pdf">
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: JPG, PNG, PDF (Max: 5MB)</small>
        </div>

        <!-- Notes -->
        <div class="field-group">
            <label class="form-label" for="notes">Catatan</label>
            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Catatan">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hidden fields for compatibility -->
        <input type="hidden" name="category" value="Routine">
        <input type="hidden" name="cost" id="hidden_cost" value="{{ old('cost', 0) }}">
        <input type="hidden" name="description" id="hidden_description" value="{{ old('description', '-') }}">

        <!-- Action Buttons -->
        <div class="d-flex gap-2 justify-content-end mt-4 mb-5" style="padding-bottom: 40px;">
            <a href="{{ route('maintenances.index') }}" class="btn btn-cancel">
                BATAL
            </a>
            <button type="submit" class="btn btn-save">
                DAFTAR
            </button>
        </div>
    </form>
</div>

<!-- Vehicle Selection Modal -->
<div id="vehicleModal" class="vehicle-modal">
    <div class="vehicle-modal-content">
        <div class="vehicle-modal-header">
            <h5 class="vehicle-modal-title">Kendaraan</h5>
            <button class="vehicle-modal-close" onclick="closeVehicleModal()">&times;</button>
        </div>
        <div class="vehicle-modal-search" style="position: relative;">
            <i class="fas fa-search vehicle-search-icon"></i>
            <input type="text" id="vehicleSearch" class="vehicle-search-input" placeholder="Cari kendaraan..." onkeyup="filterVehicles()">
        </div>
        <div class="vehicle-modal-body">
            @php
                $vehicles = \App\Models\Vehicle::all();
            @endphp
            @foreach($vehicles as $v)
                @php
                    $vLogoPath = 'assets/logos/brands/' . strtolower(str_replace(' ', '-', $v->brand)) . '.svg';
                @endphp
                <a href="{{ route('maintenances.create', ['vehicle_id' => $v->id]) }}"
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
                    <div class="vehicle-item-name" style="color: #007bff;">Tambah Kendaraan Baru</div>
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
</script>
@endpush
@endsection
