@extends('layouts.drivvo-form', [
    'pageTitle' => 'Rute',
    'pageIcon' => 'fas fa-route',
    'formAction' => route('trips.store'),
    'formId' => 'tripForm',
    'cancelRoute' => route('trips.index'),
    'modalRoute' => route('trips.create'),
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

<!-- Date -->
<div class="field-group">
    <label class="form-label">Date</label>
    <input type="date" name="trip_date" class="form-control" value="{{ old('trip_date', date('Y-m-d')) }}" required>
</div>

<!-- Start and End Time -->
<div class="row">
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">Waktu Start</label>
            <div class="input-group">
                <input type="time" name="start_time" id="startTimeInput" class="form-control" value="{{ old('start_time', date('H:i')) }}" style="border-right: 0;">
                <button type="button" class="input-group-text" onclick="openStartTimePicker()" style="cursor: pointer; background: white; border-left: 0;">
                    <i class="far fa-clock" style="color: #6c757d;"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">Waktu End</label>
            <div class="input-group">
                <input type="time" name="end_time" id="endTimeInput" class="form-control" value="{{ old('end_time', date('H:i')) }}" style="border-right: 0;">
                <button type="button" class="input-group-text" onclick="openEndTimePicker()" style="cursor: pointer; background: white; border-left: 0;">
                    <i class="far fa-clock" style="color: #6c757d;">
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Start and End Odometer -->
<div class="row">
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">Start Odometer</label>
            <div class="input-group">
                <input type="number" step="0.01" name="start_odometer" id="startOdometer" class="form-control"
                       value="{{ old('start_odometer') }}"
                       min="{{ $lastOdometer }}"
                       placeholder="Enter start odometer" required>
                <span class="input-group-text">km</span>
            </div>
            @if($lastOdometer > 0)
                <small class="text-muted">Latest Odometer: {{ number_format($lastOdometer, 0, ',', '.') }} km</small>
            @else
                <small class="text-muted">Latest Odometer: 0 km</small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">End Odometer</label>
            <div class="input-group">
                <input type="number" step="0.01" name="end_odometer" id="endOdometer" class="form-control" value="{{ old('end_odometer') }}" placeholder="Enter end odometer">
                <span class="input-group-text">km</span>
            </div>
        </div>
    </div>
</div>

<!-- Distance Tempuh -->
<div class="field-group">
    <label class="form-label">Distance tempuh</label>
    <div class="input-group">
        <input type="number" step="0.01" name="distance" id="distance" class="form-control" value="{{ old('distance') }}" placeholder="0" readonly>
        <span class="input-group-text">km</span>
    </div>
    <small class="text-muted">Automatically calculated from end odometer - start odometer</small>
</div>

<!-- Locations Awal -->
<div class="field-group">
    <label class="form-label">Locations awal</label>
    <input type="text" name="start_location" class="form-control" value="{{ old('start_location') }}" placeholder="Contoh: Kantor Jakarta">
</div>

<!-- Locations Destination -->
<div class="field-group">
    <label class="form-label">Locations Destination</label>
    <input type="text" name="end_location" class="form-control" value="{{ old('end_location') }}" placeholder="Contoh: Bandung">
</div>

<!-- Driver -->
<div class="field-group">
    <label class="form-label">Driver</label>
    <input type="text" name="driver" class="form-control" value="{{ old('driver') }}" placeholder="Name driver">
</div>

<!-- Destination trip -->
<div class="field-group">
    <label class="form-label">Destination trip</label>
    <select name="purpose" class="form-select">
        <option value="">Select Destination</option>
        <option value="Bisnis" {{ old('purpose') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
        <option value="Pribadi" {{ old('purpose') == 'Pribadi' ? 'selected' : '' }}>Pribadi</option>
        <option value="Rental" {{ old('purpose') == 'Rental' ? 'selected' : '' }}>Rental</option>
        <option value="Service" {{ old('purpose') == 'Service' ? 'selected' : '' }}>Service</option>
        <option value="Others" {{ old('purpose') == 'Others' ? 'selected' : '' }}>Others</option>
    </select>
</div>

<!-- Type Rute -->
<div class="field-group">
    <label class="form-label">Type rute</label>
    <select name="route_type" class="form-select">
        <option value="">Select Type rute</option>
        <option value="Tol" {{ old('route_type') == 'Tol' ? 'selected' : '' }}>Tol</option>
        <option value="Dalam Kota" {{ old('route_type') == 'Dalam Kota' ? 'selected' : '' }}>Dalam Kota</option>
        <option value="Luar Kota" {{ old('route_type') == 'Luar Kota' ? 'selected' : '' }}>Luar Kota</option>
        <option value="Campuran" {{ old('route_type') == 'Campuran' ? 'selected' : '' }}>Campuran</option>
    </select>
</div>

<!-- Notes -->
<div class="field-group">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Add trip notes (optional)">{{ old('notes') }}</textarea>
</div>
@endsection

@section('additional-scripts')
// Validate start odometer
const startOdometerInput = document.getElementById('startOdometer');
const lastOdometer = parseFloat(startOdometerInput.getAttribute('min')) || 0;

startOdometerInput.addEventListener('blur', function() {
    const currentValue = parseFloat(this.value) || 0;
    if (currentValue < lastOdometer) {
        alert('Odometer cannot be less than Latest Odometer: ' + lastOdometer.toFixed(0) + ' km');
        this.value = '';
        this.focus();
    }
});

// Auto-calculate distance from odometer
document.getElementById('startOdometer').addEventListener('input', calculateDistance);
document.getElementById('endOdometer').addEventListener('input', calculateDistance);

function calculateDistance() {
    const startOdometer = parseFloat(document.getElementById('startOdometer').value) || 0;
    const endOdometer = parseFloat(document.getElementById('endOdometer').value) || 0;

    if (endOdometer > startOdometer) {
        const distance = endOdometer - startOdometer;
        document.getElementById('distance').value = distance.toFixed(2);
    } else {
        document.getElementById('distance').value = '';
    }
}

// Time Pickers for Start and End Time
let currentTimePickerType = 'start'; // 'start' or 'end'

// Auto-fill current time when user focuses on time inputs
document.addEventListener('DOMContentLoaded', function() {
    const startTimeInput = document.getElementById('startTimeInput');
    const endTimeInput = document.getElementById('endTimeInput');

    [startTimeInput, endTimeInput].forEach(timeInput => {
        if (timeInput && !timeInput.value) {
            timeInput.addEventListener('focus', function() {
                if (!this.value) {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    this.value = `${hours}:${minutes}`;
                }
            }, { once: true });
        }
    });
});

function openStartTimePicker() {
    currentTimePickerType = 'start';
    const timeInput = document.getElementById('startTimeInput');
    openTimePickerModal(timeInput);
}

function openEndTimePicker() {
    currentTimePickerType = 'end';
    const timeInput = document.getElementById('endTimeInput');
    openTimePickerModal(timeInput);
}

function openTimePickerModal(timeInput) {
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
    selectingHour = true;
}

function confirmTime() {
    const timeDisplay = document.getElementById('timeDisplay');
    const timeInputId = currentTimePickerType === 'start' ? 'startTimeInput' : 'endTimeInput';
    const timeInput = document.getElementById(timeInputId);
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




























