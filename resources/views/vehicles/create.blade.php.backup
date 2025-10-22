@extends('layouts.drivvo')

@section('title', 'Tambah Kendaraan')

@push('styles')
<style>
    .vehicle-type-selector {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }
    .vehicle-type-btn {
        border: 2px solid #e0e0e0;
        background: white;
        padding: 20px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .vehicle-type-btn:hover {
        border-color: #3498db;
        background: #f8f9fa;
    }
    .vehicle-type-btn.active {
        border-color: #3498db;
        background: #e3f2fd;
    }
    .vehicle-type-btn i {
        font-size: 32px;
        color: #6c757d;
    }
    .vehicle-type-btn.active i {
        color: #3498db;
    }
    .vehicle-type-btn span {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
    }
    .form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        background: white;
    }
    .form-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    .form-content {
        padding: 24px;
        background: white;
    }
    .form-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container-fluid" style="max-width: 800px; padding-top: 20px;">
    <div class="card border-0 shadow-sm">
        <!-- Form Header -->
        <div class="form-header">
            <div class="form-icon">
                <i class="fas fa-car"></i>
            </div>
            <h5>Kendaraan</h5>
        </div>

        <!-- Form Content -->
        <div class="form-content">
            <form action="{{ route('vehicles.store') }}" method="POST" id="vehicleForm">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}"
                                   placeholder="Contoh: Mobil Keluarga">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="license_plate" class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('license_plate') is-invalid @enderror" 
                                   id="license_plate" name="license_plate" value="{{ old('license_plate') }}"
                                   placeholder="B 1234 XYZ">
                            @error('license_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="brand" class="form-label">Merek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand') }}"
                                   placeholder="Toyota, Honda, dll">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model') }}"
                                   placeholder="Avanza, Jazz, dll">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('year') is-invalid @enderror" 
                                   id="year" name="year" value="{{ old('year') }}"
                                   placeholder="2020">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="engine_type" class="form-label">Jenis Mesin <span class="text-danger">*</span></label>
                            <select class="form-select @error('engine_type') is-invalid @enderror" 
                                    id="engine_type" name="engine_type">
                                <option value="">Pilih Jenis Mesin</option>
                                <option value="Gasoline" {{ old('engine_type') == 'Gasoline' ? 'selected' : '' }}>Bensin</option>
                                <option value="Diesel" {{ old('engine_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="Hybrid" {{ old('engine_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="Electric" {{ old('engine_type') == 'Electric' ? 'selected' : '' }}>Listrik</option>
                            </select>
                            @error('engine_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="transmission" class="form-label">Transmisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('transmission') is-invalid @enderror" 
                                    id="transmission" name="transmission">
                                <option value="">Pilih Transmisi</option>
                                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Otomatis</option>
                                <option value="CVT" {{ old('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tank_capacity" class="form-label">Kapasitas Tangki (L)</label>
                            <input type="number" class="form-control @error('tank_capacity') is-invalid @enderror" 
                                   id="tank_capacity" name="tank_capacity" value="{{ old('tank_capacity') }}"
                                   step="0.1" min="0" placeholder="45">
                            @error('tank_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="odometer" class="form-label">Odometer Saat Ini (KM) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('odometer') is-invalid @enderror" 
                                   id="odometer" name="odometer" value="{{ old('odometer') }}"
                                   step="0.1" min="0" placeholder="50000">
                            @error('odometer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="color" class="form-label">Warna</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                   id="color" name="color" value="{{ old('color') }}"
                                   placeholder="Hitam, Putih, dll">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="Catatan tambahan tentang kendaraan...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Kendaraan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    <strong>Tips:</strong>
                </p>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Gunakan nama yang mudah diingat untuk kendaraan Anda
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Pastikan plat nomor diisi dengan benar dan unik
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Odometer awal penting untuk tracking yang akurat
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        Kapasitas tangki membantu perhitungan konsumsi BBM
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection