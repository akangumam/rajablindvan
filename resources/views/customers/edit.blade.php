@extends('layouts.drivvo-form', [
    'pageTitle' => 'Edit Pengguna',
    'pageIcon' => 'fa-users',
    'formAction' => route('customers.update', $customer),
    'formId' => 'customerForm',
    'cancelRoute' => route('customers.index'),
    'hideVehicleSelector' => true,
])

@section('form-fields')
@method('PUT')

<!-- Nama Depan & Belakang -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="first_name" class="form-label">
            <i class="far fa-user" style="color: #5B7C99; margin-right: 8px;"></i>
            Nama depan
        </label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name) }}" placeholder="Nama depan" required>
        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="last_name" class="form-label">
            <i class="far fa-user" style="color: #5B7C99; margin-right: 8px; opacity: 0;"></i>
            Nama belakang
        </label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name) }}" placeholder="Nama belakang">
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Email -->
<div class="mb-3">
    <label for="email" class="form-label">
        <i class="far fa-envelope" style="color: #5B7C99; margin-right: 8px;"></i>
        Email
    </label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->email) }}" placeholder="Email">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Tipe Pengguna (Read only saat edit) -->
<div class="mb-3">
    <label for="userType" class="form-label">
        <i class="fas fa-id-card" style="color: #5B7C99; margin-right: 8px;"></i>
        Tipe Pengguna
    </label>
    <input type="text" class="form-control" id="userTypeInput" value="{{ $customer->user_type ?? 'Customer' }}" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
    <small class="text-muted">Tipe pengguna tidak dapat diubah setelah dibuat</small>
</div>

<!-- Izin mengemudi & Kategori SIM -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="id_number" class="form-label">
            <i class="far fa-id-card" style="color: #5B7C99; margin-right: 8px;"></i>
            Izin mengemudi
        </label>
        <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number" name="id_number" value="{{ old('id_number', $customer->id_number) }}" placeholder="Izin mengemudi">
        @error('id_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="license_category" class="form-label">
            <i class="far fa-id-card" style="color: #5B7C99; margin-right: 8px; opacity: 0;"></i>
            Kategori SIM
        </label>
        <input type="text" class="form-control @error('license_category') is-invalid @enderror" id="license_category" name="license_category" value="{{ old('license_category', $customer->license_category) }}" placeholder="Kategori SIM">
        @error('license_category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Masa berlaku izin mengemudi -->
<div class="mb-3">
    <label for="license_expiry" class="form-label">
        <i class="far fa-calendar" style="color: #5B7C99; margin-right: 8px;"></i>
        Masa berlaku izin mengemudi
    </label>
    <input type="date" class="form-control @error('license_expiry') is-invalid @enderror" id="license_expiry" name="license_expiry" value="{{ old('license_expiry', $customer->license_expiry ? $customer->license_expiry->format('Y-m-d') : '') }}" placeholder="DD/MM/YYYY">
    @error('license_expiry')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- No. Telepon -->
<div class="mb-3">
    <label for="phone" class="form-label">
        <i class="fas fa-phone" style="color: #5B7C99; margin-right: 8px;"></i>
        No. Telepon
    </label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="08123456789" required>
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Alamat -->
<div class="mb-3">
    <label for="address" class="form-label">
        <i class="fas fa-map-marker-alt" style="color: #5B7C99; margin-right: 8px;"></i>
        Alamat
    </label>
    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Alamat lengkap">{{ old('address', $customer->address) }}</textarea>
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Catatan -->
<div class="mb-3">
    <label for="notes" class="form-label">
        <i class="far fa-sticky-note" style="color: #5B7C99; margin-right: 8px;"></i>
        Catatan
    </label>
    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Catatan tambahan...">{{ old('notes', $customer->notes) }}</textarea>
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@endsection
