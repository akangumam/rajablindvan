# Monitoring Alerts Feature - Deployment Guide

## 🎯 Fitur Yang Dibuat

Monitoring alerts dengan detail screen untuk menampilkan kendaraan yang overdue pada:

-   **STNK** (Surat Tanda Nomor Kendaraan)
-   **KIR** (Keur Inspeksi Roda)
-   **GPS** (GPS Tracker)

## 📂 File Backend Yang Diubah/Dibuat

### 1. DashboardController.php (UPDATE)

**Path:** `app/Http/Controllers/Api/DashboardController.php`

**Perubahan:** Menambahkan 3 field baru di array alerts:

```php
'alerts' => [
    'upcoming_maintenance' => $maintenanceDue,
    'overdue_rentals' => $overdueRentals,
    'stnk_overdue' => $stnkOverdue,    // NEW
    'kir_overdue' => $kirOverdue,       // NEW
    'gps_overdue' => $gpsOverdue,       // NEW
],
```

### 2. MonitoringController.php (NEW)

**Path:** `app/Http/Controllers/Api/MonitoringController.php`

**3 endpoint baru:**

-   `stnkOverdue()` - List kendaraan dengan STNK expired
-   `kirOverdue()` - List kendaraan dengan KIR expired
-   `gpsOverdue()` - List kendaraan dengan GPS expired

### 3. routes/api.php (UPDATE)

**Path:** `routes/api.php`

**Tambahan routes:**

```php
use App\Http\Controllers\Api\MonitoringController;

// Di dalam middleware auth:sanctum
Route::prefix('monitoring')->group(function () {
    Route::get('/stnk-overdue', [MonitoringController::class, 'stnkOverdue']);
    Route::get('/kir-overdue', [MonitoringController::class, 'kirOverdue']);
    Route::get('/gps-overdue', [MonitoringController::class, 'gpsOverdue']);
});
```

## 📦 Cara Deploy Backend

### Opsi 1: Manual Upload (FTP/cPanel)

```
1. Upload file berikut ke server:
   - app/Http/Controllers/Api/DashboardController.php
   - app/Http/Controllers/Api/MonitoringController.php (NEW FILE)
   - routes/api.php

2. Login SSH dan jalankan:
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
```

### Opsi 2: Via Git

```bash
cd vehicle-dashboard

# Add files
git add app/Http/Controllers/Api/DashboardController.php
git add app/Http/Controllers/Api/MonitoringController.php
git add routes/api.php

# Commit
git commit -m "Add monitoring alerts with detail screens (STNK, KIR, GPS)"

# Push
git push origin main

# Di server hosting (SSH):
cd public_html
git pull origin main
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 🧪 Test Backend API

Setelah deploy, test endpoint dengan curl:

```bash
# 1. Test Dashboard (harus ada stnk_overdue, kir_overdue, gps_overdue)
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://rajafleet.khaerulumam.id/api/v1/dashboard

# 2. Test STNK Overdue List
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://rajafleet.khaerulumam.id/api/v1/monitoring/stnk-overdue

# 3. Test KIR Overdue List
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://rajafleet.khaerulumam.id/api/v1/monitoring/kir-overdue

# 4. Test GPS Overdue List
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://rajafleet.khaerulumam.id/api/v1/monitoring/gps-overdue
```

**Expected Response (Detail Endpoint):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "license_plate": "B 1234 XYZ",
            "brand": "Toyota",
            "model": "Avanza",
            "year": 2020,
            "status": "available",
            "location_name": "Jakarta",
            "stnk_expiry_date": "2024-11-24",
            "days_overdue": 47
        }
    ]
}
```

## 📱 Mobile App Changes

### Files Baru:

1. `lib/models/monitoring_vehicle.dart` - Model kendaraan monitoring
2. `lib/services/monitoring_service.dart` - Service API monitoring
3. `lib/screens/monitoring/monitoring_detail_screen.dart` - UI detail screen

### Files Updated:

1. `lib/main.dart` - Routes untuk 3 monitoring screens
2. `lib/models/dashboard_stats.dart` - Fields stnkOverdue, kirOverdue, gpsOverdue
3. `lib/screens/dashboard/dashboard_screen.dart` - Section Monitoring Alerts + navigation

### User Flow:

