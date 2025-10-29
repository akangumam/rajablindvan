@extends('layouts.drivvo')

@section('title', 'Rental Data')

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
    }
    .btn-add:hover {
        background: #3498db;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
</style>

<div class="page-header">
    <h1 class="page-title">Rental</h1>
    <a href="{{ route('rentals.create') }}" class="btn-add">
        ADD NEW
    </a>
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

@if($rentals->count() > 0)
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Rental</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Periode</th>
                        <th>Tipe</th>
                        <th>Duration</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $rental)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $rental->rental_code }}</div>
                            <small class="text-muted">{{ $rental->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $rental->customer->name }}</div>
                            <small class="text-muted">{{ $rental->customer->phone }}</small>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $rental->vehicle->name }}</div>
                            <small class="text-muted">{{ $rental->vehicle->license_plate }}</small>
                        </td>
                        <td>
                            <div>{{ $rental->start_date->format('d M Y') }}</div>
                            <div>{{ $rental->end_date->format('d M Y') }}</div>
                            @if($rental->isOverdue())
                                <small class="text-danger">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Overdue {{ $rental->getDaysOverdue() }} hari
                                </small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $rental->getRentalTypeLabel() }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $rental->duration_days }} days</span>
                        </td>
                        <td>
                            <div class="fw-bold">Rp {{ number_format($rental->getFinalAmount(), 0, ',', '.') }}</div>
                            @if($rental->additional_charges > 0)
                                <small class="text-muted">
                                    +{{ number_format($rental->additional_charges, 0, ',', '.') }}
                                </small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $rental->Status_class }}">
                                {{ $rental->Status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('rentals.show', $rental) }}">
                                            <i class="bi bi-eye me-2"></i>Detail
                                        </a>
                                    </li>
                                    @if($rental->Status === 'reserved')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('rentals.edit', $rental) }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    @endif
                                    @if($rental->canBeStarted())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#startRentalModal{{ $rental->id }}">
                                            <i class="bi bi-play-circle me-2"></i>Start Rental
                                        </a>
                                    </li>
                                    @endif
                                    @if($rental->canBeCompleted())
                                    <li>
                                        <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#completeRentalModal{{ $rental->id }}">
                                            <i class="bi bi-check-circle me-2"></i>Endkan
                                        </a>
                                    </li>
                                    @endif
                                    @if($rental->Status !== 'active')
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('rentals.destroy', $rental) }}" method="POST" 
                                              onsubmit="return confirm('Yakin want to delete rental ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Start Rental Modal -->
                    @if($rental->canBeStarted())
                    <div class="modal fade" id="startRentalModal{{ $rental->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('rentals.start', $rental) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Start Rental - {{ $rental->rental_code }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Current Odometer (km)</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="actual_start_odometer" 
                                                   min="{{ $rental->start_odometer }}" 
                                                   value="{{ $rental->start_odometer }}" 
                                                   step="0.1" 
                                                   required>
                                            <small class="text-muted">Minimum: {{ number_format($rental->start_odometer) }} km</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                        <button type="submit" class="btn btn-success">Start Rental</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Complete Rental Modal -->
                    @if($rental->canBeCompleted())
                    <div class="modal fade" id="completeRentalModal{{ $rental->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('rentals.complete', $rental) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Endkan Rental - {{ $rental->rental_code }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">End Odometer (km) <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="end_odometer" 
                                                   min="{{ $rental->start_odometer }}" 
                                                   step="0.1" 
                                                   required>
                                            <small class="text-muted">Minimum: {{ number_format($rental->start_odometer) }} km</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Additional Expenses (Rp)</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="additional_charges" 
                                                   min="0" 
                                                   step="1000"
                                                   placeholder="0">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Notes Additional Expenses</label>
                                            <textarea class="form-control" 
                                                      name="additional_charges_notes" 
                                                      rows="2" 
                                                      placeholder="Denda, bahan bakar, dll..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                        <button type="submit" class="btn btn-warning">Endkan Rental</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $rentals->links() }}
</div>

@else
<div class="text-center py-5">
    <i class="bi bi-calendar-check display-1 text-muted"></i>
    <h3 class="mt-3">No data yet Rental</h3>
    <p class="text-muted">Start dengan menambahkan rental pertama you.</p>
    <a href="{{ route('rentals.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Add First Rental
    </a>
</div>
@endif
@endsection



























