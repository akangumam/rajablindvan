@extends('layouts.drivvo')

@section('title', 'Add New Order')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">
            <i class="bi bi-plus-circle"></i> Add New Order
        </h1>
        <p class="page-subtitle">Create a new order based on vehicle</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Order Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vehicle_id" class="form-label">1. Vehicle Name<span class="text-danger">*</span></label>
                        <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                            <option value="">Select Vehicle</option>
                            @forelse($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }}
                            </option>
                            @empty
                            <option value="" disabled>No vehicles available</option>
                            @endforelse
                        </select>
                        @error('vehicle_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">2. License Plate</label>
                        <input type="text" class="form-control" id="license_plate_display" readonly placeholder="Auto-filled from vehicle">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">3. Year of Manufacture</label>
                        <input type="text" class="form-control" id="year_display" readonly placeholder="Auto-filled from vehicle">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="customer_id" class="form-label">4. Customer <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                            <a href="{{ route('customers.create') }}" class="btn btn-outline-primary" title="Add New Customer">
                                <i class="bi bi-person-plus"></i> ADD Customer
                            </a>
                        </div>
                        @error('customer_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Click "ADD Customer" to create new customer</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="rental_type" class="form-label">5. Rental Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('rental_type') is-invalid @enderror" id="rental_type" name="rental_type" required>
                            <option value="">Select Type</option>
                            <option value="Sewa Harian" {{ old('rental_type') == 'Sewa Harian' ? 'selected' : '' }}>Sewa Harian</option>
                            <option value="Sewa Bulanan" {{ old('rental_type') == 'Sewa Bulanan' ? 'selected' : '' }}>Sewa Bulanan</option>
                        </select>
                        @error('rental_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">6. Start Contract <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Contract <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> 7. Save
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Information Box -->
    <div class="alert alert-info mt-3">
        <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Information:</h6>
        <ul class="mb-0">
            <li>Menampilkan seluruh kendaraan dengan status <strong>Active</strong> baik yang sudah tersewa atau belum tersewa</li>
            <li>License Plate dan Year akan otomatis terisi setelah memilih kendaraan</li>
            <li>Untuk menambah customer baru, klik tombol <strong>ADD Customer</strong></li>
        </ul>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.page-subtitle {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 0;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
    padding: 1rem 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.text-danger {
    color: #dc3545 !important;
}
</style>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#vehicle_id').select2({
        theme: 'bootstrap-5',
        placeholder: "Select Vehicle",
        allowClear: true,
        width: '100%'
    });

    $('#customer_id').select2({
        theme: 'bootstrap-5',
        placeholder: "Select Customer",
        allowClear: true,
        width: '100%' // Fix for input group
    });

    // Vehicle data from backend
    const vehicles = @json($vehicles);

    // Handle change event using jQuery for Select2 compatibility
    $('#vehicle_id').on('change', function() {
        const selectedId = $(this).val();
        const vehicle = vehicles.find(v => v.id == selectedId);

        if (vehicle) {
            $('#license_plate_display').val(vehicle.license_plate || '-');
            $('#year_display').val(vehicle.year || '-');
        } else {
            $('#license_plate_display').val('');
            $('#year_display').val('');
        }
    });
});
</script>
@endpush
@endsection
