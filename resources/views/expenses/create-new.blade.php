@extends('layouts.drivvo-form', [
    'pageTitle' => 'Add New Expense',
    'pageIcon' => 'fas fa-credit-card',
    'formAction' => route('expenses.store'),
    'formId' => 'expenseForm',
    'cancelRoute' => route('expenses.index'),
    'modalRoute' => route('expenses.create'),
    'vehicle' => $vehicle ?? null
])

@section('form-fields')
@php
    // Get last odometer from this vehicle
    $lastOdometer = 0;
    if(isset($vehicle)) {
        $lastFill = $vehicle->fuelFills()->latest('fill_date')->first();
        $lastMaintenance = $vehicle->maintenances()->latest('maintenance_date')->first();
        $lastExpense = $vehicle->expenses()->latest('expense_date')->first();
        $lastTrip = $vehicle->trips()->latest('trip_date')->first();
        
        $odometerValues = collect([
            $lastFill ? $lastFill->odometer : 0,
            $lastMaintenance ? $lastMaintenance->odometer : 0,
            $lastExpense ? $lastExpense->odometer : 0,
            $lastTrip ? $lastTrip->end_odometer ?? $lastTrip->start_odometer : 0
        ]);
        
        $lastOdometer = $odometerValues->max();
    }
@endphp

<!-- Date -->
<div class="field-group">
    <label class="form-label">Date</label>
    <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
</div>

<!-- Time -->
<div class="field-group">
    <label class="form-label">Time</label>
    <div class="input-group">
        <input type="time" name="expense_time" id="expenseTimeInput" class="form-control" value="{{ old('expense_time', date('H:i')) }}" required style="border-right: 0;">
        <button type="button" class="input-group-text" onclick="openExpenseTimePicker()" style="cursor: pointer; background: white; border-left: 0;">
            <i class="far fa-clock" style="color: #6c757d;"></i>
        </button>
    </div>
</div>

<!-- Odometer -->
<div class="field-group">
    <label class="form-label">Odometer (km)</label>
    <div class="input-group">
        <input type="number" step="0.01" name="odometer" id="expenseOdometerInput" class="form-control" 
               value="{{ old('odometer') }}" 
               min="{{ $lastOdometer }}" 
               placeholder="Enter Current Odometer">
        <span class="input-group-text">km</span>
    </div>
    @if($lastOdometer > 0)
        <small class="text-muted">Latest Odometer: {{ number_format($lastOdometer, 0, ',', '.') }} km</small>
    @else
        <small class="text-muted">Latest Odometer: 0 km</small>
    @endif
</div>

<!-- Type of Expense -->
<div class="field-group">
    <label class="form-label">Type of Expense</label>
    <select name="expense_type_id" class="form-control @error('expense_type_id') is-invalid @enderror" required>
        <option value="">Select Expense Type</option>
        @foreach($expenseTypes as $expenseType)
            <option value="{{ $expenseType->id }}" {{ old('expense_type_id') == $expenseType->id ? 'selected' : '' }}>
                {{ $expenseType->name }}
            </option>
        @endforeach
    </select>
    @error('expense_type_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- STNK Expiry Date (Hidden by default) -->
<div class="field-group" id="stnkExpiryGroup" style="display: none;">
    <label class="form-label">STNK Expiry Date</label>
    <input type="date" name="stnk_expiry_date" class="form-control" value="{{ old('stnk_expiry_date') }}">
    <small class="text-muted">Next STNK expiration date</small>
</div>

<!-- KIR Expiry Date (Hidden by default) -->
<div class="field-group" id="kirExpiryGroup" style="display: none;">
    <label class="form-label">KIR Expiry Date</label>
    <input type="date" name="kir_expiry_date" class="form-control" value="{{ old('kir_expiry_date') }}">
    <small class="text-muted">Next KIR expiration date</small>
</div>

<!-- Place -->
<div class="field-group">
    <label class="form-label">Place</label>
    <input type="text" name="place" class="form-control" value="{{ old('place') }}" placeholder="Select place" onclick="openPlaceModal()" readonly required>
</div>

<!-- User -->
<div class="field-group">
    <label class="form-label">User</label>
    @if(auth()->check())
        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    @else
        <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}" placeholder="Enter user name">
        <input type="hidden" name="user_id" value="">
    @endif
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

<!-- Notes -->
<div class="field-group">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Add notes (optional)">{{ old('notes') }}</textarea>
</div>

