@extends('layouts.drivvo')

@section('title', 'Settings')

@push('styles')
<style>
body {
    background-color: #f8f9fa;
}

.settings-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
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
}

.settings-number {
    width: 24px;
    font-weight: 500;
    color: #6c757d;
    font-size: 14px;
}

.settings-label {
    font-size: 15px;
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
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-cog"></i>
        Settings
    </h1>
    <p class="page-subtitle">Configure your application preferences and formatting options</p>
</div>

<div class="settings-container">
    <!-- Header -->
    <div class="settings-header">
        <h4>SETTINGS <span class="settings-count">- (9)</span></h4>
    </div>

    <!-- Section 1-3: Apps Settings -->
    <div class="settings-section">
        <ul class="settings-list">
            <li class="settings-item">
                <a href="{{ route('settings.format') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">1.</span>
                        <i class="fas fa-sliders-h" style="color: #667eea; font-size: 16px;"></i>
                        <span class="settings-label">Apps Format</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.account') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">2.</span>
                        <i class="fas fa-user-circle" style="color: #3498db; font-size: 16px;"></i>
                        <span class="settings-label">My Account</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">3.</span>
                        <i class="fas fa-folder-open" style="color: #f39c12; font-size: 16px;"></i>
                        <span class="settings-label">File and Storage</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
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
                        <span class="settings-label">Place</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.service-types') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">5.</span>
                        <i class="fas fa-wrench" style="color: #95a5a6; font-size: 16px;"></i>
                        <span class="settings-label">Types of Service</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.expense-types') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">6.</span>
                        <i class="fas fa-money-bill-wave" style="color: #e67e22; font-size: 16px;"></i>
                        <span class="settings-label">Type of Expense</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.income-types') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">7.</span>
                        <i class="fas fa-coins" style="color: #27ae60; font-size: 16px;"></i>
                        <span class="settings-label">Type of Income</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.investors.index') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">8.</span>
                        <i class="fas fa-user-tie" style="color: #f39c12; font-size: 16px;"></i>
                        <span class="settings-label">Investors</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
                </a>
            </li>
            <li class="settings-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-link">
                    <div class="settings-link-content">
                        <span class="settings-number">9.</span>
                        <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 16px;"></i>
                        <span class="settings-label">Payment Methods</span>
                    </div>
                    <i class="fas fa-chevron-right settings-arrow"></i>
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
            - Add New<br>
            - Edit<br>
            - Delete
        </div>
    </div>
</div>
@endsection






























