@extends('layouts.drivvo')

@section('title', 'Tambah Servis Baru')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-wrench"></i>
                    Tambah Servis Baru
                </h1>
                <p class="page-subtitle mb-0">Catat perawatan dan servis kendaraan Anda</p>
            </div>
            <a href="{{ route('maintenances.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle me-3 mt-1" style="font-size: 20px;"></i>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-2">Terdapat kesalahan dalam pengisian form:</h6>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm" enctype="multipart/form-data">
                @csrf

                <!-- Vehicle Selection -->
                <div class="form-section mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-car text-primary me-2"></i>
                        Informasi Kendaraan
                    </h5>
                    <div class="row">
                        <div class="col-md-12">
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
                                    <input type="hidden" name="vehicle_id" id="vehicle_id" required>

                                    <div class="dropdown-menu w-100 p-2" aria-labelledby="vehicleDropdownBtn">
                                        <div class="mb-2 position-relative">
                                            <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   id="vehicleSearchInput"
                                                   placeholder="Cari Nama atau No Plat..."
                                                   style="padding-left: 40px; padding-right: 40px;"
                                                   onclick="event.stopPropagation()"
                                                   autofocus>
                                            <button type="button"
                                                    class="btn btn-sm position-absolute"
                                                    style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none;"
                                                    id="clearVehicleSearch"
                                                    onclick="document.getElementById('vehicleSearchInput').value=''; document.querySelectorAll('.vehicle-option').forEach(opt => opt.style.display = 'block'); event.stopPropagation();">
                                                <i class="fas fa-times text-muted"></i>
                                            </button>
                                        </div>
                                        <div class="vehicle-list-container" style="max-height: 250px; overflow-y: auto;">
                                            @foreach($vehicles as $vehicle)
                                                <a class="dropdown-item vehicle-option"
                                                   href="#"
                                                   data-value="{{ $vehicle->id }}"
                                                   data-odometer="{{ $vehicle->getLatestOdometer() }}"
                                                   data-text="{{ $vehicle->name }} {{ $vehicle->license_plate }}"
                                                   onclick="selectVehicle(this, event)">
                                                     <div class="d-flex justify-content-between align-items-center">
                                                         <div>
                                                             <strong>{{ $vehicle->name }}</strong>
                                                             <br>
                                                             <small class="text-muted">{{ $vehicle->license_plate }}</small>
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
                                   value="{{ old('service_date', date('Y-m-d')) }}"
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
                                   value="{{ old('service_time', date('H:i')) }}"
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
                                <span id="lastOdometerDisplay" class="ms-2" style="display:none; font-weight: normal; font-size: 0.9rem;">
                                    (Last: <span id="lastOdometerValue" class="fw-bold text-dark"></span> <span class="text-danger">*</span>)
                                </span>
                            </label>
                            <div class="input-group">
                                <input type="text"
                                       name="odometer"
                                       id="odometer"
                                       class="form-control currency-input @error('odometer') is-invalid @enderror"
                                       placeholder="Masukkan odometer"
                                       value="{{ old('odometer') }}"
                                       required
                                       inputmode="numeric">
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
                                <button type="button"
                                        class="btn btn-sm btn-info text-white"
                                        onclick="showPartsReference()"
                                        title="Lihat Referensi Harga Parts">
                                    <i class="fas fa-info-circle"></i>
                                </button>
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
                            <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    Tempat Servis
                                    <span class="text-danger">*</span>
                                </span>
                                <a href="javascript:void(0)" onclick="openQuickAddLocationModal()" class="btn btn-sm btn-link text-primary p-0 text-decoration-none">
                                    <i class="fas fa-plus-circle me-1"></i>Tambah Tempat
                                </a>
                            </label>
                            <select name="place"
                                    id="place"
                                    class="form-select @error('place') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Tempat Servis</option>
                                @php
                                    $locations = \App\Models\Location::active()->get();
                                @endphp
                                <option value="new" class="fw-bold text-primary" onclick="openQuickAddLocationModal()">+ Tambah Tempat Baru</option>
                                @if($locations->count() > 0)
                                    @foreach($locations as $location)
                                        <option value="{{ $location->name }}" {{ old('place') == $location->name ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Workshop A" {{ old('place') == 'Workshop A' ? 'selected' : '' }}>Workshop A</option>
                                    <option value="Workshop B" {{ old('place') == 'Workshop B' ? 'selected' : '' }}>Workshop B</option>
                                @endif
                            </select>
                            @error('place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User (Auto-filled, read-only) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Penanggung Jawab
                            </label>
                            <input type="text"
                                   class="form-control bg-light"
                                   value="{{ Auth::user()->name }}"
                                   readonly>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <small class="text-muted">Otomatis terisi berdasarkan akun yang login</small>
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-2 text-primary"></i>
                                Metode Pembayaran
                                <span class="text-danger">*</span>
                            </label>
                            <select name="payment_method"
                                    id="payment_method"
                                    class="form-select @error('payment_method') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Metode Pembayaran</option>
                                @if(isset($paymentMethods) && $paymentMethods->count() > 0)
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->name }}" {{ old('payment_method') == $method->name ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
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
                            <textarea name="notes"
                                      id="notes"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Tambahkan catatan atau keterangan tambahan tentang service ini...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Attachment -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-paperclip me-2 text-primary"></i>
                                Lampiran File
                            </label>
                            <div class="custom-file-upload">
                                <input type="file"
                                       name="attachment"
                                       id="attachment"
                                       class="form-control @error('attachment') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format yang didukung: JPG, PNG, PDF, DOC, DOCX (Maks. 5MB)
                                </small>
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div id="filePreview" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                    <a href="{{ route('maintenances.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-times me-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>
                        Simpan Servis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Parts Reference Modal -->
<div class="modal fade" id="partsReferenceModal" tabindex="-1" aria-labelledby="partsReferenceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="partsReferenceModalLabel">
                    <i class="fas fa-info-circle me-2"></i>
                    Referensi Harga Parts
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    Berikut adalah daftar harga parts sebagai referensi untuk servis kendaraan Anda.
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="40%">Nama Part</th>
                                <th width="30%">Kategori</th>
                                <th width="25%" class="text-end">Harga Estimasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Oli Mesin (4L)</td>
                                <td><span class="badge bg-success">Servis Rutin</span></td>
                                <td class="text-end">Rp 150.000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Filter Oli</td>
                                <td><span class="badge bg-success">Servis Rutin</span></td>
                                <td class="text-end">Rp 45.000</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Filter Udara</td>
                                <td><span class="badge bg-success">Servis Rutin</span></td>
                                <td class="text-end">Rp 85.000</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Busi (Set 4pcs)</td>
                                <td><span class="badge bg-warning text-dark">Tune Up</span></td>
                                <td class="text-end">Rp 120.000</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Kampas Rem Depan</td>
                                <td><span class="badge bg-danger">Perbaikan</span></td>
                                <td class="text-end">Rp 250.000</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Kampas Rem Belakang</td>
                                <td><span class="badge bg-danger">Perbaikan</span></td>
                                <td class="text-end">Rp 200.000</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Aki/Battery 45Ah</td>
                                <td><span class="badge bg-danger">Perbaikan</span></td>
                                <td class="text-end">Rp 650.000</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Ban (per piece)</td>
                                <td><span class="badge bg-danger">Perbaikan</span></td>
                                <td class="text-end">Rp 800.000</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Wiper Blade (Sepasang)</td>
                                <td><span class="badge bg-info">Aksesoris</span></td>
                                <td class="text-end">Rp 75.000</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Coolant/Air Radiator (4L)</td>
                                <td><span class="badge bg-success">Servis Rutin</span></td>
                                <td class="text-end">Rp 95.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Catatan:</strong> Harga di atas adalah estimasi dan dapat berubah sewaktu-waktu. Silakan konfirmasi harga aktual dengan bengkel.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Service Selection Modal -->
<div class="modal fade" id="serviceSelectionModal" tabindex="-1" aria-labelledby="serviceSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <h5 class="modal-title mb-0" id="serviceSelectionModalLabel">
                        <i class="fas fa-wrench me-2"></i>
                        Jenis Servis
                    </h5>
                    <div class="input-group" style="max-width: 300px; position: relative;">
                        <span class="input-group-text bg-white border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control border-0"
                               id="serviceSearchInput"
                               placeholder="Cari servis..."
                               autofocus
                               style="padding-right: 35px; background: white;"
                               autocomplete="off">
                        <button type="button"
                                class="btn position-absolute"
                                style="right: 5px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: none; z-index: 10;"
                                id="clearServiceSearch"
                                onclick="document.getElementById('serviceSearchInput').value=''; document.getElementById('clearServiceSearch').style.display='none'; renderServiceList('');">
                            <i class="fas fa-times text-muted"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="service-list" id="serviceListContainer">
                    <!-- Services will be dynamically loaded here -->
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-primary" onclick="openQuickAddServiceTypeModal()">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Baru
                </button>
                <button type="button" class="btn btn-primary px-4" onclick="confirmServiceSelection()">
                    <i class="fas fa-check me-2"></i>
                    Pilih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quick Add Location -->
<div class="modal fade" id="quickAddLocationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-map-marker-alt me-2"></i>Tambah Tempat Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickAddLocationForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Tempat <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Bengkel Maju">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" required placeholder="Contoh: BM01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" required placeholder="Alamat lengkap bengkel"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Quick Add Service Type -->
<div class="modal fade" id="quickAddServiceTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-wrench me-2"></i>Tambah Jenis Servis Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickAddServiceTypeForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Servis <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="new_service_name_input" class="form-control" required placeholder="Contoh: Service AC">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" placeholder="Keterangan singkat (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .page-header {
        background: white;
        padding: 30px;
        border-radius: 12px;
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
        color: #fd7e14;
        font-size: 24px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }

    .form-section {
        padding: 24px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #fd7e14;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #fd7e14;
        box-shadow: 0 0 0 3px rgba(253, 126, 20, 0.1);
        outline: none;
    }

    .input-group-text {
        background: white;
        border: 2px solid #e9ecef;
        font-size: 14px;
        font-weight: 600;
        color: #6c757d;
        border-left: none;
    }

    .input-group .form-control {
        border-right: none;
    }

    .input-group .form-control:focus {
        border-color: #fd7e14;
    }

    .input-group .form-control:focus + .input-group-text {
        border-color: #fd7e14;
    }

    .btn-primary {
        background: #fd7e14;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #e56b0f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);
    }

    .btn-secondary {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-info {
        background: #17a2b8;
        border: none;
    }

    .btn-info:hover {
        background: #138496;
    }

    .custom-file-upload {
        position: relative;
    }

    .custom-file-upload input[type="file"] {
        cursor: pointer;
    }

    #filePreview {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        display: none;
    }

    #filePreview.show {
        display: block;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        background: #fd7e14;
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    /* Service Selection Modal Styles */
    .service-list {
        padding: 20px;
    }

    .service-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s ease;
    }

    .service-item:hover {
        background-color: #f8f9fa;
    }

    .service-item:last-child {
        border-bottom: none;
    }

    .service-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        margin-right: 16px;
        accent-color: #0d6efd;
    }

    .service-name {
        flex: 1;
        font-size: 15px;
        color: #2c3e50;
        font-weight: 500;
    }

    .service-price-input {
        width: 200px;
        padding: 8px 12px;
        border: 2px solid #dee2e6;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .service-price-input:focus {
        border-color: #0d6efd;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .service-price-input.hidden {
        display: none;
    }

    .selected-service-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .selected-service-item:last-child {
        margin-bottom: 0;
    }

    .selected-service-name {
        font-weight: 500;
        color: #2c3e50;
        flex: 1;
    }

    .selected-service-price {
        font-weight: 600;
        color: #0d6efd;
        margin-right: 12px;
    }

    .remove-service-btn {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .remove-service-btn:hover {
        background: #bb2d3b;
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
// Set current time when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill current time when user focuses on time input
    const timeInput = document.getElementById('service_time');
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

    // Focus on vehicle select
    const vehicleSelect = document.getElementById('vehicle_id');
    if (vehicleSelect && !vehicleSelect.value) {
        vehicleSelect.focus();
    }

    // File upload preview
    const attachmentInput = document.getElementById('attachment');
    const filePreview = document.getElementById('filePreview');

    if (attachmentInput) {
        attachmentInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
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

// Function to show parts reference modal
function showPartsReference() {
    const modal = new bootstrap.Modal(document.getElementById('partsReferenceModal'));
    modal.show();
}

// Function to clear file
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

// Service Selection Logic
let availableServices = [];

// Load services from backend database
@if(isset($serviceTypes) && $serviceTypes->count() > 0)
    availableServices = [
        @foreach($serviceTypes as $type)
        { id: '{{ Str::slug($type->name) }}', name: '{{ $type->name }}', refPrice: {{ $type->price ?? 0 }} },
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
        // Format existing price if any
        let price = '';
        if (selectedService && selectedService.price) {
            price = formatCurrency(selectedService.price);
        }

        // Reference price label
        const refPriceLabel = service.refPrice && service.refPrice > 0
            ? `<small class="text-muted ms-2">(Ref: Rp ${formatCurrency(service.refPrice.toString())})</small>`
            : '';

        const item = document.createElement('div');
        item.className = 'service-item';
        item.innerHTML = `
            <input type="checkbox" class="service-checkbox" id="check_${service.id}"
                   ${isSelected ? 'checked' : ''} onchange="toggleServicePrice('${service.id}', this)">
            <label class="service-name" for="check_${service.id}">${service.name}${refPriceLabel}</label>
            <input type="text" class="service-price-input currency-input ${isSelected ? '' : 'hidden'}"
                   id="price_${service.id}" placeholder="Harga (Rp)" value="${price}"
                   oninput="this.value = formatCurrency(this.value, true); updateServicePrice('${service.id}', this.value)">
        `;
        container.appendChild(item);
    });
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatPriceInput(input) {
    if (typeof formatCurrency === 'function') {
        input.value = formatCurrency(input.value);
    } else {
        // Fallback if global function not loaded
        let value = input.value.replace(/\D/g, '');
        if (value) {
            value = parseInt(value, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        input.value = value;
    }
}

function toggleServicePrice(serviceId, checkbox) {
    const priceInput = document.getElementById(`price_${serviceId}`);
    if (checkbox.checked) {
        priceInput.classList.remove('hidden');

        // Add to selected services if not exists
        const service = availableServices.find(s => s.id === serviceId);
        if (!selectedServices.some(s => s.id === serviceId)) {
            // Auto-fill with reference price if available
            const refPrice = service.refPrice || 0;
            if (refPrice > 0) {
                priceInput.value = formatCurrency(refPrice.toString());
                selectedServices.push({ ...service, price: refPrice });
            } else {
                selectedServices.push({ ...service, price: '' });
            }
        }

        priceInput.focus();
    } else {
        priceInput.classList.add('hidden');
        priceInput.value = '';

        // Remove from selected services
        selectedServices = selectedServices.filter(s => s.id !== serviceId);
    }
}

function updateServicePrice(serviceId, formattedPrice) {
    const index = selectedServices.findIndex(s => s.id === serviceId);
    if (index !== -1) {
        // Store raw number using global parser
        selectedServices[index].price = parseCurrency(formattedPrice);
    }
}

function addNewServiceType() {
    const searchInput = document.getElementById('serviceSearchInput');
    const newServiceName = searchInput.value.trim();

    if (newServiceName) {
        // Check if already exists
        if (availableServices.some(s => s.name.toLowerCase() === newServiceName.toLowerCase())) {
            alert('Servis ini sudah ada dalam daftar.');
            return;
        }

        const newId = newServiceName.toLowerCase().replace(/[^a-z0-9]/g, '_');
        const newService = { id: newId, name: newServiceName };

        availableServices.push(newService);
        // Sort alphabetically
        availableServices.sort((a, b) => a.name.localeCompare(b.name));

        renderServiceList(searchInput.value);

        // Auto select the new service
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

// Auto-focus when dropdown opens
document.getElementById('vehicleDropdownBtn')?.addEventListener('shown.bs.dropdown', function() {
    const searchInput = document.getElementById('vehicleSearchInput');
    if (searchInput) {
        setTimeout(() => {
            searchInput.focus();
        }, 100);
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
    const odometer = parseFloat(element.getAttribute('data-odometer')) || 0;

    document.getElementById('vehicle_id').value = value;
    document.getElementById('vehicleDropdownText').textContent = text;

    // Auto-fill and strict validation logic
    const odometerInput = document.getElementById('odometer');
    const lastOdometerDisplay = document.getElementById('lastOdometerDisplay');
    const lastOdometerValue = document.getElementById('lastOdometerValue');

    if (odometerInput) {
        // Set values and constraints
        odometerInput.value = odometer; // Pre-fill with last known
        odometerInput.min = odometer;

        // Update Label Display
        if (lastOdometerDisplay && lastOdometerValue && odometer > 0) {
            lastOdometerDisplay.style.display = 'inline-block';
            lastOdometerValue.textContent = odometer + ' KM';
        } else if (lastOdometerDisplay) {
            lastOdometerDisplay.style.display = 'none';
        }

        // Input Validation Visuals
        odometerInput.oninput = function() {
            if (parseFloat(this.value) < odometer) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        };
    }

    // Highlight selected
    document.querySelectorAll('.vehicle-option').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
}

// AJAX Quick Add Functions
let quickAddLocationModal;
let quickAddServiceTypeModal;

function openQuickAddLocationModal() {
    if (!quickAddLocationModal) {
        quickAddLocationModal = new bootstrap.Modal(document.getElementById('quickAddLocationModal'));
    }
    quickAddLocationModal.show();
}

function openQuickAddServiceTypeModal() {
    if (!quickAddServiceTypeModal) {
        quickAddServiceTypeModal = new bootstrap.Modal(document.getElementById('quickAddServiceTypeModal'));
    }
    const currentSearch = document.getElementById('serviceSearchInput').value;
    if (currentSearch) {
        document.getElementById('new_service_name_input').value = currentSearch;
    }
    quickAddServiceTypeModal.show();
}

// Handle Add New Redirection (Replaced by AJAX)
document.addEventListener('DOMContentLoaded', function() {
    const placeSelect = document.getElementById('place');

    if (placeSelect) {
        placeSelect.addEventListener('change', function() {
            if (this.value === 'new') {
                this.value = ""; // Reset dropdown
                openQuickAddLocationModal();
            }
        });
    }

    // Handle AJAX forms
    document.getElementById('quickAddLocationForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

        fetch("{{ route('settings.locations.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add to select
                const option = new Option(data.data.name, data.data.name, true, true);
                placeSelect.add(option, placeSelect.options[1]);
                quickAddLocationModal.hide();
                this.reset();
            } else {
                alert('Error: ' + (data.message || 'Gagal menyimpan data'));
            }
        })
        .catch(err => alert('Gagal menghubungkan ke server'))
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        });
    });

    document.getElementById('quickAddServiceTypeForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

        fetch("{{ route('settings.service-types.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newService = {
                    id: data.data.id.toString(), // Ensure string ID for consistency
                    name: data.data.name
                };

                // Add to availableServices
                availableServices.push(newService);
                availableServices.sort((a, b) => a.name.localeCompare(b.name));

                // Re-render and select
                renderServiceList(document.getElementById('serviceSearchInput').value);

                // Find and check the new item
                setTimeout(() => {
                    const checkbox = document.getElementById(`check_${newService.id}`);
                    if (checkbox) {
                        checkbox.checked = true;
                        toggleServicePrice(newService.id, checkbox);
                    }
                }, 100);

                quickAddServiceTypeModal.hide();
                this.reset();
            } else {
                alert('Error: ' + (data.message || 'Gagal menyimpan data'));
            }
        })
        .catch(err => alert('Gagal menghubungkan ke server'))
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        });
    });
});

// Pre-select vehicle if exists
document.addEventListener('DOMContentLoaded', function() {
    const oldVehicleId = "{{ old('vehicle_id', request('vehicle_id')) }}";
    if (oldVehicleId) {
        const option = document.querySelector(`.vehicle-option[data-value="${oldVehicleId}"]`);
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
            // Special check for selected_services array
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

@endsection
