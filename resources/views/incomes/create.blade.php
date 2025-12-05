@extends('layouts.drivvo')

@section('title', 'Tambah Income Baru')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-coins"></i>
                    Tambah Pendapatan Baru
                </h1>
                <p class="page-subtitle mb-0">Catat pendapatan kendaraan Anda</p>
            </div>
            <a href="{{ route('incomes.index') }}" class="btn btn-outline-secondary">
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

            <form action="{{ route('incomes.store') }}" method="POST" enctype="multipart/form-data" id="incomeForm">
                @csrf

                <!-- Vehicle Information -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-car text-primary me-2"></i>
                        Informasi Kendaraan
                    </h5>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Vehicle Selection -->
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
                                    <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{ old('vehicle_id') }}" required>

                                    <div class="dropdown-menu w-100 p-2" aria-labelledby="vehicleDropdownBtn">
                                        <div class="mb-2 position-relative">
                                            <input type="text"
                                                   class="form-control form-control-sm pe-4"
                                                   id="vehicleSearchInput"
                                                   placeholder="Cari kendaraan..."
                                                   onclick="event.stopPropagation()"
                                                   autofocus>
                                            <button type="button"
                                                    class="btn btn-sm position-absolute"
                                                    style="right: 5px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none;"
                                                    id="clearVehicleSearch"
                                                    onclick="clearSearch('vehicleSearchInput', 'clearVehicleSearch'); event.stopPropagation();">
                                                <i class="fas fa-times text-muted"></i>
                                            </button>
                                        </div>
                                        <div class="vehicle-list-container" style="max-height: 250px; overflow-y: auto;">
                                            @php
                                                $user = auth()->user();
                                                if ($user && $user->isPengelola()) {
                                                    $vehicles = \App\Models\Vehicle::active()->orderBy('brand')->get();
                                                } elseif ($user && $user->isSopir()) {
                                                    $vehicles = $user->vehicles()->where('is_active', true)->orderBy('brand')->get();
                                                } else {
                                                    $vehicles = \App\Models\Vehicle::active()->orderBy('brand')->get();
                                                }
                                            @endphp
                                            @foreach($vehicles as $veh)
                                                <a class="dropdown-item vehicle-option"
                                                   href="#"
                                                   data-value="{{ $veh->id }}"
                                                   data-brand="{{ $veh->brand }}"
                                                   data-model="{{ $veh->model }}"
                                                   data-plate="{{ $veh->license_plate }}"
                                                   data-text="{{ $veh->brand }} {{ $veh->model }} ({{ $veh->license_plate }})"
                                                   onclick="selectVehicle(this, event)">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $veh->brand }} {{ $veh->model }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $veh->license_plate }}</small>
                                                        </div>
                                                    </div>
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

                <!-- Income Information -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>
                        Detail Pendapatan
                    </h5>

                    <div class="row">
                        <!-- Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Tanggal
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="income_date"
                                   id="income_date"
                                   class="form-control @error('income_date') is-invalid @enderror"
                                   value="{{ old('income_date', date('Y-m-d')) }}"
                                   required>
                            @error('income_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Time -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                Waktu
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time"
                                   name="income_time"
                                   id="income_time"
                                   class="form-control @error('income_time') is-invalid @enderror"
                                   value="{{ old('income_time') }}"
                                   required>
                            @error('income_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Odometer -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                Odometer
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       name="odometer"
                                       id="odometer"
                                       class="form-control @error('odometer') is-invalid @enderror"
                                       placeholder="Masukkan odometer"
                                       value="{{ old('odometer') }}"
                                       min="0"
                                       step="1">
                                <span class="input-group-text">KM</span>
                            </div>
                            @error('odometer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type of Income -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tags me-2 text-primary"></i>
                                Jenis Pendapatan
                                <span class="text-danger">*</span>
                            </label>
                            <select name="income_type_id" id="incomeTypeSelect" class="form-select @error('income_type_id') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Pendapatan</option>
                                @php
                                    $incomeTypes = \App\Models\IncomeType::active()->orderBy('name')->get();
                                @endphp
                                @foreach($incomeTypes as $incomeType)
                                    <option value="{{ $incomeType->id }}" {{ old('income_type_id') == $incomeType->id ? 'selected' : '' }}>
                                        {{ $incomeType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('income_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Value/Amount -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                Nilai Pendapatan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number"
                                       name="amount"
                                       id="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       placeholder="Masukkan jumlah pendapatan"
                                       value="{{ old('amount') }}"
                                       required
                                       min="0"
                                       step="1">
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Pengguna
                            </label>
                            @if(auth()->check())
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            @else
                                <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}" placeholder="Nama pengguna">
                            @endif
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>
                                Catatan
                            </label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Attachment -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-paperclip me-2 text-primary"></i>
                                Lampiran
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file"
                                       name="attachment"
                                       id="attachment"
                                       class="form-control"
                                       accept="image/*,.pdf,.doc,.docx">
                                <div id="filePreview" class="mt-2"></div>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle me-1"></i>
                                Format yang diterima: JPG, PNG, PDF, DOC, DOCX (Maks. 5MB)
                            </small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                    <a href="{{ route('incomes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Simpan Pendapatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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

    .file-upload-wrapper {
        position: relative;
    }

    #filePreview {
        display: none;
    }

    #filePreview.show {
        display: block;
    }

    .file-info {
        display: flex;
        align-items: center;
        padding: 12px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        gap: 12px;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #28a745;
        color: white;
        border-radius: 8px;
        font-size: 20px;
    }

    .page-header {
        background: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        font-size: 24px;
        color: #28a745;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }
</style>
@endpush

@push('scripts')
<script>
// Clear search function
function clearSearch(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    if (input) {
        input.value = '';
        input.focus();
        input.dispatchEvent(new Event('input'));
    }
    if (button) {
        button.style.display = 'none';
    }
}

// Auto-focus when dropdown opens and show/hide clear button
document.getElementById('vehicleDropdownBtn')?.addEventListener('shown.bs.dropdown', function() {
    const searchInput = document.getElementById('vehicleSearchInput');
    if (searchInput) {
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }
});

// Vehicle Custom Dropdown Logic
const vehicleSearchInput = document.getElementById('vehicleSearchInput');
const clearVehicleBtn = document.getElementById('clearVehicleSearch');

vehicleSearchInput?.addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.vehicle-option');

    // Show/hide clear button
    if (clearVehicleBtn) {
        clearVehicleBtn.style.display = searchText ? 'block' : 'none';
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

// Pre-select vehicle if exists
document.addEventListener('DOMContentLoaded', function() {
    // Set waktu default sesuai sistem
    const timeInput = document.getElementById('income_time');
    if (timeInput && !timeInput.value) {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        timeInput.value = `${hours}:${minutes}`;
    }

    const vehicleId = "{{ old('vehicle_id') }}";
    if (vehicleId) {
        const option = document.querySelector(`.vehicle-option[data-value="${vehicleId}"]`);
        if (option) {
            selectVehicle(option, { preventDefault: () => {} });
        }
    }

    // File upload preview
    const attachmentInput = document.getElementById('attachment');
    const filePreview = document.getElementById('filePreview');

    if (attachmentInput) {
        attachmentInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                let iconClass = 'fa-file';
                if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                    iconClass = 'fa-file-image';
                } else if (fileExtension === 'pdf') {
                    iconClass = 'fa-file-pdf';
                } else if (['doc', 'docx'].includes(fileExtension)) {
                    iconClass = 'fa-file-word';
                }

                filePreview.innerHTML = `
                    <div class="file-info">
                        <div class="file-icon">
                            <i class="fas ${iconClass}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">${fileName}</div>
                            <small class="text-muted">${fileSize} MB</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                filePreview.classList.add('show');
            }
        });
    }
});

function clearFile() {
    const attachmentInput = document.getElementById('attachment');
    const filePreview = document.getElementById('filePreview');

    if (attachmentInput) {
        attachmentInput.value = '';
    }
    if (filePreview) {
        filePreview.innerHTML = '';
        filePreview.classList.remove('show');
    }
}

// Form validation
document.getElementById('incomeForm')?.addEventListener('submit', function(e) {
    const requiredFields = [
        { id: 'vehicle_id', name: 'Kendaraan' },
        { id: 'income_date', name: 'Tanggal' },
        { id: 'income_time', name: 'Waktu' },
        { id: 'incomeTypeSelect', name: 'Jenis Pendapatan' },
        { id: 'amount', name: 'Nilai Pendapatan' }
    ];

    let isValid = true;
    let missingFields = [];

    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element && !element.value) {
            isValid = false;
            missingFields.push(field.name);
            element.classList.add('is-invalid');
        } else if (element) {
            element.classList.remove('is-invalid');
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