<!-- Attach File -->
<div class="field-group">
    <label class="form-label">Attachment</label>
    <button type="button" class="btn" onclick="document.getElementById('attachmentInput').click();" style="width: 100%; padding: 12px; border: 2px solid #1976d2; border-radius: 24px; background: white; color: #1976d2; font-weight: 500; text-transform: uppercase; font-size: 14px;">
        <i class="fas fa-paperclip" style="margin-right: 8px;"></i>
        <span id="attachmentButtonText">ATTACH FILE</span>
    </button>
    <input type="file" name="attachment" id="attachmentInput" style="display: none;" accept="image/*,.pdf,.doc,.docx" onchange="updateAttachmentButtonText(this)">
</div>

<!-- Hidden field for amount (will be auto-filled from expense type) -->
<input type="hidden" name="amount" id="expenseAmount" value="0">
<input type="hidden" name="category" value="Other">
<input type="hidden" name="description" id="expenseDescription" value="">

@endsection

@section('modals')
<!-- Expense Type Modal -->
<div class="modal fade" id="expenseTypeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 20px;">
                <h5 class="modal-title">Type of Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Search Box -->
                <div style="padding: 16px; border-bottom: 1px solid #e0e0e0;">
                    <input type="text" id="expenseTypeSearch" class="form-control" placeholder="Search expense type" style="border-radius: 8px;">
                </div>
                
                <!-- Expense Type List -->
                <div id="expenseTypeList" style="max-height: 400px; overflow-y: auto;">
                    <div class="expense-type-item" data-type="STNK Extension" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">STNK Extension</div>
                    </div>
                    <div class="expense-type-item" data-type="KIR Extension" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">KIR Extension</div>
                    </div>
                    <div class="expense-type-item" data-type="Parking" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Parking</div>
                    </div>
                    <div class="expense-type-item" data-type="Toll" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Toll</div>
                    </div>
                    <div class="expense-type-item" data-type="Insurance" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Insurance</div>
                    </div>
                    <div class="expense-type-item" data-type="Tax" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Tax</div>
                    </div>
                    <div class="expense-type-item" data-type="Fine" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Fine</div>
                    </div>
                    <div class="expense-type-item" data-type="Accessories" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Accessories</div>
                    </div>
                    <div class="expense-type-item" data-type="Others" data-amount="0" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Others</div>
                    </div>
                </div>
                
                <!-- Add New Button -->
                <div style="padding: 16px;">
                    <button type="button" class="btn btn-link" style="color: #1976d2; text-decoration: none; width: 100%; text-align: center;" onclick="addNewExpenseType()">
                        <i class="fas fa-plus-circle" style="margin-right: 8px;"></i>Add New Expense Type
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Place Modal -->
<div class="modal fade" id="placeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 20px;">
                <h5 class="modal-title">Place</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Search Box -->
                <div style="padding: 16px; border-bottom: 1px solid #e0e0e0;">
                    <input type="text" id="placeSearch" class="form-control" placeholder="Search place" style="border-radius: 8px;">
                </div>
                
                <!-- Place List -->
                <div id="placeList" style="max-height: 400px; overflow-y: auto;">
                    <div class="place-item" data-place="Workshop A" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Workshop A</div>
                    </div>
                    <div class="place-item" data-place="Official Dealer" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Official Dealer</div>
                    </div>
                    <div class="place-item" data-place="Gas Station" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Gas Station</div>
                    </div>
                    <div class="place-item" data-place="Car Wash" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Car Wash</div>
                    </div>
                    <div class="place-item" data-place="Others" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Others</div>
                    </div>
                </div>
                
                <!-- Add New Button -->
                <div style="padding: 16px;">
                    <button type="button" class="btn btn-link" style="color: #1976d2; text-decoration: none; width: 100%; text-align: center;" onclick="addNewPlace()">
                        <i class="fas fa-plus-circle" style="margin-right: 8px;"></i>Add New Place
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 20px;">
                <h5 class="modal-title">Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Search Box -->
                <div style="padding: 16px; border-bottom: 1px solid #e0e0e0;">
                    <input type="text" id="paymentMethodSearch" class="form-control" placeholder="Search payment method" style="border-radius: 8px;">
                </div>
                
                <!-- Payment Method List -->
                <div id="paymentMethodList" style="max-height: 400px; overflow-y: auto;">
                    <div class="payment-method-item" data-method="Cash" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Cash</div>
                    </div>
                    <div class="payment-method-item" data-method="Credit Card" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Credit Card</div>
                    </div>
                    <div class="payment-method-item" data-method="Debit Card" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Debit Card</div>
                    </div>
                    <div class="payment-method-item" data-method="Bank Transfer" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Bank Transfer</div>
                    </div>
                    <div class="payment-method-item" data-method="E-Wallet" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">E-Wallet</div>
                    </div>
                    <div class="payment-method-item" data-method="Others" style="padding: 16px; border-bottom: 1px solid #f0f0f0; cursor: pointer;">
                        <div style="font-weight: 500;">Others</div>
                    </div>
                </div>
                
                <!-- Add New Button -->
                <div style="padding: 16px;">
                    <button type="button" class="btn btn-link" style="color: #1976d2; text-decoration: none; width: 100%; text-align: center;" onclick="addNewPaymentMethod()">
                        <i class="fas fa-plus-circle" style="margin-right: 8px;"></i>Add New Payment Method
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
// Update attachment button text
function updateAttachmentButtonText(input) {
    const buttonText = document.getElementById('attachmentButtonText');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024).toFixed(2);
        buttonText.textContent = `${file.name} (${fileSize} KB)`;
    } else {
        buttonText.textContent = 'ATTACH FILE';
    }
}

