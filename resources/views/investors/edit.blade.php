@extends('layouts.drivvo')

@section('title', __('common.edit_investor_title'))

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-user-tie"></i> {{ __('common.edit_investor_title') }}: {{ $investor->name }}
    </h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('settings.investors.update', $investor) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">{{ __('common.investor_name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $investor->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">{{ __('common.email') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $investor->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">{{ __('common.phone') }}</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $investor->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="id_number" class="form-label">{{ __('common.id_number') }}</label>
                    <input type="text" class="form-control @error('id_number') is-invalid @enderror" 
                           id="id_number" name="id_number" value="{{ old('id_number', $investor->id_number) }}">
                    @error('id_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">{{ __('common.address') }}</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="3">{{ old('address', $investor->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="investment_percentage" class="form-label">{{ __('common.profit_share_percentage') }} <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('investment_percentage') is-invalid @enderror" 
                           id="investment_percentage" name="investment_percentage" 
                           value="{{ old('investment_percentage', $investor->investment_percentage) }}" 
                           min="0" max="100" step="0.01" required>
                    <small class="text-muted">{{ __('common.profit_share_example') }}</small>
                    @error('investment_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">{{ __('common.status') }} <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="active" {{ old('status', $investor->status) === 'active' ? 'selected' : '' }}>{{ __('common.active') }}</option>
                        <option value="inactive" {{ old('status', $investor->status) === 'inactive' ? 'selected' : '' }}>{{ __('common.inactive') }}</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">{{ __('common.notes') }}</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes', $investor->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('settings.investors.show', $investor) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> {{ __('common.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('common.update') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
