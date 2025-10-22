@extends('layouts.drivvo')

@section('title', 'Dashboard')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <!-- Vehicle Selector Button -->
            <button class="btn btn-link p-0 text-decoration-none" type="button" data-bs-toggle="modal" data-bs-target="#vehicleModal" style="border: none; box-shadow: none;">
                <h5 class="mb-0 text-muted d-inline">
                    {{ $activeVehicle ? $activeVehicle->brand . ' ' . $activeVehicle->model : 'Pilih Kendaraan' }}
                    <i class="fas fa-chevron-down ms-2" style="font-size: 12px;"></i>
                </h5>
            </button>
            <nav style="font-size: 14px;">
                <span class="text-primary">{{ $activeVehicle ? $activeVehicle->brand . ' ' . $activeVehicle->model : 'Pilih Kendaraan' }}</span> <i class="fas fa-chevron-right text-muted mx-2" style="font-size: 10px;"></i> <span class="text-muted">Riwayat</span>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <i class="fas fa-crown text-warning me-2"></i>
            <span class="text-muted">{{ $activeVehicle ? $activeVehicle->license_plate : 'ARMADA 100' }}</span>
            <div class="ms-3 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <span class="text-white fw-bold">
                    @if($activeVehicle)
                        {{ strtoupper(substr($activeVehicle->brand, 0, 1) . substr($activeVehicle->model, 0, 1)) }}
                    @else
                        KK
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Content Body -->
<div class="content-body">
    <div class="container-fluid p-4">
        <div class="row">
        <!-- Left Side - Riwayat/History -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center" style="min-height: 400px;">
                    <!-- Empty State Illustration -->
                    <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                        <div>
                            <!-- Rocket Illustration -->
                            <div class="mb-4">
                                <i class="fas fa-rocket text-primary" style="font-size: 4rem; opacity: 0.7;"></i>
                            </div>
                            
                            <h4 class="text-muted mb-3">Siap untuk memulai?</h4>
                            <p class="text-muted mb-4">
                                Klik <i class="fas fa-plus text-primary"></i> dan tambahkan pengisian bahan bakar, pengeluaran atau servis pertama Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Financial Summary -->
        <div class="col-lg-5">
            <!-- Bulan Lalu Summary -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-dark">Bulan Ini</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Biaya</h6>
                                <h4 class="text-danger mb-0">
                                    {{ number_format($totalCosts, 0, ',', '.') }}
                                </h4>
                                <small class="text-muted">
                                    {{ number_format($totalCosts, 0, ',', '.') }} Berdasarkan hari
                                </small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Pendapatan</h6>
                                <h4 class="text-success mb-0">
                                    {{ number_format($totalIncome, 0, ',', '.') }}
                                </h4>
                                <small class="text-muted">
                                    {{ number_format($totalIncome, 0, ',', '.') }} Berdasarkan hari
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Breakdown Expenses -->
                    <div class="row text-center mt-4">
                        <div class="col-4">
                            <div class="text-center">
                                <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-gas-pump text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Pengisian</small>
                                    <strong>{{ $fuelPercentage }}%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-tools text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Layanan</small>
                                    <strong>{{ $maintenancePercentage }}%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Beban</small>
                                    <strong>{{ $expensePercentage }}%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="text-center">
                                <h4 class="text-primary mb-1">{{ $totalVehicles }}</h4>
                                <small class="text-muted">Total Mobil</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <h4 class="text-success mb-1">{{ $availableVehicles }}</h4>
                                <small class="text-muted">Tersedia</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <h4 class="text-warning mb-1">{{ $activeRentals }}</h4>
                                <small class="text-muted">Disewa</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full Report Button -->
            <div class="mt-4">
                <button class="btn btn-outline-primary w-100" onclick="window.location.href='{{ route('reports.dashboard') }}'">
                    LAPORAN PENUH
                </button>
            </div>
        </div>
    </div>
</div>



<script>
function openQuickAdd(type) {
    const modal = new bootstrap.Modal(document.getElementById('quickAddModal'));
    modal.show();
}
</script>
@endsection