@extends('layouts.drivvo-form', [
    'pageTitle' => 'Pengisian',
    'pageIcon' => 'fas fa-gas-pump',
    'formAction' => route('fuel-fills.store'),
    'formId' => 'fuelFillForm',
    'cancelRoute' => route('fuel-fills.index'),
    'modalRoute' => route('fuel-fills.create'),
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
            <label class="form-label">Jam</label>
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

<!-- Type Bahan Bakar -->
<div class="field-group">
    <label class="form-label">Type bahan bakar</label>
    <input type="text" name="fuel_type" id="fuelTypeInput" class="form-control"
           value="{{ old('fuel_type') }}"
           placeholder="Select Type bahan bakar"
           readonly
           onclick="openFuelTypeModal()"
           style="cursor: pointer; background: white;" required>
    <input type="hidden" id="fuelTypeValue" name="fuel_type_value">
</div>

<!-- Price per Liter -->
<div class="field-group">
    <label class="form-label">Price/liter</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" step="0.01" name="price_per_liter" id="pricePerLiter" class="form-control" value="{{ old('price_per_liter') }}" placeholder="0">
    </div>
</div>

<!-- Total Price -->
<div class="field-group">
    <label class="form-label">Total</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" step="0.01" name="total_price" id="totalPrice" class="form-control" value="{{ old('total_price') }}" placeholder="0" required>
    </div>
</div>

<!-- Liter -->
<div class="field-group">
    <label class="form-label">Liter</label>
    <div class="input-group">
        <input type="number" step="0.01" name="liters" id="liters" class="form-control" value="{{ old('liters') }}" placeholder="0" required>
        <span class="input-group-text">L</span>
    </div>
</div>

<!-- Tanki Penuh -->
<div class="field-group">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="full_tank" id="fullTank" value="1" {{ old('full_tank') ? 'checked' : '' }}>
        <label class="form-check-label" for="fullTank">
            Tanki penuh
        </label>
    </div>
</div>

<!-- Gas Stations -->
<div class="field-group">
    <label class="form-label">
        <i class="fas fa-gas-pump" style="color: #6c757d; margin-right: 8px;"></i>
        Gas Stations
    </label>
    <input type="text" name="Gas Stations" id="Gas StationsInput" class="form-control"
           value="{{ old('Gas Stations') }}"
           placeholder="Select Gas Stations"
           readonly
           onclick="openGas StationsModal()"
           style="cursor: pointer; background: white;">
</div>

<!-- Pengendara -->
<div class="field-group">
    <label class="form-label">
        <i class="fas fa-user" style="color: #6c757d; margin-right: 8px;"></i>
        Pengendara
    </label>
    <input type="text" name="driver" id="driverInput" class="form-control"
           value="{{ old('driver') }}"
           placeholder="Select pengendara"
           readonly
           onclick="openDriverModal()"
           style="cursor: pointer; background: white;">
</div>

<!-- Reasons -->
<div class="field-group">
    <label class="form-label">
        <i class="fas fa-briefcase" style="color: #6c757d; margin-right: 8px;"></i>
        Reasons (Optional)
    </label>
    <input type="text" name="reason" id="reasonInput" class="form-control"
           value="{{ old('reason') }}"
           placeholder="Select Reasons"
           readonly
           onclick="openReasonModal()"
           style="cursor: pointer; background: white;">
</div>

<!-- Payment Methods -->
<div class="field-group">
    <label class="form-label">
        <i class="fas fa-credit-card" style="color: #6c757d; margin-right: 8px;"></i>
        Payment Methods (Optional)
    </label>
    <input type="text" name="payment_method" id="paymentMethodInput" class="form-control"
           value="{{ old('payment_method') }}"
           placeholder="Select Payment Methods"
           readonly
           onclick="openPaymentMethodModal()"
           style="cursor: pointer; background: white;">
</div>

<!-- Pengisian bahan bakar seNot yetnya terlewatkan -->
<div class="field-group">
    <div class="form-check" style="display: flex; align-items: center; gap: 12px;">
        <label class="form-check-label" for="missedFilling" style="color: #5B7C99; font-size: 15px; order: 1;">
            Pengisian bahan bakar seNot yetnya terlewatkan?
        </label>
        <input class="form-check-input" type="checkbox" name="missed_filling" id="missedFilling" value="1"
               {{ old('missed_filling') ? 'checked' : '' }}
               style="order: 2; margin: 0; width: 48px; height: 24px; cursor: pointer;">
    </div>
</div>

<!-- Lampirkan File -->
<div class="field-group">
    <button type="button" class="btn" onclick="document.getElementById('attachmentInput').click();" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
        <i class="fas fa-paperclip" style="margin-right: 8px;"></i>
        <span id="attachmentButtonText">LAMPIRKAN FILE</span>
    </button>
    <input type="file" name="attachment" id="attachmentInput" style="display: none;" accept="image/*,.pdf" onchange="updateAttachmentButtonText(this)">
    <input type="hidden" name="category" value="fuel">
</div>

<!-- Notes -->
<div class="field-group">
    <label class="form-label">
        <i class="fas fa-align-left" style="color: #6c757d; margin-right: 8px;"></i>
        Notes
    </label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan Notes (opsional)">{{ old('notes') }}</textarea>
</div>
@endsection

@section('modals')
<!-- Fuel Type Modal -->
<div class="modal fade" id="fuelTypeModal" tabindex="-1" aria-labelledby="fuelTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="fuelTypeModalLabel" style="font-size: 18px; font-weight: 500;">Bahan bakar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Search Box -->
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="fuelTypeSearch" class="form-control" placeholder="Search bahan bakar..." style="border-left: 0;" autofocus>
                    </div>
                </div>

                <!-- Fuel Types List -->
                <div id="fuelTypeList" style="max-height: 300px; overflow-y: auto;">
                    <div class="fuel-type-item" data-value="Bensin" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Gasoline</span>
                    </div>
                    <div class="fuel-type-item" data-value="Bensin Premium" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Bensin Premium</span>
                    </div>
                    <div class="fuel-type-item" data-value="CNG" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">CNG</span>
                    </div>
                    <div class="fuel-type-item" data-value="Diesel" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Diesel</span>
                    </div>
                    <div class="fuel-type-item" data-value="Etanol" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Etanol</span>
                    </div>
                </div>

                <!-- Add New Button -->
                <div style="padding: 16px 20px; border-top: 2px solid #e0e0e0;">
                    <button type="button" class="btn" onclick="showAddFuelTypeForm()" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        ADD NEW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Fuel Type Modal -->
<div class="modal fade" id="addFuelTypeModal" tabindex="-1" aria-labelledby="addFuelTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="addFuelTypeModalLabel" style="font-size: 18px; font-weight: 500;">Add Fuel Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="newFuelTypeName" class="form-label">Name Bahan Bakar</label>
                    <input type="text" class="form-control" id="newFuelTypeName" placeholder="Contoh: Pertalite, Pertamax, dll">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 12px 16px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="addNewFuelType()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Gas Stations Modal -->
<div class="modal fade" id="Gas StationsModal" tabindex="-1" aria-labelledby="Gas StationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="Gas StationsModalLabel" style="font-size: 18px; font-weight: 500;">Gas Stations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="Gas StationsSearch" class="form-control" placeholder="Search Gas Stations..." style="border-left: 0;" autofocus>
                    </div>
                </div>
                <div id="Gas StationsList" style="max-height: 300px; overflow-y: auto;">
                    <div class="Gas Stations-item" data-value="Shell" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Shell</span>
                    </div>
                    <div class="Gas Stations-item" data-value="Pertamina" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Pertamina</span>
                    </div>
                    <div class="Gas Stations-item" data-value="Total" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Total</span>
                    </div>
                    <div class="Gas Stations-item" data-value="BP" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">BP</span>
                    </div>
                </div>
                <div style="padding: 16px 20px; border-top: 2px solid #e0e0e0;">
                    <button type="button" class="btn" onclick="showAddGas StationsForm()" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        ADD NEW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Gas Stations Modal -->
<div class="modal fade" id="addGas StationsModal" tabindex="-1" aria-labelledby="addGas StationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="addGas StationsModalLabel" style="font-size: 18px; font-weight: 500;">Add Gas Station</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="newGas StationsName" class="form-label">Name Gas Stations</label>
                    <input type="text" class="form-control" id="newGas StationsName" placeholder="Contoh: Shell, Pertamina, dll">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 12px 16px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="addNewGas Stations()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Driver Modal -->
<div class="modal fade" id="driverModal" tabindex="-1" aria-labelledby="driverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="driverModalLabel" style="font-size: 18px; font-weight: 500;">Pengendara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="driverSearch" class="form-control" placeholder="Search pengendara..." style="border-left: 0;" autofocus>
                    </div>
                </div>
                <div id="driverList" style="max-height: 300px; overflow-y: auto;">
                    @forelse($users as $user)
                    <div class="driver-item" data-value="{{ $user->name }}" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">{{ $user->name }}</span>
                        @if($user->Email)
                        <br><small style="color: #9e9e9e; font-size: 13px;">{{ $user->Email }}</small>
                        @endif
                    </div>
                    @empty
                    <div style="padding: 16px 20px; text-align: center; color: #9e9e9e;">
                        <small>No data yet pengendara</small>
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
                    <label for="newDriverName" class="form-label">Name Pengendara</label>
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

<!-- Reason Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="reasonModalLabel" style="font-size: 18px; font-weight: 500;">Reasons</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #e0e0e0;">
                    <div class="input-group">
                        <span class="input-group-text" style="background: white; border-right: 0;">
                            <i class="fas fa-search" style="color: #6c757d;"></i>
                        </span>
                        <input type="text" id="reasonSearch" class="form-control" placeholder="Search Reasons..." style="border-left: 0;" autofocus>
                    </div>
                </div>
                <div id="reasonList" style="max-height: 300px; overflow-y: auto;">
                    <div class="reason-item" data-value="Bisnis" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Bisnis</span>
                    </div>
                    <div class="reason-item" data-value="Pribadi" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Pribadi</span>
                    </div>
                    <div class="reason-item" data-value="Operasional" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Operasional</span>
                    </div>
                    <div class="reason-item" data-value="Rental" style="padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #5B7C99; font-size: 15px;">Rental</span>
                    </div>
                </div>
                <div style="padding: 16px 20px; border-top: 2px solid #e0e0e0;">
                    <button type="button" class="btn" onclick="showAddReasonForm()" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
                        ADD NEW
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Reason Modal -->
<div class="modal fade" id="addReasonModal" tabindex="-1" aria-labelledby="addReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 16px 20px;">
                <h5 class="modal-title" id="addReasonModalLabel" style="font-size: 18px; font-weight: 500;">Add Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="newReasonName" class="form-label">Reasons</label>
                    <input type="text" class="form-control" id="newReasonName" placeholder="Enter reason">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 12px 16px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" onclick="addNewReason()">Save</button>
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
                        <input type="text" id="paymentMethodSearch" class="form-control" placeholder="Search Payment Methods..." style="border-left: 0;" autofocus>
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
// Fuel Type Modal Functions
function openFuelTypeModal() {
    const modal = new bootstrap.Modal(document.getElementById('fuelTypeModal'));
    modal.show();
}

// Search fuel types
document.getElementById('fuelTypeSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const items = document.querySelectorAll('.fuel-type-item');

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(searchText)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

// Select fuel type
document.querySelectorAll('.fuel-type-item').forEach(item => {
    item.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        document.getElementById('fuelTypeInput').value = value;
        document.getElementById('fuelTypeValue').value = value;

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('fuelTypeModal'));
        modal.hide();
    });

    // Hover effect
    item.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f0f0f0';
    });
    item.addEventListener('mouseleave', function() {
        this.style.backgroundColor = 'white';
    });
});

