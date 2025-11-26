# Map Picker Implementation - Fitur Pin Lokasi

## 📍 Overview

Fitur **Map Picker** telah ditambahkan pada menu **Settings > Tempat** untuk memudahkan pengguna dalam menentukan koordinat lokasi dengan tepat menggunakan peta interaktif.

## ✨ Fitur

### 1. **Interactive Map Picker**
- Menggunakan **Leaflet.js** dengan **OpenStreetMap** tiles (gratis, tidak perlu API key)
- Peta interaktif dengan kemampuan zoom dan pan
- Klik pada peta untuk menempatkan marker/pin
- Marker dapat dipindahkan dengan klik di lokasi baru

### 2. **Real-time Coordinate Display**
- Menampilkan koordinat Latitude dan Longitude secara real-time
- Koordinat ditampilkan dengan presisi 8 angka desimal
- Update otomatis saat marker dipindahkan

### 3. **Form Fields Lengkap**
- **Nama Tempat** (wajib)
- **Kode Tempat** (wajib) - contoh: JKT, BDG
- **Alamat** (wajib)
- **Telepon** (opsional)
- **Nama Manager** (opsional)
- **Koordinat** (otomatis dari map picker)

## 🎯 Cara Penggunaan

### Menambah Lokasi Baru

1. Buka menu **Pengaturan** → **Tempat**
2. Klik tombol **"+ TAMBAH TEMPAT BARU"**
3. Modal akan terbuka dengan form dan peta
4. Isi data-data yang diperlukan:
   - Nama Tempat (wajib)
   - Kode Tempat (wajib)
   - Alamat (wajib)
   - Telepon (opsional)
   - Nama Manager (opsional)
5. **Pin Lokasi pada Peta:**
   - Scroll/zoom peta ke lokasi yang diinginkan
   - Klik pada peta untuk menempatkan marker
   - Marker biru akan muncul di lokasi yang diklik
   - Koordinat otomatis terisi dan ditampilkan
6. Klik tombol **"SIMPAN"**

### Mengedit Lokasi

1. Pada list tempat, klik tombol **Edit** (icon pensil biru)
2. Modal edit akan terbuka dengan data existing
3. Peta akan menampilkan marker di koordinat yang tersimpan
4. Anda bisa mengubah semua field termasuk memindahkan marker
5. Klik **"SIMPAN"** untuk menyimpan perubahan

## 🔧 Technical Implementation

### Frontend Components

#### 1. **Leaflet.js Integration**
```html
<!-- CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
```

#### 2. **Map Container**
```html
<div id="map"></div>
```

#### 3. **JavaScript Functions**

**initMap(lat, lng)** - Inisialisasi peta dengan koordinat
- Default: Jakarta (-6.2088, 106.8456)
- Zoom level: 13
- Tile provider: OpenStreetMap

**placeMarker(latlng)** - Menempatkan marker di peta
- Remove marker lama jika ada
- Tambah marker baru
- Update koordinat di form

**openAddModal()** - Buka modal tambah tempat
- Reset semua field
- Init map dengan koordinat default Jakarta

**openEditModal(location)** - Buka modal edit tempat
- Populate semua field dengan data existing
- Init map dengan koordinat tersimpan (atau default jika tidak ada)

### Backend API

#### Endpoint: `POST /settings/locations`
**Request Body:**
```json
{
  "name": "Jakarta Office",
  "code": "JKT",
  "address": "Jl. Sudirman No. 123, Jakarta",
  "phone": "021-12345678",
  "manager_name": "John Doe",
  "latitude": -6.2088,
  "longitude": 106.8456
}
```

#### Endpoint: `PUT /settings/locations/{id}`
**Request Body:** Same as POST

#### Endpoint: `DELETE /settings/locations/{id}`
**Response:**
```json
{
  "success": true,
  "message": "Place deleted successfully"
}
```

### Database Schema

```php
Schema::table('locations', function (Blueprint $table) {
    $table->text('address')->nullable()->after('name');
    $table->decimal('latitude', 10, 8)->nullable()->after('address');
    $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
});
```

**Fields:**
- `latitude`: Decimal(10,8) - Range: -90 to 90
- `longitude`: Decimal(11,8) - Range: -180 to 180

### Model Updates

File: `app/Models/Location.php`

```php
protected $fillable = [
    'name',
    'code',
    'address',
    'phone',
    'manager_name',
    'is_active',
    'latitude',
    'longitude',
    'google_place_id'
];
```

### Controller Updates

File: `app/Http/Controllers/SettingsController.php`

**Validation Rules:**
```php
[
    'name' => 'required|string|max:255|unique:locations,name',
    'code' => 'required|string|max:10|unique:locations,code',
    'address' => 'required|string',
    'phone' => 'nullable|string|max:20',
    'manager_name' => 'nullable|string|max:255',
    'latitude' => 'nullable|numeric|between:-90,90',
    'longitude' => 'nullable|numeric|between:-180,180',
]
```

## 📊 Features Summary

| Feature | Status | Description |
|---------|--------|-------------|
| Interactive Map | ✅ | Leaflet.js with OpenStreetMap |
| Click to Pin | ✅ | Single click to place marker |
| Coordinate Display | ✅ | Real-time lat/lng display |
| Form Validation | ✅ | Required fields validation |
| Edit Mode | ✅ | Load existing coordinates |
| Mobile Friendly | ✅ | Responsive design |
| No API Key Required | ✅ | Uses free OpenStreetMap |

## 🎨 UI/UX Improvements

1. **Visual Feedback**
   - Info box dengan instruksi penggunaan
   - Coordinate display boxes dengan styling modern
   - Map dengan border dan border-radius

2. **User Experience**
   - Map auto-resize saat modal dibuka
   - Default location: Jakarta (dapat disesuaikan)
   - Smooth transitions dan animations

3. **Responsive Design**
   - Modal width: 700px (dari 500px)
   - Map height: 400px
   - Grid layout untuk coordinate display

## 🔐 Permissions

- Hanya user dengan role **super_admin** dan **manager** yang bisa manage locations
- Terproteksi dengan middleware authentication

## 🚀 Future Enhancements

Potensial improvements yang bisa ditambahkan:

1. **Search Location** - Geocoding untuk search alamat
2. **Google Maps Integration** - Opsi untuk gunakan Google Maps
3. **GPS Current Location** - Get user's current location
4. **Multiple Markers** - Support untuk multiple locations
5. **Export Coordinates** - Export ke CSV/Excel
6. **Reverse Geocoding** - Auto-fill address dari koordinat

## 📝 Notes

- Migration file: `2025_11_26_095905_add_address_and_coordinates_to_locations_table.php`
- View file: `resources/views/settings/locations.blade.php`
- Controller: `app/Http/Controllers/SettingsController.php`
- Model: `app/Models/Location.php`

## ✅ Testing Checklist

- [x] Modal opens successfully
- [x] Map loads correctly
- [x] Click to place marker works
- [x] Coordinates update in real-time
- [x] Form validation works
- [x] Save functionality works
- [x] Edit mode loads existing coordinates
- [x] Delete functionality works
- [x] Responsive on mobile devices

---

**Implementation Date:** 26 November 2025
**Developer:** Antigravity AI Assistant
**Status:** ✅ Completed and Tested
