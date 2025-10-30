@extends('layouts.drivvo-form', [
    'pageTitle' => __('customer.add_customer'),
    'pageIcon' => 'fa-users',
    'formAction' => route('customers.store'),
    'formId' => 'customerForm',
    'cancelRoute' => route('customers.index'),
    'hideVehicleSelector' => true,
])

@section('form-fields')
<!-- Name Depan & Belakang -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="first_name" class="form-label">
            <i class="far fa-user" style="color: #5B7C99; margin-right: 8px;"></i>
            Name depan
        </label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Name depan" required>
        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="last_name" class="form-label">
            <i class="far fa-user" style="color: #5B7C99; margin-right: 8px; opacity: 0;"></i>
            Name belakang
        </label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Name belakang">
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Email -->
<div class="mb-3">
    <label for="Email" class="form-label">
        <i class="far fa-envelope" style="color: #5B7C99; margin-right: 8px;"></i>
        Email
    </label>
    <input type="Email" class="form-control @error('Email') is-invalid @enderror" id="Email" name="Email" value="{{ old('Email') }}" placeholder="Email">
    @error('Email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Tipe Pengguna -->
<div class="mb-3">
    <label for="userType" class="form-label">
        <i class="fas fa-id-card" style="color: #5B7C99; margin-right: 8px;"></i>
        Tipe Pengguna
    </label>
    <input type="text" class="form-control" id="userTypeInput" name="user_type" value="{{ old('user_type') }}" placeholder="Tipe Pengguna" readonly onclick="openUserTypeModalDirect()" style="cursor: pointer; background-color: white;">
    @error('user_type')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<!-- Izin mengemudi & Kategori SIM -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="id_number" class="form-label">
            <i class="far fa-id-card" style="color: #5B7C99; margin-right: 8px;"></i>
            Izin mengemudi (Optional)
        </label>
        <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number" name="id_number" value="{{ old('id_number') }}" placeholder="Izin mengemudi">
        @error('id_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="license_category" class="form-label">
            <i class="far fa-id-card" style="color: #5B7C99; margin-right: 8px; opacity: 0;"></i>
            Kategori SIM (Optional)
        </label>
        <input type="text" class="form-control @error('license_category') is-invalid @enderror" id="license_category" name="license_category" value="{{ old('license_category') }}" placeholder="Kategori SIM">
        @error('license_category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Masa berlaku izin mengemudi -->
<div class="mb-3">
    <label for="license_expiry" class="form-label">
        <i class="far fa-calendar" style="color: #5B7C99; margin-right: 8px;"></i>
        Masa berlaku izin mengemudi (Optional)
    </label>
    <input type="date" class="form-control @error('license_expiry') is-invalid @enderror" id="license_expiry" name="license_expiry" value="{{ old('license_expiry') }}" placeholder="DD/MM/YYYY">
    @error('license_expiry')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- No. Phone -->
<div class="mb-3">
    <label for="phone" class="form-label">
        <i class="fas fa-phone" style="color: #5B7C99; margin-right: 8px;"></i>
        No. Phone
    </label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08123456789" required>
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Address -->
<div class="mb-3">
    <label for="address" class="form-label">
        <i class="fas fa-map-marker-alt" style="color: #5B7C99; margin-right: 8px;"></i>
        Address
    </label>
    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Address lengkap">{{ old('address') }}</textarea>
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Notes -->
<div class="mb-3">
    <label for="notes" class="form-label">
        <i class="far fa-sticky-note" style="color: #5B7C99; margin-right: 8px;"></i>
        Notes
    </label>
    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Notes tambahan...">{{ old('notes') }}</textarea>
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@endsection

@section('modals')
<!-- User Type Modal -->
<div class="modal fade" id="userTypeModal" tabindex="-1" aria-labelledby="userTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: none; padding: 24px 24px 16px 24px;">
                <h5 class="modal-title" id="userTypeModalLabel" style="font-size: 20px; font-weight: 400; color: #212529; font-family: 'Roboto Slab', serif;">Tipe Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #0d6efd;"></button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div id="userTypeList">
                    <div class="user-type-item" data-value="Pengelola" style="padding: 24px 32px; cursor: pointer; border-bottom: none; background: white;">
                        <div style="font-size: 18px; font-weight: 400; color: #0d6efd; margin-bottom: 8px;">Pengelola</div>
                        <div style="font-size: 14px; color: #6c757d; line-height: 1.5;">Ini memiliki akses ke All Vehicle, dapat mengelola dan menListkan driver baru.</div>
                    </div>
                    <div class="user-type-item" data-value="driver" style="padding: 24px 32px; cursor: pointer; border-bottom: none; background: white;">
                        <div style="font-size: 18px; font-weight: 400; color: #0d6efd; margin-bottom: 8px;">driver</div>
                        <div style="font-size: 14px; color: #6c757d; line-height: 1.5;">Pengemudi hanya memiliki akses ke Vehicle yang checked oleh manajer armada.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Definisi fungsi HARUS di atas agar bisa dipanggil dari onclick
window.openUserTypeModalDirect = function() {
    console.log('Opening modal...');
    const modalElement = document.getElementById('userTypeModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('Modal shown');
    } else {
        console.error('Modal element not found!');
        alert('Modal tidak ditemukan! Silakan refresh halaman.');
    }
};

// Setup setelah DOM ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Ready - Setting up user type modal');
    
    const userTypeInput = document.getElementById('userTypeInput');
    const userTypeModal = document.getElementById('userTypeModal');
    
    console.log('Input element:', userTypeInput);
    console.log('Modal element:', userTypeModal);
    
    if (!userTypeInput || !userTypeModal) {
        console.error('Required elements not found!');
        return;
    }
    
    // Setup click handlers untuk item di modal
    const items = document.querySelectorAll('.user-type-item');
    console.log('Found user type items:', items.length);
    
    items.forEach(function(item) {
        item.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            console.log('Selected:', value);
            
            // Set value
            userTypeInput.value = value;
            
            // Close modal
            const modalInstance = bootstrap.Modal.getInstance(userTypeModal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
        
        // Hover effects
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'white';
            this.style.transform = 'scale(1)';
        });
    });
    
    console.log('User type modal setup complete');
});
</script>
@endsection

@section('additional-scripts')
<!-- Script already dipindahkan ke section modals -->
@endsection























