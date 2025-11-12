@extends('layouts.drivvo')@extends('layouts.drivvo')



@section('title', 'Edit Service')@section('title', 'Edit Maintenance')



@section('content')@section('content')

<style><div class="container-fluid py-4">

    .page-header {    <div class="row justify-content-center">

        background: white;        <div class="col-lg-10">

        padding: 30px;            <div class="card">

        border-radius: 12px;                <div class="card-header d-flex justify-content-between align-items-center">

        box-shadow: 0 1px 3px rgba(0,0,0,0.1);                    <h5 class="mb-0">

        margin-bottom: 24px;                        <i class="fas fa-edit text-warning me-2"></i>

    }                        Edit Maintenance

                        </h5>

    .page-title {                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary btn-sm">

        font-size: 28px;                        <i class="fas fa-arrow-left me-1"></i>Back

        font-weight: 700;                    </a>

        color: #1a1a1a;                </div>

        margin: 0 0 8px 0;                <div class="card-body">

        display: flex;                    <form action="{{ route('maintenances.update', $maintenance) }}" method="POST">

        align-items: center;                        @csrf

        gap: 12px;                        @method('PUT')

    }

                            <div class="row">

    .page-title i {                            <!-- Vehicle dan Date -->

        color: #ffc107;                            <div class="col-md-6">

        font-size: 24px;                                <div class="mb-3">

    }                                    <label for="vehicle_id" class="form-label">

                                            <i class="fas fa-car me-1"></i>Vehicle <span class="text-danger">*</span>

    .page-subtitle {                                    </label>

        font-size: 14px;                                    <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>

        color: #6c757d;                                        <option value="">Select Vehicle</option>

        margin: 0;                                        @foreach($vehicles as $vehicle)

    }                                            <option value="{{ $vehicle->id }}" {{ $maintenance->vehicle_id == $vehicle->id ? 'selected' : '' }}>

                                                    {{ $vehicle->name }} ({{ $vehicle->license_plate }})

    .form-container {                                            </option>

        background: white;                                        @endforeach

        padding: 32px;                                    </select>

        border-radius: 12px;                                    @error('vehicle_id')

        box-shadow: 0 1px 3px rgba(0,0,0,0.1);                                        <div class="invalid-feedback">{{ $message }}</div>

        max-width: 800px;                                    @enderror

        margin: 0 auto;                                </div>

    }

                                    <div class="mb-3">

    .form-group {                                    <label for="maintenance_date" class="form-label">

        margin-bottom: 24px;                                        <i class="fas fa-calendar me-1"></i>Date Maintenance <span class="text-danger">*</span>

    }                                    </label>

                                        <input type="date"

    .form-label {                                           class="form-control @error('maintenance_date') is-invalid @enderror"

        font-weight: 600;                                           id="maintenance_date"

        color: #2c3e50;                                           name="maintenance_date"

        margin-bottom: 8px;                                           value="{{ old('maintenance_date', $maintenance->maintenance_date) }}"

        font-size: 14px;                                           required>

        display: block;                                    @error('maintenance_date')

    }                                        <div class="invalid-feedback">{{ $message }}</div>

                                        @enderror

    .form-control, .form-select {                                </div>

        border: 2px solid #e9ecef;

        border-radius: 8px;                                <div class="mb-3">

        padding: 12px 16px;                                    <label for="odometer" class="form-label">

        font-size: 14px;                                        <i class="fas fa-tachometer-alt me-1"></i>Odometer (km) <span class="text-danger">*</span>

        transition: all 0.3s ease;                                    </label>

        width: 100%;                                    <input type="number"

    }                                           class="form-control @error('odometer') is-invalid @enderror"

                                               id="odometer"

    .form-control:focus, .form-select:focus {                                           name="odometer"

        border-color: #ffc107;                                           value="{{ old('odometer', $maintenance->odometer) }}"

        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);                                           min="0"

        outline: none;                                           step="0.01"

    }                                           required>

                                        @error('odometer')

    .btn-warning {                                        <div class="invalid-feedback">{{ $message }}</div>

        background: #ffc107;                                    @enderror

        border: none;                                </div>

        padding: 12px 24px;                            </div>

        border-radius: 8px;

        font-weight: 600;                            <!-- Type dan Kategori -->

        font-size: 14px;                            <div class="col-md-6">

        transition: all 0.3s ease;                                <div class="mb-3">

        color: #212529;                                    <label for="type" class="form-label">

    }                                        <i class="fas fa-wrench me-1"></i>Type Maintenance <span class="text-danger">*</span>

                                        </label>

    .btn-warning:hover {                                    <input type="text"

        background: #ffb30f;                                           class="form-control @error('type') is-invalid @enderror"

        transform: translateY(-2px);                                           id="type"

        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);                                           name="type"

        color: #212529;                                           value="{{ old('type', $maintenance->type) }}"

    }                                           placeholder="Example: Oil Change, Regular Service"

                                               required>

    .btn-secondary {                                    @error('type')

        background: #6c757d;                                        <div class="invalid-feedback">{{ $message }}</div>

        border: none;                                    @enderror

        padding: 12px 24px;                                </div>

        border-radius: 8px;

        font-weight: 600;                                <div class="mb-3">

        font-size: 14px;                                    <label for="category" class="form-label">

        transition: all 0.3s ease;                                        <i class="fas fa-tags me-1"></i>Kategori <span class="text-danger">*</span>

        color: white;                                    </label>

        text-decoration: none;                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>

    }                                        <option value="">Select Kategori</option>

                                            <option value="Routine" {{ $maintenance->category == 'Routine' ? 'selected' : '' }}>Rutin</option>

    .btn-secondary:hover {                                        <option value="Repair" {{ $maintenance->category == 'Repair' ? 'selected' : '' }}>Perbaikan</option>

        background: #5a6268;                                        <option value="Emergency" {{ $maintenance->category == 'Emergency' ? 'selected' : '' }}>Darurat</option>

        color: white;                                    </select>

        text-decoration: none;                                    @error('category')

    }                                        <div class="invalid-feedback">{{ $message }}</div>

                                        @enderror

    .form-actions {                                </div>

        display: flex;

        gap: 12px;                                <div class="mb-3">

        justify-content: flex-end;                                    <label for="Status" class="form-label">

        margin-top: 32px;                                        <i class="fas fa-flag me-1"></i>Status <span class="text-danger">*</span>

        padding-top: 24px;                                    </label>

        border-top: 1px solid #e9ecef;                                    <select class="form-select @error('Status') is-invalid @enderror" id="Status" name="Status" required>

    }                                        <option value="">Select Status</option>

                                            <option value="Completed" {{ $maintenance->Status == 'Completed' ? 'selected' : '' }}>End</option>

    .required {                                        <option value="Scheduled" {{ $maintenance->Status == 'Scheduled' ? 'selected' : '' }}>Terjadwal</option>

        color: #dc3545;                                        <option value="Overdue" {{ $maintenance->Status == 'Overdue' ? 'selected' : '' }}>Overdue</option>

    }                                    </select>

                                        @error('Status')

    .input-group-text {                                        <div class="invalid-feedback">{{ $message }}</div>

        background: white;                                    @enderror

        border: 2px solid #e9ecef;                                </div>

        border-left: none;                            </div>

        color: #6c757d;                        </div>

    }

                            <!-- Deskripsi -->

    .input-group .form-control {                        <div class="row">

        border-right: none;                            <div class="col-12">

    }                                <div class="mb-3">

                                        <label for="description" class="form-label">

    .input-group .form-control:focus + .input-group-text {                                        <i class="fas fa-file-alt me-1"></i>Deskripsi <span class="text-danger">*</span>

        border-color: #ffc107;                                    </label>

    }                                    <textarea class="form-control @error('description') is-invalid @enderror"

