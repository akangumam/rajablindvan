@extends('layouts.drivvo')

@section('title', 'Pengaturan - Akun saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-gear-fill text-primary me-2"></i>
                        Pengaturan
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <!-- Sub-menu Pengaturan -->
                    <a href="{{ route('settings.units') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-speedometer2 text-muted me-2"></i>
                        Satuan
                    </a>
                    <a href="{{ route('settings.reminders') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-bell text-muted me-2"></i>
                        Pengingat
                    </a>
                    <a href="{{ route('settings.format') }}" class="list-group-item list-group-item-action ps-4">
                        <i class="bi bi-calendar3 text-muted me-2"></i>
                        Format
                    </a>
                    
                    <!-- Divider -->
                    <div class="list-group-item bg-light py-1"></div>
                    
                    <a href="{{ route('settings.account') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-person-circle text-primary me-2"></i>
                        Akun saya
                    </a>
                    <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark-text text-muted me-2"></i>
                        File dan penyimpanan
                    </a>
                    <a href="{{ route('settings.fuel-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-fuel-pump text-muted me-2"></i>
                        Bahan bakar
                    </a>
                    <a href="{{ route('settings.fuel-stations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop text-muted me-2"></i>
                        Spbu
                    </a>
                    <a href="{{ route('settings.locations') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt text-muted me-2"></i>
                        Lokasi
                    </a>
                    <a href="{{ route('settings.service-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wrench text-muted me-2"></i>
                        Jenis layanan
                    </a>
                    <a href="{{ route('settings.expense-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-wallet2 text-muted me-2"></i>
                        Jenis biaya
                    </a>
                    <a href="{{ route('settings.income-types') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-cash-stack text-muted me-2"></i>
                        Jenis pendapatan
                    </a>
                    <a href="{{ route('settings.reasons') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-briefcase text-muted me-2"></i>
                        Alasan
                    </a>
                    <a href="{{ route('settings.payment-methods') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-credit-card text-muted me-2"></i>
                        Cara Pembayaran
                    </a>
                    <a href="{{ route('settings.forms') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark text-muted me-2"></i>
                        Formulir
                    </a>
                    <a href="{{ route('settings.contacts') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-envelope text-muted me-2"></i>
                        Menghubungi
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Akun saya</h5>
                </div>
                <div class="card-body">
                   

                    <!-- Rincianku -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Rincianku</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Nama</label>
                            <div>
                                <a href="#" class="text-primary text-decoration-none">
                                    {{ auth()->user()->name ?? 'Khaerul Umam' }}
                                </a>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <div>
                                <a href="#" class="text-primary text-decoration-none">
                                    {{ auth()->user()->email ?? 'napsterweb.id@gmail.com' }}
                                </a>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Izin mengemudi</label>
                            <div>
                                <a href="#" class="text-primary text-decoration-none">Daftar</a>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Masa berlaku izin mengemudi</label>
                            <div>
                                <a href="#" class="text-primary text-decoration-none">Daftar</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Kata kunci -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Kata kunci</h6>
                        <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key me-2"></i>GANTI KATA KUNCI
                        </a>
                    </div>

                    <hr>

                    <!-- Hapus Akun -->
                    <div class="mt-4">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash me-2"></i>HAPUS AKUN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ganti Kata Kunci</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Kata Kunci Lama</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Kata Kunci Baru</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Konfirmasi Kata Kunci Baru</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
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

<!-- Modal Hapus Akun -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">Hapus Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Pengingat!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p>Apakah Anda yakin ingin menghapus akun Anda? Semua data Anda akan dihapus secara permanen.</p>
                <form method="POST" action="#" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="passwordConfirm" class="form-label">Masukkan kata kunci Anda untuk konfirmasi:</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">Hapus Akun</button>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item-action:hover {
    background-color: #f8f9fa;
}
.list-group-item-action.active {
    background-color: #e7f3ff;
    border-left: 3px solid #0d6efd;
    color: #0d6efd;
}
</style>
@endsection
