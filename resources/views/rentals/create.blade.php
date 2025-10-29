@extends('layouts.drivvo')

@section('title', 'Add Rental')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-plus text-primary me-2"></i>
                        Add New Rental
                    </h5>
                    <a href="{{ route('rentals.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('rentals.store') }}" method="POST" id="rentalForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Customer & Vehicle -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-users me-2"></i>Customer & Vehicle
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">
                                        Customer <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror" 
                                            id="customer_id" 
                                            name="customer_id" 
                                            required>
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" 
                                                    {{ (old('customer_id', $selectedCustomer?->id) == $customer->id) ? 'selected' : '' }}
                                                    data-phone="{{ $customer->phone }}"
                                                    data-id-number="{{ $customer->id_number }}">
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="customerInfo" class="mt-2 p-2 bg-light rounded d-none">
                                        <small>
                                            <strong>Phone:</strong> <span id="customerPhone"></span><br>
                                            <strong>No. Identitas:</strong> <span id="customerIdNumber"></span>
                                        </small>
                                    </div>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="vehicle_id" class="form-label">
                                        Vehicle <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('vehicle_id') is-invalid @enderror" 
                                            id="vehicle_id" 
                                            name="vehicle_id" 
                                            required>
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" 
                                                    {{ (old('vehicle_id', $selectedVehicle?->id) == $vehicle->id) ? 'selected' : '' }}
                                                    data-license="{{ $vehicle->license_plate }}"
                                                    data-odometer="{{ $vehicle->getLatestOdometer() }}"
                                                    data-available="{{ $vehicle->isAvailableForRental() ? 'true' : 'false' }}">
                                                {{ $vehicle->name }} ({{ $vehicle->license_plate }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="vehicleInfo" class="mt-2 p-2 bg-light rounded d-none">
                                        <small>
                                            <strong>Plat Nomor:</strong> <span id="vehicleLicense"></span><br>
                                            <strong>Latest Odometer:</strong> <span id="vehicleOdometer"></span> km<br>
                                            <strong>Status:</strong> <span id="vehicleStatus"></span>
                                        </small>
                                    </div>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Periode Rental -->
                            <div class="col-md-6">
                                <h6 class="text-success mb-3">
                                    <i class="fas fa-calendar me-2"></i>Periode Rental
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">
                                                Date Start <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control @error('start_date') is-invalid @enderror" 
                                                   id="start_date" 
                                                   name="start_date" 
                                                   value="{{ old('start_date', date('Y-m-d')) }}" 
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
                                                Date End <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control @error('end_date') is-invalid @enderror" 
                                                   id="end_date" 
                                                   name="end_date" 
                                                   value="{{ old('end_date') }}" 
                                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
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
                                        <option value="daily" {{ old('rental_type', 'daily') == 'daily' ? 'selected' : '' }}>
                                            Daily (Per Hari)
                                        </option>
                                        <option value="weekly" {{ old('rental_type') == 'weekly' ? 'selected' : '' }}>
                                            Weekly (Per Minggu)
                                        </option>
                                        <option value="monthly" {{ old('rental_type') == 'monthly' ? 'selected' : '' }}>
                                            Monthly (Per Bulan)
                                        </option>
                                    </select>
                                    @error('rental_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Rental Type Hints -->
                                    <div class="alert alert-light border mt-2" id="rentalTypeHint">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <span id="rentalTypeHintText">Select Date Start dan End sesuai kebutuhan</span>
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="alert alert-info" id="durationInfo" style="display: none;">
                                        <strong>Duration:</strong> <span id="durationDays">0</span> hari
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="daily_rate" class="form-label">
                                                <span id="rateLabel">Rate per Day</span> (Rp) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('daily_rate') is-invalid @enderror" 
                                                   id="daily_rate" 
                                                   name="daily_rate" 
                                                   value="{{ old('daily_rate') }}" 
                                                   min="0" 
                                                   step="1000"
                                                   placeholder="300000"
                                                   required>
                                            @error('daily_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Weekly Rate (hidden by default) -->
                                        <div class="mb-3" id="weeklyRateField" style="display: none;">
                                            <label for="weekly_rate" class="form-label">
                                                Rate per Week (Rp)
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('weekly_rate') is-invalid @enderror" 
                                                   id="weekly_rate" 
                                                   name="weekly_rate" 
                                                   value="{{ old('weekly_rate') }}" 
                                                   min="0" 
                                                   step="1000"
                                                   placeholder="2000000">
                                            @error('weekly_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Monthly Rate (hidden by default) -->
                                        <div class="mb-3" id="monthlyRateField" style="display: none;">
                                            <label for="monthly_rate" class="form-label">
                                                Rate per Month (Rp)
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('monthly_rate') is-invalid @enderror" 
                                                   id="monthly_rate" 
                                                   name="monthly_rate" 
                                                   value="{{ old('monthly_rate') }}" 
                                                   min="0" 
                                                   step="1000"
                                                   placeholder="8000000">
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
                                                   value="{{ old('deposit') }}" 
                                                   min="0" 
                                                   step="1000"
                                                   placeholder="500000"
                                                   required>
                                            @error('deposit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="alert alert-warning" id="totalInfo" style="display: none;">
                                        <strong>Total Rental:</strong> Rp <span id="totalAmount">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Locations & Notes -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-warning mb-3">
                                    <i class="fas fa-map-marker-alt me-2"></i>Locations
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="pickup_location" class="form-label">Locations Pengambilan</label>
                                    <input type="text" 
                                           class="form-control @error('pickup_location') is-invalid @enderror" 
                                           id="pickup_location" 
                                           name="pickup_location" 
                                           value="{{ old('pickup_location') }}" 
                                           placeholder="Address pengambilan Vehicle">
                                    @error('pickup_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="return_location" class="form-label">Locations Pengembalian</label>
                                    <input type="text" 
                                           class="form-control @error('return_location') is-invalid @enderror" 
                                           id="return_location" 
                                           name="return_location" 
                                           value="{{ old('return_location') }}" 
                                           placeholder="Address pengembalian Vehicle">
                                    @error('return_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-info mb-3">
                                    <i class="fas fa-sticky-note me-2"></i>Notes
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes Rental</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="5" 
                                              placeholder="Notes khusus untuk rental ini...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('rentals.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>CANCEL
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Save Rental
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerSelect = document.getElementById('customer_id');
    const vehicleSelect = document.getElementById('vehicle_id');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const dailyRateInput = document.getElementById('daily_rate');
    
    // Customer info display
    customerSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const customerInfo = document.getElementById('customerInfo');
        
        if (selectedOption.value) {
            document.getElementById('customerPhone').textContent = selectedOption.dataset.phone;
            document.getElementById('customerIdNumber').textContent = selectedOption.dataset.idNumber;
            customerInfo.classList.remove('d-none');
        } else {
            customerInfo.classList.add('d-none');
        }
    });
    
    // Vehicle info display
    vehicleSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const vehicleInfo = document.getElementById('vehicleInfo');
        
        if (selectedOption.value) {
            document.getElementById('vehicleLicense').textContent = selectedOption.dataset.license;
            document.getElementById('vehicleOdometer').textContent = new Intl.NumberFormat().format(selectedOption.dataset.odometer);
            
            const StatusSpan = document.getElementById('vehicleStatus');
            if (selectedOption.dataset.available === 'true') {
                StatusSpan.innerHTML = '<span class="text-success">Available</span>';
            } else {
                StatusSpan.innerHTML = '<span class="text-danger">Tidak Available</span>';
            }
            
            vehicleInfo.classList.remove('d-none');
        } else {
            vehicleInfo.classList.add('d-none');
        }
    });
    
    // Duration and total calculation
    function calculateDurationAndTotal() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const dailyRate = parseFloat(dailyRateInput.value) || 0;
        
        if (startDate && endDate && endDate > startDate) {
            const timeDifference = endDate.getTime() - startDate.getTime();
            const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)) + 1;
            
            document.getElementById('durationDays').textContent = dayDifference;
            document.getElementById('durationInfo').style.display = 'block';
            
            if (dailyRate > 0) {
                const totalAmount = dailyRate * dayDifference;
                document.getElementById('totalAmount').textContent = new Intl.NumberFormat().format(totalAmount);
                document.getElementById('totalInfo').style.display = 'block';
            } else {
                document.getElementById('totalInfo').style.display = 'none';
            }
        } else {
            document.getElementById('durationInfo').style.display = 'none';
            document.getElementById('totalInfo').style.display = 'none';
        }
    }
    
    startDateInput.addEventListener('change', function() {
        const startDate = new Date(this.value);
        const rentalType = rentalTypeSelect.value;
        
        if (startDate && this.value) {
            let endDate = new Date(startDate);
            
            switch(rentalType) {
                case 'weekly':
                    // Auto set end date to 1 week later (7 days)
                    endDate.setDate(startDate.getDate() + 6); // 7 days total (including start date)
                    endDateInput.value = endDate.toISOString().split('T')[0];
                    endDateInput.min = endDate.toISOString().split('T')[0];
                    break;
                    
                case 'monthly':
                    // Auto set end date to 1 month later (30 days)
                    endDate.setDate(startDate.getDate() + 29); // 30 days total (including start date)
                    endDateInput.value = endDate.toISOString().split('T')[0];
                    endDateInput.min = endDate.toISOString().split('T')[0];
                    break;
                    
                default: // daily
                    // Normal behavior - minimum next day
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(startDate.getDate() + 1);
                    endDateInput.min = minEndDate.toISOString().split('T')[0];
                    break;
            }
        }
        
        calculateDurationAndTotal();
    });
    
    endDateInput.addEventListener('change', function() {
        const rentalType = rentalTypeSelect.value;
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(this.value);
        
        if (startDate && endDate && rentalType !== 'daily') {
            const duration = Math.ceil((endDate - startDate) / (1000 * 3600 * 24)) + 1;
            
            // Validate duration based on rental type
            if (rentalType === 'weekly' && duration % 7 !== 0) {
                // Suggest nearest week boundary
                const suggestedWeeks = Math.ceil(duration / 7);
                const suggestedEndDate = new Date(startDate);
                suggestedEndDate.setDate(startDate.getDate() + (suggestedWeeks * 7) - 1);
                
                if (confirm(`For weekly rentals, duration should be multiples of 7 days.\nDo you want to change the End Date to ${suggestedEndDate.toLocaleDateString('id-ID')}?`)) {
                    this.value = suggestedEndDate.toISOString().split('T')[0];
                }
            } else if (rentalType === 'monthly' && duration % 30 !== 0) {
                // Suggest nearest month boundary
                const suggestedMonths = Math.ceil(duration / 30);
                const suggestedEndDate = new Date(startDate);
                suggestedEndDate.setDate(startDate.getDate() + (suggestedMonths * 30) - 1);
                
                if (confirm(`For monthly rentals, duration should be multiples of 30 days.\nDo you want to change the End Date to ${suggestedEndDate.toLocaleDateString('id-ID')}?`)) {
                    this.value = suggestedEndDate.toISOString().split('T')[0];
                }
            }
        }
        
        calculateDurationAndTotal();
    });
    
    dailyRateInput.addEventListener('input', calculateDurationAndTotal);
    
    // Handle rental type changes
    const rentalTypeSelect = document.getElementById('rental_type');
    const dailyRateField = document.querySelector('#daily_rate').closest('.mb-3');
    const weeklyRateField = document.getElementById('weeklyRateField');
    const monthlyRateField = document.getElementById('monthlyRateField');
    const rateLabel = document.getElementById('rateLabel');
    const rentalTypeHintText = document.getElementById('rentalTypeHintText');
    
    function handleRentalTypeChange() {
        const rentalType = rentalTypeSelect.value;
        
        // Reset visibility
        dailyRateField.style.display = 'block';
        weeklyRateField.style.display = 'none';
        monthlyRateField.style.display = 'none';
        
        // Update label and show appropriate fields
        switch(rentalType) {
            case 'daily':
                rateLabel.textContent = 'Rate per Day';
                dailyRateField.querySelector('input').required = true;
                rentalTypeHintText.textContent = 'Select Date Start dan End sesuai kebutuhan';
                
                // Reset end date constraints for daily rental
                if (startDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const minEndDate = new Date(startDate);
                    minEndDate.setDate(startDate.getDate() + 1);
                    endDateInput.min = minEndDate.toISOString().split('T')[0];
                }
                break;
                
            case 'weekly':
                rateLabel.textContent = 'Rate per Week';
                dailyRateField.style.display = 'block';
                weeklyRateField.style.display = 'block';
                weeklyRateField.querySelector('input').required = true;
                rentalTypeHintText.textContent = 'After selecting Start Date, End Date will be automatically set 1 week later';
                
                // Auto-adjust dates for weekly rental
                if (startDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(startDate);
                    endDate.setDate(startDate.getDate() + 6); // 1 week
                    endDateInput.value = endDate.toISOString().split('T')[0];
                    endDateInput.min = endDate.toISOString().split('T')[0];
                }
                break;
                
            case 'monthly':
                rateLabel.textContent = 'Rate per Month';
                dailyRateField.style.display = 'block';
                monthlyRateField.style.display = 'block';
                monthlyRateField.querySelector('input').required = true;
                rentalTypeHintText.textContent = 'After selecting Start Date, End Date will be automatically set 1 month later';
                
                // Auto-adjust dates for monthly rental
                if (startDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(startDate);
                    endDate.setDate(startDate.getDate() + 29); // 1 month
                    endDateInput.value = endDate.toISOString().split('T')[0];
                    endDateInput.min = endDate.toISOString().split('T')[0];
                }
                break;
        }
        
        calculateDurationAndTotal();
    }
    
    // Update calculation function to consider rental type
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
            
            document.getElementById('durationDays').textContent = dayDifference;
            document.getElementById('durationInfo').style.display = 'block';
            
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
            
            if (rate > 0) {
                document.getElementById('totalAmount').textContent = new Intl.NumberFormat().format(totalAmount);
                document.getElementById('totalInfo').style.display = 'block';
                
                // Update duration display with rental type info
                document.getElementById('durationDays').innerHTML = 
                    `${dayDifference} hari (${units} ${unitLabel})`;
            } else {
                document.getElementById('totalInfo').style.display = 'none';
            }
        } else {
            document.getElementById('durationInfo').style.display = 'none';
            document.getElementById('totalInfo').style.display = 'none';
        }
    }
    
    rentalTypeSelect.addEventListener('change', handleRentalTypeChange);
    document.getElementById('weekly_rate').addEventListener('input', calculateDurationAndTotal);
    document.getElementById('monthly_rate').addEventListener('input', calculateDurationAndTotal);
    
    // Initialize rental type
    handleRentalTypeChange();
    
    // Trigger customer and vehicle info on page load if pre-selected
    if (customerSelect.value) {
        customerSelect.dispatchEvent(new Event('change'));
    }
    if (vehicleSelect.value) {
        vehicleSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection



























