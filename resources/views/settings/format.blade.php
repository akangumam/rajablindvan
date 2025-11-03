@extends('layouts.drivvo')

@section('title', 'Settings - Format')

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

.settings-page-section {
    margin-bottom: 30px;
}

.settings-page-section-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.settings-page-field {
    margin-bottom: 20px;
}

.settings-page-field-label {
    display: block;
    font-size: 15px;
    font-weight: 500;
    color: #333;
    margin-bottom: 10px;
}

.settings-page-select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 15px;
    color: #333;
    background-color: white;
    cursor: pointer;
}

.settings-page-format-example {
    font-size: 14px;
    color: #007bff;
    margin-top: 5px;
}

.btn-primary {
    background: #007bff;
    color: white;
    border: none;
    padding: 12px 40px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    font-size: 14px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #0056b3;
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

.alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 1rem;
    background: transparent;
    border: 0;
    cursor: pointer;
}

.settings-page-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
}

.settings-page-toggle-switch {
    position: relative;
    width: 50px;
    height: 28px;
    background: #ccc;
    border-radius: 28px;
    cursor: pointer;
    transition: background 0.3s;
}

.settings-page-toggle-switch.active {
    background: #007bff;
}

.settings-page-toggle-switch::after {
    content: '';
    position: absolute;
    width: 24px;
    height: 24px;
    background: white;
    border-radius: 50%;
    top: 2px;
    left: 2px;
    transition: left 0.3s;
}

.settings-page-toggle-switch.active::after {
    left: 24px;
}

