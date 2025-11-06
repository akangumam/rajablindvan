@extends('layouts.drivvo')

@section('title', 'Pengaturan - Tempat')

@push('styles')
<style>
.settings-page-layout {
    display: flex;
    gap: 20px;
    padding: 20px;
}

.settings-page-sidebar {
    flex: 0 0 320px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    height: fit-content;
}

.settings-page-sidebar-header {
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.settings-page-sidebar-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #333;
}

.settings-page-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.settings-page-menu-item {
    border-bottom: 1px solid #f0f0f0;
}

.settings-page-menu-item:last-child {
    border-bottom: none;
}

.settings-page-menu-link {
    display: block;
    padding: 16px 20px;
    text-decoration: none;
    color: #333;
    font-size: 15px;
    transition: background 0.2s;
}

.settings-page-menu-link:hover {
    background: #f8f9fa;
    color: #333;
}

.settings-page-menu-link.active {
    background: #e7f3ff;
    color: #007bff;
    font-weight: 500;
}

.settings-page-content {
    flex: 1;
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.settings-page-content-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.settings-page-content-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.Lokasi-section {
    margin-bottom: 30px;
}

.Lokasi-field {
    margin-bottom: 20px;
}

.Lokasi-field-label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 10px;
    display: block;
    font-weight: 500;
}

