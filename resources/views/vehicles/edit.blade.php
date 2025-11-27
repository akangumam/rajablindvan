@extends('layouts.drivvo')

@section('title', 'Edit Vehicle')

@push('styles')
<style>
    .form-section {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e9ecef;
    }
    .form-label {
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
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
    .btn-save {
        background: #3498db;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    .btn-save:hover {
        background: #2980b9;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .btn-cancel {
        background: white;
        color: #666;
        border: 2px solid #ddd;
        padding: 10px 32px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    .btn-cancel:hover {
        border-color: #999;
        color: #333;
    }
    
    /* Brand Popup Modal */
    .brand-popup {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    .brand-popup-content {
        background-color: white;
        margin: 3% auto;
        padding: 0;
        border-radius: 16px;
        width: 90%;
        max-width: 650px;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
    }
    .brand-popup-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .brand-popup-header h5 {
        flex: 1;
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    .brand-search-container {
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
    }
    .brand-search-input {
        width: 100%;
        padding: 10px 40px 10px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
    }
    .brand-search-wrapper {
        position: relative;
    }
    .brand-search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    .brand-popup-body {
        padding: 20px 24px;
        overflow-y: auto;
        flex: 1;
    }
    .brand-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 16px;
    }
    .brand-item {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 20px 16px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
        background: white;
    }
    .brand-item:hover {
        border-color: #3498db;
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .brand-item img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-bottom: 12px;
    }
    .brand-item span {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        display: block;
    }
    .brand-popup-footer {
        padding: 16px 24px;
        border-top: 1px solid #e9ecef;
        text-align: center;
    }
    .add-new-brand-btn {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        text-transform: uppercase;
    }
    .add-new-brand-btn:hover {
        text-decoration: underline;
    }
    .close-popup {
        font-size: 24px;
        font-weight: bold;
        color: #3498db;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
    }
    .close-popup:hover {
        color: #2980b9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid" style="max-width: 900px; margin: 0 auto;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Vehicle</h4>
            <p class="text-muted mb-0">Update Vehicle Information {{ $vehicle->brand }} {{ $vehicle->model }}</p>
        </div>
        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
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

    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Vehicle Information -->
        <div class="form-section mb-4">
            <h5 class="section-title">
                <i class="fas fa-car me-2 text-primary"></i>Vehicle Information
            </h5>
            
            <!-- Row 1: Brand & Type -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="brandInput" name="brand" value="{{ old('brand', $vehicle->brand) }}" required readonly style="cursor: pointer;" placeholder="Click to select brand">
                    <small class="text-muted">Click to select from list</small>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="vehicle_type">
                        <option value="">Select vehicle type</option>
                        <option value="MPV" {{ old('vehicle_type', $vehicle->vehicle_type) == 'MPV' ? 'selected' : '' }}>MPV</option>
                        <option value="SUV" {{ old('vehicle_type', $vehicle->vehicle_type) == 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option value="Sedan" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="Hatchback" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                        <option value="Crossover" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Crossover' ? 'selected' : '' }}>Crossover</option>
                        <option value="Van" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Van' ? 'selected' : '' }}>Van</option>
                        <option value="BOX" {{ old('vehicle_type', $vehicle->vehicle_type) == 'BOX' ? 'selected' : '' }}>BOX</option>
                        <option value="Light Truck" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Light Truck' ? 'selected' : '' }}>Light Truck</option>
                        <option value="Medium Truck" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Medium Truck' ? 'selected' : '' }}>Medium Truck</option>
                        <option value="Heavy Truck" {{ old('vehicle_type', $vehicle->vehicle_type) == 'Heavy Truck' ? 'selected' : '' }}>Heavy Truck</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Vehicle Name & Model -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nameInput" name="name" value="{{ old('name', $vehicle->name) }}" required placeholder="Enter vehicle name or nickname">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Model <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="modelInput" name="model" value="{{ old('model', $vehicle->model) }}" required placeholder="Enter vehicle model">
                </div>
            </div>

            <!-- Row 3: Year & License Plate -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Year of Manufacture</label>
                    <select class="form-select" name="year">
                        <option value="">Select year</option>
                        @for($y = date('Y'); $y >= 1980; $y--)
                            <option value="{{ $y }}" {{ old('year', $vehicle->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">License Plate/Plat Nomor</label>
                    <input type="text" class="form-control" name="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" placeholder="B 1234 ABC" style="text-transform: uppercase;">
                </div>
            </div>

            <!-- Row 3.5: Ownership / Kepemilikan -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Kepemilikan <span class="text-danger">*</span></label>
                    @php
                        $currentOwnership = old('ownership_select');
                        if (!$currentOwnership) {
                            $currentOwnership = $vehicle->ownership_type == 'company' ? 'company' : 'investor_'.$vehicle->investor_id;
                        }
                    @endphp
                    <select class="form-select" name="ownership_select" id="ownershipSelect" required>
                        <option value="">-- Pilih Kepemilikan --</option>
                        <option value="company" {{ $currentOwnership == 'company' ? 'selected' : '' }}>Company Owned</option>
                        <optgroup label="Investors">
                            @foreach(\App\Models\Investor::where('status', 'active')->orderBy('name')->get() as $inv)
                                <option value="investor_{{ $inv->id }}" {{ $currentOwnership == 'investor_'.$inv->id ? 'selected' : '' }}>
                                    {{ $inv->name }} ({{ $inv->investment_percentage }}%)
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    <small class="text-muted">Pilih Company Owned atau Investor pemilik kendaraan</small>
                    
                    <!-- Hidden fields for backend -->
                    <input type="hidden" name="ownership_type" id="ownershipType" value="{{ old('ownership_type', $vehicle->ownership_type) }}">
                    <input type="hidden" name="investor_id" id="investorId" value="{{ old('investor_id', $vehicle->investor_id) }}">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <select class="form-select" name="location_id" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach(\App\Models\Location::all() as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $vehicle->location_id) == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @push('scripts')
            <script>
                document.getElementById('ownershipSelect').addEventListener('change', function() {
                    const value = this.value;
                    const ownershipType = document.getElementById('ownershipType');
                    const investorId = document.getElementById('investorId');
                    
                    if (value === 'company') {
                        ownershipType.value = 'company';
                        investorId.value = '';
                    } else if (value.startsWith('investor_')) {
                        ownershipType.value = 'investor';
                        investorId.value = value.replace('investor_', '');
                    }
                });
                
                // Trigger on page load untuk set initial values
                document.addEventListener('DOMContentLoaded', function() {
                    const select = document.getElementById('ownershipSelect');
                    if (select.value) {
                        select.dispatchEvent(new Event('change'));
                    }
                });
            </script>
            @endpush



            <!-- Row 4: Chassis Number & Engine Number -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Chassis Number/Nomor Rangka</label>
                    <input type="text" class="form-control" name="chassis_number" value="{{ old('chassis_number', $vehicle->chassis_number) }}" placeholder="Enter chassis number" style="text-transform: uppercase;">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Engine Number/Nomor Mesin</label>
                    <input type="text" class="form-control" name="engine_number" value="{{ old('engine_number', $vehicle->engine_number) }}" placeholder="Enter engine number" style="text-transform: uppercase;">
                </div>
            </div>

            <!-- Row 5: STNK Number & STNK Expiry -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Vehicle Registration Certificate Number/Nomor STNK</label>
                    <input type="text" class="form-control" name="stnk_number" value="{{ old('stnk_number', $vehicle->stnk_number) }}" placeholder="Enter STNK number" style="text-transform: uppercase;">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">VRCN Expiry Date/Masa Berlaku STNK</label>
                    <input type="date" class="form-control" name="stnk_expiry_date" value="{{ old('stnk_expiry_date', $vehicle->stnk_expiry_date ? $vehicle->stnk_expiry_date->format('Y-m-d') : '') }}">
                </div>
            </div>

            <!-- Row 6: KIR Number & KIR Expiry -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Vehicle Inspection Number/Nomor KIR</label>
                    <input type="text" class="form-control" name="kir_number" value="{{ old('kir_number', $vehicle->kir_number) }}" placeholder="Enter KIR number" style="text-transform: uppercase;">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">VIN Expiry Date/Masa Berlaku KIR</label>
                    <input type="date" class="form-control" name="kir_expiry_date" value="{{ old('kir_expiry_date', $vehicle->kir_expiry_date ? $vehicle->kir_expiry_date->format('Y-m-d') : '') }}">
                </div>
            </div>

            <!-- Row 6.5: GPS Expiry Date -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">GPS Expiry Date/Masa Berlaku GPS</label>
                    <input type="date" class="form-control" name="gps_expiry_date" value="{{ old('gps_expiry_date', $vehicle->gps_expiry_date ? $vehicle->gps_expiry_date->format('Y-m-d') : '') }}">
                    <small class="text-muted">Warning akan muncul 7 hari sebelum expired</small>
                </div>
            </div>

            <!-- Row 7: Barcode Upload & Document Upload -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Upload Barcode</label>
                    <input type="file" class="form-control" name="barcode_image" accept="image/*" id="barcodeUpload">
                    <small class="text-muted">Automatically view Barcode after Upload</small>
                    @if($vehicle->barcode_path)
                        <div class="mt-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Current barcode:</small>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteBarcode()">
                                    <i class="fas fa-trash me-1"></i>Hapus Barcode
                                </button>
                            </div>
                            <img src="{{ Storage::url($vehicle->barcode_path) }}" alt="Current Barcode" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                        </div>
                    @endif
                    <div id="barcodePreview" class="mt-2" style="display: none;">
                        <small class="text-muted">New barcode:</small><br>
                        <img id="barcodeImg" src="" alt="Barcode Preview" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Upload Dokumen Kendaraan</label>
                    <input type="text" class="form-control mb-2" name="document_name" value="{{ old('document_name', $vehicle->document_name) }}" placeholder="Enter document name">
                    <input type="file" class="form-control" name="vehicle_document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <small class="text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG</small>
                    @if($vehicle->document_path)
                        <div class="mt-2">
                            <small class="text-muted">Current document: <a href="{{ Storage::url($vehicle->document_path) }}" target="_blank">{{ $vehicle->document_name ?? 'View Document' }}</a></small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status and Notes -->
        <div class="form-section mb-4">
            <h5 class="section-title">
                <i class="fas fa-info-circle me-2 text-primary"></i>Status dan Notes
            </h5>
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $vehicle->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        <strong>Status Active</strong>
                        <p class="text-muted small mb-0">Active Vehicle will be displayed in list available vehicles</p>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="notes" rows="4" placeholder="Add notes about this vehicle...">{{ old('notes', $vehicle->notes) }}</textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 justify-content-end">
            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-cancel">
                <i class="fas fa-times me-2"></i>CANCEL
            </a>
            <button type="submit" class="btn btn-save">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </form>
    
    <!-- Hidden Form for Deleting Barcode -->
    @if($vehicle->barcode_path)
    <form id="deleteBarcodeForm" action="{{ route('vehicles.delete-barcode', $vehicle->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif

</div>

<!-- Brand Popup Modal -->
<div id="brandPopup" class="brand-popup">
    <div class="brand-popup-content">
        <div class="brand-popup-header">
            <h5>Select Brand</h5>
            <button class="close-popup" id="closeBrandPopup">&times;</button>
        </div>
        
        <div class="brand-search-container">
            <div class="brand-search-wrapper">
                <input type="text" class="brand-search-input" id="brandSearchInput" placeholder="Search brand...">
                <i class="fas fa-search brand-search-icon"></i>
            </div>
        </div>
        
        <div class="brand-popup-body">
            <div class="brand-grid" id="brandGrid">
                <div class="brand-item" data-brand="Toyota" data-search="toyota">
                    <img src="{{ asset('assets/logos/brands/toyota.svg') }}" alt="Toyota">
                    <span>Toyota</span>
                </div>
                <div class="brand-item" data-brand="Honda" data-search="honda">
                    <img src="{{ asset('assets/logos/brands/honda.svg') }}" alt="Honda">
                    <span>Honda</span>
                </div>
                <div class="brand-item" data-brand="Daihatsu" data-search="daihatsu">
                    <img src="{{ asset('assets/logos/brands/daihatsu.svg') }}" alt="Daihatsu">
                    <span>Daihatsu</span>
                </div>
                <div class="brand-item" data-brand="Mitsubishi" data-search="mitsubishi">
                    <img src="{{ asset('assets/logos/brands/mitsubishi.svg') }}" alt="Mitsubishi">
                    <span>Mitsubishi</span>
                </div>
                <div class="brand-item" data-brand="Suzuki" data-search="suzuki">
                    <img src="{{ asset('assets/logos/brands/suzuki.svg') }}" alt="Suzuki">
                    <span>Suzuki</span>
                </div>
                <div class="brand-item" data-brand="Nissan" data-search="nissan">
                    <img src="{{ asset('assets/logos/brands/nissan.svg') }}" alt="Nissan">
                    <span>Nissan</span>
                </div>
                <div class="brand-item" data-brand="Isuzu" data-search="isuzu">
                    <img src="{{ asset('assets/logos/brands/isuzu.svg') }}" alt="Isuzu">
                    <span>Isuzu</span>
                </div>
                <div class="brand-item" data-brand="Mercedes-Benz" data-search="mercedes benz">
                    <img src="{{ asset('assets/logos/brands/mercedes-benz.svg') }}" alt="Mercedes-Benz">
                    <span>Mercedes-Benz</span>
                </div>
                <div class="brand-item" data-brand="BMW" data-search="bmw">
                    <img src="{{ asset('assets/logos/brands/bmw.svg') }}" alt="BMW">
                    <span>BMW</span>
                </div>
                <div class="brand-item" data-brand="Hyundai" data-search="hyundai">
                    <img src="{{ asset('assets/logos/brands/hyundai.svg') }}" alt="Hyundai">
                    <span>Hyundai</span>
                </div>
                <div class="brand-item" data-brand="KIA" data-search="kia">
                    <img src="{{ asset('assets/logos/brands/kia.svg') }}" alt="KIA">
                    <span>KIA</span>
                </div>
            </div>
        </div>
        
        <div class="brand-popup-footer">
            <a href="#" class="add-new-brand-btn" id="addNewBrand">ADD NEW</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Brand popup elements
const brandPopup = document.getElementById('brandPopup');
const closeBrandPopup = document.getElementById('closeBrandPopup');
const brandInput = document.getElementById('brandInput');
const brandSearchInput = document.getElementById('brandSearchInput');
const brandGrid = document.getElementById('brandGrid');
const addNewBrand = document.getElementById('addNewBrand');

// Open popup when clicking brand input
brandInput.addEventListener('click', function() {
    brandPopup.style.display = 'block';
    brandSearchInput.value = '';
    document.querySelectorAll('.brand-item').forEach(item => {
        item.style.display = 'block';
    });
});

// Close popup
closeBrandPopup.addEventListener('click', function() {
    brandPopup.style.display = 'none';
});

// Close on outside click
window.addEventListener('click', function(event) {
    if (event.target == brandPopup) {
        brandPopup.style.display = 'none';
    }
});

// Search functionality
brandSearchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.brand-item').forEach(item => {
        const searchText = item.getAttribute('data-search').toLowerCase();
        if (searchText.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

// Select brand
document.querySelectorAll('.brand-item').forEach(item => {
    item.addEventListener('click', function() {
        const brand = this.getAttribute('data-brand');
        brandInput.value = brand;
        brandInput.setAttribute('readonly', 'readonly');
        brandPopup.style.display = 'none';
    });
});

// Add new brand
addNewBrand.addEventListener('click', function(e) {
    e.preventDefault();
    brandInput.removeAttribute('readonly');
    brandInput.value = '';
    brandInput.focus();
    brandInput.setAttribute('placeholder', 'Type brand manually...');
    brandPopup.style.display = 'none';
});

// Barcode preview
const barcodeUpload = document.getElementById('barcodeUpload');
if (barcodeUpload) {
    barcodeUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('barcodeImg').src = event.target.result;
                document.getElementById('barcodePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('barcodePreview').style.display = 'none';
        }
    });
}

// Delete Barcode Confirmation
function confirmDeleteBarcode() {
    if (confirm('Apakah Anda yakin ingin menghapus barcode ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteBarcodeForm').submit();
    }
}

</script>
@endpush
@endsection




