// Expense Type Modal Functions
function openExpenseTypeModal() {
    const modal = new bootstrap.Modal(document.getElementById('expenseTypeModal'));
    modal.show();
}

document.querySelectorAll('.expense-type-item').forEach(item => {
    item.addEventListener('click', function() {
        const expenseType = this.getAttribute('data-type');
        const amount = this.getAttribute('data-amount');
        
        document.querySelector('input[name="expense_type"]').value = expenseType;
        document.getElementById('expenseAmount').value = amount;
        document.getElementById('expenseDescription').value = expenseType;
        
        // Show/hide expiry date fields based on expense type
        const stnkGroup = document.getElementById('stnkExpiryGroup');
        const kirGroup = document.getElementById('kirExpiryGroup');
        
        if (expenseType === 'STNK Extension') {
            stnkGroup.style.display = 'block';
            kirGroup.style.display = 'none';
        } else if (expenseType === 'KIR Extension') {
            stnkGroup.style.display = 'none';
            kirGroup.style.display = 'block';
        } else {
            stnkGroup.style.display = 'none';
            kirGroup.style.display = 'none';
        }
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('expenseTypeModal'));
        modal.hide();
    });
});

// Search expense type
document.getElementById('expenseTypeSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.expense-type-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

function addNewExpenseType() {
    const newType = prompt('Enter new expense type:');
    if (newType) {
        document.querySelector('input[name="expense_type"]').value = newType;
        document.getElementById('expenseDescription').value = newType;
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('expenseTypeModal'));
        modal.hide();
        
        alert('Expense Type "' + newType + '" successfully added!');
    }
}

// Place Modal Functions
function openPlaceModal() {
    const modal = new bootstrap.Modal(document.getElementById('placeModal'));
    modal.show();
}

document.querySelectorAll('.place-item').forEach(item => {
    item.addEventListener('click', function() {
        const place = this.getAttribute('data-place');
        document.querySelector('input[name="place"]').value = place;
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('placeModal'));
        modal.hide();
    });
});

// Search place
document.getElementById('placeSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.place-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

function addNewPlace() {
    const newPlace = prompt('Enter new place:');
    if (newPlace) {
        document.querySelector('input[name="place"]').value = newPlace;
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('placeModal'));
        modal.hide();
        
        alert('Place "' + newPlace + '" successfully added!');
    }
}

// Payment Method Modal Functions
function openPaymentMethodModal() {
    const modal = new bootstrap.Modal(document.getElementById('paymentMethodModal'));
    modal.show();
}

document.querySelectorAll('.payment-method-item').forEach(item => {
    item.addEventListener('click', function() {
        const method = this.getAttribute('data-method');
        document.querySelector('input[name="payment_method"]').value = method;
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentMethodModal'));
        modal.hide();
    });
});