.Lokasi-list {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.Lokasi-list-header {
    background: #f8f9fa;
    padding: 15px 20px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    align-items: center;
    gap: 20px;
}

.Lokasi-list-header > span:nth-child(1) {
    justify-self: start;
    padding-left: 30px;
}

.Lokasi-list-header > span:nth-child(2) {
    justify-self: start;
}

.Lokasi-list-header > button {
    justify-self: end;
}

/* Removed redundant CSS - using grid positioning instead */

.Lokasi-list-item {
    padding: 15px 20px;
    border-top: 1px solid #e9ecef;
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    align-items: center;
    gap: 20px;
    transition: background 0.2s;
    position: relative;
}

.Lokasi-list-item > .Lokasi-info {
    justify-self: start;
}

.Lokasi-list-item > .Lokasi-address {
    justify-self: start;
}

.Lokasi-list-item > .Lokasi-actions {
    justify-self: end;
}

.Lokasi-list-item:hover {
    background: #f8f9fa;
}

.Lokasi-info {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-left: 0;
}

.Lokasi-icon {
    width: 18px;
    flex-shrink: 0;
}

.Lokasi-icon {
    width: 40px;
    height: 40px;
    background: #e7f3ff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
    font-size: 18px;
}

.Lokasi-name {
    font-size: 15px;
    color: #333;
    font-weight: 500;
    text-align: left !important;
}

.Lokasi-address {
    font-size: 14px;
    color: #666;
    line-height: 1.4;
    text-align: left !important;
    padding: 0 !important;
    margin: 0 !important;
    align-self: start;
    justify-self: start;
    position: relative;
    left: 0;
}

.Lokasi-actions {
    display: flex;
    gap: 10px;
}

.btn-add {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-add:hover {
    background: #0056b3;
}

.btn-edit {
    background: transparent;
    color: #007bff;
    border: 1px solid #007bff;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    pointer-events: auto;
    z-index: 10;
}

.btn-edit:hover {
    background: #007bff;
    color: white;
}

.btn-delete {
    background: transparent;
    color: #dc3545;
    border: 1px solid #dc3545;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    pointer-events: auto;
    z-index: 10;
}

.btn-delete:hover {
    background: #dc3545;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #6c757d;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    overflow: auto;
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    background: none;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.close:hover,
.close:focus {
    color: #000;
}

.modal-body {
    padding: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-primary {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #0056b3;
}
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-cog"></i>
        Pengaturan
    </h1>
    <p class="page-subtitle">Konfigurasi preferensi aplikasi dan opsi format</p>
</div>

<div class="settings-page-layout">
    <div class="settings-page-sidebar">
        <div class="settings-page-sidebar-header">
            <h2 class="settings-page-sidebar-title">Pengaturan</h2>
        </div>
        <ul class="settings-page-menu">
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.format') }}" class="settings-page-menu-link">
                    <i class="fas fa-sliders-h" style="color: #667eea; font-size: 14px; margin-right: 12px;"></i>
                    Format Aplikasi
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.account') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-circle" style="color: #3498db; font-size: 14px; margin-right: 12px;"></i>
                    Akun Saya
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-page-menu-link">
                    <i class="fas fa-folder-open" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    File dan Penyimpanan
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.locations') }}" class="settings-page-menu-link active">
                    <i class="fas fa-map-marker-alt" style="color: #e74c3c; font-size: 14px; margin-right: 12px;"></i>
                    Tempat
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.service-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-wrench" style="color: #95a5a6; font-size: 14px; margin-right: 12px;"></i>
                    Jenis Services
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.expense-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-money-bill-wave" style="color: #e67e22; font-size: 14px; margin-right: 12px;"></i>
                    Jenis Pengeluaran
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.income-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-coins" style="color: #27ae60; font-size: 14px; margin-right: 12px;"></i>
                    Jenis Pendapatan
                </a>
            </li>
            @if(auth()->user()->hasRole(['super_admin']))
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.investors.index') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-tie" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    Investor
                </a>
            </li>
            @endif
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-page-menu-link">
                    <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 14px; margin-right: 12px;"></i>
                    Metode Pembayaran
                </a>
            </li>
        </ul>
    </div>

    <div class="settings-page-content">
        <div class="settings-page-content-header">
            <h1 class="settings-page-content-title">Tempat</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="lokasi-section">
            <div class="Lokasi-field">
                <label class="Lokasi-field-label">List of Tempat</label>
                <div class="Lokasi-list">
                    <div class="Lokasi-list-header">
                        <span>Tempat</span>
                        <span>Alamat</span>
                        <button class="btn-add" onclick="openAddModal()">
                            <i class="fas fa-plus me-1"></i> TAMBAH TEMPAT BARU
                        </button>
                    </div>
                    
                    @if($locations->isEmpty())
                        <div class="Lokasi-list-item" style="grid-column: 1 / -1; justify-self: center; color: #999;">
                            No Tempat found. Click "TAMBAH TEMPAT BARU" to create one.
                        </div>
                    @else
                        @foreach($locations as $location)
                        <div class="Lokasi-list-item" data-id="{{ $location->id }}">
                            <div class="Lokasi-info">
                                <div class="Lokasi-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="Lokasi-name">{{ $location->name }}</div>
                            </div>
                            <div class="Lokasi-address">
                                {{ $location->address ?? 'Tidak ada alamat' }}
                            </div>
                            <div class="Lokasi-actions">
                                <button class="btn-edit" onclick="openEditModal($1, $2, $3)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-delete" onclick="confirmDelete({{ $location->id }}, '{{ $location->name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="LokasiModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">TAMBAH BARU Lokasi</h2>
            <button class="close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="LokasiForm">
                <input type="hidden" id="LokasiId" value="">
                <div class="form-group">
                    <label class="form-label">Lokasi Name *</label>
                    <input type="text" class="form-control" id="LokasiName" Lokasiholder="Enter Lokasi name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="LokasiDescription" Lokasiholder="Enter description (optional)" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal()">BATAL</button>
            <button type="button" class="btn-primary" onclick="SIMPANLokasi()">SIMPAN</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let isEditMode = false;

function openAddModal() {
    console.log('openAddModal called'); // Debug log
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Add New Tempat';
    document.getElementById('LokasiId').value = '';
    document.getElementById('LokasiName').value = '';
    document.getElementById('LokasiDescription').value = '';
    document.getElementById('LokasiModal').classList.add('show');
}

function openEditModal(id, name, address) {
    console.log('openEditModal called with id:', id); // Debug log
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Tempat';
    document.getElementById('LokasiId').value = id;
    document.getElementById('LokasiName').value = name;
    document.getElementById('LokasiDescription').value = address || '';
    document.getElementById('LokasiModal').classList.add('show');
}

function closeModal() {
    document.getElementById('LokasiModal').classList.remove('show');
}

function SIMPANLokasi() {
    const id = document.getElementById('LokasiId').value;
    const name = document.getElementById('LokasiName').value.trim();
    const description = document.getElementById('LokasiDescription').value.trim();
    
    if (!name) {
        alert('Please enter Lokasi name');
        return;
    }

    const url = isEditMode 
        ? '{{ route("settings.locations.update", ":id") }}'.replace(':id', id)
        : '{{ route("settings.locations.store") }}';
    
    const method = isEditMode ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            description: description
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            location.reload(); // Refresh page to show new data
        } else {
            alert('Error: ' + (data.message || 'Something went wrong'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to SIMPAN Lokasi. Please try again.');
    });
}

function confirmDelete(id, name) {
    if (confirm('Are you sure you want to delete "' + name + '"?')) {
        fetch('{{ route("settings.locations.destroy", ":id") }}'.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Refresh page
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete Lokasi. Please try again.');
        });
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('LokasiModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
@endpush

@endsection
