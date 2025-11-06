@extends('layouts.drivvo')

@section('title', 'Pengaturan - File dan Penyimpanan')

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

.storage-section {
    margin-bottom: 30px;
}

.storage-field {
    margin-bottom: 20px;
}

.storage-field-label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 6px;
    display: block;
}

.storage-field-value {
    font-size: 15px;
    color: #333;
    font-weight: 500;
}

.storage-usage {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.storage-usage-title {
    font-size: 15px;
    color: #6c757d;
    margin-bottom: 10px;
}

.storage-usage-bar {
    height: 10px;
    background: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
}

.storage-usage-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    transition: width 0.3s;
}

.storage-usage-text {
    font-size: 14px;
    color: #333;
    font-weight: 500;
}

.file-list {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.file-list-header {
    background: #f8f9fa;
    padding: 12px 20px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.file-list-item {
    padding: 15px 20px;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.2s;
}

.file-list-item:hover {
    background: #f8f9fa;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.file-icon {
    width: 40px;
    height: 40px;
    background: #e7f3ff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
    font-size: 18px;
}

.file-details {
    display: flex;
    flex-direction: column;
}

.file-name {
    font-size: 14px;
    color: #333;
    font-weight: 500;
}

.file-meta {
    font-size: 12px;
    color: #6c757d;
}

.file-actions {
    display: flex;
    gap: 10px;
}

.btn-download {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-download:hover {
    background: #0056b3;
    color: white;
}

.btn-delete {
    background: transparent;
    color: #dc3545;
    border: 1px solid #dc3545;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-delete:hover {
    background: #dc3545;
    color: white;
}

.action-section {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #e9ecef;
}

.action-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #6c757d;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 1rem;
    background: transparent;
    border: 0;
    cursor: pointer;
    font-size: 1.5rem;
    opacity: 0.5;
}

.alert-dismissible .btn-close:hover {
    opacity: 1;
}

.form-control {
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 10px 15px;
    font-size: 14px;
}

.form-control:focus {
    border-color: #007bff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.text-danger {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    display: block;
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
                <a href="{{ route('settings.account') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-circle" style="color: #3498db; font-size: 14px; margin-right: 12px;"></i>
                    Akun Saya
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-page-menu-link active">
                    <i class="fas fa-folder-open" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    File dan Penyimpanan
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.locations') }}" class="settings-page-menu-link">
                    <i class="fas fa-map-marker-alt" style="color: #e74c3c; font-size: 14px; margin-right: 12px;"></i>
                    Tempat
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
            <h1 class="settings-page-content-title">File dan Penyimpanan</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="storage-section">
            <!-- Upload Form Section -->
            <div class="storage-field">
                <label class="storage-field-label">1. Upload New File</label>
                <form action="{{ route('settings.file-storage.upload') }}" method="POST" enctype="multipart/form-data" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Select File</label>
                            <input type="file" name="file" class="form-control" required accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="fuel">Fuel</option>
                                <option value="expense">Expense</option>
                                <option value="income">Income</option>
                                <option value="service">Service</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control">Upload</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="storage-field">
                <label class="storage-field-label">2. Total Storage Usage</label>
                <div class="storage-usage">
                    <div class="storage-usage-title">Using {{ number_format($usedStorageMB, 0) }} MB ({{ number_format($usagePercentage, 0) }}%) of {{ number_format($storageLimitMB, 0) }} MB</div>
                    <div class="storage-usage-bar">
                        <div class="storage-usage-fill" style="width: {{ min($usagePercentage, 100) }}%; background: linear-gradient(90deg, 
                            #ff9500 0%, 
                            #ff9500 {{ $categoryStats['fuel']['percentage'] }}%, 
                            #ff5722 {{ $categoryStats['fuel']['percentage'] }}%, 
                            #ff5722 {{ $categoryStats['fuel']['percentage'] + $categoryStats['expense']['percentage'] }}%, 
                            #4caf50 {{ $categoryStats['fuel']['percentage'] + $categoryStats['expense']['percentage'] }}%, 
                            #4caf50 {{ $categoryStats['fuel']['percentage'] + $categoryStats['expense']['percentage'] + $categoryStats['income']['percentage'] }}%, 
                            #795548 {{ $categoryStats['fuel']['percentage'] + $categoryStats['expense']['percentage'] + $categoryStats['income']['percentage'] }}%, 
                            #795548 100%);"></div>
                    </div>
                    
                    <!-- Category Legend -->
                    <div class="storage-legend" style="margin-top: 15px; display: flex; flex-wrap: wrap; gap: 15px;">
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 16px; height: 16px; background: #ff9500; border-radius: 3px; display: inline-block;"></span>
                            <span style="font-size: 13px; color: #666;">Fuel ({{ number_format($categoryStats['fuel']['size'], 0) }} MB)</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 16px; height: 16px; background: #ff5722; border-radius: 3px; display: inline-block;"></span>
                            <span style="font-size: 13px; color: #666;">Expense ({{ number_format($categoryStats['expense']['size'], 0) }} MB)</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 16px; height: 16px; background: #4caf50; border-radius: 3px; display: inline-block;"></span>
                            <span style="font-size: 13px; color: #666;">Income ({{ number_format($categoryStats['income']['size'], 0) }} MB)</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 16px; height: 16px; background: #795548; border-radius: 3px; display: inline-block;"></span>
                            <span style="font-size: 13px; color: #666;">Service ({{ number_format($categoryStats['service']['size'], 0) }} MB)</span>
                        </div>
                        <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 16px; height: 16px; background: #e9ecef; border-radius: 3px; display: inline-block; border: 1px solid #dee2e6;"></span>
                            <span style="font-size: 13px; color: #666;">Unused ({{ number_format($unusedMB, 0) }} MB)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="storage-field">
                <label class="storage-field-label">3. List Uploaded File</label>
                <div class="file-list">
                    <div class="file-list-header">Uploaded Files ({{ $files->count() }})</div>
                    
                    @forelse($files as $file)
                    <div class="file-list-item">
                        <div class="file-info">
                            <div class="file-icon">
                                <i class="fas {{ $file->file_icon }}"></i>
                            </div>
                            <div class="file-details">
                                <div class="file-name">{{ $file->original_name }}</div>
                                <div class="file-meta">
                                    {{ ucfirst($file->file_type) }} • {{ $file->file_size_formatted }} • Uploaded on {{ $file->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="file-actions">
                            <a href="{{ route('settings.file-storage.download', $file->id) }}" class="btn-download">
                                <i class="fas fa-download me-1"></i> DOWNLOAD
                            </a>
                            <form action="{{ route('settings.file-storage.delete', $file->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div>No files uploaded yet. Upload your first file above!</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if($files->count() > 0)
        <div class="action-section">
            <h3 class="action-title">ACTION : Download File</h3>
            <a href="{{ route('settings.file-storage.download-all') }}" class="btn-download" style="padding: 12px 32px;">
                <i class="fas fa-download me-2"></i> DOWNLOAD ALL FILES
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