// Show add fuel type form
function showAddFuelTypeForm() {
    const fuelModal = bootstrap.Modal.getInstance(document.getElementById('fuelTypeModal'));
    fuelModal.hide();

    const addModal = new bootstrap.Modal(document.getElementById('addFuelTypeModal'));
    addModal.show();
}

// Add new fuel type
function addNewFuelType() {
    const newFuelName = document.getElementById('newFuelTypeName').value.trim();

    if (newFuelName === '') {
        alert('Mohon Enter fuel name');
        return;
    }

    // Check if already exists
    const existingItems = document.querySelectorAll('.fuel-type-item');
    let exists = false;
    existingItems.forEach(item => {
        if (item.getAttribute('data-value').toLowerCase() === newFuelName.toLowerCase()) {
            exists = true;
        }
    });

    if (exists) {
        alert('Bahan bakar ini already exists in list');
        return;
    }

    // Add to list
    const fuelTypeList = document.getElementById('fuelTypeList');
    const newItem = document.createElement('div');
    newItem.className = 'fuel-type-item';
    newItem.setAttribute('data-value', newFuelName);
    newItem.style.padding = '16px 20px';
    newItem.style.cursor = 'pointer';
    newItem.style.borderBottom = '1px solid #f0f0f0';
    newItem.innerHTML = `<span style="color: #5B7C99; font-size: 15px;">${newFuelName}</span>`;

    // Add click event
    newItem.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        document.getElementById('fuelTypeInput').value = value;
        document.getElementById('fuelTypeValue').value = value;

        const modal = bootstrap.Modal.getInstance(document.getElementById('fuelTypeModal'));
        modal.hide();
    });

    // Add hover effect
    newItem.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f0f0f0';
    });
    newItem.addEventListener('mouseleave', function() {
        this.style.backgroundColor = 'white';
    });

    fuelTypeList.appendChild(newItem);

    // Close add modal and show main modal
    const addModal = bootstrap.Modal.getInstance(document.getElementById('addFuelTypeModal'));
    addModal.hide();

    // Select the newly added item
    document.getElementById('fuelTypeInput').value = newFuelName;
    document.getElementById('fuelTypeValue').value = newFuelName;

    // Clear input
    document.getElementById('newFuelTypeName').value = '';

    // Show success message
    alert('Bahan bakar "' + newFuelName + '" berhasil ditambahkan!');
}

