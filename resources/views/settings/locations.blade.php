@extends('layouts.drivvo')

@section('title', 'Pengaturan - Tempat')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
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
    grid-template-columns: 240px 1fr 240px auto;
    align-items: center;
    gap: 20px;
}

.Lokasi-list-header > span {
    text-align: left;
    padding: 0;
    margin: 0;
}

.Lokasi-list-header > button {
    justify-self: end;
}

.Lokasi-list-item {
    padding: 15px 20px;
    border-top: 1px solid #e9ecef;
    display: grid;
    grid-template-columns: 240px 1fr 240px auto;
    align-items: center;
    gap: 20px;
    transition: background 0.2s;
    position: relative;
}

.Lokasi-list-item > * {
    align-self: center;
    padding: 0;
    margin: 0;
}

.Lokasi-list-item > .Lokasi-info {
    padding: 0;
    margin: 0;
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
    padding: 0;
    margin: 0;
    text-align: left;
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
    flex-shrink: 0;
}

.Lokasi-name {
    font-size: 15px;
    color: #333;
    font-weight: 500;
    text-align: left;
}

.Lokasi-address {
    font-size: 14px;
    color: #666;
    line-height: 1.4;
    text-align: left;
    padding: 0;
    margin: 0;
}

.Lokasi-coordinates {
    font-size: 13px;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 3px;
    align-items: flex-start;
    padding: 0;
    margin: 0;
}

.coordinate-link {
    color: #007bff;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
    font-family: 'Courier New', monospace;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 4px;
    background: #e7f3ff;
    width: fit-content;
}

.coordinate-link:hover {
    color: #0056b3;
    background: #cce5ff;
    text-decoration: none;
}

.coordinate-link i {
    font-size: 11px;
}

.no-coordinates {
    color: #999;
    font-style: italic;
    font-size: 13px;
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
    max-width: 700px;
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

/* Map Styles */
#map {
    width: 100%;
    height: 400px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #dee2e6;
}

.map-info {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
    margin-bottom: 15px;
    font-size: 13px;
    color: #666;
}

.map-info i {
    margin-right: 8px;
    color: #007bff;
}

.coordinates-display {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 10px;
}

.coordinate-box {
    background: white;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #dee2e6;
    font-size: 12px;
}

.coordinate-label {
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 5px;
}

