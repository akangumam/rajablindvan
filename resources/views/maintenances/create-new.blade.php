@extends('layouts.drivvo-form', [
    'pageTitle' => 'Add New Service',
    'pageIcon' => 'fas fa-wrench',
    'formAction' => route('maintenances.store'),
    'formId' => 'maintenanceForm',
    'cancelRoute' => route('maintenances.index'),
    'modalRoute' => route('maintenances.create'),
    'vehicle' => $vehicle ?? null
])

@section('form-fields')
@php
    // Get last odometer from this vehicle
    $lastOdometer = 0;
    if(isset($vehicle)) {
        $lastFill = $vehicle->fuelFills()->latest('fill_date')->first();
        $lastMaintenance = $vehicle->maintenances()->latest('maintenance_date')->first();
        $lastTrip = $vehicle->trips()->latest('trip_date')->first();
        
        $odometerValues = collect([
            $lastFill ? $lastFill->odometer : 0,
            $lastMaintenance ? $lastMaintenance->odometer : 0,
            $lastTrip ? $lastTrip->end_odometer ?? $lastTrip->start_odometer : 0
        ]);
        
        $lastOdometer = $odometerValues->max();
    }
@endphp

<!-- Hidden fields for backend compatibility -->
<input type="hidden" name="category" value="service">
<input type="hidden" name="cost" value="0">
<input type="hidden" name="description" value="-">

<!-- Date dan Waktu -->
<div class="row">
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">Time</label>
            <div class="input-group">
                <input type="time" name="time" id="timeInput" class="form-control" value="{{ old('time', date('H:i')) }}" required style="border-right: 0;">
                <button type="button" class="input-group-text" onclick="openTimePicker()" style="cursor: pointer; background: white; border-left: 0;">
                    <i class="far fa-clock" style="color: #6c757d;"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Odometer -->
<div class="field-group">
    <label class="form-label">Odometer (km)</label>
    <div class="input-group">
        <input type="number" step="0.01" name="odometer" id="odometerInput" class="form-control" 
               value="{{ old('odometer') }}" 
               min="{{ $lastOdometer }}" 
               placeholder="Enter Current Odometer" required>
        <span class="input-group-text">km</span>
    </div>
    @if($lastOdometer > 0)
        <small class="text-muted">Latest Odometer: {{ number_format($lastOdometer, 0, ',', '.') }} km</small>
    @else
        <small class="text-muted">Latest Odometer: 0 km</small>
    @endif
</div>

<!-- Service Type -->
<div class="field-group">
    <label class="form-label">Service Type</label>
    <select name="service_type_id" class="form-control @error('service_type_id') is-invalid @enderror" required>
        <option value="">Select Service Type</option>
        @foreach($serviceTypes as $serviceType)
            <option value="{{ $serviceType->id }}" {{ old('service_type_id') == $serviceType->id ? 'selected' : '' }}>
                {{ $serviceType->name }}
            </option>
        @endforeach
    </select>
    @error('service_type_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Place -->
<div class="field-group">
    <label class="form-label">Place</label>
    <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Workshop name or location">
</div>

<!-- Driver -->
<div class="field-group">
    <label class="form-label">Driver</label>
    <input type="text" name="driver" id="driverInput" class="form-control"
           value="{{ old('driver') }}"
           placeholder="Select driver"
           readonly
           onclick="openDriverModal()"
           style="cursor: pointer; background: white;">
</div>

<!-- Payment Method -->
<div class="field-group">
    <label class="form-label">Payment Method</label>
    <select name="payment_method_id" class="form-control @error('payment_method_id') is-invalid @enderror" required>
        <option value="">Select Payment Method</option>
        @foreach($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->id }}" {{ old('payment_method_id') == $paymentMethod->id ? 'selected' : '' }}>
                {{ $paymentMethod->name }}
            </option>
        @endforeach
    </select>
    @error('payment_method_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Upload Attachment -->
<div class="field-group">
    <label class="form-label">Attachment</label>
    <button type="button" class="btn" onclick="document.getElementById('attachmentInput').click();" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
        <i class="fas fa-paperclip" style="margin-right: 8px;"></i>
        <span id="attachmentButtonText">ATTACH FILE</span>
    </button>
    <input type="file" name="attachment" id="attachmentInput" style="display: none;" accept="image/*,.pdf" onchange="updateAttachmentButtonText(this)">
</div>

<!-- Notes -->
<div class="field-group">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Add notes (optional)">{{ old('notes') }}</textarea>
</div>
@endsection

@section('modals')
<!-- Service Types Modal -->
<div class="modal fade" id="serviceTypesModal" tabindex="-1" aria-labelledby="serviceTypesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="serviceTypesModalLabel" style="font-size: 18px; font-weight: 500;">Service Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Search Box -->
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="serviceTypeSearch" class="form-control" placeholder="Search Service Type..." style="border-left: 0;">
                    </div>
                </div>
                
                <!-- Service Types List with Checkboxes -->
                <div id="serviceTypesList" style="max-height: 400px; overflow-y: auto;">
                    <!-- AC -->
                    <div class="service-type-item" data-value="AC" data-price="0" style="padding: 12px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <input type="checkbox" class="form-check-input service-checkbox" id="service_ac" style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                            <label for="service_ac" style="color: #5B7C99; font-size: 15px; cursor: pointer; margin: 0; flex: 1;">AC</label>
                        </div>
                        <input type="number" class="form-control service-price-input" placeholder="Nilai" style="width: 150px; display: none; text-align: right;" step="0.01" min="0">
                    </div>
                    
                    <!-- Ban Baru -->
                    <div class="service-type-item" data-value="Ban Baru" data-price="0" style="padding: 12px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <input type="checkbox" class="form-check-input service-checkbox" id="service_new_tires" style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                            <label for="service_new_tires" style="color: #5B7C99; font-size: 15px; cursor: pointer; margin: 0; flex: 1;">New Tires</label>
                        </div>
                        <input type="number" class="form-control service-price-input" placeholder="Nilai" style="width: 150px; display: none; text-align: right;" step="0.01" min="0">
                    </div>
                    
                    <!-- Batere -->
                    <div class="service-type-item" data-value="Batere" data-price="0" style="padding: 12px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <input type="checkbox" class="form-check-input service-checkbox" id="service_batere" style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                            <label for="service_batere" style="color: #5B7C99; font-size: 15px; cursor: pointer; margin: 0; flex: 1;">Batere</label>
                        </div>
                        <input type="number" class="form-control service-price-input" placeholder="Nilai" style="width: 150px; display: none; text-align: right;" step="0.01" min="0">
                    </div>
                    
                    <!-- Cost Tenaga Kerja -->
                    <div class="service-type-item" data-value="Cost Tenaga Kerja" data-price="0" style="padding: 12px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <input type="checkbox" class="form-check-input service-checkbox" id="service_tenaga_kerja" style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                            <label for="service_tenaga_kerja" style="color: #5B7C99; font-size: 15px; cursor: pointer; margin: 0; flex: 1;">Cost Tenaga Kerja</label>
                        </div>
                        <input type="number" class="form-control service-price-input" placeholder="Nilai" style="width: 150px; display: none; text-align: right;" step="0.01" min="0">
                    </div>
                    
                    <!-- Brake Fluid -->
                    <div class="service-type-item" data-value="Brake Fluid" data-price="0" style="padding: 12px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <input type="checkbox" class="form-check-input service-checkbox" id="service_brake_fluid" style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                            <label for="service_brake_fluid" style="color: #5B7C99; font-size: 15px; cursor: pointer; margin: 0; flex: 1;">Brake Fluid</label>
                        </div>
                        <input type="number" class="form-control service-price-input" placeholder="Nilai" style="width: 150px; display: none; text-align: right;" step="0.01" min="0">
                    </div>
                </div>
                
                <!-- Footer with Buttons -->
                <div style="padding: 16px 20px; border-top: 2px solid #e0e0e0; display: flex; gap: 12px;">
                    <button type="button" class="btn" onclick="showAddServiceTypeForm()" style="flex: 1; padding: 12px; border: 2px solid #e0e0e0; border-radius: 24px; background: white; color: #6c757d; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        ADD SERVICE
                    </button>
                    <button type="button" class="btn" onclick="confirmServiceSelection()" style="flex: 1; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: #1976d2; color: white; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Service Type Modal -->
<div class="modal fade" id="addServiceTypeModal" tabindex="-1" aria-labelledby="addServiceTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="addServiceTypeModalLabel" style="font-size: 18px; font-weight: 500;">Add Service Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="newServiceTypeName" class="form-label" style="color: #5B7C99; font-size: 14px;">Service Type Name</label>
                    <input type="text" id="newServiceTypeName" class="form-control" placeholder="Enter service type name" style="border-radius: 8px; padding: 12px;">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 16px 20px;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="padding: 10px 24px; border: 2px solid #e0e0e0; border-radius: 24px; background: white; color: #6c757d; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                    CANCEL
                </button>
                <button type="button" class="btn" onclick="addNewServiceType()" style="padding: 10px 24px; border: 2px solid #1976d2; border-radius: 24px; background: #1976d2; color: white; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Driver Modal -->
<div class="modal fade" id="driverModal" tabindex="-1" aria-labelledby="driverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="driverModalLabel" style="font-size: 18px; font-weight: 500;">Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="driverSearch" class="form-control" placeholder="Search driver..." style="border-left: 0;">
                    </div>
                </div>
                <div id="driverList" style="max-height: 300px; overflow-y: auto;">
                    @forelse($users ?? [] as $user)
                    <div class="driver-item" data-value="{{ $user->name }}" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">{{ $user->name }}</span>
                        @if($user->Email)
                        <br><small style="color: #9e9e9e; font-size: 13px;">{{ $user->Email }}</small>
                        @endif
                    </div>
                    @empty
                    <div style="padding: 16px 20px; text-align: center; color: #9e9e9e;">
                        <small>No driver data yet</small>
                    </div>
                    @endforelse
                </div>
                <div style="padding: 16px 20px; border-top: 2px solid #e0e0e0;">
                    <button type="button" class="btn" onclick="showAddDriverForm()" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        ADD NEW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Driver Modal -->
<div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="addDriverModalLabel" style="font-size: 18px; font-weight: 500;">Add Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="newDriverName" class="form-label">Driver Name</label>
                    <input type="text" class="form-control" id="newDriverName" placeholder="Enter driver name">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 12px 16px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="addNewDriver()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="paymentMethodModalLabel" style="font-size: 18px; font-weight: 500;">Payment Methods</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="paymentMethodSearch" class="form-control" placeholder="Search Payment Methods..." style="border-left: 0;">
                    </div>
                </div>
                <div id="paymentMethodList" style="max-height: 300px; overflow-y: auto;">
                    <div class="payment-method-item" data-value="Tunai" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Tunai</span>
                    </div>
                    <div class="payment-method-item" data-value="Kartu Debit" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Kartu Debit</span>
                    </div>
                    <div class="payment-method-item" data-value="Kartu Kredit" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Kartu Kredit</span>
                    </div>
                    <div class="payment-method-item" data-value="E-Wallet" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">E-Wallet</span>
                    </div>
                    <div class="payment-method-item" data-value="Transfer Bank" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Transfer Bank</span>
                    </div>
                </div>
                <div style="padding: 16px 20px; border-top: 2px solid #e0e0e0;">
                    <button type="button" class="btn" onclick="showAddPaymentMethodForm()" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        ADD NEW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Payment Method Modal -->
<div class="modal fade" id="addPaymentMethodModal" tabindex="-1" aria-labelledby="addPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="addPaymentMethodModalLabel" style="font-size: 18px; font-weight: 500;">Add Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="newPaymentMethodName" class="form-label">Payment Methods</label>
                    <input type="text" class="form-control" id="newPaymentMethodName" placeholder="Enter payment method">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 12px 16px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="addNewPaymentMethod()">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
// ===== SERVICE TYPES MULTI-SELECT =====
let selectedServices = [];

function openServiceTypesModal() {
    const modal = new bootstrap.Modal(document.getElementById('serviceTypesModal'));
    modal.show();
}

// Search service types
document.getElementById('serviceTypeSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const items = document.querySelectorAll('.service-type-item');
    
    items.forEach(item => {
        const label = item.querySelector('label').textContent.toLowerCase();
        item.style.display = label.includes(searchText) ? 'flex' : 'none';
    });
});

