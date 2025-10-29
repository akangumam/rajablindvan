@extends('layouts.drivvo')

@section('title', 'Edit Maintenance')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-warning me-2"></i>
                        Edit Maintenance
                    </h5>
                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('maintenances.update', $maintenance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Vehicle dan Date -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="vehicle_id" class="form-label">
                                        <i class="fas fa-car me-1"></i>Vehicle <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ $maintenance->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->name }} ({{ $vehicle->license_plate }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="maintenance_date" class="form-label">
                                        <i class="fas fa-calendar me-1"></i>Date Maintenance <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('maintenance_date') is-invalid @enderror" 
                                           id="maintenance_date" 
                                           name="maintenance_date" 
                                           value="{{ old('maintenance_date', $maintenance->maintenance_date) }}" 
                                           required>
                                    @error('maintenance_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="odometer" class="form-label">
                                        <i class="fas fa-tachometer-alt me-1"></i>Odometer (km) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('odometer') is-invalid @enderror" 
                                           id="odometer" 
                                           name="odometer" 
                                           value="{{ old('odometer', $maintenance->odometer) }}" 
                                           min="0" 
                                           step="0.01" 
                                           required>
                                    @error('odometer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Type dan Kategori -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">
                                        <i class="fas fa-wrench me-1"></i>Type Maintenance <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('type') is-invalid @enderror" 
                                           id="type" 
                                           name="type" 
                                           value="{{ old('type', $maintenance->type) }}" 
                                           placeholder="Example: Oil Change, Regular Service" 
                                           required>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">
                                        <i class="fas fa-tags me-1"></i>Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                        <option value="">Select Kategori</option>
                                        <option value="Routine" {{ $maintenance->category == 'Routine' ? 'selected' : '' }}>Rutin</option>
                                        <option value="Repair" {{ $maintenance->category == 'Repair' ? 'selected' : '' }}>Perbaikan</option>
                                        <option value="Emergency" {{ $maintenance->category == 'Emergency' ? 'selected' : '' }}>Darurat</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="Status" class="form-label">
                                        <i class="fas fa-flag me-1"></i>Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('Status') is-invalid @enderror" id="Status" name="Status" required>
                                        <option value="">Select Status</option>
                                        <option value="Completed" {{ $maintenance->Status == 'Completed' ? 'selected' : '' }}>End</option>
                                        <option value="Scheduled" {{ $maintenance->Status == 'Scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="Overdue" {{ $maintenance->Status == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('Status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-file-alt me-1"></i>Deskripsi <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Jelaskan detail Maintenance yang dilakukan..." 
                                              required>{{ old('description', $maintenance->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Workshop dan Cost -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="workshop" class="form-label">
                                        <i class="fas fa-store me-1"></i>Bengkel/Workshop
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('workshop') is-invalid @enderror" 
                                           id="workshop" 
                                           name="workshop" 
                                           value="{{ old('workshop', $maintenance->workshop) }}" 
                                           placeholder="Name bengkel">
                                    @error('workshop')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cost" class="form-label">
                                        <i class="fas fa-money-bill me-1"></i>Cost (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('cost') is-invalid @enderror" 
                                           id="cost" 
                                           name="cost" 
                                           value="{{ old('cost', $maintenance->cost) }}" 
                                           min="0" 
                                           step="1000" 
                                           required>
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Maintenance Selanjutnya -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="next_maintenance_date" class="form-label">
                                        <i class="fas fa-calendar-alt me-1"></i>Date Maintenance Selanjutnya
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('next_maintenance_date') is-invalid @enderror" 
                                           id="next_maintenance_date" 
                                           name="next_maintenance_date" 
                                           value="{{ old('next_maintenance_date', $maintenance->next_maintenance_date) }}">
                                    @error('next_maintenance_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="next_maintenance_odometer" class="form-label">
                                        <i class="fas fa-tachometer-alt me-1"></i>Odometer Maintenance Selanjutnya (km)
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('next_maintenance_odometer') is-invalid @enderror" 
                                           id="next_maintenance_odometer" 
                                           name="next_maintenance_odometer" 
                                           value="{{ old('next_maintenance_odometer', $maintenance->next_maintenance_odometer) }}" 
                                           min="0" 
                                           step="0.01">
                                    @error('next_maintenance_odometer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Suku Cadang dan Notes -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parts_replaced" class="form-label">
                                        <i class="fas fa-cog me-1"></i>Parts Replaced
                                    </label>
                                    <textarea class="form-control @error('parts_replaced') is-invalid @enderror" 
                                              id="parts_replaced" 
                                              name="parts_replaced" 
                                              rows="2" 
                                              placeholder="List Parts Replaced...">{{ old('parts_replaced', $maintenance->parts_replaced) }}</textarea>
                                    @error('parts_replaced')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">
                                        <i class="fas fa-sticky-note me-1"></i>Notes Tambahan
                                    </label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="2" 
                                              placeholder="Additional notes...">{{ old('notes', $maintenance->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('maintenances.show', $maintenance) }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>CANCEL
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i>Update Maintenance
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




























