@extends('layouts.drivvo')

@section('title', 'Edit Rental')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Edit Rental - {{ $rental->rental_code }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rentals.update', $rental) }}" method="POST" id="rentalForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Customer Selection -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>Customer
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">
                                        Pilih Customer <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror" 
                                            id="customer_id" 
                                            name="customer_id" 
                                            required>
                                        <option value="">-- Pilih Customer --</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" 
                                                    {{ old('customer_id', $rental->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Vehicle Selection -->
                            <div class="col-md-6">
                                <h6 class="text-success mb-3">
                                    <i class="fas fa-car me-2"></i>Kendaraan
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="vehicle_id" class="form-label">
                                        Pilih Kendaraan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('vehicle_id') is-invalid @enderror" 
                                            id="vehicle_id" 
                                            name="vehicle_id" 
                                            required>
                                        <option value="">-- Pilih Kendaraan --</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" 
                                                    data-daily-rate="{{ $vehicle->daily_rental_rate }}"
                                                    data-weekly-rate="{{ $vehicle->weekly_rental_rate }}"
                                                    data-monthly-rate="{{ $vehicle->monthly_rental_rate }}"
                                                    {{ old('vehicle_id', $rental->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->name }} - {{ $vehicle->license_plate }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Periode Rental -->
                            <div class="col-md-6">
                                <h6 class="text-warning mb-3">
                                    <i class="fas fa-calendar me-2"></i>Periode Rental
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">
                                                Tanggal Mulai <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control @error('start_date') is-invalid @enderror" 
                                                   id="start_date" 
                                                   name="start_date" 
                                                   value="{{ old('start_date', $rental->start_date->format('Y-m-d')) }}" 
                                                   min="{{ date('Y-m-d') }}"
                                                   required>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">
                                                Tanggal Selesai <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control @error('end_date') is-invalid @enderror" 
                                                   id="end_date" 
                                                   name="end_date" 
                                                   value="{{ old('end_date', $rental->end_date->format('Y-m-d')) }}" 
                                                   required>
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="rental_type" class="form-label">
                                        Tipe Rental <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('rental_type') is-invalid @enderror" 
                                            id="rental_type" 
                                            name="rental_type" 
                                            required>
                                        <option value="daily" {{ old('rental_type', $rental->rental_type) == 'daily' ? 'selected' : '' }}>
                                            Harian (Per Hari)
                                        </option>
                                        <option value="weekly" {{ old('rental_type', $rental->rental_type) == 'weekly' ? 'selected' : '' }}>
                                            Mingguan (Per Minggu)
                                        </option>
                                        <option value="monthly" {{ old('rental_type', $rental->rental_type) == 'monthly' ? 'selected' : '' }}>
                                            Bulanan (Per Bulan)
                                        </option>
                                    </select>
                                    @error('rental_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="alert alert-info" id="durationInfo">
                                        <strong>Durasi:</strong> <span id="durationDays">{{ $rental->duration_days }}</span> hari
                                    </div>
                                </div>
                            </div>

                            <!-- Tarif -->
                            <div class="col-md-6">
                                <h6 class="text-info mb-3">
                                    <i class="fas fa-money-bill me-2"></i>Tarif & Deposit
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="daily_rate" class="form-label">
                                                <span id="rateLabel">Tarif per Hari</span> (Rp) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('daily_rate') is-invalid @enderror" 
                                                   id="daily_rate" 
                                                   name="daily_rate" 
                                                   value="{{ old('daily_rate', $rental->daily_rate) }}" 
                                                   min="0" 
                                                   step="1000"
                                                   required>
                                            @error('daily_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Weekly Rate -->
                                        <div class="mb-3" id="weeklyRateField" style="display: none;">
                                            <label for="weekly_rate" class="form-label">
                                                Tarif per Minggu (Rp)
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('weekly_rate') is-invalid @enderror" 
                                                   id="weekly_rate" 
                                                   name="weekly_rate" 
                                                   value="{{ old('weekly_rate', $rental->weekly_rate) }}" 
                                                   min="0" 
                                                   step="1000">
                                            @error('weekly_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Monthly Rate -->
                                        <div class="mb-3" id="monthlyRateField" style="display: none;">
                                            <label for="monthly_rate" class="form-label">
                                                Tarif per Bulan (Rp)
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('monthly_rate') is-invalid @enderror" 
                                                   id="monthly_rate" 
                                                   name="monthly_rate" 
                                                   value="{{ old('monthly_rate', $rental->monthly_rate) }}" 
                                                   min="0" 
                                                   step="1000">
                                            @error('monthly_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="deposit" class="form-label">
                                                Deposit (Rp) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('deposit') is-invalid @enderror" 
                                                   id="deposit" 
                                                   name="deposit" 
                                                   value="{{ old('deposit', $rental->deposit) }}" 
                                                   min="0" 
                                                   step="1000"
                                                   required>
                                            @error('deposit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="alert alert-success" id="totalInfo">
                                        <strong>Total Biaya:</strong> Rp <span id="totalAmount">{{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pickup_location" class="form-label">
                                        <i class="fas fa-map-marker-alt text-success me-1"></i>
                                        Lokasi Pengambilan
                                    </label>
                                    <textarea class="form-control @error('pickup_location') is-invalid @enderror" 
                                              id="pickup_location" 
                                              name="pickup_location" 
                                              rows="3" 
                                              placeholder="Alamat pengambilan kendaraan...">{{ old('pickup_location', $rental->pickup_location) }}</textarea>
                                    @error('pickup_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="return_location" class="form-label">
                                        <i class="fas fa-map-marker-alt text-warning me-1"></i>
                                        Lokasi Pengembalian
                                    </label>
                                    <textarea class="form-control @error('return_location') is-invalid @enderror" 
                                              id="return_location" 
                                              name="return_location" 
                                              rows="3" 
                                              placeholder="Alamat pengembalian kendaraan...">{{ old('return_location', $rental->return_location) }}</textarea>
                                    @error('return_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">
                                        <i class="fas fa-sticky-note text-info me-1"></i>
                                        Catatan
                                    </label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="3" 
                                              placeholder="Catatan tambahan...">{{ old('notes', $rental->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rentals.show', $rental) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Rental
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const dailyRateInput = document.getElementById('daily_rate');
    const rentalTypeSelect = document.getElementById('rental_type');
    const dailyRateField = document.querySelector('#daily_rate').closest('.mb-3');
    const weeklyRateField = document.getElementById('weeklyRateField');
    const monthlyRateField = document.getElementById('monthlyRateField');
    const rateLabel = document.getElementById('rateLabel');

    function handleRentalTypeChange() {
        const rentalType = rentalTypeSelect.value;
        
        // Reset visibility
        dailyRateField.style.display = 'block';
        weeklyRateField.style.display = 'none';
        monthlyRateField.style.display = 'none';
        
        // Update label and show appropriate fields
        switch(rentalType) {
            case 'daily':
                rateLabel.textContent = 'Tarif per Hari';
                dailyRateField.querySelector('input').required = true;
                break;
                
            case 'weekly':
                rateLabel.textContent = 'Tarif per Minggu';
                dailyRateField.style.display = 'block';
                weeklyRateField.style.display = 'block';
                weeklyRateField.querySelector('input').required = true;
                break;
                
            case 'monthly':
                rateLabel.textContent = 'Tarif per Bulan';
                dailyRateField.style.display = 'block';
                monthlyRateField.style.display = 'block';
                monthlyRateField.querySelector('input').required = true;
                break;
        }
        
        calculateDurationAndTotal();
    }

    function calculateDurationAndTotal() {
        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
        const rentalType = rentalTypeSelect.value;
        const dailyRate = parseFloat(dailyRateInput.value) || 0;
        const weeklyRate = parseFloat(document.getElementById('weekly_rate').value) || 0;
        const monthlyRate = parseFloat(document.getElementById('monthly_rate').value) || 0;
        
        if (startDate && endDate && endDate > startDate) {
            const timeDifference = endDate.getTime() - startDate.getTime();
            const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)) + 1;
            
            let totalAmount = 0;
            let rate = 0;
            let units = 0;
            let unitLabel = '';
            
            switch(rentalType) {
                case 'daily':
                    rate = dailyRate;
                    units = dayDifference;
                    unitLabel = 'hari';
                    totalAmount = rate * units;
                    break;
                    
                case 'weekly':
                    rate = weeklyRate || (dailyRate * 7);
                    units = Math.ceil(dayDifference / 7);
                    unitLabel = 'minggu';
                    totalAmount = rate * units;
                    break;
                    
                case 'monthly':
                    rate = monthlyRate || (dailyRate * 30);
                    units = Math.ceil(dayDifference / 30);
                    unitLabel = 'bulan';
                    totalAmount = rate * units;
                    break;
            }
            
            document.getElementById('durationDays').innerHTML = 
                `${dayDifference} hari (${units} ${unitLabel})`;
            
            if (rate > 0) {
                document.getElementById('totalAmount').textContent = new Intl.NumberFormat().format(totalAmount);
            }
        }
    }
    
    startDateInput.addEventListener('change', function() {
        // Update minimum end date
        const startDate = new Date(this.value);
        const minEndDate = new Date(startDate);
        minEndDate.setDate(startDate.getDate() + 1);
        endDateInput.min = minEndDate.toISOString().split('T')[0];
        
        calculateDurationAndTotal();
    });
    
    endDateInput.addEventListener('change', calculateDurationAndTotal);
    dailyRateInput.addEventListener('input', calculateDurationAndTotal);
    rentalTypeSelect.addEventListener('change', handleRentalTypeChange);
    document.getElementById('weekly_rate').addEventListener('input', calculateDurationAndTotal);
    document.getElementById('monthly_rate').addEventListener('input', calculateDurationAndTotal);
    
    // Initialize
    handleRentalTypeChange();
    calculateDurationAndTotal();
});
</script>
@endsection