// Handle checkbox change - show/hide price input
document.querySelectorAll('.service-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const item = this.closest('.service-type-item');
        const priceInput = item.querySelector('.service-price-input');
        
        if (this.checked) {
            priceInput.style.display = 'block';
            priceInput.focus();
        } else {
            priceInput.style.display = 'none';
            priceInput.value = '';
        }
    });
});

// Handle label click to toggle checkbox
document.querySelectorAll('.service-type-item label').forEach(label => {
    label.addEventListener('click', function(e) {
        e.preventDefault();
        const checkbox = this.closest('.service-type-item').querySelector('.service-checkbox');
        checkbox.click();
    });
});

// Show add service type form
function showAddServiceTypeForm() {
    bootstrap.Modal.getInstance(document.getElementById('serviceTypesModal')).hide();
    new bootstrap.Modal(document.getElementById('addServiceTypeModal')).show();
}

// Add new service type
function addNewServiceType() {
    const newName = document.getElementById('newServiceTypeName').value.trim();
    if (!newName) {
        alert('Mohon Enter service type name');
        return;
    }
    
    // Check for duplicates
    const existingServices = document.querySelectorAll('.service-type-item span:first-child');
    for (let service of existingServices) {
        if (service.textContent.toLowerCase() === newName.toLowerCase()) {
            alert('Service Type "' + newName + '" already exists!');
            return;
        }
    }
    
    // Add new service to list
    const serviceTypeList = document.getElementById('serviceTypeList');
    const newItem = document.createElement('div');
    newItem.className = 'service-type-item';
    newItem.style.cssText = 'padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;';
    newItem.innerHTML = `
        <div style="display: flex; align-items: center; gap: 12px;">
            <input type="checkbox" class="service-checkbox" style="width: 20px; height: 20px; cursor: pointer;">
            <span style="color: #5B7C99; font-size: 15px;">${newName}</span>
        </div>
        <input type="number" class="service-price-input" placeholder="Price" style="display: none; width: 150px; padding: 8px; border: 1px solid #e0e0e0; border-radius: 8px; text-align: right;">
    `;
    
    serviceTypeList.appendChild(newItem);
    
    // Add event listeners to the new checkbox
    const checkbox = newItem.querySelector('.service-checkbox');
    const priceInput = newItem.querySelector('.service-price-input');
    
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            priceInput.style.display = 'block';
            priceInput.focus();
        } else {
            priceInput.style.display = 'none';
            priceInput.value = '';
        }
    });
    
    newItem.addEventListener('click', function(e) {
        if (e.target !== checkbox && e.target !== priceInput) {
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
    
    newItem.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    newItem.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
    
    // Close add modal and return to service types modal
    bootstrap.Modal.getInstance(document.getElementById('addServiceTypeModal')).hide();
    document.getElementById('newServiceTypeName').value = '';
    new bootstrap.Modal(document.getElementById('serviceTypesModal')).show();
    
    alert('Service Type "' + newName + '" successfully added!');
}

// Select all services
function selectAllServices() {
    const checkboxes = document.querySelectorAll('.service-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        if (!allChecked) {
            checkbox.checked = true;
            const priceInput = checkbox.closest('.service-type-item').querySelector('.service-price-input');
            priceInput.style.display = 'block';
        } else {
            checkbox.checked = false;
            const priceInput = checkbox.closest('.service-type-item').querySelector('.service-price-input');
            priceInput.style.display = 'none';
            priceInput.value = '';
        }
    });
}

