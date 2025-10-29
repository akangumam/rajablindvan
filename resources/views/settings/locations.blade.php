@extends('layouts.drivvo')

@section('title', 'Settings - Place')

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

.place-section {
    margin-bottom: 30px;
}

.place-field {
    margin-bottom: 20px;
}

.place-field-label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 10px;
    display: block;
    font-weight: 500;
}

.place-list {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.place-list-header {
    background: #f8f9fa;
    padding: 15px 20px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.place-list-item {
    padding: 15px 20px;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.2s;
}

.place-list-item:hover {
    background: #f8f9fa;
}

.place-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.place-icon {
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

.place-name {
    font-size: 15px;
    color: #333;
    font-weight: 500;
}

.place-actions {
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
        Settings
    </h1>
    <p class="page-subtitle">Configure your application preferences and formatting options</p>
</div>

<div class="settings-page-layout">
    <div class="settings-page-sidebar">
        <div class="settings-page-sidebar-header">
            <h2 class="settings-page-sidebar-title">Settings</h2>
        </div>
        <ul class="settings-page-menu">
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.format') }}" class="settings-page-menu-link">
                    <i class="fas fa-sliders-h" style="color: #667eea; font-size: 14px; margin-right: 12px;"></i>
                    Apps Format
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.account') }}" class="settings-page-menu-link">
                    <i class="fas fa-user-circle" style="color: #3498db; font-size: 14px; margin-right: 12px;"></i>
                    My Account
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.file-storage') }}" class="settings-page-menu-link">
                    <i class="fas fa-folder-open" style="color: #f39c12; font-size: 14px; margin-right: 12px;"></i>
                    File and Storage
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.locations') }}" class="settings-page-menu-link active">
                    <i class="fas fa-map-marker-alt" style="color: #e74c3c; font-size: 14px; margin-right: 12px;"></i>
                    Place
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.service-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-wrench" style="color: #95a5a6; font-size: 14px; margin-right: 12px;"></i>
                    Type of Services
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.expense-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-money-bill-wave" style="color: #e67e22; font-size: 14px; margin-right: 12px;"></i>
                    Type of Expense
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.income-types') }}" class="settings-page-menu-link">
                    <i class="fas fa-coins" style="color: #27ae60; font-size: 14px; margin-right: 12px;"></i>
                    Type of Income
                </a>
            </li>
            <li class="settings-page-menu-item">
                <a href="{{ route('settings.payment-methods') }}" class="settings-page-menu-link">
                    <i class="fas fa-credit-card" style="color: #9b59b6; font-size: 14px; margin-right: 12px;"></i>
                    Payment Methods
                </a>
            </li>
        </ul>
    </div>

    <div class="settings-page-content">
        <div class="settings-page-content-header">
            <h1 class="settings-page-content-title">Place</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="place-section">
            <div class="place-field">
                <label class="place-field-label">List of Places</label>
                <div class="place-list">
                    <div class="place-list-header">
                        <span>Places</span>
                        <button class="btn-add" onclick="openAddModal()">
                            <i class="fas fa-plus me-1"></i> ADD NEW PLACE
                        </button>
                    </div>
                    
                    @if($locations->isEmpty())
                        <div class="place-list-item" style="justify-content: center; color: #999;">
                            No places found. Click "ADD NEW PLACE" to create one.
                        </div>
                    @else
                        @foreach($locations as $location)
                        <div class="place-list-item" data-id="{{ $location->id }}">
                            <div class="place-info">
                                <div class="place-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="place-name">{{ $location->name }}</div>
                            </div>
                            <div class="place-actions">
                                <button class="btn-edit" onclick="openEditModal({{ $location->id }}, '{{ $location->name }}', '{{ $location->address }}')">
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
<div id="placeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Add New Place</h2>
            <button class="close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="placeForm">
                <input type="hidden" id="placeId" value="">
                <div class="form-group">
                    <label class="form-label">Place Name *</label>
                    <input type="text" class="form-control" id="placeName" placeholder="Enter place name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="placeDescription" placeholder="Enter description (optional)" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal()">CANCEL</button>
            <button type="button" class="btn-primary" onclick="savePlace()">SAVE</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let isEditMode = false;

function openAddModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Add New Place';
    document.getElementById('placeId').value = '';
    document.getElementById('placeName').value = '';
    document.getElementById('placeDescription').value = '';
    document.getElementById('placeModal').classList.add('show');
}

function openEditModal(id, name, description) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Place';
    document.getElementById('placeId').value = id;
    document.getElementById('placeName').value = name;
    document.getElementById('placeDescription').value = description || '';
    document.getElementById('placeModal').classList.add('show');
}

function closeModal() {
    document.getElementById('placeModal').classList.remove('show');
}

function savePlace() {
    const id = document.getElementById('placeId').value;
    const name = document.getElementById('placeName').value.trim();
    const description = document.getElementById('placeDescription').value.trim();
    
    if (!name) {
        alert('Please enter place name');
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
        alert('Failed to save place. Please try again.');
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
            alert('Failed to delete place. Please try again.');
        });
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('placeModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
@endpush

@endsection
