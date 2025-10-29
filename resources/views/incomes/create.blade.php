@extends('layouts.drivvo-form', [
    'pageTitle' => 'Income',
    'pageSubtitle' => 'Add new income entry',
    'pageIcon' => 'fas fa-wallet',
    'formAction' => route('incomes.store'),
    'formId' => 'incomeForm',
    'cancelRoute' => route('incomes.index'),
    'modalRoute' => route('incomes.create'),
    'vehicle' => $vehicle ?? null
])

@section('form-fields')
<!-- 1. Date (Calendar selection, default today) -->
<div class="mb-4">
    <label class="form-label">Date <span class="text-danger">*</span></label>
    <input type="date" name="income_date" class="form-control @error('income_date') is-invalid @enderror" value="{{ old('income_date', date('Y-m-d')) }}" required>
    @error('income_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- 2. Time (automatic time, default now) -->
<div class="mb-4">
    <label class="form-label">Time <span class="text-danger">*</span></label>
    <input type="time" name="income_time" class="form-control @error('income_time') is-invalid @enderror" value="{{ old('income_time', date('H:i')) }}" required>
    @error('income_time')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- 3. Odometer (Free Text) -->
<div class="mb-4">
    <label class="form-label">Odometer</label>
    <div class="input-group">
        <input type="number" step="0.01" name="odometer" class="form-control @error('odometer') is-invalid @enderror" value="{{ old('odometer') }}" placeholder="Enter odometer reading">
        <span class="input-group-text">km</span>
    </div>
    @error('odometer')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- 4. Type of Income (Dropdown - will be based on setting menu) -->
<div class="mb-4">
    <label class="form-label">Type of Income <span class="text-danger">*</span></label>
    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
        <option value="">Select Type</option>
        <option value="Rental" {{ old('type') == 'Rental' ? 'selected' : '' }}>Rental</option>
        <option value="Service" {{ old('type') == 'Service' ? 'selected' : '' }}>Service</option>
        <option value="Transport" {{ old('type') == 'Transport' ? 'selected' : '' }}>Transport</option>
        <option value="Delivery" {{ old('type') == 'Delivery' ? 'selected' : '' }}>Delivery</option>
        <option value="Others" {{ old('type') == 'Others' ? 'selected' : '' }}>Others</option>
    </select>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">Income type will be configurable from Settings menu</small>
</div>

<!-- 5. Value (Free Text - Number) -->
<div class="mb-4">
    <label class="form-label">Value <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" placeholder="0" required>
    </div>
    @error('amount')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- 6. User (based on account logged in - readonly display) -->
<div class="mb-4">
    <label class="form-label">User</label>
    <input type="text" class="form-control" value="{{ auth()->check() ? auth()->user()->name : 'Guest' }}" readonly style="background-color: #f8f9fa;">
    <small class="text-muted">Automatically set to logged in user</small>
</div>

<!-- 7. Notes (free Text) -->
<div class="mb-4">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Add notes (optional)">{{ old('notes') }}</textarea>
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- 8. Attach File Button -->
<div class="mb-4">
    <label class="form-label">Attach File</label>
    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
    @error('attachment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">Accepted: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</small>
</div>
@endsection




























