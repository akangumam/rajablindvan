@extends('layouts.drivvo')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" style="background: #d4edda; border: none; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;" role="alert">
    <i class="fas fa-check-circle" style="font-size: 20px; color: #155724;"></i>
    <div style="flex: 1; color: #155724; font-weight: 500;">{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="dashboard-header">
    <h1 class="dashboard-title">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard Monitoring
    </h1>
    <p class="dashboard-subtitle">Real-time fleet monitoring and expiry alerts</p>
</div>

{{-- ===== FLEET STATUS: BOOKED & AVAILABLE (PALING ATAS) ===== --}}
<div class="row mb-4">
    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
        <div class="fleet-stat-card booked-card">
            <div class="fleet-stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ $bookedVehicles }}</div>
                <div class="fleet-stat-label">Kendaraan Dipesan</div>
                <div class="fleet-stat-sub">BOOKED</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
        <div class="fleet-stat-card available-card">
            <div class="fleet-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ $availableVehicles }}</div>
                <div class="fleet-stat-label">Kendaraan Tersedia</div>
                <div class="fleet-stat-sub">AVAILABLE</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="fleet-stat-card total-card">
            <div class="fleet-stat-icon">
                <i class="fas fa-car-side"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ $totalFleet }}</div>
                <div class="fleet-stat-label">Total Armada</div>
                <div class="fleet-stat-sub">TOTAL FLEET</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FINANCIAL SUMMARY - BULAN INI ===== --}}
<div class="section-label mb-3">
    <i class="fas fa-chart-pie me-2"></i>
    Ringkasan Keuangan Bulan Ini