// File attachment button text update
function updateAttachmentButtonText(input) {
    const buttonText = document.getElementById('attachmentButtonText');
    if (input.files && input.files[0]) {
        buttonText.textContent = input.files[0].name;
    } else {
        buttonText.textContent = 'LAMPIRKAN FILE';
    }
}

// ===== Gas Stations MODAL FUNCTIONS =====
function openGas StationsModal() {
    const modal = new bootstrap.Modal(document.getElementById('Gas StationsModal'));
    modal.show();
}

document.getElementById('Gas StationsSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const items = document.querySelectorAll('.Gas Stations-item');
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchText) ? 'block' : 'none';
    });
});

document.querySelectorAll('.Gas Stations-item').forEach(item => {
    item.addEventListener('click', function() {
        document.getElementById('Gas StationsInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('Gas StationsModal')).hide();
    });
    item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
});

function showAddGas StationsForm() {
    bootstrap.Modal.getInstance(document.getElementById('Gas StationsModal')).hide();
    new bootstrap.Modal(document.getElementById('addGas StationsModal')).show();
}

function addNewGas Stations() {
    const newName = document.getElementById('newGas StationsName').value.trim();
    if (!newName) { alert('Mohon Enter gas station name'); return; }

    const Gas StationsList = document.getElementById('Gas StationsList');
    const newItem = document.createElement('div');
    newItem.className = 'Gas Stations-item';
    newItem.setAttribute('data-value', newName);
    newItem.style.cssText = 'padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;';
    newItem.innerHTML = `<span style="color: #5B7C99; font-size: 15px;">${newName}</span>`;

    newItem.addEventListener('click', function() {
        document.getElementById('Gas StationsInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('Gas StationsModal')).hide();
    });
    newItem.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    newItem.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });

    Gas StationsList.appendChild(newItem);
    bootstrap.Modal.getInstance(document.getElementById('addGas StationsModal')).hide();
    document.getElementById('Gas StationsInput').value = newName;
    document.getElementById('newGas StationsName').value = '';
    alert('Gas Stations "' + newName + '" berhasil ditambahkan!');
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
    alert('Pengendara "' + newName + '" berhasil ditambahkan!');
}

