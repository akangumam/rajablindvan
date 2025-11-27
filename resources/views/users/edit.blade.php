@extends('layouts.drivvo-form', [
    'pageTitle' => 'Edit Pengguna',
    'pageSubtitle' => 'Perbarui informasi akun pengguna',
    'formAction' => route('users.update', $user),
    'formMethod' => 'PUT',
    'hideVehicleSelector' => true,
    'cancelRoute' => route('users.index')
])

@section('form-fields')
<!-- First Name -->
<div class="mb-4">
    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Masukkan nama depan" required>
    @error('first_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <!-- Last Name -->
    <div class="mb-4">
        <label class="form-label">Nama Belakang <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Masukkan nama belakang" required>
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" placeholder="user@example.com" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Title/Position -->
    <div class="mb-4">
        <label class="form-label">Jabatan/Posisi</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $user->title) }}" placeholder="Contoh: Manajer Penjualan, Direktur Operasional">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Role/Authorization -->
    <div class="mb-4">
        <label class="form-label">Tipe Pengguna/Otorisasi <span class="text-danger">*</span></label>
        <select class="form-control @error('role') is-invalid @enderror" name="role" required>
            <option value="">Pilih Tipe Pengguna</option>
            <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Administrator</option>
            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Sales</option>
            <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operation</option>
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">
            <strong>Administrator:</strong> Akses penuh ke semua fitur<br>
            <strong>Sales:</strong> Dapat mengelola kendaraan, sewa, dan laporan penjualan<br>
            <strong>Operation:</strong> Akses terbatas ke kendaraan yang ditugaskan dan operasional
        </small>
    </div>

    <!-- User Status -->
    <div class="mb-4">
        <label class="form-label">Status Pengguna <span class="text-danger">*</span></label>
        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
            <option value="active" {{ old('status', $user->status ?? ($user->is_active ? 'active' : 'inactive')) == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status', $user->status ?? ($user->is_active ? 'active' : 'inactive')) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password Reset Note -->
    @if(auth()->user()->isSuperAdmin())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Untuk mengubah password pengguna, gunakan fitur <a href="{{ route('users.reset-password-form', $user) }}" class="alert-link">Reset Password</a>.
    </div>
    @endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
    });
});
</script>
@endpush
