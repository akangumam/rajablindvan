@extends('layouts.drivvo-form', [
    'pageTitle' => 'Add New User',
    'pageSubtitle' => 'Create a new user account',
    'formAction' => route('users.store'),
    'formMethod' => 'POST',
    'hideVehicleSelector' => true,
    'cancelRoute' => route('users.index')
])

@section('form-fields')
<!-- First Name -->
<div class="mb-4">
    <label class="form-label">First Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" required>
    @error('first_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <!-- Last Name -->
    <div class="mb-4">
        <label class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" required>
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label class="form-label">Email Address <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="user@example.com" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Title/Position -->
    <div class="mb-4">
        <label class="form-label">Title/Position</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="e.g., Sales Manager, Operations Director">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- User Type/Authorization -->
    <div class="mb-4">
        <label class="form-label">User Type/Authorization <span class="text-danger">*</span></label>
        <select class="form-control @error('user_type') is-invalid @enderror" name="user_type" required>
            <option value="">Select User Type</option>
            <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Administrator</option>
            <option value="manager" {{ old('user_type') == 'manager' ? 'selected' : '' }}>Sales</option>
            <option value="driver" {{ old('user_type') == 'driver' ? 'selected' : '' }}>Operation</option>
        </select>
        @error('user_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">
            <strong>Administrator:</strong> Full access to all features<br>
            <strong>Sales:</strong> Can manage vehicles, rentals, and sales reports<br>
            <strong>Operation:</strong> Limited access to assigned vehicles and operations
        </small>
    </div>

    <!-- User Status -->
    <div class="mb-4">
        <label class="form-label">User Status <span class="text-danger">*</span></label>
        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
    });
});
</script>
@endpush
