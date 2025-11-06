@extends('layouts.drivvo')

@section('title', 'Pengaturan')

@push('styles')
<style>
* {
    box-sizing: border-box;
}

body {
    background-color: #f8f9fa;
    overflow-x: hidden;
    width: 100%;
}

.page-header {
    overflow-x: hidden;
    width: 100%;
    max-width: 100%;
}

.page-title {
    overflow-x: hidden;
    word-wrap: break-word;
}

.page-subtitle {
    overflow-x: hidden;
    word-wrap: break-word;
}

.settings-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    width: 100%;
    overflow-x: hidden;
}

.settings-header {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.settings-header h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.settings-count {
    color: #6c757d;
    font-size: 18px;
}

.settings-section {
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.settings-section-title {
    padding: 16px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    font-weight: 600;
    font-size: 14px;
    color: #495057;
}

.settings-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.settings-item {
    border-bottom: 1px solid #f0f0f0;
}

.settings-item:last-child {
    border-bottom: none;
}

.settings-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    text-decoration: none;
    color: #333;
    transition: background 0.2s;
}

.settings-link:hover {
    background: #f8f9fa;
    color: #333;
}

.settings-link-content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.settings-number {
    width: 24px;
    font-weight: 500;
    color: #6c757d;
    font-size: 14px;
    flex-shrink: 0;
}

.settings-label {
    font-size: 15px;
    flex: 1;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.settings-link-content i {
    flex-shrink: 0;
}

.settings-arrow {
    color: #6c757d;
    font-size: 18px;
}

.settings-note {
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.settings-note-title {
    font-weight: 400;
    margin-bottom: 8px;
    font-size: 14px;
    color: #333;
}

.settings-note-text {
    font-size: 14px;
    color: #333;
    line-height: 1.8;
    margin: 0;
}

/* Mobile Responsive Styles */
@media (max-width: 768px) {
    html {
        overflow-x: hidden;
        width: 100%;
    }

    body {
        overflow-x: hidden;
        width: 100%;
    }

    .main-content {
        width: 100% !important;
        max-width: 100vw !important;
        margin-left: 0 !important;
        padding: 15px 10px !important;
        overflow-x: hidden !important;
    }

    .page-header {
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 20px 15px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .page-title {
        font-size: 22px !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }

    .page-subtitle {
        font-size: 14px !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }

    .settings-container {
        padding: 10px;
        max-width: 100%;
        width: 100%;
        overflow-x: hidden;
    }

    .settings-header {
        padding: 15px;
        margin-bottom: 15px;
        overflow-x: hidden;
    }

    .settings-header h4 {
        font-size: 16px;
        word-wrap: break-word;
    }

    .settings-count {
        font-size: 16px;
    }

    .settings-section {
        margin-bottom: 15px;
        overflow-x: hidden;
    }

    .settings-section-title {
        padding: 12px 15px;
        font-size: 13px;
    }

    .settings-item {
        overflow-x: hidden;
    }

    .settings-link {
        padding: 14px 15px;
        overflow-x: hidden;
    }

    .settings-link-content {
        gap: 10px;
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }

    .settings-number {
        width: 20px;
        font-size: 13px;
        flex-shrink: 0;
    }

    .settings-label {
        font-size: 14px;
        white-space: normal;
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.4;
    }

    .settings-link-content i {
        font-size: 14px !important;
        flex-shrink: 0;
    }

    .settings-arrow {
        font-size: 16px;
        flex-shrink: 0;
    }

    .settings-note {
        padding: 15px;
        overflow-x: hidden;
    }

    .settings-note-title {
        font-size: 13px;
        margin-bottom: 10px;
        word-wrap: break-word;
    }

    .settings-note-text {
        font-size: 13px;
        line-height: 1.6;
        word-wrap: break-word;
    }
}

@media (max-width: 480px) {
    .settings-container {
        padding: 5px;
    }

    .settings-header {
        padding: 12px;
    }

    .settings-header h4 {
        font-size: 15px;
    }

    .settings-link {
        padding: 12px;
    }

    .settings-label {
        font-size: 13px;
    }

    .settings-note {
        padding: 12px;
    }
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

<div class="settings-container">
    <!-- Header -->
    <div class="settings-header">
        <h4>Pengaturan <span class="settings-count">- (9)</span></h4>
    </div>

    <!-- Section 1-3: Apps Pengaturan -->
    <div class="settings-section">
        <ul class="settings-list">
            <li class="settings-item">
                <a href="{{ route('settings.format') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">1.</span>
                        <i class="fas fa-sliders-h" style="color: #667eea; font-size: 16px;"></i>
                        <span class="settings-label">Format Aplikasi</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.account') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">2.</span>
                        <i class="fas fa-user-circle" style="color: #3498db; font-size: 16px;"></i>
                        <span class="settings-label">Akun Saya</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">3.</span>
                        <i class="fas fa-folder-open" style="color: #f39c12; font-size: 16px;"></i>
                        <span class="settings-label">File dan Penyimpanan</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Selection List Section -->
    <div class="settings-section">
        <div class="settings-section-title">Selection List</div>
        <ul class="settings-list">
            <li class="settings-item">
                <a href="{{ route('settings.locations') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">4.</span>
                        <i class="fas fa-map-marker-alt" style="color: #e74c3c; font-size: 16px;"></i>
                        <span class="settings-label">Tempat</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.service-types') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">5.</span>
                        <i class="fas fa-wrench" style="color: #95a5a6; font-size: 16px;"></i>
                        <span class="settings-label">Jenis Service</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.expense-types') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">6.</span>
                        <i class="fas fa-money-bill-wave" style="color: #e67e22; font-size: 16px;"></i>
                        <span class="settings-label">Jenis Pengeluaran</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.income-types') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">7.</span>
                        <i class="fas fa-coins" style="color: #27ae60; font-size: 16px;"></i>
                        <span class="settings-label">Jenis Pendapatan</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.investors.index') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">8.</span>
                        <i class="fas fa-user-tie" style="color: #f39c12; font-size: 16px;"></i>
                        <span class="settings-label">Investor</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">9.</span>
                        <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 16px;"></i>
                        <span class="settings-label">Metode Pembayaran</span>
                    </div>
                    <i class="fas fa-chevron-right Pengaturan-arrow"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Note Section -->
    <div class="settings-note">
        <div class="settings-note-title">
            Pada sub menu kategori Selection List terdiri atas beberapa fungsi sbb:
        </div>
        <div class="settings-note-text">
            - TAMBAH BARU<br>
            - Edit<br>
            - Delete
        </div>
    </div>
</div>
@endsection






























