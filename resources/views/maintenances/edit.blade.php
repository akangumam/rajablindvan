@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')



@section('title', 'Edit Service')



@section('content')@section('title', 'Edit Service')@section('title', 'Edit Maintenance')

<style>

    .page-header {

        background: white;

        padding: 30px;@section('content')@section('content')

        border-radius: 12px;

        box-shadow: 0 1px 3px rgba(0,0,0,0.1);<style><div class="container-fluid py-4">

        margin-bottom: 24px;

    }    .page-header {    <div class="row justify-content-center">



    .page-title {        background: white;        <div class="col-lg-10">

        font-size: 28px;

        font-weight: 700;        padding: 30px;            <div class="card">

        color: #1a1a1a;

        margin: 0 0 8px 0;        border-radius: 12px;                <div class="card-header d-flex justify-content-between align-items-center">

        display: flex;

        align-items: center;        box-shadow: 0 1px 3px rgba(0,0,0,0.1);                    <h5 class="mb-0">

        gap: 12px;

    }        margin-bottom: 24px;                        <i class="fas fa-edit text-warning me-2"></i>



    .page-title i {    }                        Edit Maintenance

        color: #ffc107;

        font-size: 24px;                        </h5>

    }

        .page-title {                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary btn-sm">

    .page-subtitle {

        font-size: 14px;        font-size: 28px;                        <i class="fas fa-arrow-left me-1"></i>Back

        color: #6c757d;

        margin: 0;        font-weight: 700;                    </a>

    }

            color: #1a1a1a;                </div>

    .form-container {

        background: white;        margin: 0 0 8px 0;                <div class="card-body">

        padding: 32px;

        border-radius: 12px;        display: flex;                    <form action="{{ route('maintenances.update', $maintenance) }}" method="POST">

        box-shadow: 0 1px 3px rgba(0,0,0,0.1);

        max-width: 800px;        align-items: center;                        @csrf

        margin: 0 auto;

    }        gap: 12px;                        @method('PUT')



    .form-group {    }

        margin-bottom: 24px;

    }                            <div class="row">



    .form-label {    .page-title i {                            <!-- Vehicle dan Date -->

        font-weight: 600;

        color: #2c3e50;        color: #ffc107;                            <div class="col-md-6">

        margin-bottom: 8px;

        font-size: 14px;        font-size: 24px;                                <div class="mb-3">

        display: block;

    }    }                                    <label for="vehicle_id" class="form-label">



    .form-control, .form-select {                                            <i class="fas fa-car me-1"></i>Vehicle <span class="text-danger">*</span>

        border: 2px solid #e9ecef;

        border-radius: 8px;    .page-subtitle {                                    </label>

        padding: 12px 16px;

        font-size: 14px;        font-size: 14px;                                    <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>

        transition: all 0.3s ease;

        width: 100%;        color: #6c757d;                                        <option value="">Select Vehicle</option>

    }

            margin: 0;                                        @foreach($vehicles as $vehicle)

    .form-control:focus, .form-select:focus {

        border-color: #ffc107;    }                                            <option value="{{ $vehicle->id }}" {{ $maintenance->vehicle_id == $vehicle->id ? 'selected' : '' }}>

        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);

        outline: none;                                                    {{ $vehicle->name }} ({{ $vehicle->license_plate }})

    }

        .form-container {                                            </option>

    .btn-warning {

        background: #ffc107;        background: white;                                        @endforeach

        border: none;

        padding: 12px 24px;        padding: 32px;                                    </select>

        border-radius: 8px;

        font-weight: 600;        border-radius: 12px;                                    @error('vehicle_id')

        font-size: 14px;

        transition: all 0.3s ease;        box-shadow: 0 1px 3px rgba(0,0,0,0.1);                                        <div class="invalid-feedback">{{ $message }}</div>

        color: #212529;

    }        max-width: 800px;                                    @enderror



    .btn-warning:hover {        margin: 0 auto;                                </div>

        background: #ffb30f;

        transform: translateY(-2px);    }

        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);

        color: #212529;                                    <div class="mb-3">

    }

        .form-group {                                    <label for="maintenance_date" class="form-label">

    .btn-secondary {

        background: #6c757d;        margin-bottom: 24px;                                        <i class="fas fa-calendar me-1"></i>Date Maintenance <span class="text-danger">*</span>

        border: none;

        padding: 12px 24px;    }                                    </label>

        border-radius: 8px;

        font-weight: 600;                                        <input type="date"

        font-size: 14px;

        transition: all 0.3s ease;    .form-label {                                           class="form-control @error('maintenance_date') is-invalid @enderror"

        color: white;

        text-decoration: none;        font-weight: 600;                                           id="maintenance_date"

    }

            color: #2c3e50;                                           name="maintenance_date"

    .btn-secondary:hover {

        background: #5a6268;        margin-bottom: 8px;                                           value="{{ old('maintenance_date', $maintenance->maintenance_date) }}"

        color: white;

        text-decoration: none;        font-size: 14px;                                           required>

    }

            display: block;                                    @error('maintenance_date')

    .form-actions {

        display: flex;    }                                        <div class="invalid-feedback">{{ $message }}</div>

        gap: 12px;

        justify-content: flex-end;                                        @enderror

        margin-top: 32px;

        padding-top: 24px;    .form-control, .form-select {                                </div>

        border-top: 1px solid #e9ecef;

    }        border: 2px solid #e9ecef;



    .required {        border-radius: 8px;                                <div class="mb-3">

        color: #dc3545;

    }        padding: 12px 16px;                                    <label for="odometer" class="form-label">



    .input-group-text {        font-size: 14px;                                        <i class="fas fa-tachometer-alt me-1"></i>Odometer (km) <span class="text-danger">*</span>

        background: white;

        border: 2px solid #e9ecef;        transition: all 0.3s ease;                                    </label>

        border-left: none;

        color: #6c757d;        width: 100%;                                    <input type="number"

    }

        }                                           class="form-control @error('odometer') is-invalid @enderror"

    .input-group .form-control {

        border-right: none;                                               id="odometer"

    }

        .form-control:focus, .form-select:focus {                                           name="odometer"

    .input-group .form-control:focus + .input-group-text {

        border-color: #ffc107;        border-color: #ffc107;                                           value="{{ old('odometer', $maintenance->odometer) }}"

    }

</style>        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);                                           min="0"



