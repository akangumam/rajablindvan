@extends('layouts.drivvo')

@section('title', 'Pengaturan - Akun Saya')

@push('styles')
<style>
.settings-page-layout {
    display: flex;
    gap: 20px;
    padding: 20px;
}

.settings-page-sidebar {
    flex: 0 0 320px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    height: fit-content;
}

.settings-page-sidebar-header {
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.settings-page-sidebar-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #333;
}

.settings-page-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.settings-page-menu-item {
    border-bottom: 1px solid #f0f0f0;
}

.settings-page-menu-item:last-child {
    border-bottom: none;
}

.settings-page-menu-link {
    display: block;
    padding: 16px 20px;
    text-decoration: none;
    color: #333;
    font-size: 15px;
    transition: background 0.2s;
}

.settings-page-menu-link:hover {
    background: #f8f9fa;
    color: #333;
}

.settings-page-menu-link.active {
    background: #e7f3ff;
    color: #007bff;
    font-weight: 500;
}

.settings-page-content {
    flex: 1;
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.settings-page-content-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.settings-page-content-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.account-section {
    margin-bottom: 30px;
}

.account-section-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.account-field {
    margin-bottom: 20px;
}

.account-field-label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 6px;
    display: block;
}

.account-field-value {
    font-size: 15px;
    color: #007bff;
    text-decoration: none;
}

.account-field-value:hover {
    text-decoration: underline;
}

.btn-change-password {
    background: transparent;
    color: #007bff;
    border: none;
    padding: 10px 0;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.btn-change-password:hover {
    text-decoration: underline;
}

.btn-delete-account {
    background: transparent;
    color: #dc3545;
    border: 2px solid #dc3545;
    padding: 10px 32px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    font-size: 14px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-delete-account:hover {
    background: #dc3545;
    color: white;
}
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-cog"></i>
        Pengaturan
    </h1>
    <p class="page-subtitle">Konfigurasi preferensi aplikasi dan opsi format</p>
</div>

<div class="settings-page-layout">
    <div class="settings-page-sidebar">
        <div class="settings-page-sidebar-header">
            <h2 class="settings-page-sidebar-title">Pengaturan</h2>
        </div>
        <ul class="settings-page-menu">
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.format') }}" class="settings-page-menu-link">
                    <i class="fas fa-sliders-h" style="color: #667eea; font-size: 14px; margin-right: 12px;"></i>
                    Format Aplikasi
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.account') }}" class="settings-page-menu-link active">
                    <i class="fas fa-user-circle" style="color: #3498db; font-size: 14px; margin-right: 12px;"></i>
                    Akun Saya
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-page-menu-link">
                    <i class="fas fa-folder-open" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    File dan Penyimpanan
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.locations') }}" class="settings-page-menu-link">
                    <i class="fas fa-map-marker-alt" style="color: #e74c3c; font-size: 14px; margin-right: 12px;"></i>
                    Lokasi
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.service-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-wrench" style="color: #95a5a6; font-size: 14px; margin-right: 12px;"></i>
                    Jenis Services
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.expense-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-money-bill-wave" style="color: #e67e22; font-size: 14px; margin-right: 12px;"></i>
                    Jenis Pengeluaran
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.income-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-coins" style="color: #27ae60; font-size: 14px; margin-right: 12px;"></i>
                    Jenis Pendapatan
                </a>
            </li>
            @if(auth()->user()->hasRole(['super_admin']))
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.investors.index') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-tie" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    Investor
                </a>
            </li>
            @endif
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-page-menu-link">
                    <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 14px; margin-right: 12px;"></i>
                    Metode Pembayaran
                </a>
            </li>
        </ul>
    </div>

    <div class="settings-page-content">
        <div class="settings-page-content-header">
            <h1 class="settings-page-content-title">Akun Saya</h1>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="account-section">
            <h3 class="account-section-title">My Details</h3>
        <div class="account-section">
            <div class="account-field">
                <label class="account-field-label">1. Name</label>
                <a href="#" class="account-field-value">
                    {{ Auth::user()->name ?? (Auth::user()->first_name . ' ' . Auth::user()->last_name) }}
                </a>
            </div>

            <div class="account-field">
                <label class="account-field-label">2. Email</label>
                <a href="#" class="account-field-value">
                    {{ Auth::user()->email }}
                </a>
            </div>

            <div class="account-field">
                <label class="account-field-label">3. Position</label>
                <a href="#" class="account-field-value">{{ Auth::user()->title ?? '-' }}</a>
            </div>

            <div class="account-field">
                <label class="account-field-label">4. User Authorization / User Type</label>
                <a href="#" class="account-field-value">
                    @if(Auth::user()->role === 'super_admin')
                        Administrator
                    @elseif(Auth::user()->role === 'manager')
                        Sales
                    @elseif(Auth::user()->role === 'operator')
                        Operation
                    @else
                        {{ ucfirst(Auth::user()->role ?? Auth::user()->user_type ?? 'User') }}
                    @endif
                </a>
            </div>
        </div>

        <hr>

        <div class="account-section">
            <h3 class="account-section-title">Password</h3>
            <div class="account-field">
                <label class="account-field-label">5. Change Password</label>
                <button type="button" class="btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-key" style="margin-right: 8px;"></i>
                    CHANGE PASSWORD
                </button>
            </div>
        </div>

        <hr>

        @if(!Auth::user()->isSuperAdmin())
        <div class="account-section">
            <button type="button" class="btn-delete-account" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                <i class="fas fa-trash" style="margin-right: 8px;"></i>
                DELETE ACCOUNT
            </button>
            <p class="text-muted mt-2" style="font-size: 13px;">
                <i class="fas fa-info-circle"></i> This will permanently delete your account and all associated data.
            </p>
        </div>
        @else
        <div class="account-section">
            <div class="alert alert-warning">
                <i class="fas fa-shield-alt"></i>
                <strong>Administrator Protection:</strong> Administrator account cannot be deleted for security reasons.
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Change Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('settings.account.password') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Account -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning!</strong> This action cannot be undone.
                </div>
                <p>Are you sure you want to delete your account? All your data will be permanently deleted.</p>
                <form method="POST" action="#" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="passwordConfirm" class="form-label">Enter your password to confirm:</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">DELETE ACCOUNT</button>
            </div>
        </div>
    </div>
</div>

<style>
.modal {
    background: rgba(0,0,0,0.5);
}

.modal-content {
    border-radius: 8px;
}

.form-control {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 10px 15px;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
}

.btn-primary {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
}

.btn-danger {
    background: #dc3545;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffc107;
    color: #856404;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 15px;
}
</style>
@endsection






























