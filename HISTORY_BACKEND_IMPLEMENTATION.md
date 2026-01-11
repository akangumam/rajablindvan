# History Feature - Backend Implementation Guide

## 📋 Overview

Fitur History telah diimplementasikan di backend untuk mencatat secara otomatis semua transaksi kendaraan (BBM, servis, expense, dll) ke dalam satu tabel history_records yang bisa diakses oleh mobile app.

## 🗂️ Files Created

### 1. Database Migration

```
database/migrations/2026_01_11_000001_create_history_records_table.php
```

### 2. Model

```
app/Models/HistoryRecord.php
```

### 3. API Controller

```
app/Http/Controllers/Api/HistoryController.php
```

### 4. Observers (Auto-recording)

```
app/Observers/FuelFillObserver.php
app/Observers/MaintenanceObserver.php
app/Observers/ExpenseObserver.php
```

### 5. Command for Migration

```
app/Console/Commands/MigrateHistoryData.php
```

### 6. Updated Files

-   `routes/api.php` - Added history API endpoints
-   `app/Providers/AppServiceProvider.php` - Registered observers

## 🚀 Deployment Steps

### Step 1: Run Migration

```bash
cd vehicle-dashboard
php artisan migrate
```

Ini akan membuat tabel `history_records` dengan struktur:

-   id
-   vehicle_id (foreign key)
-   type (refueling, oil_change, service, registration, dll)
-   title
-   description
-   location
-   cost
-   odometer
-   date
-   extra_data (JSON)
-   related_id (ID dari tabel asli)
-   related_type (Model asli)
-   timestamps

### Step 2: Migrate Existing Data

Migrate semua data transaksi yang sudah ada ke history_records:

```bash
php artisan history:migrate
```

Atau jika ingin clear dulu baru migrate:

```bash
php artisan history:migrate --fresh
```

Command ini akan:

-   ✅ Migrate semua FuelFill records → history (type: refueling)
-   ✅ Migrate semua Maintenance records → history (type: service/oil_change)
-   ✅ Migrate semua Expense records → history (type: registration/labor_cost/other)

### Step 3: Test API Endpoints

#### 1. Get History Records

```bash
GET /api/v1/history
GET /api/v1/history?vehicle_id=1
GET /api/v1/history?type=refueling
GET /api/v1/history?start_date=2025-01-01&end_date=2025-12-31
GET /api/v1/history?page=2&per_page=20
```

#### 2. Get Statistics

```bash
GET /api/v1/history/stats
GET /api/v1/history/stats?vehicle_id=1
```

#### 3. Get Next Refueling Prediction

```bash
GET /api/v1/vehicles/1/next-refueling
```

## 🔄 How Auto-Recording Works

Setelah deploy, **semua transaksi baru akan otomatis tercatat** ke history_records:

### 1. FuelFill (Pengisian BBM)

Ketika user membuat/update/delete fuel fill:

```php
FuelFill::create([...]) // ← Observer auto-create HistoryRecord
```

### 2. Maintenance (Servis)

```php
Maintenance::create([...]) // ← Observer auto-create HistoryRecord
```

### 3. Expense (Pengeluaran)

```php
Expense::create([...]) // ← Observer auto-create HistoryRecord
```

## 📱 Mobile App Integration

Mobile app sudah siap dan akan otomatis fetch data dari:

-   `GET /api/v1/history` → Tampil di History timeline
-   Filter berdasarkan kendaraan dan jenis transaksi
-   Pagination support
-   Next refueling prediction

## 🧪 Testing Checklist

### Backend Testing

-   [ ] Migration berhasil: `php artisan migrate`
-   [ ] Data existing berhasil dimigrate: `php artisan history:migrate`
-   [ ] API endpoint history bisa diakses
-   [ ] Create FuelFill baru → check history_records bertambah
-   [ ] Create Maintenance baru → check history_records bertambah
-   [ ] Create Expense baru → check history_records bertambah
-   [ ] Update transaksi → check history_records ikut update
-   [ ] Delete transaksi → check history_records ikut terhapus
-   [ ] Filter by vehicle_id works
-   [ ] Filter by type works
-   [ ] Pagination works
-   [ ] Stats endpoint returns correct data
-   [ ] Next refueling prediction works (minimal 2 data BBM)

### Mobile Testing

-   [ ] Login mobile app
-   [ ] Buka tab History
-   [ ] Data history muncul
-   [ ] Pull to refresh works
-   [ ] Scroll pagination works
-   [ ] Filter by vehicle works
-   [ ] Filter by type works
-   [ ] Next refueling prediction card muncul (jika ada data)

## 🗺️ History Types Mapping

| Transaction Type    | History Type            | Display Name          |
| ------------------- | ----------------------- | --------------------- |
| FuelFill            | `refueling`             | Pengisian BBM         |
| Maintenance (Oli)   | `oil_change`            | Ganti Oli             |
| Maintenance (Other) | `service`               | Servis                |
| Expense (STNK)      | `registration`          | Perpanjangan STNK     |
| Expense (Labor)     | `labor_cost`            | Biaya Tenaga Kerja    |
| Expense (Transport) | `transport_application` | Aplikasi Transportasi |
| Expense (Other)     | `other`                 | Lainnya               |

## 🔧 Troubleshooting

### Issue: Migration error

**Solution**: Check database connection dan pastikan tidak ada table conflict

### Issue: Observer tidak jalan

**Solution**:

```bash
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

### Issue: Data tidak muncul di mobile

**Solution**:

-   Check API endpoint dengan Postman/curl
-   Verify Bearer token valid
-   Check user location_id filter

### Issue: History tidak auto-create

**Solution**:

-   Verify observers registered di AppServiceProvider
-   Check related_id dan related_type tersimpan
-   Check vehicle_id tidak null

## 📊 Database Indexes

Tabel history_records memiliki indexes untuk performa:

-   `vehicle_id` - Filter per kendaraan
-   `type` - Filter per jenis transaksi
-   `date` - Sorting chronological
-   `related_id, related_type` - Polymorphic relation

## 🎯 Next Steps

1. **Deploy migration**

    ```bash
    php artisan migrate
    ```

2. **Migrate existing data**

    ```bash
    php artisan history:migrate
    ```

3. **Test API dengan Postman**

    - Test semua endpoints
    - Verify response format

4. **Test create new transaction**

    - Buat fuel fill baru dari dashboard
    - Check history_records table
    - Verify muncul di API

5. **Test mobile app**
    - Login
    - Check History tab
    - Create new transaction dari dashboard
    - Refresh History di mobile

## 📝 Notes

-   Semua transaksi OTOMATIS tercatat, tidak perlu manual input
-   History bersifat read-only dari mobile (no add/edit/delete button)
-   Update/delete transaksi dari dashboard akan sync ke history
-   Location filter applied based on user role (admin vs driver)
-   Cost field bisa negative untuk income transactions

## ✅ Success Indicators

Fitur berhasil jika:

-   ✅ Tabel history_records exists
-   ✅ Data existing ter-migrate
-   ✅ Create transaksi baru auto-record ke history
-   ✅ API endpoint return data dengan benar
-   ✅ Mobile app History tab menampilkan data
-   ✅ Filter dan pagination berfungsi
-   ✅ Next refueling prediction muncul

---

**Ready untuk Production!** 🚀

Dokumentasi lengkap ada di:

-   `rajafleet_mobile/HISTORY_API_REQUIREMENTS.md`
-   `rajafleet_mobile/HISTORY_FEATURE_DOCUMENTATION.md`
