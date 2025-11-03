@extends('layouts.drivvo')

@section('title', 'Vehicle Detail')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-car text-primary me-2"></i>
                        Vehicle Detail - {{ $vehicle->name }}
                    </h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus me-1"></i>Add Data
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('fuel-fills.create-for-vehicle', $vehicle) }}">
                                    <i class="fas fa-gas-pump me-2"></i>Isi Bensin
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('maintenances.create-for-vehicle', $vehicle) }}">
                                    <i class="fas fa-wrench me-2"></i>Service
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('expenses.create-for-vehicle', $vehicle) }}">
                                    <i class="fas fa-receipt me-2"></i>Expenses
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm ms-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm ms-1">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Vehicle Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Vehicle Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">Vehicle Type:</td>
                                            <td>{{ $vehicle->vehicle_type ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Name:</td>
                                            <td>{{ $vehicle->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Merek:</td>
                                            <td>{{ $vehicle->brand }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Model:</td>
                                            <td>{{ $vehicle->model }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Year:</td>
                                            <td>{{ $vehicle->year }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Plat Nomor:</td>
                                            <td><span class="badge bg-dark">{{ $vehicle->license_plate }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Chassis Number:</td>
                                            <td>
                                                @if($vehicle->chassis_number)
                                                    <span class="badge bg-secondary">{{ $vehicle->chassis_number }}</span>
                                                @else
                                                    <span class="text-muted">Not Set</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Engine Number / Nomor Mesin:</td>
                                            <td>
                                                @if($vehicle->engine_number)
                                                    <span class="badge bg-info">{{ $vehicle->engine_number }}</span>
                                                @else
                                                    <span class="text-muted">Not Set</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">STNK Number:</td>
                                            <td>{{ $vehicle->stnk_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">KIR Number:</td>
                                            <td>{{ $vehicle->kir_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Engine Type:</td>
                                            <td>{{ $vehicle->engine_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Transmisi:</td>
                                            <td>{{ $vehicle->transmission }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kapasitas Tangki:</td>
                                            <td>{{ $vehicle->tank_capacity ? $vehicle->tank_capacity . ' Liters' : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Warna:</td>
                                            <td>{{ $vehicle->color ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Status:</td>
                                            <td>
                                                <span class="badge {{ $vehicle->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Barcode Section -->
                            <div class="card border-success mt-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-qrcode me-2"></i>Barcode untuk Isi BBM</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if($vehicle->barcode_path)
                                        <div class="text-center">
                                            <!-- Barcode Image - Optimized for Scanning -->
                                            <div class="p-4 bg-white border rounded d-inline-block mb-3" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                                <img src="{{ asset('storage/' . $vehicle->barcode_path) }}" 
                                                     alt="Vehicle Barcode" 
                                                     style="max-width: 100%; height: auto; max-height: 300px; display: block;"
                                                     class="img-fluid"
                                                     id="vehicleBarcode">
                                            </div>
                                            
                                            <!-- Barcode Info -->
                                            <div class="alert alert-info d-inline-block mb-3" style="max-width: 400px;">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Cara Scan:</strong><br>
                                                <small>Tap gambar untuk memperbesar, lalu scan dengan scanner SPBU</small>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                                <button type="button" class="btn btn-primary" onclick="viewBarcodeFullscreen()">
                                                    <i class="fas fa-expand me-1"></i>View Fullscreen
                                                </button>
                                                <a href="{{ asset('storage/' . $vehicle->barcode_path) }}" 
                                                   download="barcode-{{ $vehicle->license_plate }}.png"
                                                   class="btn btn-success">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="py-4">
                                            <i class="fas fa-qrcode display-4 text-muted mb-3"></i>
                                            <p class="text-muted mb-3">Barcode belum di-upload</p>
                                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-upload me-1"></i>Upload Barcode
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Vehicle Statistics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-primary mb-0">{{ number_format($stats['latest_odometer']) }}</h5>
                                                    <small class="text-muted">Latest Odometer (km)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-success mb-0">{{ $stats['avg_fuel_efficiency'] ? number_format($stats['avg_fuel_efficiency'], 1) : '-' }}</h5>
                                                    <small class="text-muted">Fuel Efficiency (km/L)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-warning mb-0">{{ $stats['total_fuel_fills'] }}</h5>
                                                    <small class="text-muted">Total Fuel Fills</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <h5 class="text-danger mb-0">Rp {{ number_format($stats['total_expenses']) }}</h5>
                                                    <small class="text-muted">Total Cost</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Expiry Dates -->
                            <div class="card border-warning mt-3">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="fas fa-calendar-times me-2"></i>Document Expiry Dates</h6>
                                </div>
                                <div class="card-body">
                                    @if($vehicle->stnk_expiry_date || $vehicle->kir_expiry_date)
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <td class="fw-bold" style="width: 40%;">STNK Expiry:</td>
                                                <td>
                                                    @if($vehicle->stnk_expiry_date)
                                                        @php
                                                            $stnkExpiry = \Carbon\Carbon::parse($vehicle->stnk_expiry_date);
                                                            $daysUntilExpiry = now()->diffInDays($stnkExpiry, false);
                                                            $badgeClass = 'bg-success';
                                                            if ($daysUntilExpiry < 0) {
                                                                $badgeClass = 'bg-danger';
                                                            } elseif ($daysUntilExpiry <= 30) {
                                                                $badgeClass = 'bg-warning text-dark';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">
                                                            {{ $stnkExpiry->format('d M Y') }}
                                                        </span>
                                                        @if($daysUntilExpiry < 0)
                                                            <small class="text-danger d-block mt-1">
                                                                <i class="fas fa-exclamation-triangle"></i> Expired {{ abs($daysUntilExpiry) }} days ago
                                                            </small>
                                                        @elseif($daysUntilExpiry <= 30)
                                                            <small class="text-warning d-block mt-1">
                                                                <i class="fas fa-clock"></i> Expires in {{ $daysUntilExpiry }} days
                                                            </small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Not Set</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">KIR Expiry:</td>
                                                <td>
                                                    @if($vehicle->kir_expiry_date)
                                                        @php
                                                            $kirExpiry = \Carbon\Carbon::parse($vehicle->kir_expiry_date);
                                                            $daysUntilExpiry = now()->diffInDays($kirExpiry, false);
                                                            $badgeClass = 'bg-success';
                                                            if ($daysUntilExpiry < 0) {
                                                                $badgeClass = 'bg-danger';
                                                            } elseif ($daysUntilExpiry <= 30) {
                                                                $badgeClass = 'bg-warning text-dark';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">
                                                            {{ $kirExpiry->format('d M Y') }}
                                                        </span>
                                                        @if($daysUntilExpiry < 0)
                                                            <small class="text-danger d-block mt-1">
                                                                <i class="fas fa-exclamation-triangle"></i> Expired {{ abs($daysUntilExpiry) }} days ago
                                                            </small>
                                                        @elseif($daysUntilExpiry <= 30)
                                                            <small class="text-warning d-block mt-1">
                                                                <i class="fas fa-clock"></i> Expires in {{ $daysUntilExpiry }} days
                                                            </small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Not Set</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-calendar-times display-6 text-muted mb-2"></i>
                                            <p class="text-muted mb-2">Tanggal expiry dokumen belum diisi</p>
                                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit me-1"></i>Update Document Dates
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($vehicle->notes)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notes</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $vehicle->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- History Tabs -->
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="vehicleTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="fuel-tab" data-bs-toggle="tab" data-bs-target="#fuel" type="button" role="tab">
                                        <i class="fas fa-gas-pump me-1"></i>Fuel History ({{ $vehicle->fuelFills->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab">
                                        <i class="fas fa-wrench me-1"></i>Maintenance History ({{ $vehicle->maintenances->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="expenses-tab" data-bs-toggle="tab" data-bs-target="#expenses" type="button" role="tab">
                                        <i class="fas fa-receipt me-1"></i>Expenses History ({{ $vehicle->expenses->count() }})
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="vehicleTabsContent">
                                <!-- Fuel Tab -->
                                <div class="tab-pane fade show active" id="fuel" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->fuelFills->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Odometer</th>
                                                                <th>Liter</th>
                                                                <th>Price/L</th>
                                                                <th>Total</th>
                                                                <th>Efisiensi</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->fuelFills->sortByDesc('fill_date')->take(10) as $fuel)
                                                            <tr>
                                                                <td>{{ $fuel->fill_date->format('d/m/Y') }}</td>
                                                                <td>{{ number_format($fuel->odometer) }} km</td>
                                                                <td>{{ $fuel->liters }} L</td>
                                                                <td>Rp {{ number_format($fuel->price_per_liter) }}</td>
                                                                <td class="fw-bold">Rp {{ number_format($fuel->total_cost) }}</td>
                                                                <td>
                                                                    @if($fuel->fuel_efficiency)
                                                                        <span class="badge bg-success">{{ number_format($fuel->fuel_efficiency, 1) }} km/L</span>
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('fuel-fills.show', $fuel) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->fuelFills->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('fuel-fills.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            View All Fuel History
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-gas-pump display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No fuel data yet</h5>
                                                    <a href="{{ route('fuel-fills.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Add Fuel Data
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Service -->
                                <div class="tab-pane fade" id="maintenance" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->maintenances->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Kategori</th>
                                                                <th>Odometer</th>
                                                                <th>Cost</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->maintenances->sortByDesc('maintenance_date')->take(10) as $maintenance)
                                                            <tr>
                                                                <td>{{ $maintenance->maintenance_date->format('d/m/Y') }}</td>
                                                                <td>{{ $maintenance->type }}</td>
                                                                <td>
                                                                    @php
                                                                        $categoryClass = match($maintenance->category) {
                                                                            'Routine' => 'primary',
                                                                            'Repair' => 'warning',
                                                                            'Emergency' => 'danger',
                                                                            default => 'secondary'
                                                                        };
                                                                    @endphp
                                                                    <span class="badge bg-{{ $categoryClass }}">{{ $maintenance->category }}</span>
                                                                </td>
                                                                <td>{{ number_format($maintenance->odometer) }} km</td>
                                                                <td class="fw-bold">Rp {{ number_format($maintenance->cost) }}</td>
                                                                <td>
                                                                    @php
                                                                        $StatusClass = match($maintenance->Status) {
                                                                            'Completed' => 'success',
                                                                            'Scheduled' => 'warning',
                                                                            'Overdue' => 'danger',
                                                                            default => 'secondary'
                                                                        };
                                                                    @endphp
                                                                    <span class="badge bg-{{ $StatusClass }}">{{ $maintenance->Status }}</span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->maintenances->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('maintenances.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            View All Maintenance History
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-wrench display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No maintenance data yet</h5>
                                                    <a href="{{ route('maintenances.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Add Maintenance Data
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Expenses -->
                                <div class="tab-pane fade" id="expenses" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->expenses->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Kategori</th>
                                                                <th>Deskripsi</th>
                                                                <th>Amount</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->expenses->sortByDesc('expense_date')->take(10) as $expense)
                                                            <tr>
                                                                <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                                                <td>
                                                                    <span class="badge bg-info">{{ $expense->getCategoryLabelAttribute() }}</span>
                                                                </td>
                                                                <td>{{ Str::limit($expense->description, 50) }}</td>
                                                                <td class="fw-bold">Rp {{ number_format($expense->amount) }}</td>
                                                                <td>
                                                                    <a href="{{ route('expenses.show', $expense) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->expenses->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('expenses.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            View All Expenses History
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-receipt display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No expenses data yet</h5>
                                                    <a href="{{ route('expenses.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Add Expense Data
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fullscreen Barcode View for Easy Scanning
function viewBarcodeFullscreen() {
    const barcodeImg = document.getElementById('vehicleBarcode');
    if (!barcodeImg) {
        alert('Barcode not found');
        return;
    }
    
    // Create fullscreen overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    `;
    
    // Create close button
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '<i class="fas fa-times"></i> Close';
    closeBtn.style.cssText = `
        position: absolute;
        top: 20px;
        right: 20px;
        background: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10000;
    `;
    closeBtn.onclick = () => document.body.removeChild(overlay);
    
    // Create barcode container
    const barcodeContainer = document.createElement('div');
    barcodeContainer.style.cssText = `
        background: white;
        padding: 40px;
        border-radius: 16px;
        text-align: center;
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    `;
    
    // Clone barcode image
    const barcodeClone = barcodeImg.cloneNode(true);
    barcodeClone.style.cssText = `
        max-width: 100%;
        max-height: 70vh;
        height: auto;
        display: block;
        margin: 0 auto;
    `;
    
    // Add vehicle info
    const vehicleInfo = document.createElement('div');
    vehicleInfo.style.cssText = `
        margin-top: 24px;
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    `;
    vehicleInfo.textContent = '{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->license_plate }}';
    
    // Add instruction
    const instruction = document.createElement('div');
    instruction.style.cssText = `
        margin-top: 12px;
        font-size: 14px;
        color: #7f8c8d;
    `;
    instruction.innerHTML = '<i class="fas fa-info-circle"></i> Tunjukkan barcode ini ke scanner SPBU';
    
    // Assemble elements
    barcodeContainer.appendChild(barcodeClone);
    barcodeContainer.appendChild(vehicleInfo);
    barcodeContainer.appendChild(instruction);
    overlay.appendChild(closeBtn);
    overlay.appendChild(barcodeContainer);
    
    // Add to body
    document.body.appendChild(overlay);
    
    // Close on overlay click (but not on container)
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            document.body.removeChild(overlay);
        }
    });
    
    // Close on ESC key
    const escHandler = (e) => {
        if (e.key === 'Escape') {
            document.body.removeChild(overlay);
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
}

// Click barcode image to view fullscreen
document.addEventListener('DOMContentLoaded', function() {
    const barcodeImg = document.getElementById('vehicleBarcode');
    if (barcodeImg) {
        barcodeImg.style.cursor = 'pointer';
        barcodeImg.onclick = viewBarcodeFullscreen;
        barcodeImg.title = 'Click to view fullscreen';
    }
});
</script>
@endpush
@endsection



