.coordinate-value {
    color: #333;
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

/* Required field asterisk */
.form-label .required {
    color: #dc3545;
    font-weight: bold;
    margin-left: 2px;
}

/* Error state */
.form-control.error {
    border-color: #dc3545;
    background-color: #fff5f5;
}

.form-control.error:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

.error-message.show {
    display: block;
}

.error-message i {
    margin-right: 5px;
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
                        <span>Koordinat</span>
                        <button class="btn-add" onclick="openAddModal()">
                            <i class="fas fa-plus me-1"></i> TAMBAH TEMPAT BARU
                        </button>
                    </div>
                    
                    @if($locations->isEmpty())
                        <div class="Lokasi-list-item" style="grid-column: 1 / -1; justify-self: center; color: #999;">
                            Belum ada tempat. Klik "TAMBAH TEMPAT BARU" untuk menambahkan.
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
                            <div class="Lokasi-coordinates">
                                @if($location->latitude && $location->longitude)
                                    <a href="https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}" 
                                       target="_blank" 
                                       class="coordinate-link"
                                       title="Buka di Google Maps">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ number_format($location->latitude, 6) }}, {{ number_format($location->longitude, 6) }}
                                    </a>
                                @else
                                    <span class="no-coordinates">Belum ada koordinat</span>
                                @endif
                            </div>
                            <div class="Lokasi-actions">
                                <button class="btn-edit" onclick='openEditModal(@json($location))'>
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
                <input type="hidden" id="LokasiLatitude" value="">
                <input type="hidden" id="LokasiLongitude" value="">
                
                <div class="form-group">
                    <label class="form-label">Nama Tempat <span class="required">*</span></label>
                    <input type="text" class="form-control" id="LokasiName" placeholder="Masukkan nama tempat" required>
                    <div class="error-message" id="errorLokasiName">
                        <i class="fas fa-exclamation-circle"></i>
                        Nama tempat harus diisi
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kode Tempat <span class="required">*</span></label>
                    <input type="text" class="form-control" id="LokasiCode" placeholder="Contoh: JKT, BDG" required>
                    <div class="error-message" id="errorLokasiCode">
                        <i class="fas fa-exclamation-circle"></i>
                        Kode tempat harus diisi
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Alamat <span class="required">*</span></label>
                    <textarea class="form-control" id="LokasiAddress" placeholder="Masukkan alamat lengkap" rows="2" required></textarea>
                    <div class="error-message" id="errorLokasiAddress">
                        <i class="fas fa-exclamation-circle"></i>
                        Alamat harus diisi
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="LokasiPhone" placeholder="Nomor telepon (opsional)">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Manager</label>
                    <input type="text" class="form-control" id="LokasiManager" placeholder="Nama manager (opsional)">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Pin Lokasi pada Peta</label>
                    <div class="map-info">
                        <i class="fas fa-info-circle"></i>
                        Klik pada peta untuk menandai lokasi. Pin akan menunjukkan koordinat yang tepat.
                    </div>
                    <div id="map"></div>
                    <div class="coordinates-display">
                        <div class="coordinate-box">
                            <div class="coordinate-label">Latitude</div>
                            <div class="coordinate-value" id="displayLatitude">-</div>
                        </div>
                        <div class="coordinate-box">
                            <div class="coordinate-label">Longitude</div>
                            <div class="coordinate-value" id="displayLongitude">-</div>
                        </div>
                    </div>
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
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
let isEditMode = false;
let map = null;
let marker = null;
let currentLat = -6.2088;  // Default to Jakarta
let currentLng = 106.8456;

// Initialize map
function initMap(lat = -6.2088, lng = 106.8456) {
    // Remove existing map if any
    if (map !== null) {
        map.remove();
    }
    
    // Create map
    map = L.map('map').setView([lat, lng], 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add click event to map
    map.on('click', function(e) {
        placeMarker(e.latlng);
    });
    
    // Place initial marker if coordinates exist
    if (lat && lng) {
        placeMarker(L.latLng(lat, lng));
    }
    
    // Fix map display issues
    setTimeout(function() {
        map.invalidateSize();
    }, 100);
}

// Place marker on map
function placeMarker(latlng) {
    // Remove existing marker
    if (marker !== null) {
        map.removeLayer(marker);
    }
    
    // Add new marker
    marker = L.marker(latlng).addTo(map);
    
    // Update coordinates
    currentLat = latlng.lat;
    currentLng = latlng.lng;
    
    // Update hidden inputs
    document.getElementById('LokasiLatitude').value = currentLat.toFixed(8);
    document.getElementById('LokasiLongitude').value = currentLng.toFixed(8);
    
    // Update display
    document.getElementById('displayLatitude').textContent = currentLat.toFixed(8);
    document.getElementById('displayLongitude').textContent = currentLng.toFixed(8);
}

function openAddModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Tambah Tempat Baru';
    document.getElementById('LokasiId').value = '';
    document.getElementById('LokasiName').value = '';
    document.getElementById('LokasiCode').value = '';
    document.getElementById('LokasiAddress').value = '';
    document.getElementById('LokasiPhone').value = '';
    document.getElementById('LokasiManager').value = '';
    document.getElementById('LokasiLatitude').value = '';
    document.getElementById('LokasiLongitude').value = '';
    document.getElementById('displayLatitude').textContent = '-';
    document.getElementById('displayLongitude').textContent = '-';
    
    document.getElementById('LokasiModal').classList.add('show');
    
    // Initialize map with default location (Jakarta)
    setTimeout(function() {
        initMap(-6.2088, 106.8456);
    }, 200);
}