// Confirm service selection
function confirmServiceSelection() {
    selectedServices = [];
    let totalCost = 0;
    const checkboxes = document.querySelectorAll('.service-checkbox:checked');
    
    if (checkboxes.length === 0) {
        alert('Select at least one Service Type');
        return;
    }
    
    // Validate all checked services have price
    let hasError = false;
    checkboxes.forEach(checkbox => {
        const item = checkbox.closest('.service-type-item');
        const priceInput = item.querySelector('.service-price-input');
        const price = parseFloat(priceInput.value) || 0;
        
        if (price === 0) {
            hasError = true;
        }
    });
    
    if (hasError) {
        alert('Please enter values for all checked services');
        return;
    }
    
    // Collect selected services
    checkboxes.forEach(checkbox => {
        const item = checkbox.closest('.service-type-item');
        const serviceName = item.getAttribute('data-value');
        const priceInput = item.querySelector('.service-price-input');
        const price = parseFloat(priceInput.value) || 0;
        
        selectedServices.push({
            name: serviceName,
            price: price
        });
        
        totalCost += price;
    });
    
    // Update display
    updateServiceTypesDisplay();
    
    // Store in hidden input as JSON
    document.getElementById('serviceTypesInput').value = JSON.stringify(selectedServices);
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('serviceTypesModal')).hide();
}

function updateServiceTypesDisplay() {
    const display = document.getElementById('serviceTypesDisplay');
    const placeholder = document.getElementById('serviceTypesPlaceholder');
    
    if (selectedServices.length === 0) {
        placeholder.style.display = 'inline';
        display.querySelectorAll('.service-badge').forEach(badge => badge.remove());
        return;
    }
    
    placeholder.style.display = 'none';
    display.querySelectorAll('.service-badge').forEach(badge => badge.remove());
    
    // Calculate total
    let totalCost = 0;
    selectedServices.forEach(service => {
        totalCost += service.price;
    });
    
    // Create summary display
    const summaryDiv = document.createElement('div');
    summaryDiv.className = 'service-badge';
    summaryDiv.style.cssText = 'width: 100%; display: flex; flex-direction: column; gap: 8px;';
    
    // Add each service as a row
    selectedServices.forEach(service => {
        const row = document.createElement('div');
        row.style.cssText = 'display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #f0f0f0; border-radius: 6px;';
        row.innerHTML = `
            <span style="color: #5B7C99; font-size: 14px; font-weight: 500;">${service.name}</span>
            <span style="color: #333; font-size: 14px;">Rp ${Number(service.price).toLocaleString('id-ID')}</span>
        `;
        summaryDiv.appendChild(row);
    });
    
    // Add total row
    const totalRow = document.createElement('div');
    totalRow.style.cssText = 'display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #e3f2fd; border-radius: 6px; border-top: 2px solid #1976d2;';
    totalRow.innerHTML = `
        <span style="color: #1976d2; font-size: 15px; font-weight: 600;">Total Cost</span>
        <span style="color: #1976d2; font-size: 15px; font-weight: 600;">Rp ${Number(totalCost).toLocaleString('id-ID')}</span>
    `;
    summaryDiv.appendChild(totalRow);
    
    // Add "+ SERVICE TYPE" button
    const addButton = document.createElement('button');
    addButton.type = 'button';
    addButton.style.cssText = 'display: flex; align-items: center; gap: 8px; padding: 8px 12px; background: white; border: 1px solid #1976d2; border-radius: 6px; color: #1976d2; font-size: 14px; font-weight: 500; cursor: pointer; margin-top: 4px;';
    addButton.innerHTML = '<i class="fas fa-plus"></i> SERVICE TYPE';
    addButton.onclick = function(e) {
        e.stopPropagation();
        openServiceTypesModal();
    };
    summaryDiv.appendChild(addButton);
    
    display.appendChild(summaryDiv);
}

