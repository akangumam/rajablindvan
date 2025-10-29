@extends('layouts.fullscreen')

@section('title', 'Add Vehicle Pertama')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100" style="padding: 20px;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-sm border-0" style="border-radius: 12px; background: white;">
                    <div class="card-body p-4">
                        <!-- Header with Icon -->
                        <div class="text-center mb-4">
                            <div class="logo-wrapper mb-3">
                                <div class="brand-logo">
                                    <img src="{{ asset('assets/logos/brands/Radja-Blind-Van-Logo.png') }}" alt="Radja Blind Van" class="logo-image">
                                </div>
                            </div>
                            <h3 class="fw-semibold text-dark mb-2" style="font-size: 1.5rem;">Add Vehicle pertama you</h3>
                            <p class="text-muted mb-0" style="font-size: 14px;">Start Manage Vehicle dengan menambahkan Basic Information berikut.</p>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('vehicles.store') }}" method="POST" id="firstVehicleForm">
                            @csrf
                            
                            <!-- Tipe Vehicle -->
                            <div class="mb-3">
                                <div class="input-group position-relative">
                                    <span class="input-icon vehicle-type-icon" style="background: #f8f9fa; border-radius: 4px; padding: 4px 6px; border: 1px solid #dee2e6; font-size: 16px; color: #495057; font-weight: bold;">
                                        <span id="vehicleTypeIconElement">🚗</span>
                                    </span>
                                    <button type="button" 
                                            class="form-control custom-input text-start vehicle-type-button"
                                            id="vehicleTypeBtn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#vehicleTypeModal">
                                        <span id="selectedVehicleType" class="text-muted">Tipe Vehicle</span>
                                    </button>
                                    <input type="hidden" name="type" id="vehicleTypeInput" required>
                                </div>
                            </div>

                            <!-- Brand/Merk -->
                            <div class="mb-3">
                                <div class="input-group position-relative">
                                    <span class="input-icon" style="background: #f8f9fa; border-radius: 4px; padding: 4px 6px; border: 1px solid #dee2e6; font-size: 16px; color: #495057; font-weight: bold;">
                                        ©
                                    </span>
                                    <div class="brand-dropdown">
                                        <button type="button" class="form-control custom-input text-start brand-dropdown-toggle" id="brandDropdownBtn" data-selected="">
                                            <span class="brand-text">Brand</span>
                                        </button>
                                        <div class="brand-dropdown-menu" id="brandDropdownMenu">
                                            <div class="brand-option" data-value="">
                                                <span>Brand</span>
                                            </div>
                                            <div class="brand-option" data-value="Toyota">
                                                <img src="{{ asset('assets/logos/brands/toyota.svg') }}" alt="Toyota" class="brand-logo-small">
                                                <span>Toyota</span>
                                            </div>
                                            <div class="brand-option" data-value="Honda">
                                                <img src="{{ asset('assets/logos/brands/honda.svg') }}" alt="Honda" class="brand-logo-small">
                                                <span>Honda</span>
                                            </div>
                                            <div class="brand-option" data-value="Daihatsu">
                                                <img src="{{ asset('assets/logos/brands/daihatsu.svg') }}" alt="Daihatsu" class="brand-logo-small">
                                                <span>Daihatsu</span>
                                            </div>
                                            <div class="brand-option" data-value="Mitsubishi">
                                                <img src="{{ asset('assets/logos/brands/mitsubishi.svg') }}" alt="Mitsubishi" class="brand-logo-small">
                                                <span>Mitsubishi</span>
                                            </div>
                                            <div class="brand-option" data-value="Suzuki">
                                                <img src="{{ asset('assets/logos/brands/suzuki.svg') }}" alt="Suzuki" class="brand-logo-small">
                                                <span>Suzuki</span>
                                            </div>
                                            <div class="brand-option" data-value="Nissan">
                                                <img src="{{ asset('assets/logos/brands/nissan.svg') }}" alt="Nissan" class="brand-logo-small">
                                                <span>Nissan</span>
                                            </div>
                                            <div class="brand-option" data-value="Hyundai">
                                                <img src="{{ asset('assets/logos/brands/hyundai.svg') }}" alt="Hyundai" class="brand-logo-small">
                                                <span>Hyundai</span>
                                            </div>
                                            <div class="brand-option" data-value="Kia">
                                                <img src="{{ asset('assets/logos/brands/kia.svg') }}" alt="Kia" class="brand-logo-small">
                                                <span>Kia</span>
                                            </div>
                                            <div class="brand-option" data-value="BMW">
                                                <img src="{{ asset('assets/logos/brands/bmw.svg') }}" alt="BMW" class="brand-logo-small">
                                                <span>BMW</span>
                                            </div>
                                            <div class="brand-option" data-value="Mercedes-Benz">
                                                <img src="{{ asset('assets/logos/brands/mercedes-benz.svg') }}" alt="Mercedes-Benz" class="brand-logo-small">
                                                <span>Mercedes-Benz</span>
                                            </div>
                                            <div class="brand-option" data-value="Others">
                                                <span>Others</span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="brand" id="brandInput" required>
                                </div>
                            </div>

                            <!-- Model -->
                            <div class="mb-3">
                                <div class="input-group position-relative">
                                    <span class="input-icon" style="background: #f8f9fa; border-radius: 4px; padding: 4px 6px; border: 1px solid #dee2e6; font-size: 16px; color: #495057; font-weight: bold;">
                                        🏷️
                                    </span>
                                    <input type="text" 
                                           class="form-control custom-input" 
                                           name="model" 
                                           placeholder="Model"
                                           required>
                                </div>
                            </div>

                            <!-- Name Mobil -->
                            <div class="mb-4">
                                <div class="input-group position-relative">
                                    <span class="input-icon" style="background: #f8f9fa; border-radius: 4px; padding: 4px 6px; border: 1px solid #dee2e6; font-size: 16px; color: #495057; font-weight: bold;">
                                        ✍️
                                    </span>
                                    <input type="text" 
                                           class="form-control custom-input" 
                                           name="name" 
                                           placeholder="Name mobil"
                                           required>
                                </div>
                            </div>

                            <!-- Hidden Fields -->
                            <input type="hidden" name="year" value="{{ date('Y') }}">
                            <input type="hidden" name="license_plate" value="">
                            <input type="hidden" name="engine_type" value="Gasoline">
                            <input type="hidden" name="transmission" value="Manual">
                            <input type="hidden" name="color" value="">
                            <input type="hidden" name="is_active" value="1">
                            <input type="hidden" name="location_id" value="1">

                            <!-- Error Message -->
                            <div id="errorMessage" class="alert alert-danger d-none" style="border-radius: 8px; margin-bottom: 16px;">
                                <strong>Please lengkapi All field berikut:</strong>
                                <ul id="errorList" class="mb-0 mt-2"></ul>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-3 mt-4">
                                <button type="button"
                                        class="btn btn-outline-secondary flex-fill custom-btn-outline"
                                        onclick="resetForm()"
                                        style="border-radius: 8px; font-weight: 500; text-transform: uppercase; font-size: 14px; padding: 14px;">
                                    CANCEL
                                </button>
                                <button type="submit"
                                        class="btn btn-primary flex-fill custom-btn-primary"
                                        id="submitBtn"
                                        style="border-radius: 8px; font-weight: 500; text-transform: uppercase; font-size: 14px; padding: 14px; background-color: #007bff; border-color: #007bff;">
                                    List
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Type Modal -->
<div class="modal fade" id="vehicleTypeModal" tabindex="-1" aria-labelledby="vehicleTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title fw-semibold text-dark" id="vehicleTypeModalLabel">Tipe Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div class="vehicle-type-options">
                    <div class="vehicle-type-option" data-type="Bis">
                        <div class="vehicle-icon">
                            <i class="fas fa-bus text-primary" style="font-size: 24px;"></i>
                        </div>
                        <span class="vehicle-label">Bis</span>
                    </div>
                    <div class="vehicle-type-option" data-type="Mobil">
                        <div class="vehicle-icon">
                            <i class="fas fa-car text-primary" style="font-size: 24px;"></i>
                        </div>
                        <span class="vehicle-label">Mobil</span>
                    </div>
                    <div class="vehicle-type-option" data-type="Sepeda motor">
                        <div class="vehicle-icon">
                            <i class="fas fa-motorcycle text-primary" style="font-size: 24px;"></i>
                        </div>
                        <span class="vehicle-label">Sepeda motor</span>
                    </div>
                    <div class="vehicle-type-option" data-type="Truk">
                        <div class="vehicle-icon">
                            <i class="fas fa-truck text-primary" style="font-size: 24px;"></i>
                        </div>
                        <span class="vehicle-label">Truk</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-2">
                <div class="d-flex gap-3 w-100">
                    <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal" style="border-radius: 25px; font-weight: 500; text-transform: uppercase;">CANCEL</button>
                    <button type="button" class="btn btn-primary flex-fill" id="confirmVehicleType" style="border-radius: 25px; font-weight: 500; text-transform: uppercase; background-color: #007bff;">List</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Logo Styling */
