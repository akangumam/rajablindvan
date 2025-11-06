@extends('layouts.drivvo')

@section('title', 'Settings - Investors')

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
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: #333;
}
</style>
@endpush

@section('content')
<div class="settings-page-layout">
    <!-- Sidebar Menu -->
    <div class="settings-page-sidebar">
        <div class="settings-page-sidebar-header">
            <h2 class="settings-page-sidebar-title">Settings</h2>
        </div>
        <ul class="settings-page-menu">
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.format') }}" class="settings-page-menu-link">
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
                    Types of Service
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
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.investors.index') }}" class="settings-page-menu-link active">
                    <i class="fas fa-user-tie" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    Investors
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-page-menu-link">
                    <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 14px; margin-right: 12px;"></i>
                    Payment Methods
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="settings-page-content">
        <div class="settings-page-content-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="settings-page-content-title">{{ __('common.investors') }}</h1>
                <a href="{{ route('settings.investors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('common.add_investor') }}
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Investor Name</th>
                        <th>Vehicles Count</th>
                        <th>Profit Share</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investors as $investor)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $investor->name }}</div>
                                @if($investor->id_number)
                                    <small class="text-muted">{{ $investor->id_number }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="fas fa-car"></i> {{ $investor->vehicles_count }} Unit
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $investor->investment_percentage }}%</span>
                            </td>
                            <td>
                                @if($investor->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('settings.investors.show', $investor) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="View Report">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="{{ route('settings.investors.edit', $investor) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('settings.investors.destroy', $investor) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this investor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-info-circle"></i> No investors data yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($investors->hasPages())
            <div class="mt-3">
                {{ $investors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection