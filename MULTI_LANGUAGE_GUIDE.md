# Multi-Language Feature Documentation

## Overview

Aplikasi Radja Blind Van sekarang mendukung **2 bahasa**:

-   🇮🇩 **Bahasa Indonesia** (default)
-   🇬🇧 **English**

Semua teks di aplikasi akan otomatis berubah sesuai bahasa yang dipilih.

---

## Cara Menggunakan

### 1. Switch Bahasa

Di sidebar kiri bawah, Anda akan melihat tombol switch bahasa:

```
🇮🇩 ID | 🇬🇧 EN
```

Klik salah satu untuk mengganti bahasa. Halaman akan refresh dan semua teks akan berubah.

### 2. Bahasa Default

Bahasa default adalah **Bahasa Indonesia**. Jika pengguna belum memilih bahasa, aplikasi akan menggunakan Bahasa Indonesia.

---

## Untuk Developer

### Struktur File Translation

```
resources/lang/
├── id/                 # Bahasa Indonesia
│   ├── common.php      # Teks umum (tombol, menu, dll)
│   ├── vehicle.php     # Teks khusus kendaraan
│   └── quick_add.php   # Teks untuk quick add modal
└── en/                 # English
    ├── common.php
    ├── vehicle.php
    └── quick_add.php
```

### Cara Menggunakan Translation di Blade

#### 1. Sintaks Dasar

```blade
{{ __('common.dashboard') }}
{{ __('vehicle.add_vehicle') }}
{{ __('quick_add.fuel_fill') }}
```

#### 2. Dengan Parameter

```blade
{{ __('messages.welcome', ['name' => $user->name]) }}
```

Di file translation:

```php
'welcome' => 'Selamat datang, :name',
```

#### 3. Pluralization

```blade
{{ trans_choice('messages.vehicles', $count) }}
```

Di file translation:

```php
'vehicles' => '{0} Tidak ada kendaraan|{1} 1 kendaraan|[2,*] :count kendaraan',
```

### Menambah File Translation Baru

1. Buat file di `resources/lang/id/` dan `resources/lang/en/`

Contoh: `resources/lang/id/dashboard.php`

```php
<?php

return [
    'welcome' => 'Selamat Datang',
    'total_vehicles' => 'Total Kendaraan',
    'recent_activities' => 'Aktivitas Terkini',
];
```

2. Gunakan di Blade:

```blade
<h1>{{ __('dashboard.welcome') }}</h1>
<p>{{ __('dashboard.total_vehicles') }}: {{ $count }}</p>
```

### Menambah Key Translation Baru

Edit file yang sudah ada, tambahkan key baru:

**resources/lang/id/common.php**

```php
return [
    // ... existing keys
    'new_key' => 'Teks baru dalam Bahasa Indonesia',
];
```

**resources/lang/en/common.php**

```php
return [
    // ... existing keys
    'new_key' => 'New text in English',
];
```

### Middleware dan Controller

**SetLocale Middleware** (`app/Http/Middleware/SetLocale.php`)

-   Mengambil locale dari session
-   Set locale ke aplikasi Laravel
-   Dijalankan untuk setiap request

**LocaleController** (`app/Http/Controllers/LocaleController.php`)

-   Method `switch($locale)` untuk ganti bahasa
-   Menyimpan pilihan ke session
-   Redirect kembali ke halaman sebelumnya

### Routes

```php
// Language switcher
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->name('locale.switch');
```

### Session Storage

Bahasa yang dipilih disimpan di **session** dengan key `locale`.
Jika session hilang (browser ditutup), akan kembali ke bahasa default (Indonesia).

---

## File Translation yang Sudah Tersedia

### 1. common.php

Teks umum aplikasi:

-   Navigation menu (Dashboard, Kendaraan, dll)
-   Action buttons (Tambah, Edit, Hapus, dll)
-   Status (Aktif, Selesai, dll)
-   Messages (Berhasil, Error, dll)
-   Forms (Field labels, validations)
-   Time (Hari ini, Kemarin, dll)

### 2. vehicle.php

Teks khusus kendaraan:

-   Vehicle fields (Plat Nomor, Merek, Model, dll)
-   Vehicle types (Mobil, Motor, Truk, dll)
-   Fuel types (Bensin, Solar, dll)
-   Transmission (Manual, Otomatis, dll)
-   Rental rates (Tarif Harian, dll)

### 3. quick_add.php

Teks untuk quick add modal:

-   Pengisian / Fuel Fill
-   Layanan / Maintenance
-   Biaya / Expense
-   Pendapatan / Income
-   dll

---

## Best Practices

### ✅ DO

-   Gunakan `__()` untuk semua teks yang visible ke user
-   Kelompokkan translation berdasarkan context (vehicle, customer, report, dll)
-   Gunakan key yang deskriptif: `vehicle.license_plate` bukan `veh.lp`
-   Pastikan semua key ada di **semua bahasa**

### ❌ DON'T

-   Jangan hardcode teks di Blade: ❌ `<h1>Dashboard</h1>`
-   Jangan campur bahasa dalam satu key
-   Jangan lupa menambahkan translation untuk bahasa baru

---

## Testing

1. Test switch language:

```
http://localhost:8000/locale/id  -> Switch ke Indonesia
http://localhost:8000/locale/en  -> Switch ke English
```

2. Verify session:

```php
dd(session('locale')); // Should output 'id' or 'en'
dd(app()->getLocale()); // Current active locale
```

3. Test translation output:

```blade
{{ __('common.dashboard') }}
// ID: "Dasbor"
// EN: "Dashboard"
```

---

## Menambah Bahasa Baru

Untuk menambah bahasa baru (misal: Jepang):

1. Buat folder: `resources/lang/ja/`
2. Copy semua file dari `id/` atau `en/`
3. Translate semua key ke bahasa Jepang
4. Update `LocaleController`:

```php
if (!in_array($locale, ['id', 'en', 'ja'])) {
    abort(400);
}
```

5. Update language switcher di layout:

```blade
<a href="{{ route('locale.switch', 'ja') }}" class="btn">
    🇯🇵 JP
</a>
```

---

## Troubleshooting

### Teks tidak berubah setelah switch bahasa

-   Clear cache: `php artisan config:clear`
-   Check apakah key translation sudah benar
-   Pastikan file translation ada di kedua folder (`id/` dan `en/`)

### Session tidak tersimpan

-   Check session driver di `.env`: `SESSION_DRIVER=file`
-   Pastikan folder `storage/framework/sessions/` writable

### Translation key tidak ditemukan

-   Akan menampilkan key-nya: `common.dashboard`
-   Check typo di key
-   Pastikan file translation sudah di-include

---

## Contoh Implementasi Lengkap

### Dashboard Blade

```blade
@extends('layouts.drivvo')

@section('title', __('common.dashboard'))

@section('content')
<div class="container">
    <h1>{{ __('common.dashboard') }}</h1>

    <div class="stats">
        <div class="stat-card">
            <h3>{{ __('vehicle.total_distance') }}</h3>
            <p>{{ $totalDistance }} km</p>
        </div>

        <div class="stat-card">
            <h3>{{ __('vehicle.total_expenses') }}</h3>
            <p>Rp {{ number_format($totalExpenses) }}</p>
        </div>
    </div>

    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
        {{ __('vehicle.add_vehicle') }}
    </a>
</div>
@endsection
```

Output ketika bahasa Indonesia:

```
Dashboard -> Dasbor
Total Distance -> Total Jarak
Total Expenses -> Total Biaya
Add Vehicle -> Tambah Kendaraan
```

Output ketika bahasa English:

```
Dashboard -> Dashboard
Total Distance -> Total Distance
Total Expenses -> Total Expenses
Add Vehicle -> Add Vehicle
```

---

## Future Enhancement

-   [ ] Menambah bahasa Jepang, Mandarin, Arab
-   [ ] Auto-detect bahasa dari browser
-   [ ] Simpan preference ke database (bukan session)
-   [ ] Translation untuk email notifications
-   [ ] Translation untuk error messages
-   [ ] Admin panel untuk edit translation tanpa edit file

---

**Created by:** Radja Blind Van Development Team
**Last Updated:** {{ date('Y-m-d') }}