```
Dashboard
    ↓ (tap alert)
Monitoring Detail Screen
    ↓ (tap vehicle card)
Vehicle Detail Screen
```

### Features:

-   ✅ Color-coded alerts (Red=STNK, Orange=KIR, Purple=GPS)
-   ✅ Badge "URGENT" untuk overdue > 30 hari
-   ✅ Days overdue display
-   ✅ Pull to refresh
-   ✅ Empty state handling
-   ✅ Navigation ke vehicle detail

## 🧪 Test Mobile App

**Setelah backend deploy:**

1. **Hot Reload Mobile App**

    ```bash
    # Di terminal yang menjalankan flutter
    Tekan: r
    ```

2. **Test Dashboard:**

    - Buka dashboard
    - Pull to refresh
    - Lihat section "Monitoring Alerts"
    - Pastikan angka muncul (jika ada data overdue)

3. **Test Navigation:**

    - Tap "STNK Overdue" → List kendaraan STNK overdue
    - Tap "KIR Overdue" → List kendaraan KIR overdue
    - Tap "GPS Overdue" → List kendaraan GPS overdue

4. **Test Detail Screen:**
    - Lihat list kendaraan overdue
    - Badge "URGENT" muncul jika > 30 hari
    - Pull to refresh works
    - Tap vehicle card → Masuk ke detail kendaraan

## 🔧 Troubleshooting

### Problem: Data masih 0 di monitoring alerts

**Solusi 1: Cek Backend**

```bash
# Test API dashboard
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://rajafleet.khaerulumam.id/api/v1/dashboard \
  | jq '.data.alerts'

# Harus return: stnk_overdue, kir_overdue, gps_overdue
```

**Solusi 2: Cek Database**

```sql
-- Login ke database SQLite
SELECT COUNT(*) as stnk_overdue
FROM vehicles
WHERE stnk_expiry_date < DATE('now');

SELECT COUNT(*) as kir_overdue
FROM vehicles
WHERE kir_expiry_date < DATE('now');

SELECT COUNT(*) as gps_overdue
FROM vehicles
WHERE gps_expiry_date < DATE('now');
```

**Solusi 3: Clear Cache Backend**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

**Solusi 4: Restart Mobile App**

```bash
# Full restart (bukan hot reload)
Tekan: R (capital R)
```

### Problem: Error 404 saat buka detail screen

**Cek routes sudah deploy:**

```bash
# Di server
php artisan route:list | grep monitoring

# Harus muncul:
# GET|HEAD  api/v1/monitoring/stnk-overdue
# GET|HEAD  api/v1/monitoring/kir-overdue
# GET|HEAD  api/v1/monitoring/gps-overdue
```

### Problem: Navigation tidak berfungsi

**Cek routes di mobile app:**

```dart
// lib/main.dart harus ada:
case '/monitoring-stnk':
case '/monitoring-kir':
case '/monitoring-gps':
```

Restart app dengan `R` (full restart).

## 📊 API Response Format

### Dashboard API

```json
{
    "success": true,
    "data": {
        "alerts": {
            "stnk_overdue": 3,
            "kir_overdue": 2,
            "gps_overdue": 1
        }
    }
}
```

### Monitoring Detail API

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "license_plate": "B 1234 XYZ",
            "brand": "Toyota",
            "model": "Avanza",
            "year": 2020,
            "status": "available",
            "location_name": "Jakarta",
            "stnk_expiry_date": "2024-11-24",
            "days_overdue": 47
        }
    ]
}
```

## ✅ Checklist Deployment

-   [ ] Upload `DashboardController.php` ke server
-   [ ] Upload `MonitoringController.php` (NEW) ke server
-   [ ] Upload `routes/api.php` ke server
-   [ ] Run `php artisan route:clear` di server
-   [ ] Run `php artisan cache:clear` di server
-   [ ] Test API dashboard dengan curl
-   [ ] Test API monitoring/stnk-overdue dengan curl
-   [ ] Hot reload mobile app dengan `r`
-   [ ] Test tap monitoring alerts di dashboard
-   [ ] Test detail screen menampilkan list
-   [ ] Test tap vehicle card masuk ke detail

## 📞 Support

Jika ada masalah deployment, cek:

1. Log Laravel: `storage/logs/laravel.log`
2. Error mobile: Terminal yang running flutter
3. API response: Gunakan curl untuk test manual
