@extends('layouts.drivvo')

@section('title', 'Pengaturan - Format')

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
                    <a href="{{ route('settings.format') }}" class="list-group-item list-group-item-action ps-4 active">
                        <i class="bi bi-calendar3 text-primary me-2"></i>
                        Format
                    </a>
                    
                    <!-- Divider -->
                    <div class="list-group-item bg-light py-1"></div>
                    
                    <a href="{{ route('settings.account') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-circle text-muted me-2"></i>
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
                    <h5 class="mb-0">Format</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        
                        <!-- Terjemahan -->
                        <div class="mb-4">
                            <label for="language" class="form-label fw-bold">Terjemahan</label>
                            <select class="form-select" id="language" name="language">
                                <option value="id" selected>🇮🇩 Bahasa Indonesia</option>
                                <option value="en">🇬🇧 English</option>
                                <option value="ar">🇸🇦 العربية</option>
                                <option value="zh">🇨🇳 中文</option>
                            </select>
                        </div>

                        <hr>

                        <!-- Format tanggal -->
                        <div class="mb-4">
                            <label for="dateFormat" class="form-label fw-bold">Format tanggal</label>
                            <select class="form-select" id="dateFormat" name="date_format">
                                <option value="d/m/Y" selected>14/10/2025</option>
                                <option value="m/d/Y">10/14/2025</option>
                                <option value="Y-m-d">2025-10-14</option>
                                <option value="d-m-Y">14-10-2025</option>
                            </select>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> 14/10/2025
                            </a>
                        </div>

                        <hr>

                        <!-- Format mata uang -->
                        <div class="mb-4">
                            <label for="currencyFormat" class="form-label fw-bold">Format mata uang</label>
                            <select class="form-select" id="currencyFormat" name="currency_format">
                                <option value="idr" selected>Rp 1.000,00</option>
                                <option value="usd">$ 1,000.00</option>
                                <option value="eur">€ 1.000,00</option>
                                <option value="gbp">£ 1,000.00</option>
                            </select>
                            <a href="#" class="text-primary text-decoration-none small mt-1 d-inline-block">
                                <i class="bi bi-link-45deg"></i> Rp 1.000,00
                            </a>
                        </div>

                        <hr>

                        <!-- Tampilkan tiga angka desimal -->
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Tampilkan tiga angka desimal</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="threeDecimal" name="three_decimal">
                                <label class="form-check-label" for="threeDecimal">
                                    Nonaktif
                                </label>
                            </div>
                        </div>

                        <hr>

                        <!-- Tampilkan angka desimal -->
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Tampilkan angka desimal</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="decimal" name="decimal" checked>
                                <label class="form-check-label" for="decimal">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
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
