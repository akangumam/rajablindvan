@extends('layouts.drivvo-form', [
    'pageTitle' => 'Daftar Cek',
    'pageIcon' => 'fas fa-tasks',
    'formAction' => route('checklists.store'),
    'formId' => 'checklistForm',
    'cancelRoute' => route('checklists.index'),
    'modalRoute' => route('checklists.create'),
    'vehicle' => $vehicle ?? null
])

@section('form-fields')
<!-- Tanggal -->
<div class="field-group">
    <label class="form-label">Tanggal pemeriksaan</label>
    <input type="date" name="check_date" class="form-control" value="{{ old('check_date', date('Y-m-d')) }}" required>
</div>

<!-- Odometer -->
<div class="field-group">
    <label class="form-label">Odometer</label>
    <div class="input-group">
        <input type="number" step="0.01" name="odometer" class="form-control" value="{{ old('odometer') }}" placeholder="0">
        <span class="input-group-text">km</span>
    </div>
</div>

<!-- Jenis Checklist -->
<div class="field-group">
    <label class="form-label">Jenis pemeriksaan</label>
    <select name="checklist_type" class="form-select" required>
        <option value="">Pilih jenis</option>
        <option value="Pre-trip" {{ old('checklist_type') == 'Pre-trip' ? 'selected' : '' }}>Pre-trip</option>
        <option value="Post-trip" {{ old('checklist_type') == 'Post-trip' ? 'selected' : '' }}>Post-trip</option>
        <option value="Weekly" {{ old('checklist_type') == 'Weekly' ? 'selected' : '' }}>Mingguan</option>
        <option value="Monthly" {{ old('checklist_type') == 'Monthly' ? 'selected' : '' }}>Bulanan</option>
    </select>
</div>

<!-- Checklist Items -->
<div class="field-group">
    <label class="form-label">Item pemeriksaan</label>
    <div class="row">
        <div class="col-md-6">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="tire_pressure" value="1" id="tire_pressure">
                <label class="form-check-label" for="tire_pressure">Tekanan ban</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="tire_condition" value="1" id="tire_condition">
                <label class="form-check-label" for="tire_condition">Kondisi ban</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="brake_system" value="1" id="brake_system">
                <label class="form-check-label" for="brake_system">Sistem rem</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="lights" value="1" id="lights">
                <label class="form-check-label" for="lights">Lampu</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="fluids" value="1" id="fluids">
                <label class="form-check-label" for="fluids">Cairan (oli, coolant, dll)</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="battery" value="1" id="battery">
                <label class="form-check-label" for="battery">Aki/Battery</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="wipers" value="1" id="wipers">
                <label class="form-check-label" for="wipers">Wiper</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="mirrors" value="1" id="mirrors">
                <label class="form-check-label" for="mirrors">Spion</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="horn" value="1" id="horn">
                <label class="form-check-label" for="horn">Klakson</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="seat_belts" value="1" id="seat_belts">
                <label class="form-check-label" for="seat_belts">Sabuk pengaman</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="emergency_kit" value="1" id="emergency_kit">
                <label class="form-check-label" for="emergency_kit">Peralatan darurat</label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="documents" value="1" id="documents">
                <label class="form-check-label" for="documents">Dokumen kendaraan</label>
            </div>
        </div>
    </div>
</div>

<!-- Diperiksa Oleh -->
<div class="field-group">
    <label class="form-label">Diperiksa oleh</label>
    <input type="text" name="checked_by" class="form-control" value="{{ old('checked_by') }}" placeholder="Nama pemeriksa">
</div>

<!-- Catatan -->
<div class="field-group">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
</div>
@endsection
