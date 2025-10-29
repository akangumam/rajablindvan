@extends('layouts.drivvo')

@section('title', 'Financial Report')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-chart-pie text-primary me-2"></i>
                    Report Keuangan
                </h2>
                <div>
                    <a href="{{ route('reports.financial.excel') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel me-1"></i>Export Excel
                    </a>
                    <a href="{{ route('reports.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.financial') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Date Start</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Date End</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Revenue Rental</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($rentalRevenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Expenses</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalOperationalCosts, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-{{ $netProfit >= 0 ? 'primary' : 'warning' }} text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Keuntungan Bersih</div>
                            <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Profit Margin</div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($profitMargin, 1) }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Revenue vs Expenses Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Revenue vs Expenses</h6>
                </div>
                <div class="card-body">
                    <canvas id="financialTrendsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Expense Breakdown -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Breakdown Expenses</h6>
                </div>
                <div class="card-body">
                    <canvas id="expenseBreakdownChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Breakdown -->
    <div class="row">
        <!-- Revenue Breakdown -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Revenue</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Revenue Rental:</span>
                            <span class="fw-bold text-success">Rp {{ number_format($rentalRevenue, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Deposit Diterima:</span>
                            <span class="fw-bold text-info">Rp {{ number_format($depositReceived, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Revenue:</span>
                        <span class="fw-bold h5 text-success">Rp {{ number_format($rentalRevenue + $depositReceived, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Breakdown -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Expenses</h6>
                </div>
                <div class="card-body">
                    @foreach($expenses as $expense)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ ucfirst($expense->category) }}:</span>
                            <span class="fw-bold text-danger">Rp {{ number_format($expense->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Cost Maintenance:</span>
                            <span class="fw-bold text-danger">Rp {{ number_format($maintenanceCosts, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Cost Bahan Bakar:</span>
                            <span class="fw-bold text-danger">Rp {{ number_format($fuelCosts, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Expenses:</span>
                        <span class="fw-bold h5 text-danger">Rp {{ number_format($totalOperationalCosts, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Financial Trends Chart
    const trendsCtx = document.getElementById('financialTrendsChart').getContext('2d');
    const monthlyData = @json($monthlyData);
    
    // Prepare data for chart
    const months = [];
    const revenueData = [];
    const expenseData = [];
    
    // Create a complete month list
    for (let i = 0; i < 12; i++) {
        const date = new Date();
        date.setMonth(date.getMonth() - i);
        const monthKey = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
        months.unshift(date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short' }));
        
        const revenueItem = monthlyData.revenue.find(item => 
            item.year + '-' + String(item.month).padStart(2, '0') === monthKey
        );
        const expenseItem = monthlyData.expenses.find(item => 
            item.year + '-' + String(item.month).padStart(2, '0') === monthKey
        );
        
        revenueData.unshift(revenueItem ? revenueItem.amount : 0);
        expenseData.unshift(expenseItem ? expenseItem.amount : 0);
    }
    
    new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                borderColor: 'rgb(40, 167, 69)',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.1
            }, {
                label: 'Expenses',
                data: expenseData,
                borderColor: 'rgb(220, 53, 69)',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
    
    // Expense Breakdown Chart
    const expenseCtx = document.getElementById('expenseBreakdownChart').getContext('2d');
    const expenseData = @json($expenses);
    
    const expenseLabels = [];
    const expenseValues = [];
    const expenseColors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#fd7e14'];
    
    expenseData.forEach((item, index) => {
        expenseLabels.push(item.category.charAt(0).toUpperCase() + item.category.slice(1));
        expenseValues.push(item.total);
    });
    
    // Add maintenance and fuel costs
    expenseLabels.push('Maintenance');
    expenseValues.push({{ $maintenanceCosts }});
    expenseLabels.push('Bahan Bakar');
    expenseValues.push({{ $fuelCosts }});
    
    new Chart(expenseCtx, {
        type: 'doughnut',
        data: {
            labels: expenseLabels,
            datasets: [{
                data: expenseValues,
                backgroundColor: expenseColors.slice(0, expenseLabels.length)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endsection



























