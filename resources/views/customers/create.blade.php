@extends('layouts.drivvo-form', [
    'pageTitle' => __('customer.add_customer'),
    'pageIcon' => 'fa-users',
    'formAction' => route('customers.store'),
    'formId' => 'customerForm',
    'cancelRoute' => route('customers.index'),
    'hideVehicleSelector' => true,
])

@section('form-fields')
<!-- Company Name -->
<div class="mb-3">
    <label for="company_name" class="form-label">
        <i class="fas fa-building" style="color: #5B7C99; margin-right: 8px;"></i>
        Company Name
    </label>
    <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Enter company name" required>
    @error('company_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Company Address -->
<div class="mb-3">
    <label for="company_address" class="form-label">
        <i class="fas fa-map-marker-alt" style="color: #5B7C99; margin-right: 8px;"></i>
        Company Address
    </label>
    <textarea class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" rows="3" placeholder="Enter company address" required>{{ old('company_address') }}</textarea>
    @error('company_address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- PIC Name -->
<div class="mb-3">
    <label for="pic_name" class="form-label">
        <i class="far fa-user" style="color: #5B7C99; margin-right: 8px;"></i>
        PIC Name
    </label>
    <input type="text" class="form-control @error('pic_name') is-invalid @enderror" id="pic_name" name="pic_name" value="{{ old('pic_name') }}" placeholder="Enter PIC name" required>
    @error('pic_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Contact Number -->
<div class="mb-3">
    <label for="contact_number" class="form-label">
        <i class="fas fa-phone" style="color: #5B7C99; margin-right: 8px;"></i>
        Contact Number
    </label>
    <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" placeholder="Enter contact number" required>
    @error('contact_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@endsection

@section('additional-scripts')
<!-- No additional scripts needed -->
@endsection























