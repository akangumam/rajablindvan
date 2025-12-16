@extends('layouts.drivvo')

@section('title', 'Pengisian')

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
    .info-box {
        background: #e7f3ff;
        border-radius: 4px;
        padding: 12px 16px;
        margin-top: 8px;
        font-size: 12px;
    }
    .info-box-title {
        font-weight: 600;
        color: #0066cc;
        margin-bottom: 4px;
        font-size: 11px;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
    }
    .info-box-text {
        color: #495057;
        line-height: 1.5;
        font-size: 12px;
    }
    .helper-text {
        font-size: 11px;
        color: #6c757d;
        margin-top: 2px;
    }
    .info-section {
        margin-top: 8px;
    }
    .info-label {
        color: #007bff;
        font-weight: 600;
        font-size: 11px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .info-text {
        color: #6c757d;
        font-size: 11px;
        line-height: 1.4;
    }
    .toggle-section {
        margin-top: 12px;
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
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-cancel:hover {
        background: #f8f9fa;
        color: #495057;
    }
    .form-check-input {
        width: 40px;
        height: 20px;
        margin-top: 0;
        cursor: pointer;
    }
    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }
    .form-check-label {
        cursor: pointer;
        user-select: none;
        font-size: 14px;
        color: #495057;
    }
    .btn-outline-primary {
        border-radius: 4px;
        font-size: 13px;
        padding: 8px 16px;
        font-weight: 500;
    }
    .info-helper {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-switch .form-check-input {
        width: 48px;
        height: 24px;
        cursor: pointer;
    }
    .fuel-icon {
        width: 40px;
        height: 40px;
        background: #e3f2fd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3498db;
        font-size: 20px;
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
    <form action="{{ route('fuel-fills.store') }}" method="POST" id="fuelFillForm">
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

        <div style="border-bottom: 1px solid #e9ecef; margin-bottom: 24px;"></div>

        <!-- Page Title -->
        <div style="display: flex; align-items: center; margin-bottom: 24px;">
            <div class="title-icon">
                <i class="fas fa-gas-pump"></i>
            </div>
            <h4 style="margin: 0;">Pengisian</h4>
        </div>

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

        <!-- Date & Time Fields -->
        <div class="field-group">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="fill_date">Date</label>
                    <input type="date" class="form-control @error('fill_date') is-invalid @enderror" id="fill_date" name="fill_date" value="{{ old('fill_date', date('Y-m-d')) }}" required>
                    @error('fill_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="fill_time">Jam</label>
                    <input type="time" class="form-control" id="fill_time" name="fill_time" value="{{ old('fill_time', date('H:i')) }}">
                </div>
            </div>
        </div>

        <!-- Odometer Field -->
        <div class="field-group">
            <label class="form-label" for="odometer">Odometer (km)</label>
            <input type="text" class="form-control currency-input @error('odometer') is-invalid @enderror" id="odometer" name="odometer" value="{{ old('odometer', isset($vehicle) ? $vehicle->getMinimumOdometer() : '') }}" inputmode="numeric" placeholder="Odometer (km)" required>
            @if(isset($vehicle))
                <div class="helper-text">Latest Odometer: {{ number_format($vehicle->getMinimumOdometer()) }} km</div>
            @endif
            @error('odometer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fuel Type Field -->
        <div class="field-group">
            <label class="form-label" for="fuel_type">Bahan bakar</label>
            <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
                <option value="">Select bahan bakar</option>
                <option value="Pertalite" {{ old('fuel_type') == 'Pertalite' ? 'selected' : '' }}>Pertalite</option>
                <option value="Pertamax" {{ old('fuel_type') == 'Pertamax' ? 'selected' : '' }}>Pertamax</option>
                <option value="Pertamax Turbo" {{ old('fuel_type') == 'Pertamax Turbo' ? 'selected' : '' }}>Pertamax Turbo</option>
                <option value="Solar" {{ old('fuel_type') == 'Solar' ? 'selected' : '' }}>Solar</option>
                <option value="Biosolar" {{ old('fuel_type') == 'Biosolar' ? 'selected' : '' }}>Biosolar</option>
            </select>
            @error('fuel_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price, Total, Liters Fields -->
        <div class="field-group">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="price_per_liter">Price / L</label>
                    <input type="text" class="form-control currency-input @error('price_per_liter') is-invalid @enderror" id="price_per_liter" name="price_per_liter" value="{{ old('price_per_liter') }}" placeholder="Price / L" required inputmode="numeric">
                    @error('price_per_liter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="total_cost_input">Total Cost</label>
                    <input type="text" class="form-control currency-input" id="total_cost_input" placeholder="Total Cost" inputmode="numeric">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="liters">Liter</label>
                    <input type="number" class="form-control @error('liters') is-invalid @enderror" id="liters" name="liters" value="{{ old('liters') }}" step="0.1" min="0" placeholder="Liter" required>
                    @error('liters')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tank Full Toggle -->
        <div class="field-group">
            <div class="form-check form-switch d-flex align-items-start">
                <input class="form-check-input me-2 flex-shrink-0" type="checkbox" name="is_full_tank" id="is_full_tank" value="1" {{ old('is_full_tank', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_full_tank" style="margin-top: -2px;">
                    Apa kamu mengisi tangki?
                </label>
            </div>
            <div class="info-box">
                <div class="info-box-title">
                    <i class="fas fa-info-circle me-1"></i>
                    BAHAN BAKAR
                </div>
                <div class="info-box-text">
                    Jika checked, we will calculate fuel Consumption based on the last fill. Jika tidak, this entry will be considered as a partial fill and will not be used in your fuel efficiency calculation.
                </div>
            </div>
        </div>

        <!-- Gas Stations Field -->
        <div class="field-group">
            <label class="form-label" for="gas_station">Gas Stations</label>
            <input type="text" class="form-control @error('gas_station') is-invalid @enderror" id="gas_station" name="gas_station" value="{{ old('gas_station') }}" placeholder="Gas Stations">
            @error('gas_station')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Driver Field -->
        <div class="field-group">
            <label class="form-label" for="driver">Pengendara</label>
            <input type="text" class="form-control" id="driver" name="driver" value="{{ old('driver') }}" placeholder="Pengendara">
        </div>

        <!-- Reason Field -->
        <div class="field-group">
            <label class="form-label" for="reason">Reasons (Optional)</label>
            <input type="text" class="form-control" id="reason" name="reason" value="{{ old('reason') }}" placeholder="Reasons (Optional)">
        </div>

        <!-- Payment Method Field -->
        <div class="field-group">
            <label class="form-label" for="payment_method">Payment Methods (Optional)</label>
            <select class="form-select" id="payment_method" name="payment_method">
                <option value="">Select Payment Methods</option>
                <option value="Tunai" {{ old('payment_method') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="Debit" {{ old('payment_method') == 'Debit' ? 'selected' : '' }}>Debit</option>
                <option value="Kredit" {{ old('payment_method') == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
            </select>
        </div>

        <!-- Track Before Filled Toggle -->
        <div class="field-group">
            <div class="form-check form-switch d-flex align-items-start">
                <input class="form-check-input me-2 flex-shrink-0" type="checkbox" name="track_before_filled" id="track_before_filled" value="1" {{ old('track_before_filled') ? 'checked' : '' }}>
                <label class="form-check-label" for="track_before_filled" style="margin-top: -2px;">
                    Pengisian bahan bakar seNot yetnya terlewatkan?
                </label>
            </div>
            <div class="helper-text" style="margin-left: 48px;">
                If checked, fuel Consumption calculation will skip the previous fill
            </div>
        </div>

        <!-- File Attachment -->
        <div class="field-group">
            <input type="file" id="attachment" name="attachment" accept="image/*,application/pdf" style="display: none;">
            <label for="attachment" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-paperclip me-2"></i>
                LAMPIRKAN FILE
            </label>
            <div class="helper-text mt-2">
                Upload struk, foto, atau dokumen Others
            </div>
        </div>

        <!-- Notes Field -->
        <div class="field-group">
            <label class="form-label" for="notes">Notes</label>
            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" placeholder="Notes" rows="4">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hidden Field for Vehicle -->
        @if(isset($vehicle))
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
        @else
            <!-- Vehicle Selector Field -->
            <div class="field-group">
                <label class="form-label" for="vehicle_id">Select Vehicle *</label>
                <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                    <option value="">Select Vehicle</option>
                    @foreach($vehicles as $vehicleOption)
                        <option value="{{ $vehicleOption->id }}" {{ old('vehicle_id') == $vehicleOption->id ? 'selected' : '' }}>
                            {{ $vehicleOption->name }} ({{ $vehicleOption->license_plate }})
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex gap-2 justify-content-end mt-4 mb-5" style="padding-bottom: 40px;">
            <a href="{{ route('fuel-fills.index') }}" class="btn btn-cancel">
                CANCEL
            </a>
            <button type="submit" class="btn btn-save">
                List
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
            <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
            <input type="text" id="vehicleSearch" class="vehicle-search-input" placeholder="Search Vehicle..." style="padding-left: 40px; padding-right: 40px;" autofocus onkeyup="filterVehicles()" oninput="toggleClearButton('vehicleSearch', 'clearVehicleSearch')">
            <button type="button"
                    class="btn btn-sm position-absolute"
                    style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none; z-index: 10;"
                    id="clearVehicleSearch"
                    onclick="clearSearchAndFilter('vehicleSearch', 'clearVehicleSearch')">
                <i class="fas fa-times text-muted"></i>
            </button>
        </div>
        <div class="vehicle-modal-body">
            @php
                $vehicles = \App\Models\Vehicle::all();
            @endphp
            @foreach($vehicles as $v)
                @php
                    $vLogoPath = 'assets/logos/brands/' . strtolower(str_replace(' ', '-', $v->brand)) . '.svg';
                @endphp
                <a href="{{ route('fuel-fills.create', ['vehicle_id' => $v->id]) }}"
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
// Auto-fill current time when user focuses on time input
document.addEventListener('DOMContentLoaded', function() {
    const timeInput = document.getElementById('fill_time');
    if (timeInput && !timeInput.value) {
        timeInput.addEventListener('focus', function() {
            if (!this.value) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                this.value = `${hours}:${minutes}`;
            }
        }, { once: true });
    }
});

// Auto calculate liters or total cost
const pricePerLiter = document.getElementById('price_per_liter');
const totalCostInput = document.getElementById('total_cost_input');
const litersInput = document.getElementById('liters');

// Calculate liters when total cost changes
totalCostInput.addEventListener('input', function() {
    const price = parseCurrency(pricePerLiter.value) || 0;
    const total = parseCurrency(this.value) || 0;

    if (price > 0 && total > 0) {
        const liters = total / price;
        litersInput.value = liters.toFixed(2);
    }
});

// Calculate total cost when price or liters change
function calculateTotalCost() {
    const price = parseCurrency(pricePerLiter.value) || 0;
    const liters = parseFloat(litersInput.value) || 0;

    if (price > 0 && liters > 0) {
        const total = price * liters;
        totalCostInput.value = formatCurrency(Math.round(total));
    }
}

pricePerLiter.addEventListener('input', calculateTotalCost);
litersInput.addEventListener('input', calculateTotalCost);

// Modal Functions
function openVehicleModal() {
    document.getElementById('vehicleModal').classList.add('show');
    document.body.style.overflow = 'hidden';

    // Auto-focus search input
    setTimeout(() => {
        const searchInput = document.getElementById('vehicleSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }, 300);
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

// Toggle clear button visibility
function toggleClearButton(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    if (input && button) {
        button.style.display = input.value ? 'block' : 'none';
    }
}

// Clear search and re-filter
function clearSearchAndFilter(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    if (input) {
        input.value = '';
        input.focus();
        filterVehicles();
    }
    if (button) {
        button.style.display = 'none';
    }
}

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



