</style>                                              id="description"

                                              name="description"

<div class="container-fluid">                                              rows="3"

    <!-- Page Header -->                                              placeholder="Jelaskan detail Maintenance yang dilakukan..."

    <div class="page-header">                                              required>{{ old('description', $maintenance->description) }}</textarea>

        <h1 class="page-title">                                    @error('description')

            <i class="fas fa-edit"></i>                                        <div class="invalid-feedback">{{ $message }}</div>

            Edit Service                                    @enderror

        </h1>                                </div>

        <p class="page-subtitle">Update data perawatan dan service kendaraan</p>                            </div>

    </div>                        </div>



    <!-- Form Container -->                        <div class="row">

    <div class="form-container">                            <!-- Workshop dan Cost -->

        @if($errors->any())                            <div class="col-md-6">

        <div class="alert alert-danger alert-dismissible fade show" role="alert">                                <div class="mb-3">

            <i class="fas fa-exclamation-triangle me-2"></i>                                    <label for="workshop" class="form-label">

            <strong>Terdapat kesalahan:</strong>                                        <i class="fas fa-store me-1"></i>Bengkel/Workshop

            <ul class="mb-0 mt-2">                                    </label>

                @foreach($errors->all() as $error)                                    <input type="text"

                    <li>{{ $error }}</li>                                           class="form-control @error('workshop') is-invalid @enderror"

                @endforeach                                           id="workshop"

            </ul>                                           name="workshop"

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>                                           value="{{ old('workshop', $maintenance->workshop) }}"

        </div>                                           placeholder="Name bengkel">

        @endif                                    @error('workshop')

                                        <div class="invalid-feedback">{{ $message }}</div>

        <form action="{{ route('maintenances.update', $maintenance) }}" method="POST" id="maintenanceForm">                                    @enderror

            @csrf                                </div>

            @method('PUT')

                                <div class="mb-3">

            <!-- Vehicle Selection -->                                    <label for="cost" class="form-label">

            <div class="form-group">                                        <i class="fas fa-money-bill me-1"></i>Cost (Rp) <span class="text-danger">*</span>

                <label class="form-label">                                    </label>

                    <i class="fas fa-car me-2"></i>Kendaraan <span class="required">*</span>                                    <input type="number"

                </label>                                           class="form-control @error('cost') is-invalid @enderror"

                <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>                                           id="cost"

                    <option value="">Pilih Kendaraan</option>                                           name="cost"

                    @foreach($vehicles as $vehicle)                                           value="{{ old('cost', $maintenance->cost) }}"

                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $maintenance->vehicle_id) == $vehicle->id ? 'selected' : '' }}>                                           min="0"

                            {{ $vehicle->name }} - {{ $vehicle->license_plate }}                                           step="1000"

                        </option>                                           required>

                    @endforeach                                    @error('cost')

                </select>                                        <div class="invalid-feedback">{{ $message }}</div>

                @error('vehicle_id')                                    @enderror

                    <div class="invalid-feedback">{{ $message }}</div>                                </div>

                @enderror                            </div>

            </div>

                            <!-- Maintenance Selanjutnya -->

            <div class="row">                            <div class="col-md-6">

                <!-- Tanggal Service -->                                <div class="mb-3">

                <div class="col-md-6">                                    <label for="next_maintenance_date" class="form-label">

                    <div class="form-group">                                        <i class="fas fa-calendar-alt me-1"></i>Date Maintenance Selanjutnya

                        <label class="form-label">                                    </label>

                            <i class="fas fa-calendar me-2"></i>Tanggal Service <span class="required">*</span>                                    <input type="date"

                        </label>                                           class="form-control @error('next_maintenance_date') is-invalid @enderror"

                        <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror"                                            id="next_maintenance_date"

                               value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d')) }}" required>                                           name="next_maintenance_date"

                        @error('maintenance_date')                                           value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date) }}">

                            <div class="invalid-feedback">{{ $message }}</div>                                    @error('next_maintenance_date')

                        @enderror                                        <div class="invalid-feedback">{{ $message }}</div>

                    </div>                                    @enderror

                </div>                                </div>



                <!-- Odometer -->                                <div class="mb-3">

                <div class="col-md-6">                                    <label for="next_maintenance_odometer" class="form-label">

                    <div class="form-group">                                        <i class="fas fa-tachometer-alt me-1"></i>Odometer Maintenance Selanjutnya (km)

                        <label class="form-label">                                    </label>

                            <i class="fas fa-tachometer-alt me-2"></i>Odometer <span class="required">*</span>                                    <input type="number"

                        </label>                                           class="form-control @error('next_maintenance_odometer') is-invalid @enderror"

                        <div class="input-group">                                           id="next_maintenance_odometer"

                            <input type="number" name="odometer" class="form-control @error('odometer') is-invalid @enderror"                                            name="next_maintenance_odometer"

                                   placeholder="0" value="{{ old('odometer', $maintenance->odometer) }}" required min="0">                                           value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}"

                            <span class="input-group-text">KM</span>                                           min="0"

                        </div>                                           step="0.01">

                        @error('odometer')                                    @error('next_maintenance_odometer')

                            <div class="invalid-feedback">{{ $message }}</div>                                        <div class="invalid-feedback">{{ $message }}</div>

                        @enderror                                    @enderror

                    </div>                                </div>

                </div>                            </div>

            </div>                        </div>



            <div class="row">                        <!-- Suku Cadang dan Notes -->

                <!-- Jenis Service -->                        <div class="row">

                <div class="col-md-6">                            <div class="col-md-6">

                    <div class="form-group">                                <div class="mb-3">

                        <label class="form-label">                                    <label for="parts_replaced" class="form-label">

                            <i class="fas fa-wrench me-2"></i>Jenis Service <span class="required">*</span>                                        <i class="fas fa-cog me-1"></i>Parts Replaced

                        </label>                                    </label>

                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>                                    <textarea class="form-control @error('parts_replaced') is-invalid @enderror"

                            <option value="">Pilih Jenis Service</option>                                              id="parts_replaced"

                            <option value="Service Rutin" {{ old('type', $maintenance->type) == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>                                              name="parts_replaced"

                            <option value="Ganti Oli" {{ old('type', $maintenance->type) == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>                                              rows="2"

                            <option value="Tune Up" {{ old('type', $maintenance->type) == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>                                              placeholder="List Parts Replaced...">{{ old('parts_replaced', $maintenance->parts_replaced) }}</textarea>

                            <option value="Perbaikan" {{ old('type', $maintenance->type) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>                                    @error('parts_replaced')

                            <option value="Lainnya" {{ old('type', $maintenance->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>                                        <div class="invalid-feedback">{{ $message }}</div>

                        </select>                                    @enderror

                        @error('type')                                </div>

                            <div class="invalid-feedback">{{ $message }}</div>                            </div>

                        @enderror

                    </div>                            <div class="col-md-6">

                </div>                                <div class="mb-3">

                                    <label for="notes" class="form-label">

                <!-- Kategori -->                                        <i class="fas fa-sticky-note me-1"></i>Notes Tambahan

                <div class="col-md-6">                                    </label>

                    <div class="form-group">                                    <textarea class="form-control @error('notes') is-invalid @enderror"

                        <label class="form-label">                                              id="notes"

                            <i class="fas fa-tags me-2"></i>Kategori                                              name="notes"

                        </label>                                              rows="2"

                        <select name="category" class="form-select @error('category') is-invalid @enderror">                                              placeholder="Additional notes...">{{ old('notes', $maintenance->notes) }}</textarea>

                            <option value="Service" {{ old('category', $maintenance->category ?? 'Service') == 'Service' ? 'selected' : '' }}>Service</option>                                    @error('notes')

                            <option value="Repair" {{ old('category', $maintenance->category) == 'Repair' ? 'selected' : '' }}>Repair</option>                                        <div class="invalid-feedback">{{ $message }}</div>

                            <option value="Routine" {{ old('category', $maintenance->category) == 'Routine' ? 'selected' : '' }}>Routine</option>                                    @enderror

                            <option value="Emergency" {{ old('category', $maintenance->category) == 'Emergency' ? 'selected' : '' }}>Emergency</option>                                </div>

                        </select>                            </div>

                        @error('category')                        </div>

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror                        <div class="row">

                    </div>                            <div class="col-12">

                </div>                                <div class="d-flex justify-content-between">

            </div>                                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary">

                                        <i class="fas fa-times me-1"></i>CANCEL

            <!-- Tempat Service -->                                    </a>

            <div class="form-group">                                    <button type="submit" class="btn btn-warning">

                <label class="form-label">                                        <i class="fas fa-save me-1"></i>Update Maintenance

                    <i class="fas fa-map-marker-alt me-2"></i>Tempat Service                                    </button>

                </label>                                </div>

                <input type="text" name="workshop" class="form-control @error('workshop') is-invalid @enderror"                             </div>

                       placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop', $maintenance->workshop ?? $maintenance->place) }}">                        </div>

                @error('workshop')                    </form>

                    <div class="invalid-feedback">{{ $message }}</div>                </div>

                @enderror            </div>

            </div>        </div>

    </div>

            <!-- Biaya --></div>

            <div class="form-group">@endsection

                <label class="form-label">

                    <i class="fas fa-money-bill me-2"></i>Biaya Service

                </label>

                <div class="input-group">

                    <span class="input-group-text">Rp</span>

                    <input type="number" name="cost" class="form-control @error('cost') is-invalid @enderror"

                           placeholder="0" value="{{ old('cost', $maintenance->cost ?? $maintenance->total_cost) }}" min="0">

                </div>

                @error('cost')

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror

            </div>



            <!-- Keterangan -->

            <div class="form-group">

                <label class="form-label">

                    <i class="fas fa-sticky-note me-2"></i>Keterangan

                </label>

                <textarea name="description" class="form-control @error('description') is-invalid @enderror"

                          rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('description', $maintenance->description) }}</textarea>

                @error('description')

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror

            </div>



            <!-- Service Berikutnya -->

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-plus me-2"></i>Jadwal Service Berikutnya
                        </label>
                        <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror"
                               value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date ? $maintenance->next_maintenance_date->format('Y-m-d') : '') }}">
                        @error('next_maintenance_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tachometer-alt me-2"></i>Odometer Service Berikutnya
                        </label>
                        <div class="input-group">
                            <input type="number" name="next_maintenance_odometer" class="form-control @error('next_maintenance_odometer') is-invalid @enderror"
                                   placeholder="0" value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}" min="0">
                            <span class="input-group-text">KM</span>
                        </div>
                        @error('next_maintenance_odometer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-2"></i>Update Service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Basic form validation
document.addEventListener('DOMContentLoaded', function() {
    // Form validation sebelum submit
    const form = document.getElementById('maintenanceForm');
    form.addEventListener('submit', function(e) {
        const vehicleId = document.querySelector('select[name="vehicle_id"]').value;
        const maintenanceDate = document.querySelector('input[name="maintenance_date"]').value;
        const odometer = document.querySelector('input[name="odometer"]').value;
        const type = document.querySelector('select[name="type"]').value;

        if (!vehicleId) {
            e.preventDefault();
            alert('Silakan pilih kendaraan terlebih dahulu!');
            return false;
        }

        if (!maintenanceDate) {
            e.preventDefault();
            alert('Silakan isi tanggal service!');
            return false;
        }

        if (!odometer) {
            e.preventDefault();
            alert('Silakan isi odometer!');
            return false;
        }

        if (!type) {
            e.preventDefault();
            alert('Silakan pilih jenis service!');
            return false;
        }
    });
});
</script>
@endsection
