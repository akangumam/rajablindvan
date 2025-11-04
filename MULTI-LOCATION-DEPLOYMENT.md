# MULTI-LOCATION FEATURE DEPLOYMENT GUIDE

## Overview

Fitur Multi-Location memungkinkan pengelolaan 2 kantor (Jakarta dan Malang) dengan:

-   **Investor**: Bisa punya mobil di Jakarta dan Malang
-   **Customer**: Bisa sewa dari kedua lokasi
-   **Staff**: Fixed ke satu lokasi
-   **Super Admin**: Bisa lihat dan switch antara lokasi
-   **Harga**: Sementara sama untuk kedua lokasi

## Files Changed

### 1. Controllers

-   `app/Http/Controllers/VehicleController.php` - Location filtering & selector
-   `app/Http/Controllers/ExpenseController.php` - Location filtering
-   `app/Http/Controllers/DashboardController.php` - Location statistics

### 2. Middleware

-   `app/Http/Middleware/LocationFilter.php` - NEW! Handle location filtering logic

### 3. Routes

-   `routes/web.php` - Added LocationFilter middleware

### 4. Views

-   `resources/views/layouts/drivvo.blade.php` - Location selector in navbar

### 5. Models (Already Exist)

-   `app/Models/Location.php` - Already has relationships
-   `app/Models/User.php` - Already has location relationship
-   `app/Models/Vehicle.php` - Already has location relationship
-   `app/Models/Expense.php` - Already has location relationship

## Deployment Steps

### STEP 1: Pull Latest Code

```bash
cd ~/rajafleet.khaerulumam.id
git pull origin master
```

### STEP 2: Clear All Caches

```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

### STEP 3: Check Database

Karena migrations sudah pernah dijalankan sebelumnya, cek dulu:

```bash
php artisan migrate:status
```

Jika ada yang pending, jalankan:

```bash
php artisan migrate
```

### STEP 4: Verify Location Data

```bash
php artisan tinker
>>> App\Models\Location::all();
>>> exit
```

Harusnya ada 2 lokasi:

-   Jakarta (code: JKT)
-   Malang (code: MLG)

Jika belum ada, jalankan seeder:

```bash
php artisan db:seed --class=LocationSeeder
```

### STEP 5: Test Features

1. **Login sebagai Super Admin**

    - Cek apakah ada dropdown lokasi di navbar (sebelah kanan)
    - Dropdown harus ada: "Semua Lokasi", "Jakarta", "Malang"
    - Try switch lokasi, data harus berubah

2. **Login sebagai Staff**

    - Tidak ada dropdown lokasi
    - Ada badge lokasi (fixed) di navbar
    - Hanya bisa lihat data sesuai lokasi mereka

3. **Test Menu Vehicles**

    - Data terfilter sesuai lokasi yang dipilih
    - Saat create vehicle baru, ada field "Lokasi"

4. **Test Menu Expenses**

    - Data terfilter sesuai lokasi
    - Lokasi otomatis diambil dari vehicle

5. **Test Dashboard**
    - Super admin lihat statistik per lokasi
    - Staff hanya lihat statistik lokasi mereka

## Features Implemented

### ✅ Location Selector (Navbar)

-   **Super Admin**: Dropdown untuk switch lokasi
    -   "Semua Lokasi" - lihat semua data
    -   "Jakarta" - filter data Jakarta
    -   "Malang" - filter data Malang
-   **Staff**: Badge menunjukkan lokasi mereka (fixed)

### ✅ Vehicle Management

-   Filter vehicles by location
-   Location selector saat create vehicle
-   Location badge di vehicle list (coming next)

### ✅ Expense Management

-   Filter expenses by location
-   Auto-assign location dari vehicle yang dipilih

### ✅ Dashboard

-   Location statistics (untuk super admin)
-   Booked/Available per lokasi
-   STNK/KIR monitoring includes location

### ✅ Middleware LocationFilter

-   Automatically filters queries based on user role
-   Super admin can switch location
-   Staff automatically filtered to their location

## Next Steps (Optional Enhancements)

### 1. Add Location Badges

Update views untuk menampilkan badge lokasi:

```blade
@if($vehicle->location)
    <span class="badge bg-info">
        <i class="fas fa-map-marker-alt"></i> {{ $vehicle->location->name }}
    </span>
@endif
```

### 2. Update Seeders

Assign existing data ke lokasi:

```php
// VehicleSeeder
Vehicle::where('id', '<=', 10)->update(['location_id' => 1]); // Jakarta
Vehicle::where('id', '>', 10)->update(['location_id' => 2]); // Malang
```

### 3. Location Reports

Tambahkan report comparison antar lokasi (jika diperlukan nanti)

### 4. User Management

Saat create user baru, tambahkan dropdown lokasi (untuk non-super admin)

## Troubleshooting

### Issue: Dropdown lokasi tidak muncul

**Solution**:

-   Clear browser cache (Ctrl+Shift+R)
-   Check apakah user adalah super_admin: `Auth::user()->isSuperAdmin()`
-   Check di database: `SELECT role FROM users WHERE id = ?`

### Issue: Data tidak terfilter

**Solution**:

-   Check LocationFilter middleware registered di `routes/web.php`
-   Check session: `session('selected_location_id')`
-   Check controller menggunakan: `LocationFilter::getLocationId()`

### Issue: Error saat create vehicle/expense

**Solution**:

-   Pastikan location_id column ada di table
-   Pastikan location_id required di validation
-   Check migration: `php artisan migrate:status`

### Issue: Location data tidak ada

**Solution**:

```bash
php artisan db:seed --class=LocationSeeder
```

## Testing Checklist

-   [ ] Super admin bisa lihat dropdown lokasi
-   [ ] Super admin bisa switch lokasi
-   [ ] Staff tidak lihat dropdown, tapi lihat badge lokasi
-   [ ] Dashboard menampilkan data sesuai lokasi
-   [ ] Vehicle list terfilter by lokasi
-   [ ] Expense list terfilter by lokasi
-   [ ] Create vehicle memiliki field lokasi
-   [ ] Create expense otomatis ambil lokasi dari vehicle
-   [ ] Orders/Rentals bisa cross-location (customer bisa sewa dari Jakarta & Malang)

## Git Commit

```
feat: Add multi-location management system for Jakarta and Malang offices

- Add LocationFilter middleware for location-based filtering
- Update VehicleController: add location filter and location selector
- Update ExpenseController: add location filter and auto-assign location from vehicle
- Update DashboardController: add location statistics and filtering
- Add location selector in navbar (super admin can switch, staff see their location)
- Location model already exists with proper relationships
- Investors can own vehicles in both locations
- Customers can rent from both locations
- Staff are fixed to one location
- Pricing unified across locations

Commit: 8544448
```

## Support

Jika ada issue, check:

1. Log Laravel: `storage/logs/laravel.log`
2. Browser console untuk JavaScript errors
3. Network tab di DevTools untuk AJAX requests
4. Database langsung untuk verify data