.logo-wrapper {
    position: relative;
}

.brand-logo {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: 3px solid #f8f9fa;
}

.logo-image {
    width: 60px;
    height: 60px;
    object-fit: contain;
}

/* Custom Input Styling */
.input-group {
    position: relative;
    margin-bottom: 0;
}

.input-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 100 !important;
    width: 20px;
    text-align: center;
    pointer-events: none;
    display: flex !important;
    align-items: center;
    justify-content: center;
}

/* Brand Select Styling */
#brandSelect {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 20px center;
    background-repeat: no-repeat;
    background-size: 16px 16px;
    padding-right: 60px !important;
}

.brand-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
}

.brand-logo-small {
    width: 20px;
    height: 20px;
    object-fit: contain;
}

/* Custom Brand Dropdown */
.brand-dropdown {
    position: relative;
    width: 100%;
    z-index: 100;
}

.brand-dropdown-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    background: white !important;
}

.brand-dropdown-toggle:hover {
    background-color: #f8f9fa !important;
    border-color: #007bff;
}

.brand-dropdown-toggle:focus {
    background-color: white !important;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

/* Brand dropdown icon styling */
.input-group .input-icon + .brand-dropdown .brand-dropdown-toggle {
    padding-left: 55px !important;
}

/* Vehicle type button padding */
.input-group .vehicle-type-icon + .vehicle-type-button {
    padding-left: 55px !important;
}

/* Ensure all icons are visible and consistent */
.input-group .input-icon {
    position: absolute !important;
    left: 15px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    z-index: 10 !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: auto !important;
    height: auto !important;
    pointer-events: none !important;
}

.input-group .input-icon i {
    color: #495057 !important;
    font-size: 14px !important;
    font-weight: 900 !important;
    transition: color 0.3s ease;
}

.input-group:hover .input-icon i,
.input-group:focus-within .input-icon i,
.input-group .brand-dropdown.active .input-icon i {
    color: #007bff !important;
}

/* Vehicle type icon selected state */
.vehicle-type-icon .selected-icon {
    color: #007bff !important;
}

.brand-dropdown-toggle::after {
    content: '\f107';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #6c757d;
    transition: transform 0.3s ease;
}

.brand-dropdown-toggle.active::after {
    transform: rotate(180deg);
}

.brand-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    z-index: 9999;
    max-height: 200px;
    overflow-y: auto;
    display: none;
}