// ===== REASON MODAL FUNCTIONS =====
function openReasonModal() {
    const modal = new bootstrap.Modal(document.getElementById('reasonModal'));
    modal.show();
}

document.getElementById('reasonSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const items = document.querySelectorAll('.reason-item');
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchText) ? 'block' : 'none';
    });
});

document.querySelectorAll('.reason-item').forEach(item => {
    item.addEventListener('click', function() {
        document.getElementById('reasonInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('reasonModal')).hide();
    });
    item.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    item.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });
});

function showAddReasonForm() {
    bootstrap.Modal.getInstance(document.getElementById('reasonModal')).hide();
    new bootstrap.Modal(document.getElementById('addReasonModal')).show();
}

function addNewReason() {
    const newName = document.getElementById('newReasonName').value.trim();
    if (!newName) { alert('Mohon Enter reason'); return; }

    const reasonList = document.getElementById('reasonList');
    const newItem = document.createElement('div');
    newItem.className = 'reason-item';
    newItem.setAttribute('data-value', newName);
    newItem.style.cssText = 'padding: 16px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0;';
    newItem.innerHTML = `<span style="color: #5B7C99; font-size: 15px;">${newName}</span>`;

    newItem.addEventListener('click', function() {
        document.getElementById('reasonInput').value = this.getAttribute('data-value');
        bootstrap.Modal.getInstance(document.getElementById('reasonModal')).hide();
    });
    newItem.addEventListener('mouseenter', function() { this.style.backgroundColor = '#f0f0f0'; });
    newItem.addEventListener('mouseleave', function() { this.style.backgroundColor = 'white'; });

    reasonList.appendChild(newItem);
    bootstrap.Modal.getInstance(document.getElementById('addReasonModal')).hide();
    document.getElementById('reasonInput').value = newName;
    document.getElementById('newReasonName').value = '';
    alert('Reasons "' + newName + '" berhasil ditambahkan!');
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
    alert('Payment Methods "' + newName + '" berhasil ditambahkan!');
}

