@extends('layouts.drivvo')

@section('title', 'Tambah Expense Baru')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-receipt"></i>
                    Tambah Pengeluaran Baru
                </h1>
                <p class="page-subtitle mb-0">Catat pengeluaran kendaraan Anda</p>
            </div>
            <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
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

            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" id="expenseForm">
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
                                    <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{ old('vehicle_id', $vehicle->id ?? '') }}" required>

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
                                                   data-odometer="{{ $veh->getLatestOdometer() }}"
                                                   data-text="{{ $veh->brand }} {{ $veh->model }} - {{ $veh->license_plate }}"
                                                   onclick="selectVehicle(this, event)">
                                                    {{ $veh->brand }} {{ $veh->model }} - {{ $veh->license_plate }}
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

                <!-- Expense Information -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>
                        Detail Pengeluaran
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
                                   name="expense_date"
                                   id="expense_date"
                                   class="form-control @error('expense_date') is-invalid @enderror"
                                   value="{{ old('expense_date', date('Y-m-d')) }}"
                                   required>
                            @error('expense_date')
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
                                   name="expense_time"
                                   id="expense_time"
                                   class="form-control @error('expense_time') is-invalid @enderror"
                                   value="{{ old('expense_time', date('H:i')) }}"
                                   required>
                            @error('expense_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Odometer -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                Odometer
                                <span id="lastOdometerDisplay" class="ms-2" style="display:none; font-weight: normal; font-size: 0.9rem;">
                                    (Last: <span id="lastOdometerValue" class="fw-bold text-dark"></span>)
                                </span>
                            </label>
                            <div class="input-group">
                                <input type="text"
                                       name="odometer"
                                       id="odometer"
                                       class="form-control currency-input @error('odometer') is-invalid @enderror"
                                       placeholder="Masukkan odometer"
                                       value="{{ old('odometer') }}"
                                       inputmode="numeric">
                                <span class="input-group-text">KM</span>
                            </div>
                            @error('odometer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type of Expense -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tags me-2 text-primary"></i>
                                Jenis Pengeluaran
                                <span class="text-danger">*</span>
                            </label>
                            <select name="expense_type_id" id="expenseTypeSelect" class="form-select @error('expense_type_id') is-invalid @enderror" required onchange="handleExpenseTypeChange(this)">
                                <option value="">Pilih Jenis Pengeluaran</option>
                                @php
                                    $expenseTypes = \App\Models\ExpenseType::active()->orderBy('name')->get();
                                @endphp
                                <option value="new" class="fw-bold text-primary">+ Tambah Jenis Baru</option>
                                @foreach($expenseTypes as $expenseType)
                                    <option value="{{ $expenseType->id }}" data-name="{{ $expenseType->name }}" {{ old('expense_type_id') == $expenseType->id ? 'selected' : '' }}>
                                        {{ $expenseType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('expense_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- STNK Expiry Date (Conditional) -->
                        <div class="col-md-6 mb-3" id="stnkExpiryGroup" style="display: none;">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-id-card me-2 text-primary"></i>
                                Kadaluarsa STNK Selanjutnya
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="stnk_expiry_date"
                                   id="stnkExpiryDate"
                                   class="form-control"
                                   value="{{ old('stnk_expiry_date') }}">
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle me-1"></i>
                                Tanggal kadaluarsa STNK berikutnya
                            </small>
                        </div>

                        <!-- KIR Expiry Date (Conditional) -->
                        <div class="col-md-6 mb-3" id="kirExpiryGroup" style="display: none;">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-certificate me-2 text-primary"></i>
                                Kadaluarsa KIR Selanjutnya
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="kir_expiry_date"
                                   id="kirExpiryDate"
                                   class="form-control"
                                   value="{{ old('kir_expiry_date') }}">
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle me-1"></i>
                                Tanggal kadaluarsa KIR berikutnya
                            </small>
                        </div>

                        <!-- Place -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                Tempat
                                <span class="text-danger">*</span>
                            </label>
                            <select name="place"
                                    id="place"
                                    class="form-select @error('place') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Tempat</option>
                                @php
                                    $locations = \App\Models\Location::active()->orderBy('name')->get();
                                @endphp
                                <option value="new" class="fw-bold text-primary">+ Tambah Tempat Baru</option>
                                @if($locations->count() > 0)
                                    @foreach($locations as $location)
                                        <option value="{{ $location->name }}" {{ old('place') == $location->name ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Kantor Pusat" {{ old('place') == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
                                    <option value="Workshop" {{ old('place') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
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
                            @if(auth()->check())
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            @else
                                <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}" placeholder="Nama pengguna">
                            @endif
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-2 text-primary"></i>
                                Metode Pembayaran
                                <span class="text-danger">*</span>
                            </label>
                            <select name="payment_method_id" class="form-select @error('payment_method_id') is-invalid @enderror" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                @php
                                    $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();
                                @endphp
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                Jumlah Biaya
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text"
                                       name="amount"
                                       id="amount"
                                       class="form-control currency-input @error('amount') is-invalid @enderror"
                                       placeholder="Masukkan jumlah biaya"
                                       value="{{ old('amount') }}"
                                       required
                                       inputmode="numeric">
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
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
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Pengeluaran
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
        background: #007bff;
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
        color: #007bff;
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
// Auto-fill current time when user focuses on time input
document.addEventListener('DOMContentLoaded', function() {
    const timeInput = document.getElementById('expense_time');
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

// Vehicle Custom Dropdown Logic
// Auto-focus when dropdown opens
document.getElementById('vehicleDropdownBtn')?.addEventListener('shown.bs.dropdown', function() {
    const searchInput = document.getElementById('vehicleSearchInput');
    if (searchInput) {
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }
});

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
    const odometer = parseFloat(element.getAttribute('data-odometer')) || 0;

    document.getElementById('vehicle_id').value = value;
    document.getElementById('vehicleDropdownText').textContent = text;

    // Smart Odometer Logic
    const odometerInput = document.getElementById('odometer');
    const lastOdometerDisplay = document.getElementById('lastOdometerDisplay');
    const lastOdometerValue = document.getElementById('lastOdometerValue');

    if (odometerInput) {
        // Use global formatter if available, else raw
        const formattedOdo = typeof formatCurrency === 'function' ? formatCurrency(odometer) : odometer;
        odometerInput.value = formattedOdo;
        // Store raw min for validation logic if needed manually,
        // but since input is text, we rely on server validation mostly,
        // plus maybe strict client check on parse.

        // Update UI Label
        if (lastOdometerDisplay && lastOdometerValue && odometer > 0) {
            lastOdometerDisplay.style.display = 'inline-block';
            lastOdometerValue.textContent = formattedOdo + ' KM';
        } else if (lastOdometerDisplay) {
            lastOdometerDisplay.style.display = 'none';
        }
    }

    document.querySelectorAll('.vehicle-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
}

// Pre-select vehicle if exists
document.addEventListener('DOMContentLoaded', function() {
    const vehicleId = "{{ old('vehicle_id', $vehicle->id ?? '') }}";
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

// Handle Expense Type Change
function handleExpenseTypeChange(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const expenseTypeName = selectedOption.getAttribute('data-name') || '';

    const stnkGroup = document.getElementById('stnkExpiryGroup');
    const kirGroup = document.getElementById('kirExpiryGroup');
    const stnkInput = document.getElementById('stnkExpiryDate');
    const kirInput = document.getElementById('kirExpiryDate');

    // Hide both by default
    stnkGroup.style.display = 'none';
    kirGroup.style.display = 'none';
    stnkInput.removeAttribute('required');
    kirInput.removeAttribute('required');

    // Show relevant field based on expense type
    if (expenseTypeName.toLowerCase().includes('perpanjangan stnk') ||
        expenseTypeName.toLowerCase().includes('stnk extension') ||
        expenseTypeName.toLowerCase().includes('stnk')) {
        stnkGroup.style.display = 'block';
        stnkInput.setAttribute('required', 'required');
    } else if (expenseTypeName.toLowerCase().includes('perpanjangan kir') ||
               expenseTypeName.toLowerCase().includes('kir extension') ||
               expenseTypeName.toLowerCase().includes('kir')) {
        kirGroup.style.display = 'block';
        kirInput.setAttribute('required', 'required');
    }
}

// Handle Add New Redirection
document.addEventListener('DOMContentLoaded', function() {
    const expenseTypeSelect = document.getElementById('expenseTypeSelect');
    const placeSelect = document.getElementById('place');

    if (expenseTypeSelect) {
        expenseTypeSelect.addEventListener('change', function() {
            if (this.value === 'new') {
                if (confirm('Anda akan diarahkan ke halaman pengaturan untuk menambah jenis pengeluaran baru. Lanjutkan?')) {
                    window.location.href = "{{ route('settings.expense-types') }}";
                } else {
                    this.value = ""; // Reset
                }
            }
        });
    }

    if (placeSelect) {
        placeSelect.addEventListener('change', function() {
            if (this.value === 'new') {
                if (confirm('Anda akan diarahkan ke halaman pengaturan untuk menambah tempat baru. Lanjutkan?')) {
                    window.location.href = "{{ route('settings.locations') }}";
                } else {
                    this.value = ""; // Reset
                }
            }
        });
    }
});

// Form validation
document.getElementById('expenseForm')?.addEventListener('submit', function(e) {
    const requiredFields = [
        { id: 'vehicle_id', name: 'Kendaraan' },
        { id: 'expense_date', name: 'Tanggal' },
        { id: 'expense_time', name: 'Waktu' },
        { id: 'expenseTypeSelect', name: 'Jenis Pengeluaran' },
        { id: 'place', name: 'Tempat' },
        { id: 'amount', name: 'Jumlah Biaya' }
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
