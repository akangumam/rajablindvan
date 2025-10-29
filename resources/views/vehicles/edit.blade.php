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
        <a href="{{ route('vehicles.index') }}" class="btn btn-cancel">
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

    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="form-section mb-4">
            <h5 class="section-title">
                <i class="fas fa-car me-2 text-primary"></i>Basic Information
            </h5>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="brandInput" name="brand" value="{{ old('brand', $vehicle->brand) }}" required readonly style="cursor: pointer;">
                    <small class="text-muted">Click to select from list brand</small>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Model <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="model" value="{{ old('model', $vehicle->model) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $vehicle->name) }}" required>
                    <small class="text-muted">Contoh: Avanza Jakarta 1</small>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Year <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="year" value="{{ old('year', $vehicle->year) }}" maxlength="4" pattern="[0-9]{4}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}" required style="text-transform: uppercase;">
                    <small class="text-muted">Contoh: B 1234 ABC</small>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Warna</label>
                    <input type="text" class="form-control" name="color" value="{{ old('color', $vehicle->color) }}">
                </div>
            </div>
        </div>

        <!-- Spesifikasi Teknis -->
        <div class="form-section mb-4">
            <h5 class="section-title">
                <i class="fas fa-cog me-2 text-primary"></i>Spesifikasi Teknis
            </h5>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Engine Type <span class="text-danger">*</span></label>
                    <select class="form-select" name="engine_type" required>
                        <option value="">Select...</option>
                        <option value="Gasoline" {{ old('engine_type', $vehicle->engine_type) == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                        <option value="Diesel" {{ old('engine_type', $vehicle->engine_type) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Hybrid" {{ old('engine_type', $vehicle->engine_type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Electric" {{ old('engine_type', $vehicle->engine_type) == 'Electric' ? 'selected' : '' }}>Electric</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Transmisi <span class="text-danger">*</span></label>
                    <select class="form-select" name="transmission" required>
                        <option value="">Select...</option>
                        <option value="Manual" {{ old('transmission', $vehicle->transmission) == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automatic" {{ old('transmission', $vehicle->transmission) == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="CVT" {{ old('transmission', $vehicle->transmission) == 'CVT' ? 'selected' : '' }}>CVT</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Tank Capacity (Liters)</label>
                    <input type="number" class="form-control" name="tank_capacity" value="{{ old('tank_capacity', $vehicle->tank_capacity) }}" step="0.1" min="0">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Current Odometer (km) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="odometer" value="{{ old('odometer', $vehicle->odometer) }}" step="0.1" min="0" required>
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
            <a href="{{ route('vehicles.index') }}" class="btn btn-cancel">
                <i class="fas fa-times me-2"></i>CANCEL
            </a>
            <button type="submit" class="btn btn-save">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </form>
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
</script>
@endpush
@endsection




