.brand-dropdown-menu.show {
    display: block;
}

.brand-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.brand-option:hover {
    background-color: #f8f9fa;
}

.brand-option:first-child {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.brand-option:last-child {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}

.brand-text {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Vehicle Type Modal */
.vehicle-type-options {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.vehicle-type-option {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.vehicle-type-option:hover {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}

.vehicle-type-option.selected {
    background-color: #e3f2fd;
    border-color: #2196f3;
}

.vehicle-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.vehicle-label {
    font-size: 16px;
    font-weight: 500;
    color: #333;
}

.vehicle-type-option.selected .vehicle-label {
    color: #1976d2;
}

.vehicle-type-option.selected .vehicle-icon i {
    color: #1976d2 !important;
}

/* Modal customization */
.modal-content {
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.modal {
    z-index: 10000;
}

.modal-backdrop {
    z-index: 9999;
}

.modal-header .btn-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    opacity: 0.7;
}

.modal-header .btn-close:hover {
    opacity: 1;
}

.custom-input {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 18px 20px 18px 60px !important;
    font-size: 15px;
    transition: all 0.3s ease;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    position: relative;
}

.custom-input:hover {
    border-color: #b0b0b0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.custom-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    background-color: white;
    outline: none;
}

.custom-input:focus + .input-icon,
.custom-input:active + .input-icon {
    opacity: 1 !important;
    visibility: visible !important;
    z-index: 10;
}

.custom-input:focus + .input-icon i,
.custom-input:active + .input-icon i {
    color: #007bff !important;
    opacity: 1 !important;
}

/* Force icon visibility in all states */
.input-group .input-icon,
.input-group .input-icon i {
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
}

.input-group .input-icon i {
    color: #6c757d;
    font-size: 16px !important;
}

/* Icon color changes on different states */
.input-group:hover .input-icon i,
.input-group:focus-within .input-icon i {
    color: #007bff !important;
}

/* Z-index hierarchy for form elements */
.position-relative .input-icon {
    z-index: 5 !important;
}

/* Specific z-index for each form group - higher elements get higher z-index */
.mb-3:nth-child(1) { z-index: 100; } /* Tipe Vehicle */
.mb-3:nth-child(2) .brand-dropdown { z-index: 90; } /* Brand dropdown */
.mb-3:nth-child(2) .input-icon { z-index: 3 !important; } /* Brand icon */
.mb-3:nth-child(3) { z-index: 80; } /* Model */
.mb-3:nth-child(3) .input-icon { z-index: 2 !important; }
.mb-4:nth-child(4) { z-index: 70; } /* Name Mobil */
.mb-4:nth-child(4) .input-icon { z-index: 1 !important; }

.custom-input::placeholder {
    color: #9e9e9e;
    font-weight: 400;
}

/* Ensure icons stay visible */
.input-group .input-icon {
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
    z-index: 10;
}

.input-group .input-icon i {
    transition: color 0.3s ease;
    opacity: 1 !important;
    visibility: visible !important;
}

.input-group:hover .input-icon i,
.input-group:focus-within .input-icon i,
.input-group:active .input-icon i {
    color: #007bff !important;
    opacity: 1 !important;
    visibility: visible !important;
}

/* Vehicle Type Button */
.vehicle-type-button {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.vehicle-type-button:hover {
    background-color: #f8f9fa !important;
    border-color: #007bff;
}

.vehicle-type-button:focus {
    background-color: white !important;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

/* Brand Logo Preview */
.brand-logo-preview {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 3;
    width: 24px;
    height: 24px;
    display: none;
}

.brand-logo-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* Custom Button Styling */
.custom-btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
}

.custom-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
}

.custom-btn-outline {
    border: 2px solid #007bff;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 16px;
    color: #007bff;
    background: transparent;
    transition: all 0.3s ease;
}

.custom-btn-outline:hover {
    background: #007bff;
    color: white;
    transform: translateY(-2px);
}

/* Select Styling */
select.custom-input {
    padding-left: 50px;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 9 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    appearance: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandDropdownBtn = document.getElementById('brandDropdownBtn');
    const brandDropdownMenu = document.getElementById('brandDropdownMenu');
    const brandInput = document.getElementById('brandInput');
    const brandOptions = document.querySelectorAll('.brand-option');
    
    // Toggle dropdown
    brandDropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        brandDropdownMenu.classList.toggle('show');
        brandDropdownBtn.classList.toggle('active');
        
        // Toggle brand dropdown class for icon styling
        const brandDropdown = document.querySelector('.brand-dropdown');
        brandDropdown.classList.toggle('active');
    });
    
    // Handle brand selection
    brandOptions.forEach(option => {
        option.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const text = this.querySelector('span').textContent;
            const logo = this.querySelector('.brand-logo-small');
            
            // Update button text and logo
            const brandText = brandDropdownBtn.querySelector('.brand-text');
            if (logo) {
                brandText.innerHTML = `<img src="${logo.src}" alt="${text}" class="brand-logo-small"> <span>${text}</span>`;
            } else {
                brandText.innerHTML = `<span>${text}</span>`;
            }
            
            // Update hidden input
            brandInput.value = value;
            
            // Close dropdown
            brandDropdownMenu.classList.remove('show');
            brandDropdownBtn.classList.remove('active');
            
            // Remove active class from brand dropdown
            const brandDropdown = document.querySelector('.brand-dropdown');
            brandDropdown.classList.remove('active');
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.brand-dropdown')) {
            brandDropdownMenu.classList.remove('show');
            brandDropdownBtn.classList.remove('active');
            
            // Remove active class from brand dropdown
            const brandDropdown = document.querySelector('.brand-dropdown');
            brandDropdown.classList.remove('active');
        }
    });
    
    // Auto-generate license plate placeholder
    const nameInput = document.querySelector('input[name="name"]');
    const licenseInput = document.querySelector('input[name="license_plate"]');
    
    // Generate initial license plate
    function generateLicensePlate() {
        const name = nameInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 3) || 'RBV';
        licenseInput.value = `B ${Math.floor(Math.random() * 9000) + 1000} ${name}`;
        console.log('Generated license plate:', licenseInput.value);
    }
    
    nameInput.addEventListener('input', generateLicensePlate);
    
    // Generate license plate when form is submitted if empty
    document.getElementById('firstVehicleForm').addEventListener('submit', function(e) {
        if (!licenseInput.value.trim()) {
            generateLicensePlate();
        }
    });
});

