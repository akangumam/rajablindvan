@extends('layouts.drivvo')

@section('title', 'Order List')

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
    .clear-search-btn {
        position: absolute;
        right: 48px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #95a5a6;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    .clear-search-btn:hover {
        color: #e74c3c;
    }
    .sortable-header {
        cursor: pointer;
        text-decoration: none;
        color: #495057;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s;
    }
    .sortable-header:hover {
        color: #3498db;
    }
    .sort-icon {
        font-size: 0.8em;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-clipboard-list"></i>
            Order List
        </h1>
        <p class="page-subtitle">List of order based on Vehicle</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Add New Order
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Status Filter Tabs -->
<div class="status-tabs mb-4">
    <a href="{{ route('orders.index', ['status' => 'Active']) }}"
       class="status-tab {{ $status === 'Active' ? 'active' : '' }}">
        <i class="fas fa-play-circle"></i> Active Orders
        <span class="badge">{{ \App\Models\Order::where('status', 'Active')->count() }}</span>
    </a>
    <a href="{{ route('orders.index', ['status' => 'Completed']) }}"
       class="status-tab {{ $status === 'Completed' ? 'active' : '' }}">
        <i class="fas fa-check-circle"></i> History (Completed)
        <span class="badge">{{ \App\Models\Order::where('status', 'Completed')->count() }}</span>
    </a>
    <a href="{{ route('orders.index', ['status' => 'All']) }}"
       class="status-tab {{ $status === 'All' ? 'active' : '' }}">
        <i class="fas fa-list"></i> All Orders
        <span class="badge">{{ \App\Models\Order::count() }}</span>
    </a>
</div>

<!-- Search Form -->
<form action="{{ route('orders.index') }}" method="GET" class="search-form">
    <input type="hidden" name="status" value="{{ $status }}">
    <div class="search-input-wrapper position-relative">
        <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #999; z-index: 1;"></i>
        <input type="text"
               id="orderSearch"
               name="search"
               class="search-input"
               placeholder="Search by vehicle name, license plate, or customer..."
               value="{{ request('search') }}"
               style="padding-left: 40px; padding-right: 40px;"
               autofocus>
        <button type="button"
                id="clearSearch"
                class="clear-search-btn position-absolute"
                onclick="clearSearchInput('orderSearch')"
                style="right: 12px; top: 50%; transform: translateY(-50%); padding: 0; width: 24px; height: 24px; border: none; background: transparent; display: {{ request('search') ? 'flex' : 'none' }};">
            <i class="fas fa-times text-muted"></i>
        </button>
    </div>
</form>

<div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Active Orders</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'vehicle_name', 'sort_order' => request('sort_by') == 'vehicle_name' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Vehicle Name
                                    <i class="fas fa-sort{{ request('sort_by') == 'vehicle_name' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'vehicle_name' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'license_plate', 'sort_order' => request('sort_by') == 'license_plate' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    License Plate
                                    <i class="fas fa-sort{{ request('sort_by') == 'license_plate' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'license_plate' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'year', 'sort_order' => request('sort_by') == 'year' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Year
                                    <i class="fas fa-sort{{ request('sort_by') == 'year' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'year' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'customer_name', 'sort_order' => request('sort_by') == 'customer_name' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Customer
                                    <i class="fas fa-sort{{ request('sort_by') == 'customer_name' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'customer_name' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'rental_type', 'sort_order' => request('sort_by') == 'rental_type' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Rental Type
                                    <i class="fas fa-sort{{ request('sort_by') == 'rental_type' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'rental_type' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'start_date', 'sort_order' => request('sort_by') == 'start_date' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Start Date
                                    <i class="fas fa-sort{{ request('sort_by') == 'start_date' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'start_date' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'end_date', 'sort_order' => request('sort_by') == 'end_date' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    End Date
                                    <i class="fas fa-sort{{ request('sort_by') == 'end_date' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'end_date' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', array_merge(request()->query(), ['sort_by' => 'status', 'sort_order' => request('sort_by') == 'status' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" class="sortable-header">
                                    Status
                                    <i class="fas fa-sort{{ request('sort_by') == 'status' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }} sort-icon {{ request('sort_by') != 'status' ? 'text-muted opacity-25' : '' }}"></i>
                                </a>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td data-label="Vehicle Name">{{ $order->vehicle->name ?? '-' }}</td>
                            <td data-label="License Plate">{{ $order->vehicle->license_plate ?? '-' }}</td>
                            <td data-label="Year">{{ $order->vehicle->year ?? '-' }}</td>
                            <td data-label="Customer">
                                {{ $order->customer->name ?? '-' }}
                                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-link p-0 ms-1" title="Manage Customer">
                                    <i class="bi bi-person-gear"></i>
                                </a>
                            </td>
                            <td data-label="Rental Type">
                                @if($order->rental_type === 'Sewa Harian')
                                    <span class="badge bg-info">{{ $order->rental_type }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $order->rental_type }}</span>
                                @endif
                            </td>
                            <td data-label="Start Date">{{ $order->start_date->format('d M Y') }}</td>
                            <td data-label="End Date">{{ $order->end_date->format('d M Y') }}</td>
                            <td data-label="Status">
                                <span class="badge bg-{{ $order->status_color }}"
                                    @if($order->rental_type === 'Sewa Harian')
                                        title="Hijau (Untuk semua sewa Harian)"
                                    @elseif($order->remaining_days < 0)
                                        title="Merah (Lewat Jatuh tempo)"
                                    @elseif($order->remaining_days <= 7)
                                        title="Kuning (akan jatuh tempo 7 hari sebelum)"
                                    @endif
                                >
                                    <i class="bi bi-circle-fill"></i> {{ $order->status_text }}
                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    @if($order->status === 'Active')
                                    <form action="{{ route('orders.complete', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Mark this order as completed?')">
                                        @csrf
                                        <button type="submit" class="action-icon-btn btn-complete" title="Complete Order">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if(auth()->user()->canManageVehicles())
                                    <a href="{{ route('orders.edit', $order->id) }}" class="action-icon-btn btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->canDeleteRecords())
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-icon-btn btn-delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No active orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Keterangan Indikator Section -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-tachometer-alt"></i> Keterangan Indikator</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">SEWA BULANAN</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-circle-fill"></i>
                            </span>
                            <strong>Kuning</strong> (akan jatuh tempo 7 hari sebelum)
                        </li>
                        <li>
                            <span class="badge bg-danger">
                                <i class="bi bi-circle-fill"></i>
                            </span>
                            <strong>Merah</strong> (Lewat Jatuh tempo)
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">SEWA HARIAN</h6>
                    <ul class="list-unstyled">
                        <li>
                            <span class="badge bg-success">
                                <i class="bi bi-circle-fill"></i>
                            </span>
                            <strong>Hijau</strong> (Untuk semua sewa Harian)
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
    padding: 1rem 1.5rem;
}

