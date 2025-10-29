@extends('layouts.drivvo-form', [
    'pageTitle' => 'Add Reminder',
    'pageIcon' => 'fa-bell',
    'pageSubtitle' => 'Create reminder for vehicle maintenance or expenses',
    'formAction' => route('reminders.store'),
    'formId' => 'reminderForm',
    'cancelRoute' => isset($vehicle) ? route('reminders.index', ['vehicle' => $vehicle->id]) : route('reminders.index'),
])

@section('form-fields')
@if(isset($vehicle))
    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
@endif

<div class="field-group">
    <label class="form-label">Reminder title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Example: Engine Oil Change" required>
</div>

<div class="field-group">
    <label class="form-label">Kategori</label>
    <select name="category" class="form-select" required>
        <option value="">Select kategori</option>
        <option value="Service">Service</option>
        <option value="Oil Change">Oil Change</option>
        <option value="Tax">Tax</option>
        <option value="Insurance">Insurance</option>
    </select>
</div>

<div class="field-group">
    <label class="form-label">Date jatuh tempo</label>
    <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
</div>

<div class="field-group">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
</div>
@endsection

@section('additional-scripts')
console.log('Form ready');
@endsection




