// Search payment method
document.getElementById('paymentMethodSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.payment-method-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

function addNewPaymentMethod() {
    const newMethod = prompt('Enter new payment method:');
    if (newMethod) {
        document.querySelector('input[name="payment_method"]').value = newMethod;
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentMethodModal'));
        modal.hide();
        
        alert('Payment Method "' + newMethod + '" successfully added!');
    }
}

// Time Picker
function openExpenseTimePicker() {
    const timeInput = document.getElementById('expenseTimeInput');
    const currentTime = timeInput.value || '{{ date("H:i") }}';
    const [hours, minutes] = currentTime.split(':');
    
    const modal = document.createElement('div');
    modal.className = 'time-picker-modal';
    modal.innerHTML = `
        <div class="time-picker-overlay" onclick="closeExpenseTimePicker()"></div>
        <div class="time-picker-content">
            <div class="time-picker-header">
                <h5>Select</h5>
                <button type="button" class="time-picker-close" onclick="closeExpenseTimePicker()">&times;</button>
            </div>
            <div class="time-display">
                <span class="time-display-value" id="expenseTimeDisplay">${hours}:${minutes}</span>
            </div>
            <div class="time-picker-body">
                <div class="time-picker-clock">
                    <canvas id="expenseClockCanvas" width="280" height="280"></canvas>
                </div>
            </div>
            <div class="time-picker-footer">
                <button type="button" class="btn-time-cancel" onclick="closeExpenseTimePicker()">CANCEL</button>
                <button type="button" class="btn-time-ok" onclick="confirmExpenseTime()">OK</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    setTimeout(() => { drawExpenseClock(parseInt(hours), parseInt(minutes)); }, 100);
}

function closeExpenseTimePicker() {
    const modal = document.querySelector('.time-picker-modal');
    if (modal) modal.remove();
}

function confirmExpenseTime() {
    const timeDisplay = document.getElementById('expenseTimeDisplay');
    const timeInput = document.getElementById('expenseTimeInput');
    timeInput.value = timeDisplay.textContent;
    closeExpenseTimePicker();
}

let expenseSelectedHour = {{ date("H") }};
let expenseSelectedMinute = {{ date("i") }};
let expenseSelectingHour = true;

function drawExpenseClock(hour, minute) {
    expenseSelectedHour = hour;
    expenseSelectedMinute = minute;
    
    const canvas = document.getElementById('expenseClockCanvas');
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
    
    if (expenseSelectingHour) {
        for (let i = 1; i <= 12; i++) {
            const angle = (i - 3) * Math.PI / 6;
            const x = centerX + radius * 0.7 * Math.cos(angle);
            const y = centerY + radius * 0.7 * Math.sin(angle);
            
            if (i === expenseSelectedHour || (expenseSelectedHour > 12 && i === expenseSelectedHour - 12)) {
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
            
            if (i === expenseSelectedMinute) {
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
    
    const hyoungle = expenseSelectingHour 
        ? (expenseSelectedHour - 3) * Math.PI / 6
        : (expenseSelectedMinute / 5 - 3) * Math.PI / 6;
    
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
        
        if (expenseSelectingHour) {
            let hour = Math.round((angle + Math.PI / 2) / (Math.PI / 6));
            if (hour <= 0) hour += 12;
            expenseSelectedHour = hour;
            expenseSelectingHour = false;
            drawExpenseClock(expenseSelectedHour, expenseSelectedMinute);
        } else {
            let minute = Math.round((angle + Math.PI / 2) / (Math.PI / 6)) * 5;
            if (minute < 0) minute += 60;
            if (minute >= 60) minute = 0;
            expenseSelectedMinute = minute;
            drawExpenseClock(expenseSelectedHour, expenseSelectedMinute);
        }
        
        updateExpenseTimeDisplay();
    };
}

function updateExpenseTimeDisplay() {
    const timeDisplay = document.getElementById('expenseTimeDisplay');
    if (timeDisplay) {
        timeDisplay.textContent = expenseSelectedHour.toString().padStart(2, '0') + ':' + 
                                  expenseSelectedMinute.toString().padStart(2, '0');
    }
}
@endsection

@push('styles')
<style>
.time-picker-modal{position:fixed !important;top:0 !important;left:0 !important;width:100vw !important;height:100vh !important;z-index:10000 !important;display:flex !important;align-items:center !important;justify-content:center !important}
.time-picker-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5)}
.time-picker-content{position:relative;background:#fff;border-radius:8px;width:320px;box-shadow:0 8px 24px rgba(0,0,0,.2);animation:slideUp .3s}
.time-picker-header{padding:16px 20px;background:#1976d2;color:#fff;border-radius:8px 8px 0 0;display:flex;justify-content:space-between;align-items:center}
.time-picker-header h5{margin:0;font-size:16px;font-weight:500}
.time-picker-close{background:none;border:none;color:#fff;font-size:24px;cursor:pointer;padding:0;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:4px}
.time-picker-close:hover{background:rgba(255,255,255,.1)}
.time-display{padding:24px;text-align:center;background:#fff}
.time-display-value{font-size:48px;font-weight:300;color:#1976d2;font-family:'Segoe UI',Arial,sans-serif}
.time-picker-body{padding:20px;display:flex;justify-content:center;align-items:center}
.time-picker-clock{width:280px;height:280px;display:flex;align-items:center;justify-content:center}
.time-picker-clock canvas{display:block;cursor:pointer}
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




