.card-header h5 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    color: #495057;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    padding: 0.4em 0.8em;
    font-size: 0.85rem;
    font-weight: 500;
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

.action-icon-btn.btn-complete {
    background: #27ae60;
}

.action-icon-btn.btn-complete:hover {
    background: #229954;
}

.action-icon-btn.btn-delete {
    background: #e74c3c;
}

.action-icon-btn.btn-delete:hover {
    background: #c0392b;
}

/* Status Tabs */
.status-tabs {
    display: flex;
    gap: 12px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.status-tab {
    flex: 1;
    padding: 16px 24px;
    border-radius: 10px;
    background: #f8f9fa;
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.status-tab:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.status-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.status-tab i {
    font-size: 18px;
}

.status-tab .badge {
    margin-left: auto;
    background: rgba(0,0,0,0.2);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}

.status-tab.active .badge {
    background: rgba(255,255,255,0.3);
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

    .page-header .btn {
        width: 100%;
        justify-content: center;
    }

    .search-input-wrapper {
        max-width: 100%;
    }

    /* Status Tabs Mobile */
    .status-tabs {
        flex-direction: column;
        padding: 15px;
        gap: 10px;
    }

    .status-tab {
        padding: 12px 16px;
        font-size: 14px;
    }

    .status-tab i {
        font-size: 16px;
    }

    .status-tab .badge {
        font-size: 11px;
        padding: 3px 10px;
    }

    /* Card Layout for Mobile */
    .card {
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .card-header {
        padding: 15px;
    }

    .card-header h5 {
        font-size: 16px;
    }

    .card-body {
        padding: 0;
    }

    /* Hide table, show card layout */
    .table-responsive {
        overflow: visible;
    }

    .table {
        display: block;
    }

    .table thead {
        display: none;
    }

    .table tbody {
        display: block;
    }

    .table tbody tr {
        display: block;
        margin: 0;
        padding: 15px;
        border-bottom: 8px solid #f8f9fa;
        background: white;
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .table tbody td {
        display: block;
        padding: 8px 0;
        border: none;
        text-align: left !important;
    }

    .table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #6c757d;
        font-size: 11px;
        text-transform: uppercase;
        display: block;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }

    .table tbody td:first-child {
        display: none; /* Hide number column */
    }

    .action-buttons {
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }

    .action-icon-btn {
        width: auto;
        padding: 8px 16px;
        font-size: 13px;
    }

    .action-icon-btn i {
        margin-right: 6px;
    }

    /* Keterangan Indikator Mobile */
    .card.mt-4 .row {
        flex-direction: column;
    }

    .card.mt-4 .col-md-6 {
        margin-bottom: 15px;
    }

    .card.mt-4 h6 {
        font-size: 14px;
    }

    .card.mt-4 .list-unstyled li {
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .page-header {
        padding: 15px 10px;
    }

    .page-title {
        font-size: 20px;
    }

    .status-tabs {
        padding: 10px;
    }

    .status-tab {
        padding: 10px 12px;
        font-size: 13px;
    }

    .card-header {
        padding: 12px;
    }

    .table tbody tr {
        padding: 12px;
    }

    .badge {
        font-size: 11px;
        padding: 4px 10px;
    }
}
</style>

@push('scripts')
<script>
function clearSearchInput(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.value = '';
        input.form.submit();
    }
}

// Live search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('orderSearch');
    const tableRows = document.querySelectorAll('.table tbody tr');
    const clearBtn = document.querySelector('.clear-search-btn');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            // Show/hide clear button
            const clearBtn = document.getElementById('clearSearch');
            if (clearBtn) {
                clearBtn.style.display = searchTerm ? 'flex' : 'none';
            }

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