</div>
<div class="row mb-4">
    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
        <div class="fleet-stat-card income-card">
            <div class="fleet-stat-icon"><i class="fas fa-arrow-up"></i></div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ number_format($monthlyIncome, 0, ',', '.') }}</div>
                <div class="fleet-stat-label">Total Pendapatan</div>
                <div class="fleet-stat-sub">{{ now()->format('F Y') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
        <div class="fleet-stat-card expense-card">
            <div class="fleet-stat-icon"><i class="fas fa-arrow-down"></i></div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ number_format($monthlyExpense, 0, ',', '.') }}</div>
                <div class="fleet-stat-label">Total Pengeluaran</div>
                <div class="fleet-stat-sub">{{ now()->format('F Y') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="fleet-stat-card profit-card {{ $monthlyProfit < 0 ? 'loss' : '' }}">
            <div class="fleet-stat-icon">
                <i class="fas {{ $monthlyProfit >= 0 ? 'fa-chart-line' : 'fa-chart-line fa-flip-vertical' }}"></i>
            </div>
            <div class="fleet-stat-content">
                <div class="fleet-stat-number">{{ number_format(abs($monthlyProfit), 0, ',', '.') }}</div>
                <div class="fleet-stat-label">{{ $monthlyProfit >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</div>
                <div class="fleet-stat-sub">{{ now()->format('F Y') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHART PENDAPATAN VS PENGELUARAN ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="monitoring-card">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-profit">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span>Pendapatan vs Pengeluaran (6 Bulan Terakhir)</span>
                </div>
                <a href="{{ route('reports.index') }}" class="action-link">
                    Lihat Laporan <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="chart-container">
                <canvas id="incomeExpenseChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ===== LOCATION STATS (Super Admin Only) ===== --}}
@if(!empty($locationStats))
<div class="section-label mb-3">
    <i class="fas fa-map-marker-alt me-2"></i>
    Status Armada Per Lokasi
</div>
<div class="row mb-4">
    <div class="col-12">
        <div class="monitoring-card">
            <div class="table-responsive">
                <table class="table table-hover location-stats-table mb-0">
                    <thead>
                        <tr>
                            <th>Lokasi</th>
                            <th class="text-center">Total Armada</th>
                            <th class="text-center">Dipesan</th>
                            <th class="text-center">Tersedia</th>
                            <th class="text-center">Utilisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locationStats as $stat)
                        @php $utilization = $stat['total'] > 0 ? round(($stat['booked'] / $stat['total']) * 100) : 0; @endphp
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $stat['name'] }}</span>
                                @if($stat['code'])<small class="text-muted ms-1">({{ $stat['code'] }})</small>@endif
                            </td>
                            <td class="text-center">
                                <span class="badge-count bg-primary text-white">{{ $stat['total'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge-count {{ $stat['booked'] > 0 ? 'bg-danger' : 'bg-secondary' }} text-white">{{ $stat['booked'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge-count {{ $stat['available'] > 0 ? 'bg-success' : 'bg-secondary' }} text-white">{{ $stat['available'] }}</span>
                            </td>
                            <td class="text-center" style="min-width:120px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:8px; border-radius:4px;">
                                        <div class="progress-bar {{ $utilization >= 80 ? 'bg-danger' : ($utilization >= 50 ? 'bg-warning' : 'bg-success') }}"
                                             style="width:{{ $utilization }}%"></div>
                                    </div>
                                    <small class="fw-bold" style="min-width:36px;">{{ $utilization }}%</small>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== RENTAL EXPIRY MONITORING ===== --}}
<div class="section-label mb-3">
    <i class="fas fa-calendar-alt me-2"></i>
    Monitoring Masa Sewa
</div>
<div class="row mb-4">
    <div class="col-12">
        <div class="monitoring-card">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-orange">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <span>Sewa Akan Berakhir / Sudah Lewat</span>
                </div>
                <span class="badge-count {{ count($rentalExpiryMonitoring) > 0 ? 'bg-danger' : 'bg-success' }} text-white">
                    {{ count($rentalExpiryMonitoring) > 0 ? count($rentalExpiryMonitoring) : '✓' }}
                </span>
            </div>
            <div class="vehicle-list">
                @forelse($rentalExpiryMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }} <small class="text-muted">({{ $item['license_plate'] }})</small></div>
                        <div class="countdown-info">
                            <i class="fas fa-user"></i>
                            <span>{{ $item['customer'] }}</span>
                            <span class="text-muted">•</span>
                            <span class="badge {{ $item['rental_type'] === 'Sewa Harian' ? 'bg-info' : 'bg-warning text-dark' }}" style="font-size:11px;">{{ $item['rental_type'] }}</span>
                            <span class="text-muted">•</span>
                            <i class="fas fa-clock"></i>
                            <span>
                                @if($item['is_overdue'])
                                    <strong class="text-danger">{{ $item['days_remaining'] }} hari terlewat</strong>
                                @else
                                    {{ $item['days_remaining'] }} hari tersisa
                                @endif
                            </span>
                            <span class="text-muted">•</span>
                            <span>Berakhir: {{ $item['end_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            @if($item['status'] === 'red')
                                LEWAT
                            @elseif($item['status'] === 'yellow')
                                SEGERA
                            @else
                                AMAN
                            @endif
                        </span>
                        <a href="{{ route('orders.index', ['status' => 'active']) }}" class="action-link">
                            Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p class="mb-1">Tidak ada sewa yang akan segera berakhir</p>
                    <small class="text-muted">Semua pesanan aktif masih memiliki waktu lebih dari 7 hari</small>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ===== SECTION LABEL ===== --}}
<div class="section-label mb-3">
    <i class="fas fa-exclamation-triangle me-2"></i>
    Monitoring Masa Berlaku Dokumen
</div>

{{-- ===== MONITORING CARDS GRID ===== --}}
<div class="row">
    {{-- STNK --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="monitoring-card h-100">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-blue">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <span>Monitoring STNK</span>
                </div>
                 <span class="badge-count {{ count($stnkMonitoring) > 0 ? 'bg-danger' : 'bg-success' }} text-white">
                    {{ count($stnkMonitoring) > 0 ? count($stnkMonitoring) : '✓' }}
                </span>
            </div>
            <div class="vehicle-list">
                @forelse($stnkMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} hari {{ $item['status'] == 'red' ? 'terlewat' : 'tersisa' }}</span>
                            <span class="text-muted">•</span>
                            <span>{{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'WARNING' : 'URGENT' }}
                        </span>
                        <a href="{{ route('vehicles.show', ['vehicle' => $item['id']]) }}" class="action-link">
                            Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p class="mb-1">Semua STNK masih berlaku</p>
                    <small class="text-muted">Pastikan tanggal STNK sudah diisi di data kendaraan</small>
                    <div class="mt-2">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-car me-1"></i> Kelola Kendaraan
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- KIR --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="monitoring-card h-100">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-green">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <span>Monitoring KIR</span>
                </div>
                <span class="badge-count {{ count($kirMonitoring) > 0 ? 'bg-danger' : 'bg-success' }} text-white">
                    {{ count($kirMonitoring) > 0 ? count($kirMonitoring) : '✓' }}
                </span>
            </div>
            <div class="vehicle-list">
                @forelse($kirMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} hari {{ $item['status'] == 'red' ? 'terlewat' : 'tersisa' }}</span>
                            <span class="text-muted">•</span>
                            <span>{{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'WARNING' : 'URGENT' }}
                        </span>
                        <a href="{{ route('vehicles.show', ['vehicle' => $item['id']]) }}" class="action-link">
                            Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p class="mb-1">Semua KIR masih berlaku</p>
                    <small class="text-muted">Pastikan tanggal KIR sudah diisi di data kendaraan</small>
                    <div class="mt-2">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-car me-1"></i> Kelola Kendaraan
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- GPS --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="monitoring-card h-100">
            <div class="card-header-custom">
                <div class="card-title-custom">
                    <div class="card-icon icon-purple">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <span>Monitoring GPS</span>
                </div>
                <span class="badge-count {{ count($gpsMonitoring) > 0 ? 'bg-danger' : 'bg-success' }} text-white">
                    {{ count($gpsMonitoring) > 0 ? count($gpsMonitoring) : '✓' }}
                </span>
            </div>
            <div class="vehicle-list">
                @forelse($gpsMonitoring as $item)
                <div class="vehicle-item">
                    <div class="vehicle-info">
                        <div class="vehicle-name">{{ $item['vehicle_name'] }}</div>
                        <div class="countdown-info">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['days_until_expiry'] }} hari {{ $item['status'] == 'red' ? 'terlewat' : 'tersisa' }}</span>
                            <span class="text-muted">•</span>
                            <span>{{ $item['expiry_date'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge status-{{ $item['status'] }}">
                            {{ $item['status'] == 'yellow' ? 'WARNING' : 'URGENT' }}
                        </span>
                        <a href="{{ route('vehicles.show', ['vehicle' => $item['id']]) }}" class="action-link">
                            Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check-circle text-success"></i></div>
                    <p class="mb-1">Semua GPS masih berlaku</p>
                    <small class="text-muted">Pastikan tanggal GPS sudah diisi di data kendaraan</small>
                    <div class="mt-2">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-car me-1"></i> Kelola Kendaraan
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('incomeExpenseChart');
    if (!ctx) return;

    const labels  = @json($fuelChartData['labels']);
    const income  = @json($fuelChartData['income']);
    const expense = @json($fuelChartData['expense']);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: income,
                    backgroundColor: 'rgba(67, 233, 123, 0.7)',
                    borderColor: '#38f9d7',
                    borderWidth: 1,
                    borderRadius: 6,
                },
                {
                    label: 'Pengeluaran',
                    data: expense,
                    backgroundColor: 'rgba(250, 112, 154, 0.7)',
                    borderColor: '#fee140',
                    borderWidth: 1,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.dataset.label + ': Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            return 'Rp ' + value;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush



























