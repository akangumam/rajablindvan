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
                        <a href="{{ route('vehicles.export-pdf', $vehicle->id) }}" class="btn btn-success btn-sm ms-2" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Download PDF
                        </a>
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm ms-2">
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

                            <!-- Ownership Information -->
                            <div class="card border-info mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-user-tie me-2"></i>Ownership Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">Ownership Type:</td>
                                            <td>
                                                @if($vehicle->ownership_type === 'investor')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-user-tie me-1"></i>Investor Owned
                                                    </span>
                                                @else
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-building me-1"></i>Company Owned
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($vehicle->ownership_type === 'investor' && $vehicle->investor)
                                        <tr>
                                            <td class="fw-bold">Investor:</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong class="text-dark">{{ $vehicle->investor->name }}</strong>
                                                        <div class="text-muted small">
                                                            <i class="fas fa-percent me-1"></i>Profit Share: {{ $vehicle->investor->investment_percentage }}%
                                                        </div>
                                                        @if($vehicle->investor->status === 'active')
                                                            <span class="badge bg-success mt-1">Active Investor</span>
                                                        @else
                                                            <span class="badge bg-secondary mt-1">Inactive</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(auth()->user()->hasRole(['super_admin']))
                                        <tr>
                                            <td class="fw-bold">Investor Report:</td>
                                            <td>
                                                <a href="{{ route('settings.investors.show', $vehicle->investor) }}"
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-chart-line me-1"></i>View Investor Report
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- Dokumen Kendaraan - Moved to left column -->
                            <div class="card border-primary mt-3">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Dokumen Kendaraan</h6>
                                    <button type="button" class="btn btn-sm btn-light" onclick="openUploadDocumentModal()">
                                        <i class="fas fa-plus me-1"></i>Upload Dokumen
                                    </button>
                                </div>
                                <div class="card-body">
                                    @if($vehicle->documents && $vehicle->documents->count() > 0)
                                        <div class="list-group">
                                            @foreach($vehicle->documents as $doc)
                                                <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                                                    <div class="d-flex align-items-center flex-grow-1">
                                                        <i class="{{ $doc->file_icon }} fa-lg me-2 text-danger"></i>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-bold small">{{ $doc->document_name }}</div>
                                                            <small class="text-muted">
                                                                <span class="badge bg-secondary me-1">{{ $doc->document_type }}</span>
                                                                {{ $doc->file_size_formatted }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ asset('storage/' . $doc->document_path) }}"
                                                           target="_blank"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ asset('storage/' . $doc->document_path) }}"
                                                           download="{{ $doc->document_name }}"
                                                           class="btn btn-sm btn-outline-success"
                                                           title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDeleteVehicleDocument({{ $doc->id }})"
                                                                title="Delete">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-file-alt display-6 text-muted mb-2"></i>
                                            <p class="text-muted mb-0 small">Belum ada dokumen yang diupload</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Barcode Section -->
                            <div class="card border-success">
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
                                                <button type="button" class="btn btn-warning" onclick="openUploadBarcodeModal()">
                                                    <i class="fas fa-upload me-1"></i>Ganti Barcode
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="confirmDeleteBarcode()">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </button>
                                            </div>

                                        </div>
                                    @else
                                        <div class="py-4">
                                            <i class="fas fa-qrcode display-4 text-muted mb-3"></i>
                                            <p class="text-muted mb-3">Barcode belum di-upload</p>
                                            <button type="button" class="btn btn-success" onclick="openUploadBarcodeModal()">
                                                <i class="fas fa-upload me-1"></i>Upload Barcode
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Document Expiry Dates - Top position for visibility -->
                            <div class="card border-warning mt-3">
                                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Masa Berlaku Dokumen</h6>
                                    <button type="button" class="btn btn-sm btn-dark" onclick="openUpdateExpiryDatesModal()">
                                        <i class="fas fa-edit me-1"></i>Update
                                    </button>
                                </div>
                                <div class="card-body">
                                    @if($vehicle->stnk_expiry_date || $vehicle->kir_expiry_date || $vehicle->gps_expiry_date)
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <td class="fw-bold" style="width: 45%;">Masa Berlaku STNK:</td>
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
                                                        <div class="badge {{ $badgeClass }} mb-1">{{ $stnkExpiry->format('d M Y') }}</div>
                                                        @if($daysUntilExpiry < 0)
                                                            <div class="text-danger small">
                                                                <i class="fas fa-exclamation-triangle"></i> Expired {{ round(abs($daysUntilExpiry)) }} days ago
                                                            </div>
                                                        @elseif($daysUntilExpiry <= 30)
                                                            <div class="text-warning small">
                                                                <i class="fas fa-clock"></i> Expires in {{ round($daysUntilExpiry) }} days
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Not Set</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Masa Berlaku KIR:</td>
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
                                                        <div class="badge {{ $badgeClass }} mb-1">{{ $kirExpiry->format('d M Y') }}</div>
                                                        @if($daysUntilExpiry < 0)
                                                            <div class="text-danger small">
                                                                <i class="fas fa-exclamation-triangle"></i> Expired {{ round(abs($daysUntilExpiry)) }} days ago
                                                            </div>
                                                        @elseif($daysUntilExpiry <= 30)
                                                            <div class="text-warning small">
                                                                <i class="fas fa-clock"></i> Expires in {{ round($daysUntilExpiry) }} days
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Not Set</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Masa Berlaku GPS:</td>
                                                <td>
                                                    @if($vehicle->gps_expiry_date)
                                                        @php
                                                            $gpsExpiry = \Carbon\Carbon::parse($vehicle->gps_expiry_date);
                                                            $daysUntilExpiry = now()->diffInDays($gpsExpiry, false);
                                                            $badgeClass = 'bg-success';
                                                            if ($daysUntilExpiry < 0) {
                                                                $badgeClass = 'bg-danger';
                                                            } elseif ($daysUntilExpiry <= 7) {
                                                                $badgeClass = 'bg-warning text-dark';
                                                            }
                                                        @endphp
                                                        <div class="badge {{ $badgeClass }} mb-1">{{ $gpsExpiry->format('d M Y') }}</div>
                                                        @if($daysUntilExpiry < 0)
                                                            <div class="text-danger small">
                                                                <i class="fas fa-exclamation-triangle"></i> Expired {{ round(abs($daysUntilExpiry)) }} days ago
                                                            </div>
                                                        @elseif($daysUntilExpiry <= 7)
                                                            <div class="text-warning small">
                                                                <i class="fas fa-clock"></i> Expires in {{ round($daysUntilExpiry) }} days
                                                            </div>
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
                                            <button type="button" class="btn btn-sm btn-warning" onclick="openUpdateExpiryDatesModal()">
                                                <i class="fas fa-edit me-1"></i>Update Document Dates
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Vehicle Statistics -->
                            <div class="card border-info mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Kendaraan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <div class="text-primary fw-bold h5 mb-0">{{ number_format($stats['latest_odometer']) }}</div>
                                                <small class="text-muted">Odometer Terakhir (km)</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <div class="text-success fw-bold h5 mb-0">{{ $stats['avg_fuel_efficiency'] ? number_format($stats['avg_fuel_efficiency'], 1) : '-' }}</div>
                                                <small class="text-muted">Fuel Efficiency (km/L)</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <div class="text-warning fw-bold h5 mb-0">{{ $stats['total_fuel_fills'] }}</div>
                                                <small class="text-muted">Total Fuel Fills</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <div class="text-danger fw-bold h5 mb-0">{{ $stats['total_maintenance_count'] }}</div>
                                                <small class="text-muted">Total Servis</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-center p-2 bg-light rounded">
                                                <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($stats['total_cost']) }}</div>
                                                <small class="text-muted">Total Biaya</small>
                                            </div>
                                        </div>
                                    </div>
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
                                    <button class="nav-link active" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab">
                                        <i class="fas fa-wrench me-1"></i>Servis ({{ $vehicle->maintenances->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="expenses-tab" data-bs-toggle="tab" data-bs-target="#expenses" type="button" role="tab">
                                        <i class="fas fa-receipt me-1"></i>Pengeluaran ({{ $vehicle->expenses->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="income-tab" data-bs-toggle="tab" data-bs-target="#income" type="button" role="tab">
                                        <i class="fas fa-dollar-sign me-1"></i>Pendapatan ({{ $vehicle->incomes->count() }})
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="vehicleTabsContent">
                                <!-- Tab Servis -->
                                <div class="tab-pane fade show active" id="maintenance" role="tabpanel">
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
                                                    <h5 class="mt-3 text-muted">Belum ada data servis</h5>
                                                    <a href="{{ route('maintenances.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Data Servis
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Pengeluaran -->
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
                                                    <h5 class="mt-3 text-muted">Belum ada data pengeluaran</h5>
                                                    <a href="{{ route('expenses.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Data Pengeluaran
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Pendapatan -->
                                <div class="tab-pane fade" id="income" role="tabpanel">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            @if($vehicle->incomes->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Tipe</th>
                                                                <th>Jumlah</th>
                                                                <th>Catatan</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vehicle->incomes->sortByDesc('income_date')->take(10) as $income)
                                                            <tr>
                                                                <td>{{ $income->income_date->format('d/m/Y') }}</td>
                                                                <td>
                                                                    <span class="badge bg-success">{{ $income->type }}</span>
                                                                </td>
                                                                <td class="fw-bold text-success">Rp {{ number_format($income->amount) }}</td>
                                                                <td>{{ Str::limit($income->notes ?? $income->description ?? '-', 50) }}</td>
                                                                <td>
                                                                    <a href="{{ route('incomes.show', $income) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($vehicle->incomes->count() > 10)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('incomes.index') }}?vehicle={{ $vehicle->id }}" class="btn btn-outline-primary">
                                                            View All Income History
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-dollar-sign display-4 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">Belum ada data pendapatan</h5>
                                                    <a href="{{ route('incomes.create-for-vehicle', $vehicle) }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Data Pendapatan
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
</div>

<!-- Hidden Form for Deleting Barcode -->
@if($vehicle->barcode_path)
<form id="deleteBarcodeForm" action="{{ route('vehicles.delete-barcode', $vehicle->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif

<!-- Hidden Form for Deleting Vehicle Document -->
@if($vehicle->document_path)
<form id="deleteDocumentForm" action="{{ route('vehicles.delete-document', $vehicle->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif


<!-- Modal Upload Barcode -->
<div class="modal fade" id="uploadBarcodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-qrcode me-2"></i>Upload Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadBarcodeForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih File Barcode</label>
                        <input type="file" class="form-control" name="barcode_image" id="barcode_image" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                    </div>
                    <div id="barcodePreview" class="text-center mb-3" style="display:none;">
                        <img id="barcodePreviewImg" src="" alt="Preview" style="max-width: 100%; max-height: 200px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload Dokumen -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i>Upload Dokumen Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadDocumentForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Dokumen *</label>
                        <input type="text" class="form-control" name="document_name" id="document_name" placeholder="e.g., BPKB, STNK" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Dokumen *</label>
                        <select class="form-select" name="document_type" id="document_type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="BPKB">BPKB</option>
                            <option value="STNK">STNK</option>
                            <option value="KIR">KIR</option>
                            <option value="Insurance">Insurance</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Dokumen *</label>
                        <input type="file" class="form-control" name="vehicle_document" id="vehicle_document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Expiry Dates -->
<div class="modal fade" id="updateExpiryDatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Update Masa Berlaku Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateExpiryDatesForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Masa Berlaku STNK</label>
                        <input type="date" class="form-control" name="stnk_expiry_date" id="stnk_expiry_date" value="{{ $vehicle->stnk_expiry_date ? \Carbon\Carbon::parse($vehicle->stnk_expiry_date)->format('Y-m-d') : '' }}">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Masa Berlaku KIR</label>
                        <input type="date" class="form-control" name="kir_expiry_date" id="kir_expiry_date" value="{{ $vehicle->kir_expiry_date ? \Carbon\Carbon::parse($vehicle->kir_expiry_date)->format('Y-m-d') : '' }}">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Masa Berlaku GPS</label>
                        <input type="date" class="form-control" name="gps_expiry_date" id="gps_expiry_date" value="{{ $vehicle->gps_expiry_date ? \Carbon\Carbon::parse($vehicle->gps_expiry_date)->format('Y-m-d') : '' }}">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        <small>Anda dapat mengupdate satu, beberapa, atau semua tanggal sekaligus.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
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

// Delete Barcode Confirmation
function confirmDeleteBarcode() {
    if (confirm('Apakah Anda yakin ingin menghapus barcode ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteBarcodeForm').submit();
    }
}

// Fullscreen Document View
function viewDocumentFullscreen() {
    const docImg = document.getElementById('vehicleDocument');
    if (!docImg) return;

    const overlay = document.createElement('div');
    overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; display: flex; align-items: center; justify-content: center; cursor: zoom-out;';

    const img = document.createElement('img');
    img.src = docImg.src;
    img.style.cssText = 'max-width: 90%; max-height: 90%; object-fit: contain;';

    overlay.appendChild(img);
    document.body.appendChild(overlay);

    overlay.onclick = function() {
        document.body.removeChild(overlay);
    };

    const escHandler = function(e) {
        if (e.key === 'Escape') {
            document.body.removeChild(overlay);
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
}

// Click document image to view fullscreen
document.addEventListener('DOMContentLoaded', function() {
    const docImg = document.getElementById('vehicleDocument');
    if (docImg) {
        docImg.style.cursor = 'pointer';
        docImg.onclick = viewDocumentFullscreen;
        docImg.title = 'Click to view fullscreen';
    }
});

// Delete Individual Vehicle Document Confirmation
function confirmDeleteVehicleDocument(documentId) {
    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.')) {
        // Create and submit form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/vehicles/documents/${documentId}`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Open Upload Barcode Modal
function openUploadBarcodeModal() {
    const modal = new bootstrap.Modal(document.getElementById('uploadBarcodeModal'));
    modal.show();
}

// Open Upload Document Modal
function openUploadDocumentModal() {
    const modal = new bootstrap.Modal(document.getElementById('uploadDocumentModal'));
    modal.show();
}

// Open Update Expiry Dates Modal
function openUpdateExpiryDatesModal() {
    const modal = new bootstrap.Modal(document.getElementById('updateExpiryDatesModal'));
    modal.show();
}

// Preview Barcode Image
document.getElementById('barcode_image')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('barcodePreviewImg').src = e.target.result;
            document.getElementById('barcodePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Handle Upload Barcode Form
document.getElementById('uploadBarcodeForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';

    fetch('{{ route("vehicles.upload-barcode", $vehicle->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal upload barcode. Silakan coba lagi.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Handle Upload Document Form
document.getElementById('uploadDocumentForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';

    fetch('{{ route("vehicles.upload-document", $vehicle->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal upload dokumen. Silakan coba lagi.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Handle Update Expiry Dates Form
document.getElementById('updateExpiryDatesForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';

    fetch('{{ route("vehicles.update-expiry-dates", $vehicle->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal update tanggal. Silakan coba lagi.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

</script>
@endpush
@endsection



