// File attachment button text update
function updateAttachmentButtonText(input) {
    const buttonText = document.getElementById('attachmentButtonText');
    if (input.files && input.files[0]) {
        buttonText.textContent = input.files[0].name;
    } else {
        buttonText.textContent = 'ATTACH FILE';
    }
}

// ===== DRIVER MODAL FUNCTIONS =====
function openDriverModal() {
    const modal = new bootstrap.Modal(document.getElementById('driverModal'));
    modal.show();
}

document.getElementById('driverSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const items = document.querySelectorAll('.driver-item');
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchText) ? 'block' : 'none';
    });
});

document.querySelectorAll('.driver-item').forEach(item => {
    item.addEventListener('click', function() {
        document.getElementById('driverInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('driverModal')).hide();
    });
    item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
});

function showAddDriverForm() {
    bootstrap.Modal.getInstance(document.getElementById('driverModal')).hide();
    new bootstrap.Modal(document.getElementById('addDriverModal')).show();
}

function addNewDriver() {
    const newName = document.getElementById('newDriverName').value.trim();
    if (!newName) { alert('Mohon Enter driver name'); return; }
    
    const driverList = document.getElementById('driverList');
    const newItem = document.createElement('div');
    newItem.className = 'driver-item';
    newItem.setAttribute('data-value', newName);
    newItem.style.cssText = 'padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;';
    newItem.innerHTML = `<span style="color: #5B7C99; font-size: 15px;">${newName}</span>`;
    
    newItem.addEventListener('click', function() {
        document.getElementById('driverInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('driverModal')).hide();
    });
    newItem.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    newItem.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
    
    driverList.appendChild(newItem);
    bootstrap.Modal.getInstance(document.getElementById('addDriverModal')).hide();
    document.getElementById('driverInput').value = newName;
    document.getElementById('newDriverName').value = '';
    alert('Driver "' + newName + '" successfully added!');
}

// ===== PAYMENT METHOD MODAL FUNCTIONS =====
function openPaymentMethodModal() {
    const modal = new bootstrap.Modal(document.getElementById('paymentMethodModal'));
    modal.show();
}

document.getElementById('paymentMethodSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const items = document.querySelectorAll('.payment-method-item');
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchText) ? 'block' : 'none';
    });
});

