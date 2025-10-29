@extends('layouts.drivvo')

@section('title', 'Data Pengguna')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .page-title i {
        font-size: 28px;
        color: #007bff;
    }
    .page-subtitle {
        font-size: 15px;
        color: #7f8c8d;
        margin: 0;
        font-weight: 400;
    }
    .btn-add-user {
        background: white;
        border: 2px solid #3498db;
        color: #3498db;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .btn-add-user:hover {
        background: #3498db;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .user-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .user-table {
        width: 100%;
        margin: 0;
    }
    .user-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .user-table thead th {
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: capitalize;
        letter-spacing: 0.5px;
        border: none;
    }
    .sortable-header {
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .sortable-header:hover {
        color: #3498db;
    }
    .sort-icon {
        font-size: 10px;
        transition: transform 0.2s ease;
    }
    .user-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    .user-table tbody tr:last-child td {
        border-bottom: none;
    }
    .user-table tbody tr:hover {
        background: #f8f9fa;
    }
    .user-name {
        font-weight: 600;
        color: #333;
        font-size: 15px;
    }
    .user-Email {
        color: #666;
        font-size: 14px;
    }
    .badge-type {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .badge-pengelola {
        background: #e3f2fd;
        color: #1976d2;
    }
    .badge-driver {
        background: #fff3e0;
        color: #f57c00;
    }
    .Status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .Status-Active {
        background: #d4edda;
        color: #155724;
    }
    .Status-nonActive {
        background: #f8d7da;
        color: #721c24;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    .action-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
        background: #3498db;
        color: white;
    }
    .action-icon-btn:hover {
        background: #2980b9;
        transform: translateY(-1px);
    }
    .action-icon-btn.btn-edit {
        background: #3498db;
    }
    .action-icon-btn.btn-edit:hover {
        background: #2980b9;
    }
    .action-icon-btn.btn-delete {
        background: #e74c3c;
    }
    .action-icon-btn.btn-delete:hover {
        background: #c0392b;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .empty-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }
    .empty-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }
    .empty-description {
        font-size: 15px;
        color: #999;
        margin-bottom: 24px;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-users"></i>
            Customers
        </h1>
        <p class="page-subtitle">Manage customer information and contact details</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn-add-user">
        {{ strtoupper(__('common.add_new')) }}
    </a>
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

@if($customers->count() > 0)
<div class="user-table-container">
    <table class="user-table">
        <thead>
            <tr>
                <th>
                    <span class="sortable-header">
                        # Name
                        <i class="fas fa-sort sort-icon"></i>
                    </span>
                </th>
                <th>Email</th>
                <th>Tipe Pengguna</th>
                <th>Masa berlaku izin mengemudi</th>
                <th>Vehicle / Pengguna</th>
                <th>Active</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
            @php
                $user = \App\Models\User::where('Email', $customer->Email)->first();
                $userType = $user ? $user->user_type : 'Customer';
                $assignedVehicles = $user ? $user->vehicles()->count() : 0;
            @endphp
            <tr>
                <td>
                    <div class="user-name">{{ $index + 1 }}. {{ $customer->name }}</div>
                </td>
                <td>
                    <div class="user-Email">{{ $customer->Email ?? '-' }}</div>
                </td>
                <td>
                    @if($userType == 'Pengelola')
                        <span class="badge-type badge-pengelola">Administrator</span>
                    @elseif($userType == 'driver')
                        <span class="badge-type badge-driver">driver</span>
                    @else
                        <span class="badge-type" style="background: #f5f5f5; color: #666;">Customer</span>
                    @endif
                </td>
                <td>
                    <div style="color: #666;">
                        @if($userType == 'driver' && isset($customer->license_category))
                            SIM {{ $customer->license_category }}
                        @else
                            -
                        @endif
                    </div>
                </td>
                <td>
                    <div style="color: #666;">
                        @if($assignedVehicles > 0)
                            {{ $assignedVehicles }} Vehicle
                        @else
                            -
                        @endif
                    </div>
                </td>
                <td>
                    <span class="Status-badge {{ $customer->is_active ? 'Status-Active' : 'Status-nonActive' }}">
                        {{ $customer->is_active ? 'Ya' : 'Tidak' }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('customers.edit', $customer) }}" class="action-icon-btn btn-edit" title="{{ __('customer.edit_customer') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @php
                            $activeRentals = $customer->getActiveRentals()->count();
                        @endphp
                        @if($activeRentals == 0)
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, '{{ $customer->name }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-icon-btn btn-delete" title="{{ __('customer.delete_customer') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($customers->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $customers->links() }}
</div>
@endif

@else
<div class="empty-state">
    <div class="empty-icon">👥</div>
    <h3 class="empty-title">No data yet Pengguna</h3>
    <p class="empty-description">
        Start dengan menambahkan pengguna pertama you untuk mengelola sistem.
    </p>
    <a href="{{ route('customers.create') }}" class="btn-add-user">
        {{ strtoupper(__('customer.add_first')) }}
    </a>
</div>
@endif

@push('scripts')
<script>
function confirmDelete(event, userName) {
    event.preventDefault();
    
    if (confirm('{{ __("customer.delete_confirm") }} "' + userName + '"?\n\n{{ __("customer.delete_note") }}')) {
        event.target.submit();
    }
    
    return false;
}
</script>
@endpush
@endsection




