function openEditModal(location) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Tempat';
    document.getElementById('LokasiId').value = location.id;
    document.getElementById('LokasiName').value = location.name || '';
    document.getElementById('LokasiCode').value = location.code || '';
    document.getElementById('LokasiAddress').value = location.address || '';
    document.getElementById('LokasiPhone').value = location.phone || '';
    document.getElementById('LokasiManager').value = location.manager_name || '';
    document.getElementById('LokasiLatitude').value = location.latitude || '';
    document.getElementById('LokasiLongitude').value = location.longitude || '';
    
    // Update coordinate display
    if (location.latitude && location.longitude) {
        document.getElementById('displayLatitude').textContent = parseFloat(location.latitude).toFixed(8);
        document.getElementById('displayLongitude').textContent = parseFloat(location.longitude).toFixed(8);
    } else {
        document.getElementById('displayLatitude').textContent = '-';
        document.getElementById('displayLongitude').textContent = '-';
    }
    
    document.getElementById('LokasiModal').classList.add('show');
    
    // Initialize map with existing coordinates or default
    setTimeout(function() {
        const lat = location.latitude ? parseFloat(location.latitude) : -6.2088;
        const lng = location.longitude ? parseFloat(location.longitude) : 106.8456;
        initMap(lat, lng);
    }, 200);
}

function closeModal() {
    document.getElementById('LokasiModal').classList.remove('show');
    // Clean up map
    if (map !== null) {
        map.remove();
        map = null;
        marker = null;
    }
}

function SIMPANLokasi() {
    const id = document.getElementById('LokasiId').value;
    const name = document.getElementById('LokasiName').value.trim();
    const code = document.getElementById('LokasiCode').value.trim();
    const address = document.getElementById('LokasiAddress').value.trim();
    const phone = document.getElementById('LokasiPhone').value.trim();
    const manager = document.getElementById('LokasiManager').value.trim();
    const latitude = document.getElementById('LokasiLatitude').value;
    const longitude = document.getElementById('LokasiLongitude').value;
    
    // Reset all error states
    clearValidationErrors();
    
    let hasError = false;
    
    // Validate nama tempat
    if (!name) {
        showValidationError('LokasiName', 'errorLokasiName');
        hasError = true;
    }
    
    // Validate kode tempat
    if (!code) {
        showValidationError('LokasiCode', 'errorLokasiCode');
        hasError = true;
    }
    
    // Validate alamat
    if (!address) {
        showValidationError('LokasiAddress', 'errorLokasiAddress');
        hasError = true;
    }
    
    // If there are validation errors, stop here
    if (hasError) {
        return;
    }

    const url = isEditMode 
        ? '{{ route("settings.locations.update", ":id") }}'.replace(':id', id)
        : '{{ route("settings.locations.store") }}';
    
    const method = isEditMode ? 'PUT' : 'POST';

    const data = {
        name: name,
        code: code,
        address: address,
        phone: phone || null,
        manager_name: manager || null,
        latitude: latitude || null,
        longitude: longitude || null
    };

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Something went wrong'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menyimpan data. Silakan coba lagi.');
    });
}

// Show validation error
function showValidationError(fieldId, errorId) {
    const field = document.getElementById(fieldId);
    const error = document.getElementById(errorId);
    
    if (field) {
        field.classList.add('error');
        // Remove error class when user starts typing
        field.addEventListener('input', function() {
            field.classList.remove('error');
            if (error) {
                error.classList.remove('show');
            }
        }, { once: true });
    }
    
    if (error) {
        error.classList.add('show');
    }
}

// Clear all validation errors
function clearValidationErrors() {
    // Remove error class from all inputs
    document.querySelectorAll('.form-control.error').forEach(function(el) {
        el.classList.remove('error');
    });
    
    // Hide all error messages
    document.querySelectorAll('.error-message.show').forEach(function(el) {
        el.classList.remove('show');
    });
}

function confirmDelete(id, name) {
    if (confirm('Apakah Anda yakin ingin menghapus "' + name + '"?')) {
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
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus data. Silakan coba lagi.');
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
