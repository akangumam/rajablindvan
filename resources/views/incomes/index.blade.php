@extends('layouts.drivvo')

@section('title', 'Income')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .btn-add {
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
        text-decoration: none;
        display: inline-block;
    }
    .btn-add:hover {
        background: #3498db;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .income-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .income-table {
        width: 100%;
        margin: 0;
    }
    .income-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .income-table thead th {
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: capitalize;
        letter-spacing: 0.5px;
        border: none;
    }
    .income-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    .income-table tbody tr:last-child td {
        border-bottom: none;
    }
    .income-table tbody tr:hover {
        background: #f8f9fa;
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
        color: white;
        background: #f39c12;
    }
    .action-icon-btn:hover {
        background: #e67e22;
        transform: translateY(-1px);
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
    <h1 class="page-title">
        <i class="fas fa-wallet"></i>
        Income
    </h1>
    <a href="{{ route('incomes.create') }}" class="btn-add">
        <i class="fas fa-plus me-2"></i>
        ADD NEW
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($incomes->count() > 0)
<div class="income-table-container">
    <table class="income-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Type</th>
                <th>User</th>
                <th>Notes</th>
                <th>Amount</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $income)
            <tr>
                <td>{{ $income->income_date->format('d/m/Y') }}</td>
                <td>{{ $income->vehicle->name }}</td>
                <td>{{ $income->type ?? ($income->category ?? '-') }}</td>
                <td>{{ $income->user->name ?? '-' }}</td>
                <td>{{ $income->notes ?? ($income->description ?? '-') }}</td>
                <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                <td style="text-align: right;">
                    <a href="{{ route('incomes.edit', $income) }}" class="action-icon-btn" title="Edit Income">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if($incomes->hasPages())
    <div style="padding: 20px; border-top: 1px solid #e9ecef;">
        {{ $incomes->links() }}
    </div>
    @endif
</div>

@else
<div class="income-table-container">
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-wallet" style="color: white;"></i>
        </div>
        <h3 class="empty-title">No Income Yet</h3>
        <p class="empty-description">
            Start by adding your first income entry to track revenue.
        </p>
        <a href="{{ route('incomes.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i>
            Add First Income
        </a>
    </div>
</div>
@endif
@endsection




