<div class="container-fluid">        outline: none;                                           step="0.01"

    <!-- Page Header -->

    <div class="page-header">    }                                           required>

        <h1 class="page-title">

            <i class="fas fa-edit"></i>                                        @error('odometer')

            Edit Service

        </h1>    .btn-warning {                                        <div class="invalid-feedback">{{ $message }}</div>

        <p class="page-subtitle">Update data perawatan dan service kendaraan</p>

    </div>        background: #ffc107;                                    @enderror



    <!-- Form Container -->        border: none;                                </div>

    <div class="form-container">

        @if($errors->any())        padding: 12px 24px;                            </div>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="fas fa-exclamation-triangle me-2"></i>        border-radius: 8px;

            <strong>Terdapat kesalahan:</strong>

            <ul class="mb-0 mt-2">        font-weight: 600;                            <!-- Type dan Kategori -->

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>        font-size: 14px;                            <div class="col-md-6">

                @endforeach

            </ul>        transition: all 0.3s ease;                                <div class="mb-3">

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>        color: #212529;                                    <label for="type" class="form-label">

        @endif

    }                                        <i class="fas fa-wrench me-1"></i>Type Maintenance <span class="text-danger">*</span>

        <form action="{{ route('maintenances.update', $maintenance) }}" method="POST" id="maintenanceForm">

            @csrf                                        </label>

            @method('PUT')

    .btn-warning:hover {                                    <input type="text"

            <!-- Vehicle Selection -->

            <div class="form-group">        background: #ffb30f;                                           class="form-control @error('type') is-invalid @enderror"

                <label class="form-label">

                    <i class="fas fa-car me-2"></i>Kendaraan <span class="required">*</span>        transform: translateY(-2px);                                           id="type"

                </label>

                <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);                                           name="type"

                    <option value="">Pilih Kendaraan</option>

                    @foreach($vehicles as $vehicle)        color: #212529;                                           value="{{ old('type', $maintenance->type) }}"

                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $maintenance->vehicle_id) == $vehicle->id ? 'selected' : '' }}>

                            {{ $vehicle->name }} - {{ $vehicle->license_plate }}    }                                           placeholder="Example: Oil Change, Regular Service"

                        </option>

                    @endforeach                                               required>

                </select>

                @error('vehicle_id')    .btn-secondary {                                    @error('type')

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror        background: #6c757d;                                        <div class="invalid-feedback">{{ $message }}</div>

            </div>

        border: none;                                    @enderror

            <div class="row">

                <!-- Tanggal Service -->        padding: 12px 24px;                                </div>

                <div class="col-md-6">

                    <div class="form-group">        border-radius: 8px;

                        <label class="form-label">

                            <i class="fas fa-calendar me-2"></i>Tanggal Service <span class="required">*</span>        font-weight: 600;                                <div class="mb-3">

                        </label>

                        <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror"         font-size: 14px;                                    <label for="category" class="form-label">

                               value="{{ old('maintenance_date', $maintenance->maintenance_date->format('Y-m-d')) }}" required>

                        @error('maintenance_date')        transition: all 0.3s ease;                                        <i class="fas fa-tags me-1"></i>Kategori <span class="text-danger">*</span>

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror        color: white;                                    </label>

                    </div>

                </div>        text-decoration: none;                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>



                <!-- Odometer -->    }                                        <option value="">Select Kategori</option>

                <div class="col-md-6">

                    <div class="form-group">                                            <option value="Routine" {{ $maintenance->category == 'Routine' ? 'selected' : '' }}>Rutin</option>

                        <label class="form-label">

                            <i class="fas fa-tachometer-alt me-2"></i>Odometer <span class="required">*</span>    .btn-secondary:hover {                                        <option value="Repair" {{ $maintenance->category == 'Repair' ? 'selected' : '' }}>Perbaikan</option>

                        </label>

                        <div class="input-group">        background: #5a6268;                                        <option value="Emergency" {{ $maintenance->category == 'Emergency' ? 'selected' : '' }}>Darurat</option>

                            <input type="number" name="odometer" class="form-control @error('odometer') is-invalid @enderror"

                                   placeholder="0" value="{{ old('odometer', $maintenance->odometer) }}" required min="0">        color: white;                                    </select>

                            <span class="input-group-text">KM</span>

                        </div>        text-decoration: none;                                    @error('category')

                        @error('odometer')

                            <div class="invalid-feedback">{{ $message }}</div>    }                                        <div class="invalid-feedback">{{ $message }}</div>

                        @enderror

                    </div>                                        @enderror

                </div>

            </div>    .form-actions {                                </div>



            <div class="row">        display: flex;

                <!-- Jenis Service -->

                <div class="col-md-6">        gap: 12px;                                <div class="mb-3">

                    <div class="form-group">

                        <label class="form-label">        justify-content: flex-end;                                    <label for="Status" class="form-label">

                            <i class="fas fa-wrench me-2"></i>Jenis Service <span class="required">*</span>

                        </label>        margin-top: 32px;                                        <i class="fas fa-flag me-1"></i>Status <span class="text-danger">*</span>

                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>

                            <option value="">Pilih Jenis Service</option>        padding-top: 24px;                                    </label>

                            <option value="Service Rutin" {{ old('type', $maintenance->type) == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>

                            <option value="Ganti Oli" {{ old('type', $maintenance->type) == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>        border-top: 1px solid #e9ecef;                                    <select class="form-select @error('Status') is-invalid @enderror" id="Status" name="Status" required>

                            <option value="Tune Up" {{ old('type', $maintenance->type) == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>

                            <option value="Perbaikan" {{ old('type', $maintenance->type) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>    }                                        <option value="">Select Status</option>

                            <option value="Lainnya" {{ old('type', $maintenance->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>

                        </select>                                            <option value="Completed" {{ $maintenance->Status == 'Completed' ? 'selected' : '' }}>End</option>

                        @error('type')

                            <div class="invalid-feedback">{{ $message }}</div>    .required {                                        <option value="Scheduled" {{ $maintenance->Status == 'Scheduled' ? 'selected' : '' }}>Terjadwal</option>

                        @enderror

                    </div>        color: #dc3545;                                        <option value="Overdue" {{ $maintenance->Status == 'Overdue' ? 'selected' : '' }}>Overdue</option>

                </div>

    }                                    </select>

                <!-- Kategori -->

                <div class="col-md-6">                                        @error('Status')

                    <div class="form-group">

                        <label class="form-label">    .input-group-text {                                        <div class="invalid-feedback">{{ $message }}</div>

                            <i class="fas fa-tags me-2"></i>Kategori

                        </label>        background: white;                                    @enderror

                        <select name="category" class="form-select @error('category') is-invalid @enderror">

                            <option value="Service" {{ old('category', $maintenance->category ?? 'Service') == 'Service' ? 'selected' : '' }}>Service</option>        border: 2px solid #e9ecef;                                </div>

                            <option value="Repair" {{ old('category', $maintenance->category) == 'Repair' ? 'selected' : '' }}>Repair</option>

                            <option value="Routine" {{ old('category', $maintenance->category) == 'Routine' ? 'selected' : '' }}>Routine</option>        border-left: none;                            </div>

                            <option value="Emergency" {{ old('category', $maintenance->category) == 'Emergency' ? 'selected' : '' }}>Emergency</option>

                        </select>        color: #6c757d;                        </div>

                        @error('category')

                            <div class="invalid-feedback">{{ $message }}</div>    }

                        @enderror

                    </div>                            <!-- Deskripsi -->

                </div>

            </div>    .input-group .form-control {                        <div class="row">



            <!-- Tempat Service -->        border-right: none;                            <div class="col-12">

            <div class="form-group">

                <label class="form-label">    }                                <div class="mb-3">

                    <i class="fas fa-map-marker-alt me-2"></i>Tempat Service

                </label>                                        <label for="description" class="form-label">

                <input type="text" name="workshop" class="form-control @error('workshop') is-invalid @enderror"

                       placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop', $maintenance->workshop ?? $maintenance->place) }}">    .input-group .form-control:focus + .input-group-text {                                        <i class="fas fa-file-alt me-1"></i>Deskripsi <span class="text-danger">*</span>

                @error('workshop')

                    <div class="invalid-feedback">{{ $message }}</div>        border-color: #ffc107;                                    </label>

                @enderror

            </div>    }                                    <textarea class="form-control @error('description') is-invalid @enderror"



            <!-- Biaya --></style>                                              id="description"

            <div class="form-group">

                <label class="form-label">                                              name="description"

                    <i class="fas fa-money-bill me-2"></i>Biaya Service

                </label><div class="container-fluid">                                              rows="3"

                <div class="input-group">

                    <span class="input-group-text">Rp</span>    <!-- Page Header -->                                              placeholder="Jelaskan detail Maintenance yang dilakukan..."

                    <input type="number" name="cost" class="form-control @error('cost') is-invalid @enderror"

                           placeholder="0" value="{{ old('cost', $maintenance->cost ?? $maintenance->total_cost) }}" min="0">    <div class="page-header">                                              required>{{ old('description', $maintenance->description) }}</textarea>

                </div>

                @error('cost')        <h1 class="page-title">                                    @error('description')

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror            <i class="fas fa-edit"></i>                                        <div class="invalid-feedback">{{ $message }}</div>

            </div>

            Edit Service                                    @enderror

            <!-- Keterangan -->

            <div class="form-group">        </h1>                                </div>

                <label class="form-label">

                    <i class="fas fa-sticky-note me-2"></i>Keterangan        <p class="page-subtitle">Update data perawatan dan service kendaraan</p>                            </div>

                </label>

                <textarea name="description" class="form-control @error('description') is-invalid @enderror"     </div>                        </div>

                          rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('description', $maintenance->description) }}</textarea>

                @error('description')

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror    <!-- Form Container -->                        <div class="row">

            </div>

    <div class="form-container">                            <!-- Workshop dan Cost -->

            <!-- Service Berikutnya -->

            <div class="row">        @if($errors->any())                            <div class="col-md-6">

                <div class="col-md-6">

                    <div class="form-group">        <div class="alert alert-danger alert-dismissible fade show" role="alert">                                <div class="mb-3">

                        <label class="form-label">

                            <i class="fas fa-calendar-plus me-2"></i>Jadwal Service Berikutnya            <i class="fas fa-exclamation-triangle me-2"></i>                                    <label for="workshop" class="form-label">

                        </label>

                        <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror"             <strong>Terdapat kesalahan:</strong>                                        <i class="fas fa-store me-1"></i>Bengkel/Workshop

                               value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date ? $maintenance->next_maintenance_date->format('Y-m-d') : '') }}">

                        @error('next_maintenance_date')            <ul class="mb-0 mt-2">                                    </label>

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror                @foreach($errors->all() as $error)                                    <input type="text"

                    </div>

                </div>                    <li>{{ $error }}</li>                                           class="form-control @error('workshop') is-invalid @enderror"



                <div class="col-md-6">                @endforeach                                           id="workshop"

                    <div class="form-group">

                        <label class="form-label">            </ul>                                           name="workshop"

                            <i class="fas fa-tachometer-alt me-2"></i>Odometer Service Berikutnya

                        </label>            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>                                           value="{{ old('workshop', $maintenance->workshop) }}"

                        <div class="input-group">

                            <input type="number" name="next_maintenance_odometer" class="form-control @error('next_maintenance_odometer') is-invalid @enderror"         </div>                                           placeholder="Name bengkel">

                                   placeholder="0" value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}" min="0">

                            <span class="input-group-text">KM</span>        @endif                                    @error('workshop')

                        </div>

                        @error('next_maintenance_odometer')                                        <div class="invalid-feedback">{{ $message }}</div>

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror        <form action="{{ route('maintenances.update', $maintenance) }}" method="POST" id="maintenanceForm">                                    @enderror

                    </div>

                </div>            @csrf                                </div>

            </div>

            @method('PUT')

            <!-- Form Actions -->

            <div class="form-actions">                                <div class="mb-3">

                <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary">

                    <i class="fas fa-times me-2"></i>Batal            <!-- Vehicle Selection -->                                    <label for="cost" class="form-label">

                </a>

                <button type="submit" class="btn btn-warning">            <div class="form-group">                                        <i class="fas fa-money-bill me-1"></i>Cost (Rp) <span class="text-danger">*</span>

                    <i class="fas fa-save me-2"></i>Update Service

                </button>                <label class="form-label">                                    </label>

            </div>

        </form>                    <i class="fas fa-car me-2"></i>Kendaraan <span class="required">*</span>                                    <input type="number"

    </div>

</div>                </label>                                           class="form-control @error('cost') is-invalid @enderror"

@endsection
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
