@extends('layouts.drivvo-form', [
    'pageTitle' => 'Tambah Pengguna Baru',
    'pageSubtitle' => 'Buat akun pengguna baru',
    'formAction' => route('users.store'),
    'formMethod' => 'POST',
    'hideVehicleSelector' => true,
    'cancelRoute' => route('users.index')
])

@section('form-fields')
<!-- First Name -->
<div class="mb-4">
    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Masukkan nama depan" required>
    @error('first_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <!-- Last Name -->
    <div class="mb-4">
        <label class="form-label">Nama Belakang <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Masukkan nama belakang" required>
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="user@example.com" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Title/Position -->
    <div class="mb-4">
        <label class="form-label">Jabatan/Posisi</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="Contoh: Manajer Penjualan, Direktur Operasional">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Role/Authorization -->
    <div class="mb-4">
        <label class="form-label">Tipe Pengguna/Otorisasi <span class="text-danger">*</span></label>
        <select class="form-control @error('role') is-invalid @enderror" name="role" required>
            <option value="">Pilih Tipe Pengguna</option>
            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Administrator</option>
            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Sales</option>
            <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operation</option>
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

    <!-- Password -->
    <div class="mb-4">
        <label class="form-label">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Minimal 8 karakter" required minlength="8">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Password minimal 8 karakter</small>
    </div>

    <!-- Password Confirmation -->
    <div class="mb-4">
        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Ulangi password" required minlength="8">
        @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- User Status -->
    <div class="mb-4">
        <label class="form-label">Status Pengguna <span class="text-danger">*</span></label>
        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.querySelector('input[name="password"]');
    const passwordConfirmation = document.querySelector('input[name="password_confirmation"]');
    
    // Password strength indicator
    password.addEventListener('input', function() {
        const value = this.value;
        let strength = 0;
        
        if (value.length >= 8) strength++;
        if (value.match(/[a-z]/)) strength++;
        if (value.match(/[A-Z]/)) strength++;
        if (value.match(/[0-9]/)) strength++;
        if (value.match(/[^a-zA-Z0-9]/)) strength++;
        
        // You can add visual feedback here
    });
    
    // Password match validation
    form.addEventListener('submit', function(e) {
        if (password.value !== passwordConfirmation.value) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak cocok!');
            passwordConfirmation.focus();
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat...';
    });
});
</script>
@endpush
