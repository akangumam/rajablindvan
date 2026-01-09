# Update Dashboard API - Monitoring Alerts

## 🎯 Perubahan yang Dibuat

### Backend API (Laravel)

File: `app/Http/Controllers/Api/DashboardController.php`

**Menambahkan 3 data monitoring alerts:**

-   `stnk_overdue` - Jumlah kendaraan dengan STNK expired
-   `kir_overdue` - Jumlah kendaraan dengan KIR expired
-   `gps_overdue` - Jumlah kendaraan dengan GPS expired

### Response API Baru

```json
{
  "success": true,
  "data": {
    "vehicles": {...},
    "rentals": {...},
    "financial": {...},
    "alerts": {
      "upcoming_maintenance": 5,
      "overdue_rentals": 2,
      "stnk_overdue": 3,
      "kir_overdue": 2,
      "gps_overdue": 1
    },
    ...
  }
}
```

## 📦 Deploy ke Production

### Cara Deploy:

```bash
cd vehicle-dashboard

# Upload file yang diubah ke hosting
# File: app/Http/Controllers/Api/DashboardController.php

# Atau jika pakai git:
git add app/Http/Controllers/Api/DashboardController.php
git commit -m "Add monitoring alerts (STNK, KIR, GPS) to dashboard API"
git push

# Di server hosting:
php artisan config:clear
php artisan cache:clear
```

## 📱 Mobile App Changes

### Model Updated:

-   `lib/models/dashboard_stats.dart` - Added stnkOverdue, kirOverdue, gpsOverdue

### UI Updated:

-   `lib/screens/dashboard/dashboard_screen.dart` - Added Monitoring Alerts section

### Tampilan Baru:

Dashboard mobile sekarang menampilkan:

```
┌──────────────────────────────┐
│  Monitoring Alerts           │
├──────────────────────────────┤
│  📄 STNK Overdue    [3] →    │
│  📋 KIR Overdue     [2] →    │
│  📍 GPS Overdue     [1] →    │
└──────────────────────────────┘
```

## ✅ Testing

Setelah deploy backend, test dengan:

1. Buka mobile app
2. Pull to refresh di dashboard
3. Lihat section "Monitoring Alerts"
4. Pastikan angka sesuai dengan data di web dashboard

## 🔧 Troubleshooting

Jika data tidak muncul:

1. Cek API response: `https://rajafleet.khaerulumam.id/api/v1/dashboard`
2. Pastikan backend sudah di-deploy
3. Clear cache: `php artisan cache:clear`
4. Hot reload mobile app dengan tombol `r`
