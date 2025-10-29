@extends('layouts.drivvo')

@section('title', 'Report Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    Dashboard Report
                </h2>
                <div class="btn-group">
                    <a href="{{ route('reports.dashboard', ['period' => 'week']) }}" 
                       class="btn btn-{{ $period == 'week' ? 'primary' : 'outline-primary' }} btn-sm">
                        This Week
                    </a>
                    <a href="{{ route('reports.dashboard', ['period' => 'month']) }}" 
                       class="btn btn-{{ $period == 'month' ? 'primary' : 'outline-primary' }} btn-sm">
                        This Month
                    </a>
                    <a href="{{ route('reports.dashboard', ['period' => 'year']) }}" 
                       class="btn btn-{{ $period == 'year' ? 'primary' : 'outline-primary' }} btn-sm">
                        This Year
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.dashboard.pdf', request()->query()) }}" 
                       class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Rental
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRentals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Revenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rental Active
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeRentals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                available vehicles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $availableVehicles }}/{{ $totalVehicles }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Daily</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Donut Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Rental</h6>
                </div>
                <div class="card-body">
                    <canvas id="StatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Vehicles -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Performing Vehicles</h6>
                </div>
                <div class="card-body">
                    @forelse($topVehicles as $vehicle)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $vehicle->name }}</div>
                            <small class="text-muted">{{ $vehicle->license_plate }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">
                                Rp {{ number_format($vehicle->total_revenue ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">No data available Vehicle</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Customers</h6>
                </div>
                <div class="card-body">
                    @forelse($topCustomers as $customer)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $customer->name }}</div>
                            <small class="text-muted">{{ $customer->phone }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">
                                Rp {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">No data available customer</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Trend (Last 12 Months)</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Report Detail</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('reports.rentals') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-calendar-alt mb-1"></i><br>
                                Report Rental
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('reports.vehicles') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-car mb-1"></i><br>
                                Report Vehicle
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('reports.financial') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-chart-pie mb-1"></i><br>
                                Report Keuangan
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('reports.customers') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-users mb-1"></i><br>
                                Report Customer
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('rentals.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus mb-1"></i><br>
                                New Rentals
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('vehicles.create') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-plus-circle mb-1"></i><br>
                                New Vehicles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Excel Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-file-excel me-2"></i>Export Report ke Excel
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('reports.rentals.excel') }}" class="btn btn-success w-100">
                                <i class="fas fa-calendar-alt mb-1"></i><br>
                                Export Data Sewa
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('reports.vehicles.excel') }}" class="btn btn-success w-100">
                                <i class="fas fa-car mb-1"></i><br>
                                Export Vehicle Data
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('reports.financial.excel') }}" class="btn btn-success w-100">
                                <i class="fas fa-chart-pie mb-1"></i><br>
                                Export Report Keuangan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('reports.customers.excel') }}" class="btn btn-success w-100">
                                <i class="fas fa-users mb-1"></i><br>
                                Export Data Customer
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Tips:</strong> File Excel akan diunduh otomatis. you dapat membuka file dengan Microsoft Excel atau Google Sheets untuk analisis lebih lanjut.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($dailyRevenue);
    
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueData.map(item => new Date(item.date).toLocaleDateString('id-ID')),
            datasets: [{
                label: 'Revenue (Rp)',
                data: revenueData.map(item => item.revenue),
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
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
    
    // Status Chart
    const StatusCtx = document.getElementById('StatusChart').getContext('2d');
    const StatusData = @json($rentalStatusChart);
    
    new Chart(StatusCtx, {
        type: 'doughnut',
        data: {
            labels: StatusData.map(item => {
                const StatusLabels = {
                    'reserved': 'Reservasi',
                    'active': 'Active',
                    'completed': 'End',
                    'cancelled': 'DiCANCELkan'
                };
                return StatusLabels[item.Status] || item.Status;
            }),
            datasets: [{
                data: StatusData.map(item => item.count),
                backgroundColor: [
                    '#ffc107',
                    '#28a745',
                    '#007bff',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    
    // Monthly Trends Chart
    const trendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const trendsData = @json($monthlyTrends);
    
    new Chart(trendsCtx, {
        type: 'bar',
        data: {
            labels: trendsData.map(item => {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[item.month - 1] + ' ' + item.year;
            }),
            datasets: [{
                label: 'Total Rental',
                data: trendsData.map(item => item.total_rentals),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Revenue (Rp)',
                data: trendsData.map(item => item.revenue),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>
@endsection



