.settings-page-toggle-label {
    font-size: 15px;
    color: #333;
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

<div class="settings-page-layout">
    <div class="settings-page-sidebar">
        <div class="settings-page-sidebar-header">
            <h2 class="settings-page-sidebar-title">Settings</h2>
        </div>
        <ul class="settings-page-menu">
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.format') }}" class="settings-page-menu-link active">
                    <i class="fas fa-sliders-h" style="color: #667eea; font-size: 14px; margin-right: 12px;"></i>
                    Apps Format
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.account') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-circle" style="color: #3498db; font-size: 14px; margin-right: 12px;"></i>
                    My Account
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-page-menu-link">
                    <i class="fas fa-folder-open" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    File and Storage
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.locations') }}" class="settings-page-menu-link">
                    <i class="fas fa-map-marker-alt" style="color: #e74c3c; font-size: 14px; margin-right: 12px;"></i>
                    Place
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.service-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-wrench" style="color: #95a5a6; font-size: 14px; margin-right: 12px;"></i>
                    Type of Services
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.expense-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-money-bill-wave" style="color: #e67e22; font-size: 14px; margin-right: 12px;"></i>
                    Type of Expense
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.income-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-coins" style="color: #27ae60; font-size: 14px; margin-right: 12px;"></i>
                    Type of Income
                </a>
            </li>
            @if(auth()->user()->hasRole(['super_admin']))
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.investors.index') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-tie" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    Investors
                </a>
            </li>
            @endif
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-page-menu-link">
                    <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 14px; margin-right: 12px;"></i>
                    Payment Methods
                </a>
            </li>
        </ul>
    </div>

    <div class="settings-page-content">
        <div class="settings-page-content-header">
            <h1 class="settings-page-content-title">Format</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('settings.format.save') }}" method="POST">
            @csrf
            
            <div class="settings-page-section">
                <h3 class="settings-page-section-title">Format Tanggal</h3>
                <div class="settings-page-field">
                    <label class="settings-page-field-label" for="date_format">Date Format</label>
                    <select id="date_format" name="date_format" class="settings-page-select">
                        <option value="d/m/Y" {{ $dateFormat == 'd/m/Y' ? 'selected' : '' }}>14/10/2025</option>
                        <option value="m/d/Y" {{ $dateFormat == 'm/d/Y' ? 'selected' : '' }}>10/14/2025</option>
                        <option value="Y-m-d" {{ $dateFormat == 'Y-m-d' ? 'selected' : '' }}>2025-10-14</option>
                        <option value="d-m-Y" {{ $dateFormat == 'd-m-Y' ? 'selected' : '' }}>14-10-2025</option>
                        <option value="d.m.Y" {{ $dateFormat == 'd.m.Y' ? 'selected' : '' }}>14.10.2025</option>
                        <option value="d M Y" {{ $dateFormat == 'd M Y' ? 'selected' : '' }}>14 Oct 2025</option>
                        <option value="d F Y" {{ $dateFormat == 'd F Y' ? 'selected' : '' }}>14 October 2025</option>
                        <option value="l, d F Y" {{ $dateFormat == 'l, d F Y' ? 'selected' : '' }}>Tuesday, 14 October 2025</option>
                        <option value="D, d M Y" {{ $dateFormat == 'D, d M Y' ? 'selected' : '' }}>Tue, 14 Oct 2025</option>
                        <option value="F d, Y" {{ $dateFormat == 'F d, Y' ? 'selected' : '' }}>October 14, 2025</option>
                        <option value="M d, Y" {{ $dateFormat == 'M d, Y' ? 'selected' : '' }}>Oct 14, 2025</option>
                        <option value="l, F d, Y" {{ $dateFormat == 'l, F d, Y' ? 'selected' : '' }}>Tuesday, October 14, 2025</option>
                    </select>
                    <div class="settings-page-format-example" id="dateExample">14/10/2025</div>
                </div>
            </div>

            <div class="settings-page-section">
                <h3 class="settings-page-section-title">Currency</h3>
                <div class="settings-page-field">
                    <label class="settings-page-field-label" for="currency_format">Currency Format</label>
                    <select id="currency_format" name="currency_format" class="settings-page-select">
                        <option value="idr" {{ $currencyFormat == 'idr' ? 'selected' : '' }}>Rp 1.000,00</option>
                        <option value="usd" {{ $currencyFormat == 'usd' ? 'selected' : '' }}>$ 1,000.00</option>
                    </select>
                    <div class="settings-page-format-example" id="currencyExample">Rp 1.000,00</div>
                </div>
            </div>

            <div class="settings-page-section">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>SAVE
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateFormatSelect = document.getElementById('date_format');
    const dateExample = document.getElementById('dateExample');
    
    // Format examples untuk setiap option
    const dateFormats = {
        'd/m/Y': '14/10/2025',
        'm/d/Y': '10/14/2025',
        'Y-m-d': '2025-10-14',
        'd-m-Y': '14-10-2025',
        'd.m.Y': '14.10.2025',
        'd M Y': '14 Oct 2025',
        'd F Y': '14 October 2025',
        'l, d F Y': 'Tuesday, 14 October 2025',
        'D, d M Y': 'Tue, 14 Oct 2025',
        'F d, Y': 'October 14, 2025',
        'M d, Y': 'Oct 14, 2025',
        'l, F d, Y': 'Tuesday, October 14, 2025'
    };
    
    // Set initial preview
    if (dateFormatSelect && dateExample) {
        dateExample.textContent = dateFormats[dateFormatSelect.value] || '14/10/2025';
        
        dateFormatSelect.addEventListener('change', function() {
            const selectedFormat = this.value;
            dateExample.textContent = dateFormats[selectedFormat] || '14/10/2025';
        });
    }
    
    const currencyFormatSelect = document.getElementById('currency_format');
    const currencyExample = document.getElementById('currencyExample');
    
    // Set initial preview
    if (currencyFormatSelect && currencyExample) {
        currencyExample.textContent = currencyFormatSelect.value === 'usd' ? '$ 1,000.00' : 'Rp 1.000,00';
        
        currencyFormatSelect.addEventListener('change', function() {
            const selectedFormat = this.value;
            currencyExample.textContent = selectedFormat === 'usd' ? '$ 1,000.00' : 'Rp 1.000,00';
        });
    }
});
</script>
@endsection
