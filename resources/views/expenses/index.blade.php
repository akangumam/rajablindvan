@extends('layouts.drivvo')

@section('title', 'Data Expenses')

@section('content')
<style>
    .expense-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    .expense-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }
    .expense-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 16px;
    }
    .category-insurance { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .category-tax { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .category-parking { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .category-toll { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .category-fine { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .category-other { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
    
    .expense-amount {
        font-size: 20px;
        font-weight: 700;
        color: #dc3545;
    }
    .expense-date {
        font-size: 13px;
        color: #6c757d;
    }
    .vehicle-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #495057;
    }
    .category-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: white;
    }
    .stats-card {
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 13px;
        opacity: 0.9;
    }
    .page-header {
        padding: 0 0 20px 0;
        margin-bottom: 0;
        border-bottom: 2px solid #f0f0f0;
    }
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }
    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
        margin: 4px 0 0 0;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        max-width: 700px;
        margin: 0 auto;
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        top: -40px;
    }
    .empty-title {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }
    .empty-description {
        font-size: 17px;
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 40px;
        max-width: 500px;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Expenses Vehicle</h1>
        <p class="page-subtitle">Manage All Expenses Vehicle you</p>
    </div>
</div>

@if($expenses->count() > 0)

<!-- Summary Stats -->
<div class="stats-card">
    <div class="row">
        <div class="col-md-4 stat-item">
            <div class="stat-value">{{ $expenses->count() }}</div>
            <div class="stat-label">Total TransAction</div>
        </div>
        <div class="col-md-4 stat-item border-start border-end border-white border-opacity-25">
            <div class="stat-value">Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}</div>
            <div class="stat-label">Total Expenses</div>
        </div>
        <div class="col-md-4 stat-item">
            <div class="stat-value">Rp {{ number_format($expenses->avg('amount'), 0, ',', '.') }}</div>
            <div class="stat-label">Average per Transaction</div>
        </div>
    </div>
</div>
<!-- Expense List -->
<div class="row">
    @foreach($expenses as $expense)
    <div class="col-12">
        <div class="expense-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <!-- Icon -->
                    <div class="expense-icon category-{{ $expense->category }}">
                        @if($expense->category === 'insurance')
                            🛡️
                        @elseif($expense->category === 'tax')
                            📋
                        @elseif($expense->category === 'parking')
                            🅿️
                        @elseif($expense->category === 'toll')
                            🛣️
                        @elseif($expense->category === 'fine')
                            ⚠️
                        @else
                            💰
                        @endif
                    </div>

                    <!-- Main Info -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">
                                    <span class="category-badge category-{{ $expense->category }}">
                                        {{ $expense->category_label }}
                                    </span>
                                    @if($expense->is_recurring)
                                        <span class="badge bg-info">
                                            <i class="bi bi-arrow-repeat"></i> {{ ucfirst($expense->recurring_period) }}
                                        </span>
                                    @endif
                                </h6>
                                <p class="mb-1">{{ $expense->description }}</p>
                                @if($expense->subcategory)
                                    <small class="text-muted">Subkategori: {{ $expense->subcategory }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="expense-amount">Rp {{ number_format($expense->amount, 0, ',', '.') }}</div>
                                <div class="expense-date">
                                    <i class="bi bi-calendar3"></i> {{ $expense->expense_date->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="vehicle-badge">
                                    🚗 {{ $expense->vehicle->name }} - {{ $expense->vehicle->license_plate }}
                                </span>
                                @if($expense->vendor)
                                    <span class="ms-2 text-muted small">
                                        <i class="bi bi-shop"></i> {{ $expense->vendor }}
                                    </span>
                                @endif
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('expenses.show', $expense) }}">
                                            <i class="bi bi-eye me-2"></i>Lihat Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('expenses.edit', $expense) }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                              onsubmit="return confirm('Yakin want to delete data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $expenses->links() }}
</div>

@else
<div class="empty-state">
    <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 80px; box-shadow: 0 12px 32px rgba(102, 126, 234, 0.3); margin: 0 auto 40px;">
        💰
    </div>
    <h3 class="empty-title">No expenses data yet</h3>
    <p class="empty-description">
        Start record Expenses Vehicle you seperti
        insurance, tax, parking, dan Cost Others.
    </p>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
        <i class="bi bi-plus-lg me-2"></i>Tambah Expenses Pertama
    </a>
</div>
@endif
@endsection



























