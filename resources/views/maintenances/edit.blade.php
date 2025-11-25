@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')



@section('title', 'Edit Service')



@section('content')@section('title', 'Edit Service')

<div class="container-fluid py-4">

    <div class="row">

        <div class="col-12">

            <div class="card mb-4">@section('content')@section('title', 'Edit Service')

                <div class="card-body">

                    <h2 class="h4 mb-1 fw-bold"><div class="container-fluid py-4">

                        <i class="fas fa-edit text-warning me-2"></i>

                        Edit Service    <div class="row">

                    </h2>

                    <p class="text-muted mb-0">Perbarui informasi service kendaraan</p>        <div class="col-12">

                </div>

            </div>            <div class="card mb-4">@section('content')@section('title', 'Edit Service')



            <div class="card">                <div class="card-body">

                <div class="card-body">

                    @if($errors->any())                    <h2 class="h4 mb-1 fw-bold"><div class="container-fluid py-4">

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>                        <i class="fas fa-edit text-warning me-2"></i>

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)                        Edit Service    <div class="row">

                                <li>{{ $error }}</li>

                            @endforeach                    </h2>

                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>                    <p class="text-muted mb-0">Perbarui informasi service kendaraan</p>        <div class="col-12">

                    </div>

                    @endif                </div>



                    <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">            </div>            <!-- Page Header -->@section('content')@section('title', 'Edit Service')@section('title', 'Edit Maintenance')

                        @csrf

                        @method('PUT')



                        <div class="mb-3">            <div class="card">            <div class="card mb-4">

                            <label class="form-label fw-semibold">

                                <i class="fas fa-car me-2 text-primary"></i>Kendaraan                <div class="card-body">

                                <span class="text-danger">*</span>

                            </label>                    @if($errors->any())                <div class="card-body"><style>

                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>

                                <option value="">Pilih Kendaraan</option>                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                @foreach($vehicles as $vehicle)

                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $maintenance->vehicle_id) == $vehicle->id ? 'selected' : '' }}>                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>                    <h2 class="h4 mb-1 fw-bold">

                                        {{ $vehicle->name }} - {{ $vehicle->license_plate }}

                                    </option>                        <ul class="mb-0">

                                @endforeach

                            </select>                            @foreach($errors->all() as $error)                        <i class="fas fa-edit text-warning me-2"></i>    .page-header {

                            @error('vehicle_id')

                                <div class="invalid-feedback">{{ $message }}</div>                                <li>{{ $error }}</li>

                            @enderror

                        </div>                            @endforeach                        Edit Service



                        <div class="row">                        </ul>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>                    </h2>        background: white;

                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Service

                                    <span class="text-danger">*</span>                    </div>

                                </label>

                                <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror" value="{{ old('maintenance_date', $maintenance->maintenance_date ? $maintenance->maintenance_date->format('Y-m-d') : '') }}" required>                    @endif                    <p class="text-muted mb-0">Perbarui informasi service kendaraan</p>

                                @error('maintenance_date')

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror

                            </div>                    <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">                </div>        padding: 30px;@section('content')@section('content')



                            <div class="col-md-6 mb-3">                        @csrf

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer                        @method('PUT')            </div>

                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <input type="number" name="odometer" class="form-control @error('odometer') is-invalid @enderror" placeholder="0" value="{{ old('odometer', $maintenance->odometer) }}" required min="0">                        <div class="mb-3">        border-radius: 12px;

                                    <span class="input-group-text">KM</span>

                                </div>                            <label class="form-label fw-semibold">

                                @error('odometer')

                                    <div class="invalid-feedback">{{ $message }}</div>                                <i class="fas fa-car me-2 text-primary"></i>Kendaraan            <!-- Form Card -->

                                @enderror

                            </div>                                <span class="text-danger">*</span>

                        </div>

                            </label>            <div class="card">        box-shadow: 0 1px 3px rgba(0,0,0,0.1);<style><div class="container-fluid py-4">

                        <div class="row">

                            <div class="col-md-6 mb-3">                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-wrench me-2 text-primary"></i>Jenis Service                                <option value="">Pilih Kendaraan</option>                <div class="card-body">

                                    <span class="text-danger">*</span>

                                </label>                                @foreach($vehicles as $vehicle)

                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>

                                    <option value="">Pilih Jenis Service</option>                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $maintenance->vehicle_id) == $vehicle->id ? 'selected' : '' }}>                    @if($errors->any())        margin-bottom: 24px;

                                    <option value="Service Rutin" {{ old('type', $maintenance->type) == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>

                                    <option value="Ganti Oli" {{ old('type', $maintenance->type) == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>                                        {{ $vehicle->name }} - {{ $vehicle->license_plate }}

                                    <option value="Tune Up" {{ old('type', $maintenance->type) == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>

                                    <option value="Perbaikan" {{ old('type', $maintenance->type) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>                                    </option>                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                    <option value="Lainnya" {{ old('type', $maintenance->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>

                                </select>                                @endforeach

                                @error('type')

                                    <div class="invalid-feedback">{{ $message }}</div>                            </select>                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>    }    .page-header {    <div class="row justify-content-center">

                                @enderror

                            </div>                            @error('vehicle_id')



                            <div class="col-md-6 mb-3">                                <div class="invalid-feedback">{{ $message }}</div>                        <ul class="mb-0">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-tags me-2 text-primary"></i>Kategori                            @enderror

                                </label>

                                <select name="category" class="form-select @error('category') is-invalid @enderror">                        </div>                            @foreach($errors->all() as $error)

                                    <option value="Service" {{ old('category', $maintenance->category) == 'Service' ? 'selected' : '' }}>Service</option>

                                    <option value="Repair" {{ old('category', $maintenance->category) == 'Repair' ? 'selected' : '' }}>Repair</option>

                                    <option value="Routine" {{ old('category', $maintenance->category) == 'Routine' ? 'selected' : '' }}>Routine</option>

                                    <option value="Emergency" {{ old('category', $maintenance->category) == 'Emergency' ? 'selected' : '' }}>Emergency</option>                        <div class="row">                                <li>{{ $error }}</li>

                                </select>

                                @error('category')                            <div class="col-md-6 mb-3">

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                                <label class="form-label fw-semibold">                            @endforeach    .page-title {        background: white;        <div class="col-lg-10">

                            </div>

                        </div>                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Service



                        <div class="mb-3">                                    <span class="text-danger">*</span>                        </ul>

                            <label class="form-label fw-semibold">

                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat Service                                </label>

                            </label>

                            <input type="text" name="workshop" class="form-control @error('workshop') is-invalid @enderror" placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop', $maintenance->workshop) }}">                                <input type="date" name="maintenance_date"                         <button type="button" class="btn-close" data-bs-dismiss="alert"></button>        font-size: 28px;

                            @error('workshop')

                                <div class="invalid-feedback">{{ $message }}</div>                                       class="form-control @error('maintenance_date') is-invalid @enderror"

                            @enderror

                        </div>                                       value="{{ old('maintenance_date', $maintenance->maintenance_date ? $maintenance->maintenance_date->format('Y-m-d') : '') }}" required>                    </div>



                        <div class="mb-3">                                @error('maintenance_date')

                            <label class="form-label fw-semibold">

                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran                                    <div class="invalid-feedback">{{ $message }}</div>                    @endif        font-weight: 700;        padding: 30px;            <div class="card">

                                <span class="text-danger">*</span>

                            </label>                                @enderror

                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>

                                <option value="">Pilih Metode Pembayaran</option>                            </div>

                                @if(isset($paymentMethods))

                                    @foreach($paymentMethods as $method)

                                        <option value="{{ $method->name }}" {{ old('payment_method', $maintenance->payment_method) == $method->name ? 'selected' : '' }}>{{ $method->name }}</option>

                                    @endforeach                            <div class="col-md-6 mb-3">                    <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST" id="maintenanceForm">        color: #1a1a1a;

                                @else

                                    <option value="Cash" {{ old('payment_method', $maintenance->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>                                <label class="form-label fw-semibold">

                                    <option value="Transfer Bank" {{ old('payment_method', $maintenance->payment_method) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>

                                    <option value="Kartu Kredit" {{ old('payment_method', $maintenance->payment_method) == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer                        @csrf

                                @endif

                            </select>                                    <span class="text-danger">*</span>

                            @error('payment_method')

                                <div class="invalid-feedback">{{ $message }}</div>                                </label>                        @method('PUT')        margin: 0 0 8px 0;        border-radius: 12px;                <div class="card-header d-flex justify-content-between align-items-center">

                            @enderror

                        </div>                                <div class="input-group">



                        <div class="mb-3">                                    <input type="number" name="odometer"

                            <label class="form-label fw-semibold">

                                <i class="fas fa-money-bill me-2 text-primary"></i>Biaya Service                                           class="form-control @error('odometer') is-invalid @enderror"

                            </label>

                            <div class="input-group">                                           placeholder="0" value="{{ old('odometer', $maintenance->odometer) }}" required min="0">                        <!-- Vehicle Selection -->        display: flex;

                                <span class="input-group-text">Rp</span>

                                <input type="number" name="cost" class="form-control @error('cost') is-invalid @enderror" placeholder="0" value="{{ old('cost', $maintenance->cost) }}" min="0">                                    <span class="input-group-text">KM</span>

                            </div>

                            @error('cost')                                </div>                        <div class="mb-3">

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                @error('odometer')

                        </div>

                                    <div class="invalid-feedback">{{ $message }}</div>                            <label class="form-label fw-semibold">        align-items: center;        box-shadow: 0 1px 3px rgba(0,0,0,0.1);                    <h5 class="mb-0">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                @enderror

                                <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan

                            </label>                            </div>                                <i class="fas fa-car me-2 text-primary"></i>Kendaraan

                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes', $maintenance->notes) }}</textarea>

                            @error('notes')                        </div>

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                <span class="text-danger">*</span>        gap: 12px;

                        </div>

                        <div class="row">

                        <div class="row">

                            <div class="col-md-6 mb-3">                            <div class="col-md-6 mb-3">                            </label>

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>Jadwal Service Berikutnya                                <label class="form-label fw-semibold">

                                </label>

                                <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror" value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date ? $maintenance->next_maintenance_date->format('Y-m-d') : '') }}">                                    <i class="fas fa-wrench me-2 text-primary"></i>Jenis Service                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>    }        margin-bottom: 24px;                        <i class="fas fa-edit text-warning me-2"></i>

                                @error('next_maintenance_date')

                                    <div class="invalid-feedback">{{ $message }}</div>                                    <span class="text-danger">*</span>

                                @enderror

                            </div>                                </label>                                <option value="">Pilih Kendaraan</option>



                            <div class="col-md-6 mb-3">                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer Service Berikutnya                                    <option value="">Pilih Jenis Service</option>                                @foreach($vehicles as $vehicle)

                                </label>

                                <div class="input-group">                                    <option value="Service Rutin" {{ old('type', $maintenance->type) == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>

                                    <input type="number" name="next_maintenance_odometer" class="form-control @error('next_maintenance_odometer') is-invalid @enderror" placeholder="0" value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}" min="0">

                                    <span class="input-group-text">KM</span>                                    <option value="Ganti Oli" {{ old('type', $maintenance->type) == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $maintenance->vehicle_id) == $vehicle->id ? 'selected' : '' }}>

                                </div>

                                @error('next_maintenance_odometer')                                    <option value="Tune Up" {{ old('type', $maintenance->type) == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                                    <option value="Perbaikan" {{ old('type', $maintenance->type) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>                                        {{ $vehicle->name }} - {{ $vehicle->license_plate }}    .page-title i {    }                        Edit Maintenance

                            </div>

                        </div>                                    <option value="Lainnya" {{ old('type', $maintenance->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>



                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">                                </select>                                    </option>

                            <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-secondary">

                                <i class="fas fa-times me-2"></i>Batal                                @error('type')

                            </a>

                            <button type="submit" class="btn btn-warning">                                    <div class="invalid-feedback">{{ $message }}</div>                                @endforeach        color: #ffc107;

                                <i class="fas fa-save me-2"></i>Update Service

                            </button>                                @enderror

                        </div>

                    </form>                            </div>                            </select>

                </div>

            </div>

        </div>

    </div>                            <div class="col-md-6 mb-3">                            @error('vehicle_id')        font-size: 24px;                        </h5>

</div>

@endsection                                <label class="form-label fw-semibold">


                                    <i class="fas fa-tags me-2 text-primary"></i>Kategori                                <div class="invalid-feedback">{{ $message }}</div>

                                </label>

                                <select name="category" class="form-select @error('category') is-invalid @enderror">                            @enderror    }

                                    <option value="Service" {{ old('category', $maintenance->category) == 'Service' ? 'selected' : '' }}>Service</option>

                                    <option value="Repair" {{ old('category', $maintenance->category) == 'Repair' ? 'selected' : '' }}>Repair</option>                        </div>

                                    <option value="Routine" {{ old('category', $maintenance->category) == 'Routine' ? 'selected' : '' }}>Routine</option>

                                    <option value="Emergency" {{ old('category', $maintenance->category) == 'Emergency' ? 'selected' : '' }}>Emergency</option>        .page-title {                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary btn-sm">

                                </select>

                                @error('category')                        <div class="row">

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                            <!-- Service Date -->    .page-subtitle {

                            </div>

                        </div>                            <div class="col-md-6 mb-3">



                        <div class="mb-3">                                <label class="form-label fw-semibold">        font-size: 14px;        font-size: 28px;                        <i class="fas fa-arrow-left me-1"></i>Back

                            <label class="form-label fw-semibold">

                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat Service                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Service

                            </label>

                            <input type="text" name="workshop"                                     <span class="text-danger">*</span>        color: #6c757d;

                                   class="form-control @error('workshop') is-invalid @enderror"

                                   placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop', $maintenance->workshop) }}">                                </label>

                            @error('workshop')

                                <div class="invalid-feedback">{{ $message }}</div>                                <input type="date" name="maintenance_date"         margin: 0;        font-weight: 700;                    </a>

                            @enderror

                        </div>                                       class="form-control @error('maintenance_date') is-invalid @enderror"



                        <div class="mb-3">                                       value="{{ old('maintenance_date', $maintenance->maintenance_date ? $maintenance->maintenance_date->format('Y-m-d') : '') }}" required>    }

                            <label class="form-label fw-semibold">

                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran                                @error('maintenance_date')

                                <span class="text-danger">*</span>

                            </label>                                    <div class="invalid-feedback">{{ $message }}</div>            color: #1a1a1a;                </div>

                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>

                                <option value="">Pilih Metode Pembayaran</option>                                @enderror

                                @if(isset($paymentMethods))

                                    @foreach($paymentMethods as $method)                            </div>    .form-container {

                                        <option value="{{ $method->name }}" {{ old('payment_method', $maintenance->payment_method) == $method->name ? 'selected' : '' }}>

                                            {{ $method->name }}

                                        </option>

                                    @endforeach                            <!-- Odometer -->        background: white;        margin: 0 0 8px 0;                <div class="card-body">

                                @else

                                    <option value="Cash" {{ old('payment_method', $maintenance->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>                            <div class="col-md-6 mb-3">

                                    <option value="Transfer Bank" {{ old('payment_method', $maintenance->payment_method) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>

                                    <option value="Kartu Kredit" {{ old('payment_method', $maintenance->payment_method) == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>                                <label class="form-label fw-semibold">        padding: 32px;

                                @endif

                            </select>                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer

                            @error('payment_method')

                                <div class="invalid-feedback">{{ $message }}</div>                                    <span class="text-danger">*</span>        border-radius: 12px;        display: flex;                    <form action="{{ route('maintenances.update', $maintenance) }}" method="POST">

                            @enderror

                        </div>                                </label>



                        <div class="mb-3">                                <div class="input-group">        box-shadow: 0 1px 3px rgba(0,0,0,0.1);

                            <label class="form-label fw-semibold">

                                <i class="fas fa-money-bill me-2 text-primary"></i>Biaya Service                                    <input type="number" name="odometer"

                            </label>

                            <div class="input-group">                                           class="form-control @error('odometer') is-invalid @enderror"        max-width: 800px;        align-items: center;                        @csrf

                                <span class="input-group-text">Rp</span>

                                <input type="number" name="cost"                                            placeholder="0" value="{{ old('odometer', $maintenance->odometer) }}" required min="0">

                                       class="form-control @error('cost') is-invalid @enderror"

                                       placeholder="0" value="{{ old('cost', $maintenance->cost) }}" min="0">                                    <span class="input-group-text">KM</span>        margin: 0 auto;

                            </div>

                            @error('cost')                                </div>

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                @error('odometer')    }        gap: 12px;                        @method('PUT')

                        </div>

                                    <div class="invalid-feedback">{{ $message }}</div>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                @enderror

                                <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan

                            </label>                            </div>

                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"

                                      rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes', $maintenance->notes) }}</textarea>                        </div>    .form-group {    }

                            @error('notes')

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror

                        </div>                        <div class="row">        margin-bottom: 24px;



                        <div class="row">                            <!-- Service Type -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                            <div class="col-md-6 mb-3">    }                            <div class="row">

                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>Jadwal Service Berikutnya

                                </label>                                <label class="form-label fw-semibold">

                                <input type="date" name="next_maintenance_date"

                                       class="form-control @error('next_maintenance_date') is-invalid @enderror"                                    <i class="fas fa-wrench me-2 text-primary"></i>Jenis Service

                                       value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date ? $maintenance->next_maintenance_date->format('Y-m-d') : '') }}">

                                @error('next_maintenance_date')                                    <span class="text-danger">*</span>

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                                </label>    .form-label {    .page-title i {                            <!-- Vehicle dan Date -->

                            </div>

                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                                    <option value="">Pilih Jenis Service</option>        font-weight: 600;

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer Service Berikutnya

                                </label>                                    <option value="Service Rutin" {{ old('type', $maintenance->type) == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>

                                <div class="input-group">

                                    <input type="number" name="next_maintenance_odometer"                                     <option value="Ganti Oli" {{ old('type', $maintenance->type) == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>        color: #2c3e50;        color: #ffc107;                            <div class="col-md-6">

                                           class="form-control @error('next_maintenance_odometer') is-invalid @enderror"

                                           placeholder="0" value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}" min="0">                                    <option value="Tune Up" {{ old('type', $maintenance->type) == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>

                                    <span class="input-group-text">KM</span>

                                </div>                                    <option value="Perbaikan" {{ old('type', $maintenance->type) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>        margin-bottom: 8px;

                                @error('next_maintenance_odometer')

                                    <div class="invalid-feedback">{{ $message }}</div>                                    <option value="Lainnya" {{ old('type', $maintenance->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>

                                @enderror

                            </div>                                </select>        font-size: 14px;        font-size: 24px;                                <div class="mb-3">

                        </div>

                                @error('type')

                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">

                            <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-secondary">                                    <div class="invalid-feedback">{{ $message }}</div>        display: block;

                                <i class="fas fa-times me-2"></i>Batal

                            </a>                                @enderror

                            <button type="submit" class="btn btn-warning">

                                <i class="fas fa-save me-2"></i>Update Service                            </div>    }    }                                    <label for="vehicle_id" class="form-label">

                            </button>

                        </div>

                    </form>

                </div>                            <!-- Category -->

            </div>

        </div>                            <div class="col-md-6 mb-3">

    </div>

</div>                                <label class="form-label fw-semibold">    .form-control, .form-select {                                            <i class="fas fa-car me-1"></i>Vehicle <span class="text-danger">*</span>

@endsection

                                    <i class="fas fa-tags me-2 text-primary"></i>Kategori

                                </label>        border: 2px solid #e9ecef;

                                <select name="category" class="form-select @error('category') is-invalid @enderror">

                                    <option value="Service" {{ old('category', $maintenance->category) == 'Service' ? 'selected' : '' }}>Service</option>        border-radius: 8px;    .page-subtitle {                                    </label>

                                    <option value="Repair" {{ old('category', $maintenance->category) == 'Repair' ? 'selected' : '' }}>Repair</option>

                                    <option value="Routine" {{ old('category', $maintenance->category) == 'Routine' ? 'selected' : '' }}>Routine</option>        padding: 12px 16px;

                                    <option value="Emergency" {{ old('category', $maintenance->category) == 'Emergency' ? 'selected' : '' }}>Emergency</option>

                                </select>        font-size: 14px;        font-size: 14px;                                    <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>

                                @error('category')

                                    <div class="invalid-feedback">{{ $message }}</div>        transition: all 0.3s ease;

                                @enderror

                            </div>        width: 100%;        color: #6c757d;                                        <option value="">Select Vehicle</option>

                        </div>

    }

                        <!-- Workshop -->

                        <div class="mb-3">            margin: 0;                                        @foreach($vehicles as $vehicle)

                            <label class="form-label fw-semibold">

                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat Service    .form-control:focus, .form-select:focus {

                            </label>

                            <input type="text" name="workshop"         border-color: #ffc107;    }                                            <option value="{{ $vehicle->id }}" {{ $maintenance->vehicle_id == $vehicle->id ? 'selected' : '' }}>

                                   class="form-control @error('workshop') is-invalid @enderror"

                                   placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop', $maintenance->workshop) }}">        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);

                            @error('workshop')

                                <div class="invalid-feedback">{{ $message }}</div>        outline: none;                                                    {{ $vehicle->name }} ({{ $vehicle->license_plate }})

                            @enderror

                        </div>    }



                        <!-- Payment Method -->        .form-container {                                            </option>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">    .btn-warning {

                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran

                                <span class="text-danger">*</span>        background: #ffc107;        background: white;                                        @endforeach

                            </label>

                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>        border: none;

                                <option value="">Pilih Metode Pembayaran</option>

                                @if(isset($paymentMethods))        padding: 12px 24px;        padding: 32px;                                    </select>

                                    @foreach($paymentMethods as $method)

                                        <option value="{{ $method->name }}" {{ old('payment_method', $maintenance->payment_method) == $method->name ? 'selected' : '' }}>        border-radius: 8px;

                                            {{ $method->name }}

                                        </option>        font-weight: 600;        border-radius: 12px;                                    @error('vehicle_id')

                                    @endforeach

                                @else        font-size: 14px;

                                    <option value="Cash" {{ old('payment_method', $maintenance->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>

                                    <option value="Transfer Bank" {{ old('payment_method', $maintenance->payment_method) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>        transition: all 0.3s ease;        box-shadow: 0 1px 3px rgba(0,0,0,0.1);                                        <div class="invalid-feedback">{{ $message }}</div>

                                    <option value="Kartu Kredit" {{ old('payment_method', $maintenance->payment_method) == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>

                                @endif        color: #212529;

                            </select>

                            @error('payment_method')    }        max-width: 800px;                                    @enderror

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror

                        </div>

    .btn-warning:hover {        margin: 0 auto;                                </div>

                        <!-- Cost -->

                        <div class="mb-3">        background: #ffb30f;

                            <label class="form-label fw-semibold">

                                <i class="fas fa-money-bill me-2 text-primary"></i>Biaya Service        transform: translateY(-2px);    }

                            </label>

                            <div class="input-group">        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);

                                <span class="input-group-text">Rp</span>

                                <input type="number" name="cost"         color: #212529;                                    <div class="mb-3">

                                       class="form-control @error('cost') is-invalid @enderror"

                                       placeholder="0" value="{{ old('cost', $maintenance->cost) }}" min="0">    }

                            </div>

                            @error('cost')        .form-group {                                    <label for="maintenance_date" class="form-label">

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror    .btn-secondary {

                        </div>

        background: #6c757d;        margin-bottom: 24px;                                        <i class="fas fa-calendar me-1"></i>Date Maintenance <span class="text-danger">*</span>

                        <!-- Notes -->

                        <div class="mb-3">        border: none;

                            <label class="form-label fw-semibold">

                                <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan        padding: 12px 24px;    }                                    </label>

                            </label>

                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"        border-radius: 8px;

                                      rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes', $maintenance->notes) }}</textarea>

                            @error('notes')        font-weight: 600;                                        <input type="date"

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror        font-size: 14px;

                        </div>

        transition: all 0.3s ease;    .form-label {                                           class="form-control @error('maintenance_date') is-invalid @enderror"

                        <!-- Next Maintenance -->

                        <div class="row">        color: white;

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">        text-decoration: none;        font-weight: 600;                                           id="maintenance_date"

                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>Jadwal Service Berikutnya

                                </label>    }

                                <input type="date" name="next_maintenance_date"

                                       class="form-control @error('next_maintenance_date') is-invalid @enderror"            color: #2c3e50;                                           name="maintenance_date"

                                       value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date ? $maintenance->next_maintenance_date->format('Y-m-d') : '') }}">

                                @error('next_maintenance_date')    .btn-secondary:hover {

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror        background: #5a6268;        margin-bottom: 8px;                                           value="{{ old('maintenance_date', $maintenance->maintenance_date) }}"

                            </div>

        color: white;

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">        text-decoration: none;        font-size: 14px;                                           required>

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer Service Berikutnya

                                </label>    }

                                <div class="input-group">

                                    <input type="number" name="next_maintenance_odometer"             display: block;                                    @error('maintenance_date')

                                           class="form-control @error('next_maintenance_odometer') is-invalid @enderror"

                                           placeholder="0" value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}" min="0">    .form-actions {

                                    <span class="input-group-text">KM</span>

                                </div>        display: flex;    }                                        <div class="invalid-feedback">{{ $message }}</div>

                                @error('next_maintenance_odometer')

                                    <div class="invalid-feedback">{{ $message }}</div>        gap: 12px;

                                @enderror

                            </div>        justify-content: flex-end;                                        @enderror

                        </div>

        margin-top: 32px;

                        <!-- Action Buttons -->

                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">        padding-top: 24px;    .form-control, .form-select {                                </div>

                            <a href="{{ route('maintenances.show', $maintenance->id) }}" class="btn btn-secondary">

                                <i class="fas fa-times me-2"></i>Batal        border-top: 1px solid #e9ecef;

                            </a>

                            <button type="submit" class="btn btn-warning">    }        border: 2px solid #e9ecef;

                                <i class="fas fa-save me-2"></i>Update Service

                            </button>

                        </div>

                    </form>    .required {        border-radius: 8px;                                <div class="mb-3">

                </div>

            </div>        color: #dc3545;

        </div>

    </div>    }        padding: 12px 16px;                                    <label for="odometer" class="form-label">

</div>



@push('scripts')

<script>    .input-group-text {        font-size: 14px;                                        <i class="fas fa-tachometer-alt me-1"></i>Odometer (km) <span class="text-danger">*</span>

document.addEventListener('DOMContentLoaded', function() {

    // Focus on vehicle select        background: white;

    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');

    if (vehicleSelect) {        border: 2px solid #e9ecef;        transition: all 0.3s ease;                                    </label>

        vehicleSelect.focus();

    }        border-left: none;



    // Form validation        color: #6c757d;        width: 100%;                                    <input type="number"

    const form = document.getElementById('maintenanceForm');

    form.addEventListener('submit', function(e) {    }

        const vehicleId = document.querySelector('select[name="vehicle_id"]').value;

        const maintenanceDate = document.querySelector('input[name="maintenance_date"]').value;        }                                           class="form-control @error('odometer') is-invalid @enderror"

        const odometer = document.querySelector('input[name="odometer"]').value;

        const type = document.querySelector('select[name="type"]').value;    .input-group .form-control {

        const paymentMethod = document.querySelector('select[name="payment_method"]').value;

        border-right: none;                                               id="odometer"

        if (!vehicleId) {

            e.preventDefault();    }

            alert('Silakan pilih kendaraan terlebih dahulu!');

            return false;        .form-control:focus, .form-select:focus {                                           name="odometer"

        }

    .input-group .form-control:focus + .input-group-text {

        if (!maintenanceDate) {

            e.preventDefault();        border-color: #ffc107;        border-color: #ffc107;                                           value="{{ old('odometer', $maintenance->odometer) }}"

            alert('Silakan isi tanggal service!');

            return false;    }

        }

</style>        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);                                           min="0"

        if (!odometer) {

            e.preventDefault();

            alert('Silakan isi odometer!');

            return false;<div class="container-fluid">        outline: none;                                           step="0.01"

        }

    <!-- Page Header -->

        if (!type) {

            e.preventDefault();    <div class="page-header">    }                                           required>

            alert('Silakan pilih jenis service!');

            return false;        <h1 class="page-title">

        }

            <i class="fas fa-edit"></i>                                        @error('odometer')

        if (!paymentMethod) {

            e.preventDefault();            Edit Service

            alert('Silakan pilih metode pembayaran!');

            return false;        </h1>    .btn-warning {                                        <div class="invalid-feedback">{{ $message }}</div>

        }

    });        <p class="page-subtitle">Update data perawatan dan service kendaraan</p>

});

</script>    </div>        background: #ffc107;                                    @enderror

@endpush

@endsection


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
