@extends('layouts.drivvo')

@section('title', __('common.customers'))

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
    .search-form {
        margin-bottom: 20px;
    }
    .search-input-wrapper {
        position: relative;
        max-width: 400px;
    }
    .search-input {
        width: 100%;
        padding: 10px 40px 10px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .search-input:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    .search-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: #3498db;
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .search-btn:hover {
        background: #2980b9;
    }
    .pagination-wrapper {
        margin-top: 24px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .pagination-info {
        color: #666;
        font-size: 14px;
    }
    .pagination-controls {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .pagination-btn {
        padding: 8px 16px;
        border: 1px solid #e9ecef;
        background: white;
        color: #3498db;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .pagination-btn:hover:not(.disabled) {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }
    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        color: #999;
    }
    .pagination-numbers {
        display: flex;
        gap: 4px;
    }
    .pagination-number {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        background: white;
    }
    .pagination-number:hover {
        border-color: #3498db;
        color: #3498db;
        background: #f8f9fa;
    }
    .pagination-number.active {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px 15px;
            gap: 15px;
        }

        .page-title {
            font-size: 24px;
        }

        .page-title i {
            font-size: 22px;
        }

        .page-subtitle {
            font-size: 13px;
        }

        .btn-add-user {
            width: 100%;
            justify-content: center;
        }

        .search-input-wrapper {
            max-width: 100%;
        }

        /* Hide table, show card layout on mobile */
        .user-table-container {
            overflow: visible;
        }

        .user-table thead {
            display: none;
        }

        .user-table tbody {
            display: block;
        }

        .user-table tbody tr {
            display: block;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            background: white;
        }

        .user-table tbody td {
            display: block;
            padding: 8px 0;
            border: none;
            text-align: left !important;
        }

        .user-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 4px;
        }

        .user-table tbody td:first-child {
            display: none; /* Hide number column */
        }

        .action-buttons {
            justify-content: flex-start;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: 15px;
            padding: 15px;
        }

        .pagination-info {
            text-align: center;
            font-size: 13px;
        }

        .pagination-controls {
            flex-direction: column;
            width: 100%;
        }

        .pagination-btn {
            width: 100%;
            justify-content: center;
        }

        .pagination-numbers {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }

        .empty-state {
            padding: 40px 15px;
            min-height: 300px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            font-size: 40px;
        }

        .empty-title {
            font-size: 20px;
        }

        .empty-description {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .page-header {
            padding: 15px 10px;
        }

        .page-title {
            font-size: 20px;
        }

        .action-icon-btn {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .pagination-number {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-users"></i>
            {{ __('common.customers') }}
        </h1>
        <p class="page-subtitle">{{ __('common.manage_customer_info') }}</p>
    </div>
    @if(auth()->user()->canManageVehicles())
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> {{ __('common.add_new_customer') }}
    </a>
    @endif
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

<!-- Search Form -->
<form action="{{ route('customers.index') }}" method="GET" class="search-form">
    <div class="search-input-wrapper">
        <input type="text"
               id="customerSearch"
               name="search"
               class="search-input"
               placeholder="Search by company name, PIC name, or contact number..."
               value="{{ request('search') }}"
               autofocus>
        @if(request('search'))
        <button type="button" class="clear-search-btn" onclick="clearSearchInput('customerSearch')">
            <i class="fas fa-times"></i>
        </button>
        @endif
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

@if($customers->count() > 0)
<div class="user-table-container">
    <table class="user-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Company Address</th>
                <th>PIC Name</th>
                <th>Contact Number</th>
                <th>Active</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td data-label="Company Name">
                    <div class="user-name">{{ $customer->company_name ?? $customer->name }}</div>
                </td>
                <td data-label="Company Address">
                    <div class="user-email">{{ $customer->company_address ?? '-' }}</div>
                </td>
                <td data-label="PIC Name">
                    <div style="color: #666;">{{ $customer->pic_name ?? '-' }}</div>
                </td>
                <td data-label="Contact Number">
                    <div style="color: #666;">{{ $customer->contact_number ?? $customer->phone ?? '-' }}</div>
                </td>
                <td data-label="Active">
                    <span class="Status-badge {{ $customer->is_active ? 'Status-Active' : 'Status-nonActive' }}">
                        {{ $customer->is_active ? 'Ya' : 'Tidak' }}
                    </span>
                </td>
                <td data-label="Actions">
                    <div class="action-buttons">
                        @if(auth()->user()->canManageVehicles())
                        <a href="{{ route('customers.edit', $customer) }}" class="action-icon-btn btn-edit" title="{{ __('customer.edit_customer') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @endif
                        @php
                            $activeRentals = $customer->getActiveRentals()->count();
                        @endphp
                        @if($activeRentals == 0 && auth()->user()->canDeleteRecords())
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

<!-- Custom Pagination -->
@if($customers->hasPages())
<div class="pagination-wrapper">
    <div class="pagination-info">
        Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} results
    </div>

    <div class="pagination-controls">
        <!-- Previous Button -->
        @if($customers->onFirstPage())
            <span class="pagination-btn disabled">
                <i class="fas fa-chevron-left"></i> Previous
            </span>
        @else
            <a href="{{ $customers->previousPageUrl() }}" class="pagination-btn">
                <i class="fas fa-chevron-left"></i> Previous
            </a>
        @endif

        <!-- Page Numbers -->
        <div class="pagination-numbers">
            @foreach(range(1, $customers->lastPage()) as $page)
                @if($page == $customers->currentPage())
                    <span class="pagination-number active">{{ $page }}</span>
                @else
                    <a href="{{ $customers->url($page) }}" class="pagination-number">{{ $page }}</a>
                @endif
            @endforeach
        </div>

        <!-- Next Button -->
        @if($customers->hasMorePages())
            <a href="{{ $customers->nextPageUrl() }}" class="pagination-btn">
                Next <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span class="pagination-btn disabled">
                Next <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </div>
</div>
@endif

@else
<div class="empty-state">
    <div class="empty-icon">👥</div>
    <h3 class="empty-title">No data yet Pengguna</h3>
    <p class="empty-description">
        Start dengan menambahkan pengguna pertama you untuk mengelola sistem.
    </p>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> {{ strtoupper(__('customer.add_first')) }}
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

function clearSearchInput(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.value = '';
        input.form.submit();
    }
}

// Live search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('customerSearch');
    const tableRows = document.querySelectorAll('.user-table tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush
@endsection


