// Reset form function
function resetForm() {
    // Reset all form inputs
    document.getElementById('firstVehicleForm').reset();
    
    // Reset brand dropdown to default
    const brandDropdownBtn = document.getElementById('brandDropdownBtn');
    const brandText = brandDropdownBtn.querySelector('.brand-text');
    const brandInput = document.getElementById('brandInput');
    
    brandText.innerHTML = '<span>Brand</span>';
    brandInput.value = '';
    
    // Close dropdown if open
    const brandDropdownMenu = document.getElementById('brandDropdownMenu');
    brandDropdownMenu.classList.remove('show');
    brandDropdownBtn.classList.remove('active');
    
    // Clear license plate
    const licenseInput = document.querySelector('input[name="license_plate"]');
    licenseInput.value = '';
    
    // Reset vehicle type
    const selectedVehicleType = document.getElementById('selectedVehicleType');
    const vehicleTypeInput = document.getElementById('vehicleTypeInput');
    const vehicleTypeIconElement = document.getElementById('vehicleTypeIconElement');
    selectedVehicleType.textContent = 'Tipe Vehicle';
    selectedVehicleType.className = 'text-muted';
    vehicleTypeInput.value = '';
    
    // Reset icon to default
    vehicleTypeIconElement.textContent = '🚗';
    vehicleTypeIconElement.parentElement.style.color = '#495057';
    
    // Hide error messages
    document.getElementById('errorMessage').classList.add('d-none');
    
    // Update submit button state
    setTimeout(function() {
        if (typeof updateSubmitButton === 'function') {
            updateSubmitButton();
        }
    }, 100);
}

