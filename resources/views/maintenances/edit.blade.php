@extends('layouts.drivvo')

@section('title', 'Edit Servis')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-edit"></i>
                    Edit Servis
                </h1>
                <p class="page-subtitle mb-0">Perbarui informasi servis kendaraan</p>
            </div>
            <a href="{{ route('maintenances.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('maintenances.update', $maintenance) }}" method="POST" enctype="multipart/form-data" id="maintenanceForm">
                @csrf
                @method('PUT')

                <!-- Vehicle Information -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-car text-primary me-2"></i>
                        Informasi Kendaraan
                    </h5>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Vehicle Selection with Search -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Kendaraan
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="dropdown" id="vehicleDropdown">
                                    <button class="form-select text-start d-flex justify-content-between align-items-center"
                                            type="button"
                                            id="vehicleDropdownBtn"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <span id="vehicleDropdownText">Pilih Kendaraan</span>
                                    </button>
                                    <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{ old('vehicle_id', $maintenance->vehicle_id) }}" required>

                                    <div class="dropdown-menu w-100 p-2" aria-labelledby="vehicleDropdownBtn">
                                        <div class="mb-2 position-relative">
                                            <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   id="vehicleSearchInput"
                                                   placeholder="Cari kendaraan..."
                                                   style="padding-left: 40px; padding-right: 40px;"
                                                   autofocus
                                                   onclick="event.stopPropagation()">
                                            <button type="button"
                                                    class="btn position-absolute"
                                                    style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none; z-index: 10;"
                                                    id="clearVehicleSearch"
                                                    onclick="document.getElementById('vehicleSearchInput').value=''; document.getElementById('clearVehicleSearch').style.display='none'; event.stopPropagation();">
                                                <i class="fas fa-times text-muted"></i>
                                            </button>
                                        </div>
                                        <div class="vehicle-list-container" style="max-height: 250px; overflow-y: auto;">
                                            @foreach($vehicles as $vehicle)
                                                <a class="dropdown-item vehicle-option"
                                                   href="#"
                                                   data-value="{{ $vehicle->id }}"
                                                   data-text="{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}"
                                                   onclick="selectVehicle(this, event)">
                                                    {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pilih kendaraan dari daftar
                                </small>
                                @error('vehicle_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>
                        Detail Servis
                    </h5>

                    <div class="row">
                        <!-- Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Tanggal Servis
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="service_date"
                                   id="service_date"
                                   class="form-control @error('service_date') is-invalid @enderror"
                                   value="{{ old('service_date', $maintenance->service_date ? $maintenance->service_date->format('Y-m-d') : '') }}"
                                   required>
                            @error('service_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Time -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                Waktu Servis
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time"
                                   name="service_time"
                                   id="service_time"
                                   class="form-control @error('service_time') is-invalid @enderror"
                                   value="{{ old('service_time', $maintenance->service_time ?? '') }}"
                                   required>
                            @error('service_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Odometer -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                Odometer
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       name="odometer"
                                       id="odometer"
                                       class="form-control @error('odometer') is-invalid @enderror"
                                       placeholder="Masukkan odometer"
                                       value="{{ old('odometer', $maintenance->odometer) }}"
                                       required
                                       min="0"
                                       step="1">
                                <span class="input-group-text">KM</span>
                            </div>
                            @error('odometer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type of Service with Multi-Select -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-wrench me-2 text-primary"></i>
                                    Jenis Servis
                                    <span class="text-danger">*</span>
                                </span>
                            </label>

                            <!-- Button to open service selection modal -->
                            <button type="button"
                                    class="btn btn-outline-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2"
                                    onclick="openServiceModal()"
                                    id="selectServiceBtn">
                                <i class="fas fa-plus-circle"></i>
                                <span id="selectServiceBtnText">Pilih Jenis Servis</span>
                            </button>

                            <!-- Hidden input to store selected services JSON -->
                            <input type="hidden" name="selected_services" id="selected_services" required>
                            <input type="hidden" name="total_cost" id="total_cost_input">

                            @error('selected_services')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <!-- Selected Services Display -->
                            <div id="selectedServicesDisplay" class="mt-3" style="display: none;">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-list me-2"></i>Service yang Dipilih</span>
                                        <button type="button" class="btn btn-sm btn-light" onclick="openServiceModal()">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="selectedServicesList"></div>
                                        <div class="border-top pt-3 mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="fs-5">Total Biaya:</strong>
                                                <strong class="fs-4 text-primary" id="totalCostDisplay">Rp 0</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Place -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                Tempat Servis
                                <span class="text-danger">*</span>
                            </label>
                            <select name="place"
                                    id="place"
                                    class="form-select @error('place') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Tempat Servis</option>
                                @php
                                    $locations = \App\Models\Location::active()->get();
                                @endphp
                                @if($locations->count() > 0)
                                    @foreach($locations as $location)
                                        <option value="{{ $location->name }}" {{ old('place', $maintenance->place) == $location->name ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Kantor Pusat" {{ old('place', $maintenance->place) == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
                                    <option value="Workshop A" {{ old('place', $maintenance->place) == 'Workshop A' ? 'selected' : '' }}>Workshop A</option>
                                @endif
                            </select>
                            @error('place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Pengguna
                            </label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">Pilih Pengguna</option>
                                @php
                                    $users = \App\Models\User::orderBy('name')->get();
                                @endphp
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $maintenance->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-2 text-primary"></i>
                                Metode Pembayaran
                                <span class="text-danger">*</span>
                            </label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                @php
                                    $paymentMethods = \App\Models\PaymentMethod::active()->get();
                                @endphp
                                @if($paymentMethods->count() > 0)
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->name }}" {{ old('payment_method', $maintenance->payment_method) == $method->name ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Cash" {{ old('payment_method', $maintenance->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Transfer Bank" {{ old('payment_method', $maintenance->payment_method) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                @endif
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>
                                Catatan
                            </label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan tambahan...">{{ old('notes', $maintenance->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Update Servis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Service Selection Modal -->
<div class="modal fade" id="serviceSelectionModal" tabindex="-1" aria-labelledby="serviceSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceSelectionModalLabel">
                    <i class="fas fa-tools me-2"></i>Pilih Jenis Servis
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <div class="input-group" style="position: relative;">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="serviceSearchInput" placeholder="Cari servis..." autofocus style="padding-right: 35px;">
                        <button type="button"
                                class="btn position-absolute"
                                style="right: 5px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none; z-index: 10;"
                                id="clearServiceSearch"
                                onclick="document.getElementById('serviceSearchInput').value=''; document.getElementById('clearServiceSearch').style.display='none'; renderServiceList('');">
                            <i class="fas fa-times text-muted"></i>
                        </button>
                    </div>
                </div>

                <!-- Service List -->
                <div id="serviceListContainer" style="max-height: 400px; overflow-y: auto;">
                    <!-- Services will be dynamically loaded here -->
                </div>

                <!-- Add New Service Type Button -->
                <button type="button" class="btn btn-sm btn-outline-secondary mt-3 w-100" onclick="addNewServiceType()">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Baru
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="confirmServiceSelection()">
                    <i class="fas fa-check me-2"></i>Pilih
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .service-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .service-item:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }

    .service-checkbox {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        cursor: pointer;
    }

    .service-name {
        flex: 1;
        cursor: pointer;
        margin: 0;
        font-weight: 500;
    }

    .service-price-input {
        width: 200px;
        padding: 8px 12px;
        border: 2px solid #007bff;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .service-price-input:focus {
        outline: none;
        border-color: #0056b3;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .service-price-input.hidden {
        display: none;
    }

    .selected-service-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .selected-service-name {
        font-weight: 500;
        flex: 1;
    }

    .selected-service-price {
        color: #007bff;
        font-weight: 600;
        margin-right: 12px;
    }

    .remove-service-btn {
        background: transparent;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .remove-service-btn:hover {
        background: #dc3545;
        color: white;
    }

    .form-section {
        padding: 24px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e9ecef;
    }
</style>
@endpush

@push('scripts')
<script>
// Service Selection Logic
let availableServices = [];

// Load services from backend database
@php
    $serviceTypes = \App\Models\ServiceType::active()->orderBy('name')->get();
@endphp
@if($serviceTypes->count() > 0)
    availableServices = [
        @foreach($serviceTypes as $type)
        { id: '{{ Str::slug($type->name) }}', name: '{{ $type->name }}' },
        @endforeach
    ];
@else
    // Fallback default services in Indonesian
    availableServices = [
        { id: 'ac', name: 'AC' },
        { id: 'filter_udara', name: 'Filter Udara' },
        { id: 'aki', name: 'Aki' },
        { id: 'belt', name: 'Belt' },
        { id: 'minyak_rem', name: 'Minyak Rem' },
        { id: 'kampas_rem', name: 'Kampas Rem' },
        { id: 'karburator', name: 'Karburator' },
        { id: 'kopling', name: 'Kopling' },
        { id: 'coolant', name: 'Coolant' },
        { id: 'oli_mesin', name: 'Oli Mesin' },
        { id: 'perbaikan_mesin', name: 'Perbaikan Mesin' },
        { id: 'knalpot', name: 'Knalpot' },
        { id: 'filter_bensin', name: 'Filter Bensin' },
        { id: 'pompa_bensin', name: 'Pompa Bensin' },
        { id: 'oli_gardan', name: 'Oli Gardan' },
        { id: 'kaca', name: 'Kaca' },
        { id: 'pemanas', name: 'Pemanas' },
        { id: 'inspeksi', name: 'Inspeksi' },
        { id: 'biaya_jasa', name: 'Biaya Jasa' },
        { id: 'lampu', name: 'Lampu' },
        { id: 'ban_baru', name: 'Ban Baru' },
        { id: 'filter_oli', name: 'Filter Oli' },
        { id: 'cat', name: 'Cat' },
        { id: 'radiator', name: 'Radiator' },
        { id: 'atap', name: 'Atap' },
        { id: 'rotasi_ban', name: 'Rotasi Ban' },
        { id: 'sensor', name: 'Sensor' },
        { id: 'shock_breaker', name: 'Shock Breaker' },
        { id: 'busi', name: 'Busi' },
        { id: 'power_steering', name: 'Power Steering' },
        { id: 'suspensi', name: 'Suspensi' },
        { id: 'tekanan_ban', name: 'Tekanan Ban' },
        { id: 'transmisi', name: 'Transmisi' },
        { id: 'cuci', name: 'Cuci' },
        { id: 'spooring', name: 'Spooring' },
        { id: 'balancing', name: 'Balancing' },
        { id: 'wiper', name: 'Wiper' }
    ];
@endif

let selectedServices = [];
let serviceModal;

// Parse existing maintenance data to populate selectedServices
function parseExistingServices() {
    const serviceType = "{{ $maintenance->service_type ?? '' }}";
    const description = `{{ str_replace(["\r\n", "\n", "\r"], '\\n', $maintenance->description ?? '') }}`;

    if (!serviceType) return;

    const serviceNames = serviceType.split(',').map(s => s.trim());
    const breakdownMatch = description.match(/Service Breakdown:\n([\s\S]*?)(?:\n\n|$)/);

    if (breakdownMatch) {
        const lines = breakdownMatch[1].split('\n');
        lines.forEach(line => {
            const match = line.match(/(.+?)\s+\(Rp\s+([\d.]+)\)/);
            if (match) {
                const name = match[1].trim();
                const price = match[2].replace(/\./g, '');
                const id = name.toLowerCase().replace(/[^a-z0-9]/g, '_');

                selectedServices.push({ id, name, price });
            }
        });
    } else {
        // Fallback if no breakdown
        serviceNames.forEach(name => {
            if (name) {
                const id = name.toLowerCase().replace(/[^a-z0-9]/g, '_');
                selectedServices.push({ id, name, price: '' });
            }
        });
    }
}

function openServiceModal() {
    if (!serviceModal) {
        serviceModal = new bootstrap.Modal(document.getElementById('serviceSelectionModal'));
    }
    renderServiceList();
    serviceModal.show();
}

function renderServiceList(filter = '') {
    const container = document.getElementById('serviceListContainer');
    container.innerHTML = '';

    const filteredServices = availableServices.filter(service =>
        service.name.toLowerCase().includes(filter.toLowerCase())
    );

    filteredServices.forEach(service => {
        const isSelected = selectedServices.some(s => s.id === service.id);
        const selectedService = selectedServices.find(s => s.id === service.id);
        let price = '';
        if (selectedService && selectedService.price) {
            price = formatNumber(selectedService.price);
        }

        const item = document.createElement('div');
        item.className = 'service-item';
        item.innerHTML = `
            <input type="checkbox" class="service-checkbox" id="check_${service.id}"
                   ${isSelected ? 'checked' : ''} onchange="toggleServicePrice('${service.id}', this)">
            <label class="service-name" for="check_${service.id}">${service.name}</label>
            <input type="text" class="service-price-input ${isSelected ? '' : 'hidden'}"
                   id="price_${service.id}" placeholder="Harga (Rp)" value="${price}"
                   oninput="formatPriceInput(this); updateServicePrice('${service.id}', this.value)">
        `;
        container.appendChild(item);
    });
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatPriceInput(input) {
    let value = input.value.replace(/\D/g, '');
    if (value) {
        value = parseInt(value, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    input.value = value;
}

function toggleServicePrice(serviceId, checkbox) {
    const priceInput = document.getElementById(`price_${serviceId}`);
    if (checkbox.checked) {
        priceInput.classList.remove('hidden');
        priceInput.focus();

        const service = availableServices.find(s => s.id === serviceId);
        if (!selectedServices.some(s => s.id === serviceId)) {
            selectedServices.push({ ...service, price: '' });
        }
    } else {
        priceInput.classList.add('hidden');
        priceInput.value = '';
        selectedServices = selectedServices.filter(s => s.id !== serviceId);
    }
}

function updateServicePrice(serviceId, formattedPrice) {
    const index = selectedServices.findIndex(s => s.id === serviceId);
    if (index !== -1) {
        const rawPrice = formattedPrice.replace(/\./g, '');
        selectedServices[index].price = rawPrice;
    }
}

function addNewServiceType() {
    const searchInput = document.getElementById('serviceSearchInput');
    const newServiceName = searchInput.value.trim();

    if (newServiceName) {
        if (availableServices.some(s => s.name.toLowerCase() === newServiceName.toLowerCase())) {
            alert('Servis ini sudah ada dalam daftar.');
            return;
        }

        const newId = newServiceName.toLowerCase().replace(/[^a-z0-9]/g, '_');
        const newService = { id: newId, name: newServiceName };

        availableServices.push(newService);
        availableServices.sort((a, b) => a.name.localeCompare(b.name));

        renderServiceList(searchInput.value);

        const checkbox = document.getElementById(`check_${newId}`);
        if (checkbox) {
            checkbox.checked = true;
            toggleServicePrice(newId, checkbox);
        }
    } else {
        alert('Silakan ketik nama servis baru di kolom pencarian terlebih dahulu.');
        searchInput.focus();
    }
}

function confirmServiceSelection() {
    updateSelectedServicesDisplay();
    serviceModal.hide();
}

function updateSelectedServicesDisplay() {
    const displayContainer = document.getElementById('selectedServicesDisplay');
    const listContainer = document.getElementById('selectedServicesList');
    const totalCostDisplay = document.getElementById('totalCostDisplay');
    const totalCostInput = document.getElementById('total_cost_input');
    const selectedServicesInput = document.getElementById('selected_services');
    const selectBtnText = document.getElementById('selectServiceBtnText');

    listContainer.innerHTML = '';
    let totalCost = 0;

    if (selectedServices.length > 0) {
        displayContainer.style.display = 'block';
        selectBtnText.textContent = `${selectedServices.length} Servis Dipilih`;

        selectedServices.forEach(service => {
            const price = parseFloat(service.price) || 0;
            totalCost += price;

            const item = document.createElement('div');
            item.className = 'selected-service-item';
            item.innerHTML = `
                <span class="selected-service-name">${service.name}</span>
                <span class="selected-service-price">Rp ${price.toLocaleString('id-ID')}</span>
                <button type="button" class="remove-service-btn" onclick="removeService('${service.id}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            listContainer.appendChild(item);
        });
    } else {
        displayContainer.style.display = 'none';
        selectBtnText.textContent = 'Pilih Jenis Servis';
    }

    totalCostDisplay.textContent = `Rp ${totalCost.toLocaleString('id-ID')}`;
    totalCostInput.value = totalCost;
    selectedServicesInput.value = JSON.stringify(selectedServices);
}

function removeService(serviceId) {
    selectedServices = selectedServices.filter(s => s.id !== serviceId);
    updateSelectedServicesDisplay();
}

// Search functionality
document.getElementById('serviceSearchInput')?.addEventListener('input', function(e) {
    renderServiceList(e.target.value);
    // Show/hide clear button
    const clearBtn = document.getElementById('clearServiceSearch');
    if (clearBtn) {
        clearBtn.style.display = e.target.value ? 'block' : 'none';
    }
});

// Vehicle Custom Dropdown Logic
document.getElementById('vehicleSearchInput')?.addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.vehicle-option');

    // Show/hide clear button
    const clearBtn = document.getElementById('clearVehicleSearch');
    if (clearBtn) {
        clearBtn.style.display = searchText ? 'block' : 'none';
    }

    items.forEach(item => {
        const text = item.getAttribute('data-text').toLowerCase();
        if (text.includes(searchText)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

function selectVehicle(element, event) {
    event.preventDefault();
    const value = element.getAttribute('data-value');
    const text = element.getAttribute('data-text');

    document.getElementById('vehicle_id').value = value;
    document.getElementById('vehicleDropdownText').textContent = text;

    document.querySelectorAll('.vehicle-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Parse and populate existing services
    parseExistingServices();
    updateSelectedServicesDisplay();

    // Pre-select vehicle
    const vehicleId = "{{ old('vehicle_id', $maintenance->vehicle_id) }}";
    if (vehicleId) {
        const option = document.querySelector(`.vehicle-option[data-value="${vehicleId}"]`);
        if (option) {
            selectVehicle(option, { preventDefault: () => {} });
        }
    }
});

// Form validation before submit
document.getElementById('maintenanceForm')?.addEventListener('submit', function(e) {
    const requiredFields = [
        { id: 'vehicle_id', name: 'Kendaraan' },
        { id: 'service_date', name: 'Tanggal Servis' },
        { id: 'service_time', name: 'Waktu Servis' },
        { id: 'odometer', name: 'Odometer' },
        { id: 'selected_services', name: 'Jenis Servis' },
        { id: 'place', name: 'Tempat Servis' },
        { id: 'payment_method', name: 'Metode Pembayaran' }
    ];

    let isValid = true;
    let missingFields = [];

    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element && !element.value) {
            if (field.id === 'selected_services' && selectedServices.length === 0) {
                isValid = false;
                missingFields.push(field.name);
                document.getElementById('selectServiceBtn').classList.add('btn-outline-danger');
                document.getElementById('selectServiceBtn').classList.remove('btn-outline-primary');
            } else {
                isValid = false;
                missingFields.push(field.name);
                element.classList.add('is-invalid');
            }
        } else if (element) {
            element.classList.remove('is-invalid');
            if (field.id === 'selected_services') {
                document.getElementById('selectServiceBtn').classList.remove('btn-outline-danger');
                document.getElementById('selectServiceBtn').classList.add('btn-outline-primary');
            }
        }
    });

    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi field berikut:\n- ' + missingFields.join('\n- '));
        return false;
    }
});
</script>
@endpush
