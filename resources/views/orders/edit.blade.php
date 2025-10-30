@extends('layouts.drivvo')

@section('title', 'Edit Order')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">
            <i class="bi bi-pencil"></i> Edit Order
        </h1>
        <p class="page-subtitle">Update order information</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Order Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vehicle_id" class="form-label">1. Vehicle Name <span class="text-danger">*</span></label>
                        <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                            <option value="">Select Vehicle</option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ (old('vehicle_id', $order->vehicle_id) == $vehicle->id) ? 'selected' : '' }}>
                                {{ $vehicle->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">2. License Plate</label>
                        <input type="text" class="form-control" id="license_plate_display" readonly value="{{ $order->vehicle->license_plate ?? '-' }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">3. Year of Manufacture</label>
                        <input type="text" class="form-control" id="year_display" readonly value="{{ $order->vehicle->year ?? '-' }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="customer_id" class="form-label">4. Customer <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ (old('customer_id', $order->customer_id) == $customer->id) ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary" title="Manage Customer">
                                <i class="bi bi-person-gear"></i> Manage
                            </a>
                        </div>
                        @error('customer_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="rental_type" class="form-label">5. Tipe Sewa <span class="text-danger">*</span></label>
                        <select class="form-select @error('rental_type') is-invalid @enderror" id="rental_type" name="rental_type" required>
                            <option value="">Select Type</option>
                            <option value="Sewa Harian" {{ old('rental_type', $order->rental_type) == 'Sewa Harian' ? 'selected' : '' }}>Sewa Harian</option>
                            <option value="Sewa Bulanan" {{ old('rental_type', $order->rental_type) == 'Sewa Bulanan' ? 'selected' : '' }}>Sewa Bulanan</option>
                        </select>
                        @error('rental_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Active" {{ old('status', $order->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $order->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">6. Start Contract <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $order->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Contract <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $order->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> 7. Save Changes
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const vehicleSelect = document.getElementById('vehicle_id');
    const licensePlateInput = document.getElementById('license_plate_display');
    const yearInput = document.getElementById('year_display');

    // Vehicle data from backend
    const vehicles = @json($vehicles);

    vehicleSelect.addEventListener('change', function() {
        const selectedId = this.value;
        const vehicle = vehicles.find(v => v.id == selectedId);

        if (vehicle) {
            licensePlateInput.value = vehicle.license_plate || '-';
            yearInput.value = vehicle.year || '-';
        } else {
            licensePlateInput.value = '';
            yearInput.value = '';
        }
    });
});
</script>
@endsection