// Vehicle Type Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const vehicleTypeOptions = document.querySelectorAll('.vehicle-type-option');
    const confirmBtn = document.getElementById('confirmVehicleType');
    const selectedVehicleTypeSpan = document.getElementById('selectedVehicleType');
    const vehicleTypeInput = document.getElementById('vehicleTypeInput');
    let selectedType = '';
    
    // Handle vehicle type selection
    vehicleTypeOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            vehicleTypeOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Store selected type
            selectedType = this.getAttribute('data-type');
            
            // Enable confirm button
            confirmBtn.disabled = false;
        });
    });
    
    // Handle confirm button
    confirmBtn.addEventListener('click', function() {
        if (selectedType) {
            // Update the button text
            selectedVehicleTypeSpan.textContent = selectedType;
            selectedVehicleTypeSpan.className = 'text-dark';
            
            // Update hidden input
            vehicleTypeInput.value = selectedType;
            
            // Update icon based on vehicle type
            updateVehicleTypeIcon(selectedType);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('vehicleTypeModal'));
            modal.hide();
            
            // Reset selection for next time
            vehicleTypeOptions.forEach(opt => opt.classList.remove('selected'));
            selectedType = '';
            confirmBtn.disabled = true;
        }
    });
    
    // Function to update vehicle type icon
    function updateVehicleTypeIcon(type) {
        const iconElement = document.getElementById('vehicleTypeIconElement');
        let iconText = '🚗'; // default car
        
        switch(type) {
            case 'Bis':
                iconText = '🚌';
                break;
            case 'Mobil':
                iconText = '🚗';
                break;
            case 'Sepeda motor':
                iconText = '🏍️';
                break;
            case 'Truk':
                iconText = '🚛';
                break;
            default:
                iconText = '🚗';
        }
        
        iconElement.textContent = iconText;
        iconElement.parentElement.style.color = '#007bff';
    }
    
    // Reset modal when it's closed
    document.getElementById('vehicleTypeModal').addEventListener('hidden.bs.modal', function() {
        vehicleTypeOptions.forEach(opt => opt.classList.remove('selected'));
        selectedType = '';
        confirmBtn.disabled = true;
    });
    
    // Initially disable confirm button
    confirmBtn.disabled = true;
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('firstVehicleForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorMessage = document.getElementById('errorMessage');
    const errorList = document.getElementById('errorList');
    
    // Form submit validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const errors = validateForm();
        
        if (errors.length > 0) {
            showErrors(errors);
            return false;
        }
        
        hideErrors();
        
        // Debug: Log form data before submit
        const formData = new FormData(form);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Additional debug: check all required fields
        console.log('Vehicle Type:', document.getElementById('vehicleTypeInput').value);
        console.log('Brand:', document.getElementById('brandInput').value);
        console.log('Model:', document.querySelector('input[name="model"]').value);
        console.log('Name:', document.querySelector('input[name="name"]').value);
        console.log('License Plate:', document.querySelector('input[name="license_plate"]').value);
        
        // If validation passes, submit the form
        form.submit();
    });
    
    // Real-time validation on input change
    const inputs = form.querySelectorAll('input[required], button[required]');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            const errors = validateForm();
            if (errors.length === 0) {
                hideErrors();
            }
        });
    });
    
    function validateForm() {
        const errors = [];
        
        // Check vehicle type
        const vehicleType = document.getElementById('vehicleTypeInput').value;
        if (!vehicleType) {
            errors.push('Tipe Vehicle harus checked');
        }
        
        // Check brand
        const brand = document.getElementById('brandInput').value;
        if (!brand) {
            errors.push('Brand Vehicle harus checked');
        }
        
        // Check model
        const model = document.querySelector('input[name="model"]').value.trim();
        if (!model) {
            errors.push('Model Vehicle harus diisi');
        }
        
        // Check name
        const name = document.querySelector('input[name="name"]').value.trim();
        if (!name) {
            errors.push('Name mobil harus diisi');
        }
        
        return errors;
    }
    
    function showErrors(errors) {
        errorList.innerHTML = '';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        errorMessage.classList.remove('d-none');
        
        // Scroll to error message
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    function hideErrors() {
        errorMessage.classList.add('d-none');
    }
    
    // Update submit button state based on form completion
    function updateSubmitButton() {
        const errors = validateForm();
        const submitBtn = document.getElementById('submitBtn');
        
        if (errors.length > 0) {
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.title = 'Please lengkapi All field terlebih dahulu';
        } else {
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            submitBtn.title = '';
        }
    }
    
    // Monitor all form changes
    const allInputs = document.querySelectorAll('#firstVehicleForm input, #firstVehicleForm button');
    allInputs.forEach(input => {
        input.addEventListener('input', updateSubmitButton);
        input.addEventListener('change', updateSubmitButton);
    });
    
    // Monitor vehicle type and brand selection
    document.addEventListener('change', function(e) {
        if (e.target.id === 'vehicleTypeInput' || e.target.id === 'brandInput') {
            updateSubmitButton();
        }
    });
    
    // Initial button state
    setTimeout(updateSubmitButton, 100);
});
</script>
@endsection



























