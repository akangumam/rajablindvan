# Fitur Harga Referensi Jenis Servis

## Deskripsi

Fitur ini menambahkan kemampuan untuk memasukkan harga referensi pada setiap jenis servis di pengaturan. Ketika memilih jenis servis saat membuat atau mengedit maintenance, harga referensi akan otomatis muncul sebagai nilai awal yang dapat diedit.

## Perubahan yang Dilakukan

### 1. Database Migration

**File:** `database/migrations/2025_12_29_000001_add_price_to_service_types_table.php`

-   Menambahkan kolom `price` (decimal 15,2, nullable) ke tabel `service_types`

### 2. Model ServiceType

**File:** `app/Models/ServiceType.php`

-   Menambahkan field `price` ke dalam `$fillable` array

### 3. Controller SettingsController

**File:** `app/Http/Controllers/SettingsController.php`

-   Update method `storeServiceType()` untuk validasi dan simpan harga
-   Update method `updateServiceType()` untuk validasi dan update harga
-   Validasi: harga harus numeric dan tidak boleh negatif

### 4. View Settings - Service Types

**File:** `resources/views/settings/service-types.blade.php`

-   Menambahkan input field "Harga Referensi (Rp)" di modal form
-   Menampilkan harga referensi di daftar service types (warna hijau)
-   Update JavaScript untuk handle field price saat add/edit
-   Menambahkan CSS untuk styling `.service-price`

### 5. View Maintenance - Create

**File:** `resources/views/maintenances/create.blade.php`

-   Load harga referensi dari database ke `availableServices` array dengan property `refPrice`
-   Update `renderServiceList()` untuk menampilkan label "(Ref: Rp XXX)" di sebelah nama service
-   Update `toggleServicePrice()` untuk auto-fill input harga dengan harga referensi saat checkbox dicentang
-   Harga tetap editable setelah auto-fill

### 6. View Maintenance - Edit

**File:** `resources/views/maintenances/edit.blade.php`

-   Load harga referensi dari database ke `availableServices` array dengan property `refPrice`
-   Update `renderServiceList()` untuk menampilkan label "(Ref: Rp XXX)"
-   Update `toggleServicePrice()` untuk auto-fill input harga dengan harga referensi
-   Harga tetap editable setelah auto-fill

## Cara Penggunaan

### Setting Harga Referensi

1. Masuk ke menu **Pengaturan > Service Types**
2. Klik "TAMBAH BARU SERVICE" atau edit service yang sudah ada
3. Isi field "Harga Referensi (Rp)" dengan harga yang diinginkan (opsional)
4. Simpan

### Menggunakan Harga Referensi saat Maintenance

1. Saat membuat maintenance baru atau edit maintenance
2. Klik "Pilih Jenis Servis"
3. Centang checkbox jenis servis yang diinginkan
4. Jika ada harga referensi, otomatis akan terisi di input field
5. User dapat mengedit harga sesuai kebutuhan aktual
6. Tampil label "(Ref: Rp XXX)" di samping nama service untuk info

## Fitur Utama

-   ✅ Input harga referensi di settings jenis servis
-   ✅ Display harga referensi di list jenis servis (warna hijau)
-   ✅ Auto-fill harga saat pilih jenis servis (editable)
-   ✅ Label harga referensi sebagai panduan
-   ✅ Validasi: harga harus numeric dan tidak negatif
-   ✅ Harga bersifat opsional (nullable)

## Status

✅ Sudah diimplementasi dan migration telah dijalankan
✅ Tidak ada error compile/lint
✅ Siap untuk testing

## Testing Checklist

-   [ ] Tambah jenis servis baru dengan harga di settings
-   [ ] Edit jenis servis dan ubah harganya
-   [ ] Buat maintenance baru dan pilih jenis servis dengan harga
-   [ ] Verifikasi harga auto-fill dan bisa diedit
-   [ ] Edit maintenance dan verifikasi harga referensi muncul
-   [ ] Test dengan jenis servis tanpa harga (harus tetap berfungsi)
