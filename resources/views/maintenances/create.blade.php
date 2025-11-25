@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')@extends('layouts.drivvo')



@section('title', 'Tambah Service Baru')



@section('content')@section('title', 'Tambah Service Baru')

<div class="container-fluid py-4">

    <div class="row">

        <div class="col-12">

            <div class="card mb-4">@section('content')@section('title', 'Tambah Service Baru')

                <div class="card-body">

                    <h2 class="h4 mb-1 fw-bold"><div class="container-fluid py-4">

                        <i class="fas fa-plus-circle text-primary me-2"></i>

                        Tambah Service Baru    <div class="row">

                    </h2>

                    <p class="text-muted mb-0">Catat perawatan dan service kendaraan Anda</p>        <div class="col-12">

                </div>

            </div>            <div class="card mb-4">@section('content')@section('title', 'Tambah Service Baru')



            <div class="card">                <div class="card-body">

                <div class="card-body">

                    @if($errors->any())                    <h2 class="h4 mb-1 fw-bold"><div class="container-fluid py-4">

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>                        <i class="fas fa-plus-circle text-primary me-2"></i>

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)                        Tambah Service Baru    <div class="row">

                                <li>{{ $error }}</li>

                            @endforeach                    </h2>

                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>                    <p class="text-muted mb-0">Catat perawatan dan service kendaraan Anda</p>        <div class="col-12">

                    </div>

                    @endif                </div>



                    <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">            </div>            <!-- Page Header -->@section('content')@section('title', 'Tambah Service Baru')@section('title', 'Tambah Service Baru')

                        @csrf



                        <div class="mb-3">

                            <label class="form-label fw-semibold">            <div class="card">            <div class="card mb-4">

                                <i class="fas fa-car me-2 text-primary"></i>Kendaraan

                                <span class="text-danger">*</span>                <div class="card-body">

                            </label>

                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>                    @if($errors->any())                <div class="card-body"><style>

                                <option value="">Pilih Kendaraan</option>

                                @foreach($vehicles as $vehicle)                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>

                                        {{ $vehicle->name }} - {{ $vehicle->license_plate }}                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>                    <h2 class="h4 mb-1 fw-bold">

                                    </option>

                                @endforeach                        <ul class="mb-0">

                            </select>

                            @error('vehicle_id')                            @foreach($errors->all() as $error)                        <i class="fas fa-plus-circle text-primary me-2"></i>    .page-header {

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                <li>{{ $error }}</li>

                        </div>

                            @endforeach                        Tambah Service Baru

                        <div class="row">

                            <div class="col-md-6 mb-3">                        </ul>

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Service                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>                    </h2>        background: white;

                                    <span class="text-danger">*</span>

                                </label>                    </div>

                                <input type="date" name="service_date" class="form-control @error('service_date') is-invalid @enderror" value="{{ old('service_date', date('Y-m-d')) }}" required>

                                @error('service_date')                    @endif                    <p class="text-muted mb-0">Catat perawatan dan service kendaraan Anda</p>

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror

                            </div>

                    <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">                </div>        padding: 30px;@section('content')@section('content')

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                        @csrf

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer

                                    <span class="text-danger">*</span>            </div>

                                </label>

                                <div class="input-group">                        <div class="mb-3">

                                    <input type="number" name="odometer" class="form-control @error('odometer') is-invalid @enderror" placeholder="0" value="{{ old('odometer') }}" required min="0">

                                    <span class="input-group-text">KM</span>                            <label class="form-label fw-semibold">        border-radius: 12px;

                                </div>

                                @error('odometer')                                <i class="fas fa-car me-2 text-primary"></i>Kendaraan

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                                <span class="text-danger">*</span>            <!-- Form Card -->

                            </div>

                        </div>                            </label>



                        <div class="row">                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>            <div class="card">        box-shadow: 0 1px 3px rgba(0,0,0,0.1);<style><style>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                                <option value="">Pilih Kendaraan</option>

                                    <i class="fas fa-wrench me-2 text-primary"></i>Jenis Service

                                    <span class="text-danger">*</span>                                @foreach($vehicles as $vehicle)                <div class="card-body">

                                </label>

                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>

                                    <option value="">Pilih Jenis Service</option>

                                    <option value="Service Rutin" {{ old('type') == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>                                        {{ $vehicle->name }} - {{ $vehicle->license_plate }}                    @if($errors->any())        margin-bottom: 24px;

                                    <option value="Ganti Oli" {{ old('type') == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>

                                    <option value="Tune Up" {{ old('type') == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>                                    </option>

                                    <option value="Perbaikan" {{ old('type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>

                                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>                                @endforeach                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                </select>

                                @error('type')                            </select>

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                            @error('vehicle_id')                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>    }    .page-header {    .page-header {

                            </div>

                                <div class="invalid-feedback">{{ $message }}</div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                            @enderror                        <ul class="mb-0">

                                    <i class="fas fa-tags me-2 text-primary"></i>Kategori

                                </label>                        </div>

                                <select name="category" class="form-select @error('category') is-invalid @enderror">

                                    <option value="Service" {{ old('category', 'Service') == 'Service' ? 'selected' : '' }}>Service</option>                            @foreach($errors->all() as $error)

                                    <option value="Repair" {{ old('category') == 'Repair' ? 'selected' : '' }}>Repair</option>

                                    <option value="Routine" {{ old('category') == 'Routine' ? 'selected' : '' }}>Routine</option>                        <div class="row">

                                    <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>

                                </select>                            <div class="col-md-6 mb-3">                                <li>{{ $error }}</li>

                                @error('category')

                                    <div class="invalid-feedback">{{ $message }}</div>                                <label class="form-label fw-semibold">

                                @enderror

                            </div>                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Service                            @endforeach    .page-title {        background: white;        background: white;

                        </div>

                                    <span class="text-danger">*</span>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                </label>                        </ul>

                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat Service

                            </label>                                <input type="date" name="service_date"

                            <input type="text" name="workshop" class="form-control @error('workshop') is-invalid @enderror" placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop') }}">

                            @error('workshop')                                       class="form-control @error('service_date') is-invalid @enderror"                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>        font-size: 28px;

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                       value="{{ old('service_date', date('Y-m-d')) }}" required>

                        </div>

                                @error('service_date')                    </div>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                    <div class="invalid-feedback">{{ $message }}</div>

                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran

                                <span class="text-danger">*</span>                                @enderror                    @endif        font-weight: 700;        padding: 30px;        padding: 30px;

                            </label>

                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>                            </div>

                                <option value="">Pilih Metode Pembayaran</option>

                                @if(isset($paymentMethods))

                                    @foreach($paymentMethods as $method)

                                        <option value="{{ $method->name }}" {{ old('payment_method') == $method->name ? 'selected' : '' }}>{{ $method->name }}</option>                            <div class="col-md-6 mb-3">

                                    @endforeach

                                @else                                <label class="form-label fw-semibold">                    <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">        color: #1a1a1a;

                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>

                                    <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer

                                    <option value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>

                                @endif                                    <span class="text-danger">*</span>                        @csrf

                            </select>

                            @error('payment_method')                                </label>

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                <div class="input-group">        margin: 0 0 8px 0;        border-radius: 12px;        border-radius: 12px;

                        </div>

                                    <input type="number" name="odometer"

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                           class="form-control @error('odometer') is-invalid @enderror"                        <!-- Vehicle Selection -->

                                <i class="fas fa-money-bill me-2 text-primary"></i>Biaya Service

                            </label>                                           placeholder="0" value="{{ old('odometer') }}" required min="0">

                            <div class="input-group">

                                <span class="input-group-text">Rp</span>                                    <span class="input-group-text">KM</span>                        <div class="mb-3">        display: flex;

                                <input type="number" name="cost" class="form-control @error('cost') is-invalid @enderror" placeholder="0" value="{{ old('cost') }}" min="0">

                            </div>                                </div>

                            @error('cost')

                                <div class="invalid-feedback">{{ $message }}</div>                                @error('odometer')                            <label class="form-label fw-semibold">

                            @enderror

                        </div>                                    <div class="invalid-feedback">{{ $message }}</div>



                        <div class="mb-3">                                @enderror                                <i class="fas fa-car me-2 text-primary"></i>Kendaraan        align-items: center;        box-shadow: 0 1px 3px rgba(0,0,0,0.1);        box-shadow: 0 1px 3px rgba(0,0,0,0.1);

                            <label class="form-label fw-semibold">

                                <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan                            </div>

                            </label>

                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes') }}</textarea>                        </div>                                <span class="text-danger">*</span>

                            @error('notes')

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror

                        </div>                        <div class="row">                            </label>        gap: 12px;



                        <div class="row">                            <div class="col-md-6 mb-3">

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                                <label class="form-label fw-semibold">                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>

                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>Jadwal Service Berikutnya

                                </label>                                    <i class="fas fa-wrench me-2 text-primary"></i>Jenis Service

                                <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror" value="{{ old('next_maintenance_date') }}">

                                @error('next_maintenance_date')                                    <span class="text-danger">*</span>                                <option value="">Pilih Kendaraan</option>    }        margin-bottom: 24px;        margin-bottom: 24px;

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                                </label>

                            </div>

                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>                                @foreach($vehicles as $vehicle)

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">                                    <option value="">Pilih Jenis Service</option>

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer Service Berikutnya

                                </label>                                    <option value="Service Rutin" {{ old('type') == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>

                                <div class="input-group">

                                    <input type="number" name="next_maintenance_odometer" class="form-control @error('next_maintenance_odometer') is-invalid @enderror" placeholder="0" value="{{ old('next_maintenance_odometer') }}" min="0">                                    <option value="Ganti Oli" {{ old('type') == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>

                                    <span class="input-group-text">KM</span>

                                </div>                                    <option value="Tune Up" {{ old('type') == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>                                        {{ $vehicle->name }} - {{ $vehicle->license_plate }}

                                @error('next_maintenance_odometer')

                                    <div class="invalid-feedback">{{ $message }}</div>                                    <option value="Perbaikan" {{ old('type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>

                                @enderror

                            </div>                                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>                                    </option>    .page-title i {    }    }

                        </div>

                                </select>

                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">

                            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">                                @error('type')                                @endforeach

                                <i class="fas fa-times me-2"></i>Batal

                            </a>                                    <div class="invalid-feedback">{{ $message }}</div>

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-save me-2"></i>Simpan Service                                @enderror                            </select>        color: #fd7e14;

                            </button>

                        </div>                            </div>

                    </form>

                </div>                            @error('vehicle_id')

            </div>

        </div>                            <div class="col-md-6 mb-3">

    </div>

</div>                                <label class="form-label fw-semibold">                                <div class="invalid-feedback">{{ $message }}</div>        font-size: 24px;



@push('scripts')                                    <i class="fas fa-tags me-2 text-primary"></i>Kategori

<script>

document.addEventListener('DOMContentLoaded', function() {                                </label>                            @enderror

    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');

    if (vehicleSelect) {                                <select name="category" class="form-select @error('category') is-invalid @enderror">

        vehicleSelect.focus();

    }                                    <option value="Service" {{ old('category', 'Service') == 'Service' ? 'selected' : '' }}>Service</option>                        </div>    }

});

</script>                                    <option value="Repair" {{ old('category') == 'Repair' ? 'selected' : '' }}>Repair</option>

@endpush

@endsection                                    <option value="Routine" {{ old('category') == 'Routine' ? 'selected' : '' }}>Routine</option>


                                    <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>

                                </select>                        <div class="row">        .page-title {    .page-title {

                                @error('category')

                                    <div class="invalid-feedback">{{ $message }}</div>                            <!-- Service Date -->

                                @enderror

                            </div>                            <div class="col-md-6 mb-3">    .page-subtitle {

                        </div>

                                <label class="form-label fw-semibold">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                    <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Service        font-size: 14px;        font-size: 28px;        font-size: 28px;

                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat Service

                            </label>                                    <span class="text-danger">*</span>

                            <input type="text" name="workshop"

                                   class="form-control @error('workshop') is-invalid @enderror"                                </label>        color: #6c757d;

                                   placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop') }}">

                            @error('workshop')                                <input type="date" name="service_date"

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                       class="form-control @error('service_date') is-invalid @enderror"        margin: 0;        font-weight: 700;        font-weight: 700;

                        </div>

                                       value="{{ old('service_date', date('Y-m-d')) }}" required>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                @error('service_date')    }

                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran

                                <span class="text-danger">*</span>                                    <div class="invalid-feedback">{{ $message }}</div>

                            </label>

                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>                                @enderror            color: #1a1a1a;        color: #1a1a1a;

                                <option value="">Pilih Metode Pembayaran</option>

                                @if(isset($paymentMethods))                            </div>

                                    @foreach($paymentMethods as $method)

                                        <option value="{{ $method->name }}" {{ old('payment_method') == $method->name ? 'selected' : '' }}>    .form-container {

                                            {{ $method->name }}

                                        </option>                            <!-- Odometer -->

                                    @endforeach

                                @else                            <div class="col-md-6 mb-3">        background: white;        margin: 0 0 8px 0;        margin: 0 0 8px 0;

                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>

                                    <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>                                <label class="form-label fw-semibold">

                                    <option value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>

                                @endif                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer        padding: 32px;

                            </select>

                            @error('payment_method')                                    <span class="text-danger">*</span>

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                                </label>        border-radius: 12px;        display: flex;        display: flex;

                        </div>

                                <div class="input-group">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">                                    <input type="number" name="odometer"         box-shadow: 0 1px 3px rgba(0,0,0,0.1);

                                <i class="fas fa-money-bill me-2 text-primary"></i>Biaya Service

                            </label>                                           class="form-control @error('odometer') is-invalid @enderror"

                            <div class="input-group">

                                <span class="input-group-text">Rp</span>                                           placeholder="0" value="{{ old('odometer') }}" required min="0">        max-width: 800px;        align-items: center;        align-items: center;

                                <input type="number" name="cost"

                                       class="form-control @error('cost') is-invalid @enderror"                                    <span class="input-group-text">KM</span>

                                       placeholder="0" value="{{ old('cost') }}" min="0">

                            </div>                                </div>        margin: 0 auto;

                            @error('cost')

                                <div class="invalid-feedback">{{ $message }}</div>                                @error('odometer')

                            @enderror

                        </div>                                    <div class="invalid-feedback">{{ $message }}</div>    }        gap: 12px;        gap: 12px;



                        <div class="mb-3">                                @enderror

                            <label class="form-label fw-semibold">

                                <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan                            </div>

                            </label>

                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"                        </div>

                                      rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes') }}</textarea>

                            @error('notes')    .form-group {    }    }

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                        <div class="row">

                        </div>

                            <!-- Service Type -->        margin-bottom: 24px;

                        <div class="row">

                            <div class="col-md-6 mb-3">                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>Jadwal Service Berikutnya                                <label class="form-label fw-semibold">    }

                                </label>

                                <input type="date" name="next_maintenance_date"                                     <i class="fas fa-wrench me-2 text-primary"></i>Jenis Service

                                       class="form-control @error('next_maintenance_date') is-invalid @enderror"

                                       value="{{ old('next_maintenance_date') }}">                                    <span class="text-danger">*</span>

                                @error('next_maintenance_date')

                                    <div class="invalid-feedback">{{ $message }}</div>                                </label>

                                @enderror

                            </div>                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>    .form-label {    .page-title i {    .page-title i {



                            <div class="col-md-6 mb-3">                                    <option value="">Pilih Jenis Service</option>

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer Service Berikutnya                                    <option value="Service Rutin" {{ old('type') == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>        font-weight: 600;

                                </label>

                                <div class="input-group">                                    <option value="Ganti Oli" {{ old('type') == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>

                                    <input type="number" name="next_maintenance_odometer"

                                           class="form-control @error('next_maintenance_odometer') is-invalid @enderror"                                    <option value="Tune Up" {{ old('type') == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>        color: #2c3e50;        color: #fd7e14;        color: #fd7e14;

                                           placeholder="0" value="{{ old('next_maintenance_odometer') }}" min="0">

                                    <span class="input-group-text">KM</span>                                    <option value="Perbaikan" {{ old('type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>

                                </div>

                                @error('next_maintenance_odometer')                                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>        margin-bottom: 8px;

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror                                </select>

                            </div>

                        </div>                                @error('type')        font-size: 14px;        font-size: 24px;        font-size: 24px;



                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">                                    <div class="invalid-feedback">{{ $message }}</div>

                            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">

                                <i class="fas fa-times me-2"></i>Batal                                @enderror        display: block;

                            </a>

                            <button type="submit" class="btn btn-primary">                            </div>

                                <i class="fas fa-save me-2"></i>Simpan Service

                            </button>    }    }    }

                        </div>

                    </form>                            <!-- Category -->

                </div>

            </div>                            <div class="col-md-6 mb-3">

        </div>

    </div>                                <label class="form-label fw-semibold">

</div>

                                    <i class="fas fa-tags me-2 text-primary"></i>Kategori    .form-control, .form-select {

@push('scripts')

<script>                                </label>

document.addEventListener('DOMContentLoaded', function() {

    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');                                <select name="category" class="form-select @error('category') is-invalid @enderror">        border: 2px solid #e9ecef;

    if (vehicleSelect) {

        vehicleSelect.focus();                                    <option value="Service" {{ old('category', 'Service') == 'Service' ? 'selected' : '' }}>Service</option>

    }

                                    <option value="Repair" {{ old('category') == 'Repair' ? 'selected' : '' }}>Repair</option>        border-radius: 8px;    .page-subtitle {    .page-subtitle {

    const form = document.getElementById('maintenanceForm');

    form.addEventListener('submit', function(e) {                                    <option value="Routine" {{ old('category') == 'Routine' ? 'selected' : '' }}>Routine</option>

        const vehicleId = document.querySelector('select[name="vehicle_id"]').value;

        const serviceDate = document.querySelector('input[name="service_date"]').value;                                    <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>        padding: 12px 16px;

        const odometer = document.querySelector('input[name="odometer"]').value;

        const type = document.querySelector('select[name="type"]').value;                                </select>

        const paymentMethod = document.querySelector('select[name="payment_method"]').value;

                                @error('category')        font-size: 14px;        font-size: 14px;        font-size: 14px;

        if (!vehicleId || !serviceDate || !odometer || !type || !paymentMethod) {

            e.preventDefault();                                    <div class="invalid-feedback">{{ $message }}</div>

            alert('Silakan lengkapi semua field yang wajib diisi!');

            return false;                                @enderror        transition: all 0.3s ease;

        }

    });                            </div>

});

</script>                        </div>        width: 100%;        color: #6c757d;        color: #6c757d;

@endpush

@endsection


                        <!-- Workshop -->    }

                        <div class="mb-3">

                            <label class="form-label fw-semibold">            margin: 0;        margin: 0;

                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat Service

                            </label>    .form-control:focus, .form-select:focus {

                            <input type="text" name="workshop"

                                   class="form-control @error('workshop') is-invalid @enderror"        border-color: #fd7e14;    }    }

                                   placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop') }}">

                            @error('workshop')        box-shadow: 0 0 0 3px rgba(253, 126, 20, 0.1);

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror        outline: none;

                        </div>

    }

                        <!-- Payment Method -->

                        <div class="mb-3">        .form-container {    .form-container {

                            <label class="form-label fw-semibold">

                                <i class="fas fa-credit-card me-2 text-primary"></i>Metode Pembayaran    .btn-primary {

                                <span class="text-danger">*</span>

                            </label>        background: #fd7e14;        background: white;        background: white;

                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>

                                <option value="">Pilih Metode Pembayaran</option>        border: none;

                                @if(isset($paymentMethods))

                                    @foreach($paymentMethods as $method)        padding: 12px 24px;        padding: 32px;        padding: 32px;

                                        <option value="{{ $method->name }}" {{ old('payment_method') == $method->name ? 'selected' : '' }}>

                                            {{ $method->name }}        border-radius: 8px;

                                        </option>

                                    @endforeach        font-weight: 600;        border-radius: 12px;        border-radius: 12px;

                                @else

                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>        font-size: 14px;

                                    <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>

                                    <option value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>        transition: all 0.3s ease;        box-shadow: 0 1px 3px rgba(0,0,0,0.1);        box-shadow: 0 1px 3px rgba(0,0,0,0.1);

                                @endif

                            </select>    }

                            @error('payment_method')

                                <div class="invalid-feedback">{{ $message }}</div>            max-width: 800px;        max-width: 800px;

                            @enderror

                        </div>    .btn-primary:hover {



                        <!-- Cost -->        background: #e56707;        margin: 0 auto;        margin: 0 auto;

                        <div class="mb-3">

                            <label class="form-label fw-semibold">        transform: translateY(-2px);

                                <i class="fas fa-money-bill me-2 text-primary"></i>Biaya Service

                            </label>        box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);    }    }

                            <div class="input-group">

                                <span class="input-group-text">Rp</span>    }

                                <input type="number" name="cost"

                                       class="form-control @error('cost') is-invalid @enderror"

                                       placeholder="0" value="{{ old('cost') }}" min="0">

                            </div>    .btn-secondary {

                            @error('cost')

                                <div class="invalid-feedback">{{ $message }}</div>        background: #6c757d;    .form-group {    .form-group {

                            @enderror

                        </div>        border: none;



                        <!-- Notes -->        padding: 12px 24px;        margin-bottom: 24px;        margin-bottom: 24px;

                        <div class="mb-3">

                            <label class="form-label fw-semibold">        border-radius: 8px;

                                <i class="fas fa-sticky-note me-2 text-primary"></i>Keterangan

                            </label>        font-weight: 600;    }    }

                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"

                                      rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes') }}</textarea>        font-size: 14px;

                            @error('notes')

                                <div class="invalid-feedback">{{ $message }}</div>        transition: all 0.3s ease;

                            @enderror

                        </div>        color: white;



                        <!-- Next Maintenance -->        text-decoration: none;    .form-label {    .form-label {

                        <div class="row">

                            <div class="col-md-6 mb-3">    }

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-calendar-plus me-2 text-primary"></i>Jadwal Service Berikutnya            font-weight: 600;        font-weight: 600;

                                </label>

                                <input type="date" name="next_maintenance_date"     .btn-secondary:hover {

                                       class="form-control @error('next_maintenance_date') is-invalid @enderror"

                                       value="{{ old('next_maintenance_date') }}">        background: #5a6268;        color: #2c3e50;        color: #2c3e50;

                                @error('next_maintenance_date')

                                    <div class="invalid-feedback">{{ $message }}</div>        color: white;

                                @enderror

                            </div>        text-decoration: none;        margin-bottom: 8px;        margin-bottom: 8px;



                            <div class="col-md-6 mb-3">    }

                                <label class="form-label fw-semibold">

                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Odometer Service Berikutnya            font-size: 14px;        font-size: 14px;

                                </label>

                                <div class="input-group">    .form-actions {

                                    <input type="number" name="next_maintenance_odometer"

                                           class="form-control @error('next_maintenance_odometer') is-invalid @enderror"        display: flex;        display: block;        display: block;

                                           placeholder="0" value="{{ old('next_maintenance_odometer') }}" min="0">

                                    <span class="input-group-text">KM</span>        gap: 12px;

                                </div>

                                @error('next_maintenance_odometer')        justify-content: flex-end;    }    }

                                    <div class="invalid-feedback">{{ $message }}</div>

                                @enderror        margin-top: 32px;

                            </div>

                        </div>        padding-top: 24px;



                        <!-- Action Buttons -->        border-top: 1px solid #e9ecef;

                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">

                            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">    }    .form-control, .form-select {    .form-control, .form-select {

                                <i class="fas fa-times me-2"></i>Batal

                            </a>

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-save me-2"></i>Simpan Service    .required {        border: 2px solid #e9ecef;        border: 2px solid #e9ecef;

                            </button>

                        </div>        color: #dc3545;

                    </form>

                </div>    }        border-radius: 8px;        border-radius: 8px;

            </div>

        </div>

    </div>

</div>    .input-group-text {        padding: 12px 16px;        padding: 12px 16px;



@push('scripts')        background: white;

<script>

document.addEventListener('DOMContentLoaded', function() {        border: 2px solid #e9ecef;        font-size: 14px;        font-size: 14px;

    // Focus on vehicle select

    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');        border-left: none;

    if (vehicleSelect) {

        vehicleSelect.focus();        color: #6c757d;        transition: all 0.3s ease;        transition: all 0.3s ease;

    }

    }

    // Form validation

    const form = document.getElementById('maintenanceForm');            width: 100%;        width: 100%;

    form.addEventListener('submit', function(e) {

        const vehicleId = document.querySelector('select[name="vehicle_id"]').value;    .input-group .form-control {

        const serviceDate = document.querySelector('input[name="service_date"]').value;

        const odometer = document.querySelector('input[name="odometer"]').value;        border-right: none;    }    }

        const type = document.querySelector('select[name="type"]').value;

        const paymentMethod = document.querySelector('select[name="payment_method"]').value;    }



        if (!vehicleId) {

            e.preventDefault();

            alert('Silakan pilih kendaraan terlebih dahulu!');    .input-group .form-control:focus + .input-group-text {

            return false;

        }        border-color: #fd7e14;    .form-control:focus, .form-select:focus {    .form-control:focus, .form-select:focus {



        if (!serviceDate) {    }

            e.preventDefault();

            alert('Silakan isi tanggal service!');</style>        border-color: #fd7e14;        border-color: #fd7e14;

            return false;

        }



        if (!odometer) {<div class="container-fluid">        box-shadow: 0 0 0 3px rgba(253, 126, 20, 0.1);        box-shadow: 0 0 0 3px rgba(253, 126, 20, 0.1);

            e.preventDefault();

            alert('Silakan isi odometer!');    <!-- Page Header -->

            return false;

        }    <div class="page-header">        outline: none;        outline: none;



        if (!type) {        <h1 class="page-title">

            e.preventDefault();

            alert('Silakan pilih jenis service!');            <i class="fas fa-plus-circle"></i>    }    }

            return false;

        }            Tambah Service Baru



        if (!paymentMethod) {        </h1>

            e.preventDefault();

            alert('Silakan pilih metode pembayaran!');        <p class="page-subtitle">Catat perawatan dan service kendaraan Anda</p>

            return false;

        }    </div>    .btn-primary {    .btn-primary {

    });

});

</script>

@endpush    <!-- Form Container -->        background: #fd7e14;        background: #fd7e14;

@endsection

    <div class="form-container">

        @if($errors->any())        border: none;        border: none;

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="fas fa-exclamation-triangle me-2"></i>        padding: 12px 24px;        padding: 12px 24px;

            <strong>Terdapat kesalahan:</strong>

            <ul class="mb-0 mt-2">        border-radius: 8px;        border-radius: 8px;

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>        font-weight: 600;        font-weight: 600;

                @endforeach

            </ul>        font-size: 14px;        font-size: 14px;

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>        transition: all 0.3s ease;        transition: all 0.3s ease;

        @endif

    }    }

        <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">

            @csrf



            <!-- Vehicle Selection -->    .btn-primary:hover {    .btn-primary:hover {

            <div class="form-group">

                <label class="form-label">        background: #e56707;        background: #e56707;

                    <i class="fas fa-car me-2"></i>Kendaraan <span class="required">*</span>

                </label>        transform: translateY(-2px);        transform: translateY(-2px);

                <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>

                    <option value="">Pilih Kendaraan</option>        box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);        box-shadow: 0 4px 12px rgba(253, 126, 20, 0.3);

                    @foreach($vehicles as $vehicle)

                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>    }    }

                            {{ $vehicle->name }} - {{ $vehicle->license_plate }}

                        </option>

                    @endforeach

                </select>    .btn-secondary {    .btn-secondary {

                @error('vehicle_id')

                    <div class="invalid-feedback">{{ $message }}</div>        background: #6c757d;        background: #6c757d;

                @enderror

            </div>        border: none;        border: none;



            <div class="row">        padding: 12px 24px;        padding: 12px 24px;

                <!-- Tanggal Service -->

                <div class="col-md-6">        border-radius: 8px;        border-radius: 8px;

                    <div class="form-group">

                        <label class="form-label">        font-weight: 600;        font-weight: 600;

                            <i class="fas fa-calendar me-2"></i>Tanggal Service <span class="required">*</span>

                        </label>        font-size: 14px;        font-size: 14px;

                        <input type="date" name="service_date" class="form-control @error('service_date') is-invalid @enderror"

                               value="{{ old('service_date', date('Y-m-d')) }}" required>        transition: all 0.3s ease;        transition: all 0.3s ease;

                        @error('service_date')

                            <div class="invalid-feedback">{{ $message }}</div>        color: white;        color: white;

                        @enderror

                    </div>        text-decoration: none;        text-decoration: none;

                </div>

    }    }

                <!-- Odometer -->

                <div class="col-md-6">

                    <div class="form-group">

                        <label class="form-label">    .btn-secondary:hover {    .btn-secondary:hover {

                            <i class="fas fa-tachometer-alt me-2"></i>Odometer <span class="required">*</span>

                        </label>        background: #5a6268;        background: #5a6268;

                        <div class="input-group">

                            <input type="number" name="odometer" class="form-control @error('odometer') is-invalid @enderror"         color: white;        color: white;

                                   placeholder="0" value="{{ old('odometer') }}" required min="0">

                            <span class="input-group-text">KM</span>        text-decoration: none;        text-decoration: none;

                        </div>

                        @error('odometer')    }    }

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror

                    </div>

                </div>    .form-actions {    .form-actions {

            </div>

        display: flex;        display: flex;

            <div class="row">

                <!-- Jenis Service -->        gap: 12px;        gap: 12px;

                <div class="col-md-6">

                    <div class="form-group">        justify-content: flex-end;        justify-content: flex-end;

                        <label class="form-label">

                            <i class="fas fa-wrench me-2"></i>Jenis Service <span class="required">*</span>        margin-top: 32px;        margin-top: 32px;

                        </label>

                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>        padding-top: 24px;        padding-top: 24px;

                            <option value="">Pilih Jenis Service</option>

                            <option value="Service Rutin" {{ old('type') == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>        border-top: 1px solid #e9ecef;        border-top: 1px solid #e9ecef;

                            <option value="Ganti Oli" {{ old('type') == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>

                            <option value="Tune Up" {{ old('type') == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>    }    }

                            <option value="Perbaikan" {{ old('type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>

                            <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>

                        </select>

                        @error('type')    .required {    .required {

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror        color: #dc3545;        color: #dc3545;

                    </div>

                </div>    }    }



                <!-- Kategori -->

                <div class="col-md-6">

                    <div class="form-group">    .input-group-text {    .input-group-text {

                        <label class="form-label">

                            <i class="fas fa-tags me-2"></i>Kategori        background: white;        background: white;

                        </label>

                        <select name="category" class="form-select @error('category') is-invalid @enderror">        border: 2px solid #e9ecef;        border: 2px solid #e9ecef;

                            <option value="Service" {{ old('category', 'Service') == 'Service' ? 'selected' : '' }}>Service</option>

                            <option value="Repair" {{ old('category') == 'Repair' ? 'selected' : '' }}>Repair</option>        border-left: none;        border-left: none;

                            <option value="Routine" {{ old('category') == 'Routine' ? 'selected' : '' }}>Routine</option>

                            <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>        color: #6c757d;        color: #6c757d;

                        </select>

                        @error('category')    }    }

                            <div class="invalid-feedback">{{ $message }}</div>

                        @enderror

                    </div>

                </div>    .input-group .form-control {    .input-group .form-control {

            </div>

        border-right: none;        border-right: none;

            <!-- Tempat Service -->

            <div class="form-group">    }    }

                <label class="form-label">

                    <i class="fas fa-map-marker-alt me-2"></i>Tempat Service

                </label>

                <input type="text" name="workshop" class="form-control @error('workshop') is-invalid @enderror"     .input-group .form-control:focus + .input-group-text {    .input-group .form-control:focus + .input-group-text {

                       placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop') }}">

                @error('workshop')        border-color: #fd7e14;        border-color: #fd7e14;

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror    }    }

            </div>

</style></style>

            <!-- Payment Method -->

            <div class="form-group">

                <label class="form-label">

                    <i class="fas fa-credit-card me-2"></i>Metode Pembayaran <span class="required">*</span><div class="container-fluid"><div class="container-fluid">

                </label>

                <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>    <!-- Page Header -->    <!-- Page Header -->

                    <option value="">Pilih Metode Pembayaran</option>

                    @if(isset($paymentMethods))    <div class="page-header">    <div class="page-header">

                        @foreach($paymentMethods as $method)

                            <option value="{{ $method->name }}" {{ old('payment_method') == $method->name ? 'selected' : '' }}>        <h1 class="page-title">        <h1 class="page-title">

                                {{ $method->name }}

                            </option>            <i class="fas fa-plus-circle"></i>            <i class="fas fa-plus-circle"></i>

                        @endforeach

                    @else            Tambah Service Baru            Tambah Service Baru

                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>

                        <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>        </h1>        </h1>

                        <option value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>

                    @endif        <p class="page-subtitle">Catat perawatan dan service kendaraan Anda</p>        <p class="page-subtitle">Catat perawatan dan service kendaraan Anda</p>

                </select>

                @error('payment_method')    </div>    </div>

                    <div class="invalid-feedback">{{ $message }}</div>

                @enderror

            </div>

    <!-- Form Container -->    <!-- Form Container -->

            <!-- Biaya -->

            <div class="form-group">    <div class="form-container">    <div class="form-container">

                <label class="form-label">

                    <i class="fas fa-money-bill me-2"></i>Biaya Service        @if($errors->any())        @if($errors->any())

                </label>

                <div class="input-group">        <div class="alert alert-danger alert-dismissible fade show" role="alert">        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <span class="input-group-text">Rp</span>

                    <input type="number" name="cost" class="form-control @error('cost') is-invalid @enderror"             <i class="fas fa-exclamation-triangle me-2"></i>            <i class="fas fa-exclamation-triangle me-2"></i>

                           placeholder="0" value="{{ old('cost') }}" min="0">

                </div>            <strong>Terdapat kesalahan:</strong>            <strong>Terdapat kesalahan:</strong>

                @error('cost')

                    <div class="invalid-feedback">{{ $message }}</div>            <ul class="mb-0 mt-2">            <ul class="mb-0 mt-2">

                @enderror

            </div>                @foreach($errors->all() as $error)                @foreach($errors->all() as $error)



            <!-- Keterangan -->                    <li>{{ $error }}</li>                    <li>{{ $error }}</li>

            <div class="form-group">

                <label class="form-label">                @endforeach                @endforeach

                    <i class="fas fa-sticky-note me-2"></i>Keterangan

                </label>            </ul>            </ul>

                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"

                          rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('notes') }}</textarea>            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                @error('notes')

                    <div class="invalid-feedback">{{ $message }}</div>        </div>        </div>

                @enderror

            </div>        @endif        @endif



            <!-- Service Berikutnya -->

            <div class="row">

                <div class="col-md-6">        <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">        <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">

                    <div class="form-group">

                        <label class="form-label">            @csrf            @csrf

                            <i class="fas fa-calendar-plus me-2"></i>Jadwal Service Berikutnya

                        </label>

                        <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror"

                               value="{{ old('next_maintenance_date') }}">            <!-- Vehicle Selection -->    /* ===== VEHICLE MODAL POPUP ===== */

                        @error('next_maintenance_date')

                            <div class="invalid-feedback">{{ $message }}</div>            <div class="form-group">    .vehicle-modal {

                        @enderror

                    </div>                <label class="form-label">        display: none;

                </div>

                    <i class="fas fa-car me-2"></i>Kendaraan <span class="required">*</span>        position: fixed;

                <div class="col-md-6">

                    <div class="form-group">                </label>        z-index: 9999;

                        <label class="form-label">

                            <i class="fas fa-tachometer-alt me-2"></i>Odometer Service Berikutnya                <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>        left: 0 !important;

                        </label>

                        <div class="input-group">                    <option value="">Pilih Kendaraan</option>        top: 0 !important;

                            <input type="number" name="next_maintenance_odometer" class="form-control @error('next_maintenance_odometer') is-invalid @enderror"

                                   placeholder="0" value="{{ old('next_maintenance_odometer') }}" min="0">                    @foreach($vehicles as $vehicle)        right: 0 !important;

                            <span class="input-group-text">KM</span>

                        </div>                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}>        bottom: 0 !important;

                        @error('next_maintenance_odometer')

                            <div class="invalid-feedback">{{ $message }}</div>                            {{ $vehicle->name }} - {{ $vehicle->license_plate }}        width: 100vw !important;

                        @enderror

                    </div>                        </option>        height: 100vh !important;

                </div>

            </div>                    @endforeach        background-color: rgba(0,0,0,0.5);



            <!-- Form Actions -->                </select>        animation: fadeIn 0.3s;

            <div class="form-actions">

                <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">                @error('vehicle_id')        padding: 20px;

                    <i class="fas fa-times me-2"></i>Batal

                </a>                    <div class="invalid-feedback">{{ $message }}</div>        margin: 0 !important;

                <button type="submit" class="btn btn-primary">

                    <i class="fas fa-save me-2"></i>Simpan Service                @enderror    }

                </button>

            </div>            </div>    .vehicle-modal.show {

        </form>

    </div>        display: flex !important;

</div>

            <div class="row">        align-items: center;

<script>

// Auto-focus first field and basic form validation                <!-- Tanggal Service -->        justify-content: center;

document.addEventListener('DOMContentLoaded', function() {

    // Focus pada dropdown kendaraan pertama kali                <div class="col-md-6">    }

    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');

    if (vehicleSelect) {                    <div class="form-group">    .vehicle-modal-content {

        vehicleSelect.focus();

    }                        <label class="form-label">        background-color: white;



    // Form validation sebelum submit                            <i class="fas fa-calendar me-2"></i>Tanggal Service <span class="required">*</span>        border-radius: 12px;

    const form = document.getElementById('maintenanceForm');

    form.addEventListener('submit', function(e) {                        </label>        width: 90%;

        const vehicleId = document.querySelector('select[name="vehicle_id"]').value;

        const serviceDate = document.querySelector('input[name="service_date"]').value;                        <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror"         max-width: 480px;

        const odometer = document.querySelector('input[name="odometer"]').value;

        const type = document.querySelector('select[name="type"]').value;                               value="{{ old('maintenance_date', date('Y-m-d')) }}" required>        max-height: 80vh;

        const paymentMethod = document.querySelector('select[name="payment_method"]').value;

                        @error('maintenance_date')        display: flex;

        if (!vehicleId) {

            e.preventDefault();                            <div class="invalid-feedback">{{ $message }}</div>        flex-direction: column;

            alert('Silakan pilih kendaraan terlebih dahulu!');

            return false;                        @enderror        animation: slideUp 0.3s;

        }

                    </div>        position: relative;

        if (!serviceDate) {

            e.preventDefault();                </div>        margin: 0 auto;

            alert('Silakan isi tanggal service!');

            return false;        box-shadow: 0 4px 20px rgba(0,0,0,0.15);

        }

                <!-- Odometer -->    }

        if (!odometer) {

            e.preventDefault();                <div class="col-md-6">    .vehicle-modal-header {

            alert('Silakan isi odometer!');

            return false;                    <div class="form-group">        padding: 20px 24px;

        }

                        <label class="form-label">        border-bottom: 1px solid #e9ecef;

        if (!type) {

            e.preventDefault();                            <i class="fas fa-tachometer-alt me-2"></i>Odometer <span class="required">*</span>        display: flex;

            alert('Silakan pilih jenis service!');

            return false;                        </label>        justify-content: space-between;

        }

                        <div class="input-group">        align-items: center;

        if (!paymentMethod) {

            e.preventDefault();                            <input type="number" name="odometer" class="form-control @error('odometer') is-invalid @enderror"     }

            alert('Silakan pilih metode pembayaran!');

            return false;                                   placeholder="0" value="{{ old('odometer') }}" required min="0">    .vehicle-modal-title {

        }

    });                            <span class="input-group-text">KM</span>        font-size: 20px;

});

</script>                        </div>        font-weight: 600;

@endsection
                        @error('odometer')        color: #2c3e50;

                            <div class="invalid-feedback">{{ $message }}</div>        margin: 0;

                        @enderror    }

                    </div>    .vehicle-modal-close {

                </div>        background: transparent;

            </div>        border: none;

        font-size: 24px;

            <div class="row">        color: #6c757d;

                <!-- Jenis Service -->        cursor: pointer;

                <div class="col-md-6">        padding: 0;

                    <div class="form-group">        width: 32px;

                        <label class="form-label">        height: 32px;

                            <i class="fas fa-wrench me-2"></i>Jenis Service <span class="required">*</span>        display: flex;

                        </label>        align-items: center;

                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>        justify-content: center;

                            <option value="">Pilih Jenis Service</option>        border-radius: 4px;

                            <option value="Service Rutin" {{ old('type') == 'Service Rutin' ? 'selected' : '' }}>Service Rutin</option>    }

                            <option value="Ganti Oli" {{ old('type') == 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>    .vehicle-modal-close:hover {

                            <option value="Tune Up" {{ old('type') == 'Tune Up' ? 'selected' : '' }}>Tune Up</option>        background: #f8f9fa;

                            <option value="Perbaikan" {{ old('type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>    }

                            <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>    .vehicle-modal-search {

                        </select>        padding: 16px 24px;

                        @error('type')        border-bottom: 1px solid #e9ecef;

                            <div class="invalid-feedback">{{ $message }}</div>    }

                        @enderror    .vehicle-search-input {

                    </div>        width: 100%;

                </div>        padding: 10px 16px 10px 40px;

        border: 1px solid #dee2e6;

                <!-- Kategori -->        border-radius: 8px;

                <div class="col-md-6">        font-size: 14px;

                    <div class="form-group">    }

                        <label class="form-label">    .vehicle-search-icon {

                            <i class="fas fa-tags me-2"></i>Kategori        position: absolute;

                        </label>        left: 40px;

                        <select name="category" class="form-select @error('category') is-invalid @enderror">        top: 28px;

                            <option value="Service" {{ old('category', 'Service') == 'Service' ? 'selected' : '' }}>Service</option>        color: #6c757d;

                            <option value="Repair" {{ old('category') == 'Repair' ? 'selected' : '' }}>Repair</option>    }

                            <option value="Routine" {{ old('category') == 'Routine' ? 'selected' : '' }}>Routine</option>    .vehicle-modal-body {

                            <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>        padding: 0;

                        </select>        overflow-y: auto;

                        @error('category')        max-height: 400px;

                            <div class="invalid-feedback">{{ $message }}</div>    }

                        @enderror    .vehicle-list-item {

                    </div>        padding: 16px 24px;

                </div>        display: flex;

            </div>        align-items: center;

        gap: 16px;

            <!-- Tempat Service -->        cursor: pointer;

            <div class="form-group">        border-bottom: 1px solid #f8f9fa;

                <label class="form-label">        transition: background-color 0.2s;

                    <i class="fas fa-map-marker-alt me-2"></i>Tempat Service        text-decoration: none;

                </label>        color: inherit;

                <input type="text" name="workshop" class="form-control @error('workshop') is-invalid @enderror"     }

                       placeholder="Contoh: Bengkel Jaya Motor" value="{{ old('workshop') }}">    .vehicle-list-item:hover {

                @error('workshop')        background-color: #f8f9fa;

                    <div class="invalid-feedback">{{ $message }}</div>    }

                @enderror    .vehicle-list-item.active {

            </div>        background-color: #e7f3ff;

    }

            <!-- Biaya -->    .vehicle-item-logo {

            <div class="form-group">        width: 40px;

                <label class="form-label">        height: 40px;

                    <i class="fas fa-money-bill me-2"></i>Biaya Service        object-fit: contain;

                </label>        flex-shrink: 0;

                <div class="input-group">    }

                    <span class="input-group-text">Rp</span>    .vehicle-item-placeholder {

                    <input type="number" name="cost" class="form-control @error('cost') is-invalid @enderror"         width: 40px;

                           placeholder="0" value="{{ old('cost') }}" min="0">        height: 40px;

                </div>        background: #e9ecef;

                @error('cost')        border-radius: 50%;

                    <div class="invalid-feedback">{{ $message }}</div>        display: flex;

                @enderror        align-items: center;

            </div>        justify-content: center;

        color: #6c757d;

            <!-- Keterangan -->        font-size: 18px;

            <div class="form-group">        flex-shrink: 0;

                <label class="form-label">    }

                    <i class="fas fa-sticky-note me-2"></i>Keterangan    .vehicle-item-info {

                </label>        flex: 1;

                <textarea name="description" class="form-control @error('description') is-invalid @enderror"     }

                          rows="4" placeholder="Catatan tambahan tentang service ini...">{{ old('description') }}</textarea>    .vehicle-item-name {

                @error('description')        font-size: 15px;

                    <div class="invalid-feedback">{{ $message }}</div>        font-weight: 500;

                @enderror        color: #2c3e50;

            </div>        margin-bottom: 2px;

    }

            <!-- Service Berikutnya -->    .vehicle-item-plate {

            <div class="row">        font-size: 13px;

                <div class="col-md-6">        color: #6c757d;

                    <div class="form-group">    }

                        <label class="form-label">    .vehicle-item-icon {

                            <i class="fas fa-calendar-plus me-2"></i>Jadwal Service Berikutnya        color: #6c757d;

                        </label>        font-size: 18px;

                        <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror"     }

                               value="{{ old('next_maintenance_date') }}">    @keyframes fadeIn {

                        @error('next_maintenance_date')        from { opacity: 0; }

                            <div class="invalid-feedback">{{ $message }}</div>        to { opacity: 1; }

                        @enderror    }

                    </div>    @keyframes slideUp {

                </div>        from { transform: translateY(50px); opacity: 0; }

        to { transform: translateY(0); opacity: 1; }

                <div class="col-md-6">    }

                    <div class="form-group">

                        <label class="form-label">    .page-title-section {

                            <i class="fas fa-tachometer-alt me-2"></i>Odometer Service Berikutnya        display: flex;

                        </label>        align-items: center;

                        <div class="input-group">        margin-bottom: 24px;

                            <input type="number" name="next_maintenance_odometer" class="form-control @error('next_maintenance_odometer') is-invalid @enderror"         padding-bottom: 16px;

                                   placeholder="0" value="{{ old('next_maintenance_odometer') }}" min="0">        border-bottom: 1px solid #e9ecef;

                            <span class="input-group-text">KM</span>        margin-top: 0 !important;

                        </div>        padding-top: 0 !important;

                        @error('next_maintenance_odometer')    }

                            <div class="invalid-feedback">{{ $message }}</div>    .page-title-section .title-icon {

                        @enderror        width: 24px;

                    </div>        height: 24px;

                </div>        display: flex;

            </div>        align-items: center;

        justify-content: center;

            <!-- Form Actions -->        margin-right: 8px;

            <div class="form-actions">    }

                <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">    .page-title-section .title-icon i {

                    <i class="fas fa-times me-2"></i>Batal        font-size: 18px;

                </a>        color: #495057;

                <button type="submit" class="btn btn-primary">    }

                    <i class="fas fa-save me-2"></i>Simpan Service    .page-title-section h4 {

                </button>        margin-bottom: 0;

            </div>        font-size: 18px;

        </form>        font-weight: 600;

    </div>        color: #212529;

</div>    }



<script>    /* Drivvo Style Inputs */

// Auto-focus first field and basic form validation    .form-control,

document.addEventListener('DOMContentLoaded', function() {    .form-select {

    // Focus pada dropdown kendaraan pertama kali        border: 1px solid #dee2e6;

    const vehicleSelect = document.querySelector('select[name="vehicle_id"]');        border-radius: 4px;

    if (vehicleSelect) {        padding: 10px 12px;

        vehicleSelect.focus();        font-size: 14px;

    }        background-color: #fff;

        transition: all 0.2s;

    // Form validation sebelum submit    }

    const form = document.getElementById('maintenanceForm');    .form-control:focus,

    form.addEventListener('submit', function(e) {    .form-select:focus {

        const vehicleId = document.querySelector('select[name="vehicle_id"]').value;        border-color: #80bdff;

        const maintenanceDate = document.querySelector('input[name="maintenance_date"]').value;        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.1);

        const odometer = document.querySelector('input[name="odometer"]').value;        outline: 0;

        const type = document.querySelector('select[name="type"]').value;    }

    .form-label {

        if (!vehicleId) {        font-size: 13px;

            e.preventDefault();        color: #6c757d;

            alert('Silakan pilih kendaraan terlebih dahulu!');        margin-bottom: 6px;

            return false;        font-weight: 400;

        }        display: block;

    }

        if (!maintenanceDate) {    .btn-save {

            e.preventDefault();        background: #007bff;

            alert('Silakan isi tanggal service!');        color: white;

            return false;        border: none;

        }        padding: 10px 32px;

        border-radius: 4px;

        if (!odometer) {        font-weight: 500;

            e.preventDefault();        text-transform: uppercase;

            alert('Silakan isi odometer!');        transition: all 0.3s ease;

            return false;        font-size: 14px;

        }        letter-spacing: 0.5px;

    }

        if (!type) {    .btn-save:hover {

            e.preventDefault();        background: #0056b3;

            alert('Silakan pilih jenis service!');        color: white;

            return false;    }

        }    .btn-cancel {

    });        background: transparent;

});        color: #6c757d;

</script>        border: none;

@endsection        padding: 10px 32px;
        border-radius: 4px;
        font-weight: 500;
        text-transform: uppercase;
        transition: all 0.3s ease;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    .btn-cancel:hover {
        background: #f8f9fa;
        color: #495057;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .content-area {
            padding: 16px;
            padding-bottom: 80px;
            margin-bottom: 40px;
        }
        .field-with-icon {
            margin-bottom: 16px;
        }
        .main-content {
            overflow: visible;
            min-height: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="content-area">
    <form action="{{ route('maintenances.store') }}" method="POST" id="maintenanceForm">
        @csrf

        <!-- Vehicle Selector Header -->
        <div class="page-title-section" style="cursor: pointer; border-bottom: none; padding-bottom: 8px;" onclick="openVehicleModal()">
            @if(isset($vehicle))
                @php
                    $logoPath = 'assets/logos/brands/' . strtolower(str_replace(' ', '-', $vehicle->brand)) . '.svg';
                @endphp
                @if(file_exists(public_path($logoPath)))
                    <img src="{{ asset($logoPath) }}" alt="{{ $vehicle->brand }}" style="width: 32px; height: 32px; object-fit: contain; margin-right: 12px;">
                @else
                    <div style="width: 32px; height: 32px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                        <i class="fas fa-car" style="color: #3498db; font-size: 16px;"></i>
                    </div>
                @endif
                <div style="flex: 1;">
                    <h4 style="margin-bottom: 2px;">{{ $vehicle->name }}</h4>
                    <div style="font-size: 13px; color: #007bff; display: flex; align-items: center; gap: 4px;">
                        <span>Vehicle</span>
                        <i class="fas fa-chevron-right" style="font-size: 10px; color: #6c757d;"></i>
                        <span>{{ $vehicle->license_plate }}</span>
                    </div>
                </div>
                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 14px;"></i>
            @else
                <div class="title-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h4 style="flex: 1;">Select Vehicle</h4>
                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 14px;"></i>
            @endif
        </div>

        <div style="border-bottom: 1px solid #e9ecef; margin-bottom: 24px;"></div>

        <!-- Page Title -->
        <div style="display: flex; align-items: center; margin-bottom: 24px;">
            <div class="title-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <h4 style="margin: 0;">Add New Service</h4>
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

        <!-- Hidden Vehicle ID -->
        @if(isset($vehicle))
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
        @endif

        <!-- Date -->
        <div class="field-group">
            <label class="form-label" for="service_date">1. Date</label>
            <input type="date" class="form-control @error('service_date') is-invalid @enderror"
                   id="service_date" name="service_date"
                   value="{{ old('service_date', date('Y-m-d')) }}" required>
            @error('service_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Select date on automatic Calender selection/default is today</small>
        </div>

        <!-- Time -->
        <div class="field-group">
            <label class="form-label" for="service_time">2. Time</label>
            <input type="time" class="form-control @error('service_time') is-invalid @enderror"
                   id="service_time" name="service_time"
                   value="{{ old('service_time', date('H:i')) }}" required>
            @error('service_time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Select time on automatic time/default is now</small>
        </div>

        <!-- Odometer -->
        <div class="field-group">
            <label class="form-label" for="odometer">3. Odometer</label>
            <input type="number" class="form-control @error('odometer') is-invalid @enderror"
                   id="odometer" name="odometer"
                   value="{{ old('odometer', isset($vehicle) ? $vehicle->odometer : '') }}"
                   step="0.1" min="0" placeholder="Enter odometer reading" required>
            @error('odometer')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Free Text</small>
            @if(isset($vehicle))
                <small class="text-muted d-block" style="font-size: 11px;">
                    Latest: {{ number_format($vehicle->odometer, 1) }} km
                </small>
            @endif
        </div>

        <!-- Type of Service -->
        <div class="field-group">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0" for="service_type">4. Type of Service</label>
                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#partsReferenceModal" style="padding: 2px 8px; font-size: 11px;">
                    <i class="fas fa-info-circle"></i> Price Reference
                </button>
            </div>
            <select class="form-select @error('service_type') is-invalid @enderror"
                    id="service_type" name="service_type" required onchange="updateServicePrice()">
                <option value="" data-price="0">-- Select Type of Service --</option>
                <option value="Oil Change" data-price="150000" {{ old('service_type') == 'Oil Change' ? 'selected' : '' }}>Oil Change</option>
                <option value="Tire Rotation" data-price="100000" {{ old('service_type') == 'Tire Rotation' ? 'selected' : '' }}>Tire Rotation</option>
                <option value="Brake Service" data-price="500000" {{ old('service_type') == 'Brake Service' ? 'selected' : '' }}>Brake Service</option>
                <option value="Engine Repair" data-price="1500000" {{ old('service_type') == 'Engine Repair' ? 'selected' : '' }}>Engine Repair</option>
                <option value="Transmission Service" data-price="800000" {{ old('service_type') == 'Transmission Service' ? 'selected' : '' }}>Transmission Service</option>
                <option value="Battery Replacement" data-price="850000" {{ old('service_type') == 'Battery Replacement' ? 'selected' : '' }}>Battery Replacement</option>
                <option value="AC Service" data-price="400000" {{ old('service_type') == 'AC Service' ? 'selected' : '' }}>AC Service</option>
                <option value="General Inspection" data-price="200000" {{ old('service_type') == 'General Inspection' ? 'selected' : '' }}>General Inspection</option>
                <option value="Other" data-price="0" {{ old('service_type') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('service_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Drop down selection based on list that been set on setting menu</small>
        </div>

        <!-- Estimated Price (Auto-filled but editable) -->
        <div class="field-group">
            <label class="form-label" for="estimated_price">5. Estimated Service Price</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number"
                       class="form-control @error('estimated_price') is-invalid @enderror"
                       id="estimated_price"
                       name="estimated_price"
                       value="{{ old('estimated_price', '0') }}"
                       placeholder="Enter service price"
                       min="0"
                       step="1000"
                       required>
            </div>
            @error('estimated_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">
                <i class="fas fa-magic"></i> Auto-filled based on service type, but you can manually adjust the price as needed.
            </small>
        </div>

        <!-- Place -->
        <div class="field-group">
            <label class="form-label" for="place">6. Place</label>
            <select class="form-select @error('place') is-invalid @enderror"
                    id="place" name="place" required>
                <option value="">-- Select Place --</option>
                <option value="Workshop A" {{ old('place') == 'Workshop A' ? 'selected' : '' }}>Workshop A</option>
                <option value="Workshop B" {{ old('place') == 'Workshop B' ? 'selected' : '' }}>Workshop B</option>
                <option value="Official Dealer" {{ old('place') == 'Official Dealer' ? 'selected' : '' }}>Official Dealer</option>
                <option value="Independent Mechanic" {{ old('place') == 'Independent Mechanic' ? 'selected' : '' }}>Independent Mechanic</option>
                <option value="Other" {{ old('place') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('place')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Drop down selection based on list that been set on setting menu</small>
        </div>

        <!-- User -->
        <div class="field-group">
            <label class="form-label" for="user_display">7. User</label>
            <input type="text" class="form-control" id="user_display"
                   value="{{ auth()->check() ? auth()->user()->name : 'Guest' }}" readonly>
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Based on account logged in</small>
        </div>

        <!-- Payment Method -->
        <div class="field-group">
            <label class="form-label" for="payment_method">7. Payment Method</label>
            <select class="form-select @error('payment_method') is-invalid @enderror"
                    id="payment_method" name="payment_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                <option value="Debit Card" {{ old('payment_method') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                <option value="Other" {{ old('payment_method') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('payment_method')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Drop down selection based on list that been set on setting menu</small>
        </div>

        <!-- Notes -->
        <div class="field-group">
            <label class="form-label" for="notes">8. Notes</label>
            <textarea class="form-control @error('notes') is-invalid @enderror"
                      id="notes" name="notes" rows="4"
                      placeholder="Enter service notes...">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Free Text</small>
        </div>

        <!-- Attach File -->
        <div class="field-group">
            <label class="form-label">9. Attach File Button</label>
            <div>
                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('attachment').click()">
                    <i class="fas fa-paperclip me-2"></i>ATTACH FILE
                </button>
                <input type="file" class="d-none @error('attachment') is-invalid @enderror"
                       id="attachment" name="attachment"
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                       onchange="updateFileName(this)">
                <span id="fileName" class="ms-3 text-muted" style="font-size: 13px;"></span>
                @error('attachment')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <small class="text-muted d-block mt-1" style="font-size: 11px;">Max: 5MB (jpg, jpeg, png, pdf, doc, docx)</small>
        </div>

        <!-- Hidden fields for backward compatibility -->
        <input type="hidden" name="maintenance_date" id="hidden_maintenance_date">
        <input type="hidden" name="type" value="Service">
        <input type="hidden" name="category" value="Routine">
        <input type="hidden" name="cost" value="0">
        <input type="hidden" name="total_cost" value="0">
        <input type="hidden" name="description" value="-">

        <!-- Action Buttons -->
        <div class="d-flex gap-2 justify-content-end mt-4 mb-5" style="padding-bottom: 40px;">
            <a href="{{ route('maintenances.index') }}" class="btn btn-cancel">
                CANCEL
            </a>
            <button type="submit" class="btn btn-save">
                SAVE
            </button>
        </div>
    </form>
</div>

<!-- Vehicle Selection Modal -->
<div id="vehicleModal" class="vehicle-modal">
    <div class="vehicle-modal-content">
        <div class="vehicle-modal-header">
            <h5 class="vehicle-modal-title">Vehicle</h5>
            <button class="vehicle-modal-close" onclick="closeVehicleModal()">&times;</button>
        </div>
        <div class="vehicle-modal-search" style="position: relative;">
            <i class="fas fa-search vehicle-search-icon"></i>
            <input type="text" id="vehicleSearch" class="vehicle-search-input" placeholder="Search Vehicle..." onkeyup="filterVehicles()">
        </div>
        <div class="vehicle-modal-body">
            @php
                $vehicles = \App\Models\Vehicle::all();
            @endphp
            @foreach($vehicles as $v)
                @php
                    $vLogoPath = 'assets/logos/brands/' . strtolower(str_replace(' ', '-', $v->brand)) . '.svg';
                @endphp
                <a href="{{ route('maintenances.create', ['vehicle_id' => $v->id]) }}"
                   class="vehicle-list-item {{ isset($vehicle) && $vehicle->id == $v->id ? 'active' : '' }}"
                   data-vehicle-name="{{ strtolower($v->name) }}"
                   data-vehicle-plate="{{ strtolower($v->license_plate) }}">
                    @if(file_exists(public_path($vLogoPath)))
                        <img src="{{ asset($vLogoPath) }}" alt="{{ $v->brand }}" class="vehicle-item-logo">
                    @else
                        <div class="vehicle-item-placeholder">
                            <i class="fas fa-car"></i>
                        </div>
                    @endif
                    <div class="vehicle-item-info">
                        <div class="vehicle-item-name">{{ $v->name }}</div>
                        <div class="vehicle-item-plate">{{ $v->license_plate }}</div>
                    </div>
                    <i class="fas fa-truck vehicle-item-icon"></i>
                </a>
            @endforeach
            <a href="{{ route('vehicles.create') }}" class="vehicle-list-item" style="color: #007bff;">
                <div class="vehicle-item-placeholder" style="background: #e7f3ff;">
                    <i class="fas fa-plus" style="color: #007bff;"></i>
                </div>
                <div class="vehicle-item-info">
                    <div class="vehicle-item-name" style="color: #007bff;">Add New Vehicles</div>
                </div>
                <i class="fas fa-chevron-right vehicle-item-icon" style="color: #007bff;"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Modal Functions
function openVehicleModal() {
    document.getElementById('vehicleModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeVehicleModal() {
    document.getElementById('vehicleModal').classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('vehicleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVehicleModal();
    }
});

// Vehicle search filter
function filterVehicles() {
    const searchInput = document.getElementById('vehicleSearch').value.toLowerCase();
    const vehicleItems = document.querySelectorAll('.vehicle-list-item');

    vehicleItems.forEach(item => {
        const vehicleName = item.getAttribute('data-vehicle-name') || '';
        const vehiclePlate = item.getAttribute('data-vehicle-plate') || '';

        if (vehicleName.includes(searchInput) || vehiclePlate.includes(searchInput)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVehicleModal();
    }
});

// Update file name display
function updateFileName(input) {
    const fileNameSpan = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2); // Convert to MB
        fileNameSpan.textContent = `${fileName} (${fileSize} MB)`;
        fileNameSpan.style.color = '#28a745';
    } else {
        fileNameSpan.textContent = '';
    }
}

// Sync service_date to hidden maintenance_date for backward compatibility
document.getElementById('service_date').addEventListener('change', function() {
    document.getElementById('hidden_maintenance_date').value = this.value;
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial maintenance_date value
    const serviceDateValue = document.getElementById('service_date').value;
    document.getElementById('hidden_maintenance_date').value = serviceDateValue;
});

// Update Service Price based on selected service type
function updateServicePrice() {
    const serviceTypeSelect = document.getElementById('service_type');
    const estimatedPriceInput = document.getElementById('estimated_price');

    // Get selected option
    const selectedOption = serviceTypeSelect.options[serviceTypeSelect.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || '0';

    // Set the numeric value (without thousand separator for number input)
    estimatedPriceInput.value = price;

    // Optional: Add visual feedback
    estimatedPriceInput.style.backgroundColor = '#e8f4f8';
    setTimeout(() => {
        estimatedPriceInput.style.backgroundColor = '';
    }, 500);
}

// Search functionality in Parts Reference Modal
function searchParts() {
    const input = document.getElementById('partsSearch');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('partsTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 0; i < tr.length; i++) {
        const tdName = tr[i].getElementsByTagName('td')[0];
        const tdCategory = tr[i].getElementsByTagName('td')[1];
        if (tdName || tdCategory) {
            const txtName = tdName ? tdName.textContent || tdName.innerText : '';
            const txtCategory = tdCategory ? tdCategory.textContent || tdCategory.innerText : '';
            if (txtName.toLowerCase().indexOf(filter) > -1 || txtCategory.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}
</script>

<!-- Parts Reference Modal -->
<div class="modal fade" id="partsReferenceModal" tabindex="-1" aria-labelledby="partsReferenceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="partsReferenceModalLabel">
                    <i class="fas fa-tools"></i> Parts Price Reference
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <!-- Search Box -->
                <div class="mb-3">
                    <input type="text"
                           id="partsSearch"
                           class="form-control"
                           placeholder="🔍 Search parts name or category..."
                           onkeyup="searchParts()"
                           style="border-radius: 20px; padding: 10px 20px;">
                </div>

                <!-- Parts Table -->
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-striped" id="partsTable">
                        <thead style="position: sticky; top: 0; background: white; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <tr>
                                <th style="width: 35%;">Part Name</th>
                                <th style="width: 25%;">Category</th>
                                <th style="width: 20%;" class="text-end">Price (Rp)</th>
                                <th style="width: 20%;">Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Oil & Fluids -->
                            <tr>
                                <td><i class="fas fa-oil-can text-warning"></i> Engine Oil (5W-30)</td>
                                <td><span class="badge bg-warning text-dark">Oil Change</span></td>
                                <td class="text-end">150,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-oil-can text-warning"></i> Engine Oil (10W-40)</td>
                                <td><span class="badge bg-warning text-dark">Oil Change</span></td>
                                <td class="text-end">175,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-tint text-info"></i> Brake Fluid</td>
                                <td><span class="badge bg-danger">Brake Service</span></td>
                                <td class="text-end">85,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-tint text-primary"></i> Coolant</td>
                                <td><span class="badge bg-info">Engine</span></td>
                                <td class="text-end">95,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-tint text-success"></i> Transmission Fluid</td>
                                <td><span class="badge bg-secondary">Transmission</span></td>
                                <td class="text-end">225,000</td>
                                <td><span class="badge bg-warning text-dark">Limited</span></td>
                            </tr>

                            <!-- Filters -->
                            <tr>
                                <td><i class="fas fa-filter text-primary"></i> Oil Filter</td>
                                <td><span class="badge bg-warning text-dark">Oil Change</span></td>
                                <td class="text-end">45,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-filter text-secondary"></i> Air Filter</td>
                                <td><span class="badge bg-info">General</span></td>
                                <td class="text-end">65,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-filter text-dark"></i> Fuel Filter</td>
                                <td><span class="badge bg-info">Engine</span></td>
                                <td class="text-end">120,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-filter text-info"></i> Cabin Air Filter</td>
                                <td><span class="badge bg-primary">AC Service</span></td>
                                <td class="text-end">85,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>

                            <!-- Tires -->
                            <tr>
                                <td><i class="fas fa-circle text-dark"></i> Tire (Front) 185/65R15</td>
                                <td><span class="badge bg-dark">Tire</span></td>
                                <td class="text-end">550,000</td>
                                <td><span class="badge bg-warning text-dark">Limited</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-circle text-dark"></i> Tire (Rear) 185/65R15</td>
                                <td><span class="badge bg-dark">Tire</span></td>
                                <td class="text-end">550,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>

                            <!-- Brakes -->
                            <tr>
                                <td><i class="fas fa-stop-circle text-danger"></i> Brake Pad (Front)</td>
                                <td><span class="badge bg-danger">Brake Service</span></td>
                                <td class="text-end">350,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-stop-circle text-danger"></i> Brake Pad (Rear)</td>
                                <td><span class="badge bg-danger">Brake Service</span></td>
                                <td class="text-end">280,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-compact-disc text-danger"></i> Brake Disc (Front)</td>
                                <td><span class="badge bg-danger">Brake Service</span></td>
                                <td class="text-end">650,000</td>
                                <td><span class="badge bg-warning text-dark">Limited</span></td>
                            </tr>

                            <!-- Battery -->
                            <tr>
                                <td><i class="fas fa-car-battery text-success"></i> Battery 12V 60Ah</td>
                                <td><span class="badge bg-success">Battery</span></td>
                                <td class="text-end">850,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-car-battery text-success"></i> Battery 12V 80Ah</td>
                                <td><span class="badge bg-success">Battery</span></td>
                                <td class="text-end">1,250,000</td>
                                <td><span class="badge bg-warning text-dark">Limited</span></td>
                            </tr>

                            <!-- AC Parts -->
                            <tr>
                                <td><i class="fas fa-snowflake text-primary"></i> AC Refrigerant (R134a)</td>
                                <td><span class="badge bg-primary">AC Service</span></td>
                                <td class="text-end">125,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-fan text-primary"></i> AC Compressor</td>
                                <td><span class="badge bg-primary">AC Service</span></td>
                                <td class="text-end">2,500,000</td>
                                <td><span class="badge bg-danger">Out of Stock</span></td>
                            </tr>

                            <!-- Spark Plugs -->
                            <tr>
                                <td><i class="fas fa-bolt text-warning"></i> Spark Plug (Standard)</td>
                                <td><span class="badge bg-info">Engine</span></td>
                                <td class="text-end">35,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-bolt text-warning"></i> Spark Plug (Iridium)</td>
                                <td><span class="badge bg-info">Engine</span></td>
                                <td class="text-end">85,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>

                            <!-- Belts -->
                            <tr>
                                <td><i class="fas fa-grip-lines text-secondary"></i> Timing Belt</td>
                                <td><span class="badge bg-info">Engine</span></td>
                                <td class="text-end">450,000</td>
                                <td><span class="badge bg-warning text-dark">Limited</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-grip-lines text-secondary"></i> Fan Belt</td>
                                <td><span class="badge bg-info">Engine</span></td>
                                <td class="text-end">125,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>

                            <!-- Wipers -->
                            <tr>
                                <td><i class="fas fa-wind text-info"></i> Wiper Blade (Front)</td>
                                <td><span class="badge bg-info">General</span></td>
                                <td class="text-end">85,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-wind text-info"></i> Wiper Blade (Rear)</td>
                                <td><span class="badge bg-info">General</span></td>
                                <td class="text-end">65,000</td>
                                <td><span class="badge bg-success">Available</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Info -->
                <div class="alert alert-info mt-3 mb-0" style="border-radius: 12px;">
                    <i class="fas fa-info-circle"></i> <strong>Note:</strong>
                    Prices are indicative and may vary based on brand, quality, and supplier.
                    Please confirm current prices before ordering.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

@endpush
@endsection




