// Auto-calculate between price per liter, total, and liters
document.getElementById('pricePerLiter').addEventListener('input', calculateFromPriceAndLiters);
document.getElementById('liters').addEventListener('input', calculateFromPriceAndLiters);
document.getElementById('totalPrice').addEventListener('input', calculateFromTotal);

function calculateFromPriceAndLiters() {
    const pricePerLiter = parseFloat(document.getElementById('pricePerLiter').value) || 0;
    const liters = parseFloat(document.getElementById('liters').value) || 0;

    if (pricePerLiter > 0 && liters > 0) {
        const total = pricePerLiter * liters;
        document.getElementById('totalPrice').value = total.toFixed(2);
    }
}

function calculateFromTotal() {
    const totalPrice = parseFloat(document.getElementById('totalPrice').value) || 0;
    const liters = parseFloat(document.getElementById('liters').value) || 0;

    if (totalPrice > 0 && liters > 0) {
        const pricePerLiter = totalPrice / liters;
        document.getElementById('pricePerLiter').value = pricePerLiter.toFixed(2);
    }
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

// Time Picker Popup
function openTimePicker() {
    const timeInput = document.getElementById('timeInput');
    const currentTime = timeInput.value || '{{ date("H:i") }}';
    const [hours, minutes] = currentTime.split(':');

    // Create time picker modal
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

    // Draw clock
    setTimeout(() => {
        drawClock(parseInt(hours), parseInt(minutes));
    }, 100);
}

function closeTimePicker() {
    const modal = document.querySelector('.time-picker-modal');
    if (modal) {
        modal.remove();
    }
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

    // Clear canvas
    ctx.clearRect(0, 0, 280, 280);

    // Draw clock circle
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
    ctx.fillStyle = '#f0f0f0';
    ctx.fill();

    // Draw numbers
    ctx.fillStyle = '#333';
    ctx.font = 'bold 16px Arial';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';

    if (selectingHour) {
        // Draw hours
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
        // Draw minutes (every 5 minutes)
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

    // Draw hand
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

    // Center dot
    ctx.beginPath();
    ctx.arc(centerX, centerY, 6, 0, 2 * Math.PI);
    ctx.fillStyle = '#1976d2';
    ctx.fill();

    // Add click handler
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
.time-picker-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.time-picker-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.time-picker-content {
    position: relative;
    background: white;
    border-radius: 8px;
    width: 320px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.3s;
}

.time-picker-header {
    padding: 16px 20px;
    background: #1976d2;
    color: white;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.time-picker-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}

.time-picker-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.time-picker-close:hover {
    background: rgba(255, 255, 255, 0.1);
}

.time-display {
    padding: 24px;
    text-align: center;
    background: white;
}

.time-display-value {
    font-size: 48px;
    font-weight: 300;
    color: #1976d2;
    font-family: 'Segoe UI', Arial, sans-serif;
}

.time-picker-body {
    padding: 20px;
    display: flex;
    justify-content: center;
}

.time-picker-clock {
    position: relative;
}

.time-picker-footer {
    padding: 12px 16px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    border-top: 1px solid #e0e0e0;
}

.btn-time-cancel,
.btn-time-ok {
    padding: 8px 16px;
    border: none;
    background: none;
    color: #1976d2;
    font-weight: 500;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
    text-transform: uppercase;
}

.btn-time-cancel:hover,
.btn-time-ok:hover {
    background: #f0f0f0;
}

@keyframes slideUp {
    from {
        transform: translateY(50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Hide default time picker icons */
input[type="time"]::-webkit-calendar-picker-indicator {
    display: none;
}
input[type="time"]::-webkit-inner-spin-button {
    display: none;
}
input[type="time"]::-webkit-clear-button {
    display: none;
}
</style>

<script>
// Live search for all modal search inputs
document.addEventListener('DOMContentLoaded', function() {
    // Fuel Type Search
    const fuelTypeSearch = document.getElementById('fuelTypeSearch');
    if (fuelTypeSearch) {
        fuelTypeSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.fuel-type-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Gas Stations Search
    const gasStationsSearch = document.getElementById('Gas StationsSearch');
    if (gasStationsSearch) {
        gasStationsSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.Gas Stations-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Driver Search
    const driverSearch = document.getElementById('driverSearch');
    if (driverSearch) {
        driverSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.driver-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Reason Search
    const reasonSearch = document.getElementById('reasonSearch');
    if (reasonSearch) {
        reasonSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.reason-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Payment Method Search
    const paymentMethodSearch = document.getElementById('paymentMethodSearch');
    if (paymentMethodSearch) {
        paymentMethodSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.payment-method-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
</script>
@endpush




