document.querySelectorAll('.payment-method-item').forEach(item => {
    item.addEventListener('click', function() {
        document.getElementById('paymentMethodInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('paymentMethodModal')).hide();
    });
    item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
});

function showAddPaymentMethodForm() {
    bootstrap.Modal.getInstance(document.getElementById('paymentMethodModal')).hide();
    new bootstrap.Modal(document.getElementById('addPaymentMethodModal')).show();
}

function addNewPaymentMethod() {
    const newName = document.getElementById('newPaymentMethodName').value.trim();
    if (!newName) { alert('Mohon Enter payment method'); return; }
    
    const paymentMethodList = document.getElementById('paymentMethodList');
    const newItem = document.createElement('div');
    newItem.className = 'payment-method-item';
    newItem.setAttribute('data-value', newName);
    newItem.style.cssText = 'padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;';
    newItem.innerHTML = `<span style="color: #5B7C99; font-size: 15px;">${newName}</span>`;
    
    newItem.addEventListener('click', function() {
        document.getElementById('paymentMethodInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('paymentMethodModal')).hide();
    });
    newItem.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    newItem.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
    
    paymentMethodList.appendChild(newItem);
    bootstrap.Modal.getInstance(document.getElementById('addPaymentMethodModal')).hide();
    document.getElementById('paymentMethodInput').value = newName;
    document.getElementById('newPaymentMethodName').value = '';
    alert('Payment Method "' + newName + '" successfully added!');
}

// Validate odometer
const odometerInput = document.getElementById('odometerInput');
const lastOdometer = parseFloat(odometerInput.getAttribute('min')) || 0;

odometerInput.addEventListener('blur', function() {
    const currentValue = parseFloat(this.value) || 0;
    if (currentValue < lastOdometer) {
        alert('Odometer cannot be less than Latest Odometer: ' + lastOdometer.toFixed(0) + ' km');
        this.value = lastOdometer;
        this.focus();
    }
});

// Time Picker - Same as fuel-fills
function openTimePicker() {
    const timeInput = document.getElementById('timeInput');
    const currentTime = timeInput.value || '{{ date("H:i") }}';
    const [hours, minutes] = currentTime.split(':');
    
    const modal = document.createElement('div');
    modal.className = 'time-picker-modal';
    modal.innerHTML = `
        <div class="time-picker-overlay" onclick="closeTimePicker()"></div>
        <div class="time-picker-content">
            <div class="time-picker-header">
                <h5>Select</h5>
                <button type="button" class="time-picker-close" onclick="closeTimePicker()">&times;</button>
            </div>
            <div class="time-display">
                <span class="time-display-value" id="timeDisplay">${hours}:${minutes}</span>
            </div>
            <div class="time-picker-body">
                <div class="time-picker-clock">
                    <canvas id="clockCanvas" width="280" height="280"></canvas>
                </div>
            </div>
            <div class="time-picker-footer">
                <button type="button" class="btn-time-cancel" onclick="closeTimePicker()">CANCEL</button>
                <button type="button" class="btn-time-ok" onclick="confirmTime()">OK</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    setTimeout(() => { drawClock(parseInt(hours), parseInt(minutes)); }, 100);
}

function closeTimePicker() {
    const modal = document.querySelector('.time-picker-modal');
    if (modal) modal.remove();
}

function confirmTime() {
    const timeDisplay = document.getElementById('timeDisplay');
    const timeInput = document.getElementById('timeInput');
    timeInput.value = timeDisplay.textContent;
    closeTimePicker();
}

let selectedHour = {{ date("H") }};
let selectedMinute = {{ date("i") }};
let selectingHour = true;

function drawClock(hour, minute) {
    selectedHour = hour;
    selectedMinute = minute;
    
    const canvas = document.getElementById('clockCanvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const centerX = 140;
    const centerY = 140;
    const radius = 120;
    
    ctx.clearRect(0, 0, 280, 280);
    
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
    ctx.fillStyle = '#f0f0f0';
    ctx.fill();
    
    ctx.fillStyle = '#333';
    ctx.font = 'bold 16px Arial';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    
    if (selectingHour) {
        for (let i = 1; i <= 12; i++) {
            const angle = (i - 3) * Math.PI / 6;
            const x = centerX + radius * 0.7 * Math.cos(angle);
            const y = centerY + radius * 0.7 * Math.sin(angle);
            
            if (i === selectedHour || (selectedHour > 12 && i === selectedHour - 12)) {
                ctx.beginPath();
                ctx.arc(x, y, 20, 0, 2 * Math.PI);
                ctx.fillStyle = '#1976d2';
                ctx.fill();
                ctx.fillStyle = '#fff';
            } else {
                ctx.fillStyle = '#666';
            }
            
            ctx.fillText(i, x, y);
        }
    } else {
        for (let i = 0; i < 60; i += 5) {
            const angle = (i / 5 - 3) * Math.PI / 6;
            const x = centerX + radius * 0.7 * Math.cos(angle);
            const y = centerY + radius * 0.7 * Math.sin(angle);
            
            const displayMinute = i === 0 ? '00' : i.toString().padStart(2, '0');
            
            if (i === selectedMinute) {
                ctx.beginPath();
                ctx.arc(x, y, 20, 0, 2 * Math.PI);
                ctx.fillStyle = '#1976d2';
                ctx.fill();
                ctx.fillStyle = '#fff';
            } else {
                ctx.fillStyle = '#666';
            }
            
            ctx.fillText(displayMinute, x, y);
        }
    }
    
    const hyoungle = selectingHour 
        ? (selectedHour - 3) * Math.PI / 6
        : (selectedMinute / 5 - 3) * Math.PI / 6;
    
    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.lineTo(
        centerX + radius * 0.5 * Math.cos(hyoungle),
        centerY + radius * 0.5 * Math.sin(hyoungle)
    );
    ctx.strokeStyle = '#1976d2';
    ctx.lineWidth = 2;
    ctx.stroke();
    
    ctx.beginPath();
    ctx.arc(centerX, centerY, 6, 0, 2 * Math.PI);
    ctx.fillStyle = '#1976d2';
    ctx.fill();
    
    canvas.onclick = function(e) {
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left - centerX;
        const y = e.clientY - rect.top - centerY;
        const angle = Math.atan2(y, x);
        
        if (selectingHour) {
            let hour = Math.round((angle + Math.PI / 2) / (Math.PI / 6));
            if (hour <= 0) hour += 12;
            selectedHour = hour;
            selectingHour = false;
            drawClock(selectedHour, selectedMinute);
        } else {
            let minute = Math.round((angle + Math.PI / 2) / (Math.PI / 6)) * 5;
            if (minute < 0) minute += 60;
            if (minute >= 60) minute = 0;
            selectedMinute = minute;
            drawClock(selectedHour, selectedMinute);
        }
        
        updateTimeDisplay();
    };
}

function updateTimeDisplay() {
    const timeDisplay = document.getElementById('timeDisplay');
    if (timeDisplay) {
        timeDisplay.textContent = selectedHour.toString().padStart(2, '0') + ':' + 
                                  selectedMinute.toString().padStart(2, '0');
    }
}
@endsection

@push('styles')
<style>
.time-picker-modal{position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:10000;display:flex;align-items:center;justify-content:center}
.time-picker-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5)}
.time-picker-content{position:relative;background:#fff;border-radius:8px;width:320px;box-shadow:0 8px 24px rgba(0,0,0,.2);animation:slideUp .3s}
.time-picker-header{padding:16px 20px;background:#1976d2;color:#fff;border-radius:8px 8px 0 0;display:flex;justify-content:space-between;align-items:center}
.time-picker-header h5{margin:0;font-size:16px;font-weight:500}
.time-picker-close{background:none;border:none;color:#fff;font-size:24px;cursor:pointer;padding:0;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:4px}
.time-picker-close:hover{background:rgba(255,255,255,.1)}
.time-display{padding:24px;text-align:center;background:#fff}
.time-display-value{font-size:48px;font-weight:300;color:#1976d2;font-family:'Segoe UI',Arial,sans-serif}
.time-picker-body{padding:20px;display:flex;justify-content:center}
.time-picker-footer{padding:12px 16px;display:flex;justify-content:flex-end;gap:8px;border-top:1px solid #e0e0e0}
.btn-time-cancel,.btn-time-ok{padding:8px 16px;border:none;background:none;color:#1976d2;font-weight:500;cursor:pointer;border-radius:4px;font-size:14px;text-transform:uppercase}
.btn-time-cancel:hover,.btn-time-ok:hover{background:#f0f0f0}
@keyframes slideUp{from{transform:translateY(50px);opacity:0}to{transform:translateY(0);opacity:1}}
/* Hide default time picker icons */
input[type="time"]::-webkit-calendar-picker-indicator{display:none}
input[type="time"]::-webkit-inner-spin-button{display:none}
input[type="time"]::-webkit-clear-button{display:none}
</style>
@endpush




























