@extends('layouts.drivvo-form', [
    'pageTitle' => 'Edit Reminder',
    'pageIcon' => 'fa-bell',
    'pageSubtitle' => 'Update reminder information',
    'formAction' => route('reminders.update', $reminder->id),
    'formId' => 'reminderForm',
    'cancelRoute' => route('reminders.index', ['vehicle' => $reminder->vehicle_id]),
])

@section('form-fields')
@method('PUT')
<input type="hidden" name="vehicle_id" value="{{ $reminder->vehicle_id }}">

<div class="row">
    <div class="col-md-8">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-heading text-primary"></i>
                Reminder Title <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $reminder->title) }}" placeholder="Example: Engine Oil Change" required>
            @error('title')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-tag text-primary"></i>
                Category <span class="text-danger">*</span>
            </label>
            <select name="category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="Service" {{ old('category', $reminder->category) == 'Service' ? 'selected' : '' }}>Service</option>
                <option value="Oil Change" {{ old('category', $reminder->category) == 'Oil Change' ? 'selected' : '' }}>Oil Change</option>
                <option value="Tax" {{ old('category', $reminder->category) == 'Tax' ? 'selected' : '' }}>Tax</option>
                <option value="Insurance" {{ old('category', $reminder->category) == 'Insurance' ? 'selected' : '' }}>Insurance</option>
                <option value="License" {{ old('category', $reminder->category) == 'License' ? 'selected' : '' }}>License</option>
                <option value="Inspection" {{ old('category', $reminder->category) == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                <option value="Other" {{ old('category', $reminder->category) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('category')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-calendar text-primary"></i>
                Due Date <span class="text-danger">*</span>
            </label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $reminder->due_date->format('Y-m-d')) }}" required>
            @error('due_date')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-tachometer-alt text-primary"></i>
                Due Odometer (km)
            </label>
            <input type="number" name="due_odometer" class="form-control" value="{{ old('due_odometer', $reminder->due_odometer) }}" placeholder="Example: 50000" step="0.01">
            @error('due_odometer')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-bell text-primary"></i>
                Alert Days Before
            </label>
            <input type="number" name="advance_notice_days" class="form-control" value="{{ old('advance_notice_days', $reminder->advance_notice_days) }}" placeholder="7">
            @error('advance_notice_days')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-dollar-sign text-primary"></i>
                Estimated Cost (Rp)
            </label>
            <input type="number" name="estimated_cost" class="form-control" value="{{ old('estimated_cost', $reminder->estimated_cost) }}" placeholder="Example: 500000" step="0.01">
            @error('estimated_cost')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="field-group">
            <label class="form-label">
                <i class="fas fa-sync-alt text-primary"></i>
                Recurring Interval
            </label>
            <select name="recurring_interval" class="form-select" id="recurringInterval">
                <option value="">None (One-time)</option>
                <option value="Weekly" {{ old('recurring_interval', $reminder->recurring_interval) == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="Monthly" {{ old('recurring_interval', $reminder->recurring_interval) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="Quarterly" {{ old('recurring_interval', $reminder->recurring_interval) == 'Quarterly' ? 'selected' : '' }}>Quarterly (3 months)</option>
                <option value="Semi-Annually" {{ old('recurring_interval', $reminder->recurring_interval) == 'Semi-Annually' ? 'selected' : '' }}>Semi-Annually (6 months)</option>
                <option value="Yearly" {{ old('recurring_interval', $reminder->recurring_interval) == 'Yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
            @error('recurring_interval')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="field-group">
    <label class="form-label">
        <i class="fas fa-align-left text-primary"></i>
        Description
    </label>
    <textarea name="description" class="form-control" rows="3" placeholder="Enter reminder description...">{{ old('description', $reminder->description) }}</textarea>
    @error('description')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="field-group">
    <label class="form-label">
        <i class="fas fa-sticky-note text-primary"></i>
        Notes
    </label>
    <textarea name="notes" class="form-control" rows="2" placeholder="Additional notes...">{{ old('notes', $reminder->notes) }}</textarea>
    @error('notes')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="field-group">
    <div class="form-check">
        <input type="checkbox" name="is_completed" value="1" class="form-check-input" id="isCompleted" {{ old('is_completed', $reminder->is_completed) ? 'checked' : '' }}>
        <label class="form-check-label" for="isCompleted">
            <i class="fas fa-check-circle text-success"></i>
            Mark as Completed
        </label>
    </div>
</div>

<input type="hidden" name="is_recurring" id="isRecurring" value="{{ old('is_recurring', $reminder->is_recurring ? '1' : '0') }}">
@endsection

@section('additional-scripts')
// Auto set is_recurring based on recurring_interval
document.getElementById('recurringInterval').addEventListener('change', function() {
    const isRecurringInput = document.getElementById('isRecurring');
    isRecurringInput.value = this.value ? '1' : '0';
});

// Set initial value
if (document.getElementById('recurringInterval').value) {
    document.getElementById('isRecurring').value = '1';
}
@endsection
