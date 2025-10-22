# 🌍 QUICK REFERENCE - Multi-Language Feature

## 🎯 CARA PAKAI (USER)

### Switch Bahasa

```
1. Buka aplikasi
2. Lihat SIDEBAR KIRI BAWAH
3. Klik: 🇮🇩 ID (Indonesia) atau 🇬🇧 EN (English)
4. Done! Semua teks otomatis berubah
```

### URL Direct

```
http://localhost:8000/locale/id  → Bahasa Indonesia
http://localhost:8000/locale/en  → English
```

---

## 💻 CARA PAKAI (DEVELOPER)

### Sintaks Dasar di Blade

```blade
{{ __('common.dashboard') }}          → Dasbor / Dashboard
{{ __('vehicle.add_vehicle') }}       → Tambah Kendaraan / Add Vehicle
{{ __('common.save') }}               → Simpan / Save
```

### Contoh Lengkap

```blade
<h1>{{ __('common.dashboard') }}</h1>

<button class="btn btn-primary">
    {{ __('common.add_new') }}
</button>

<label>{{ __('vehicle.license_plate') }}</label>
<input type="text" placeholder="{{ __('vehicle.license_plate') }}">
```

---

## 📁 FILE STRUCTURE

```
resources/lang/
├── id/                      ← Bahasa Indonesia
│   ├── common.php           ← Tombol, menu, status umum
│   ├── vehicle.php          ← Field & tipe kendaraan
│   ├── customer.php         ← Data pelanggan
│   ├── report.php           ← Laporan & filter
│   ├── reminder.php         ← Pengingat
│   └── quick_add.php        ← Modal tambah cepat
│
└── en/                      ← English (struktur sama)
    ├── common.php
    ├── vehicle.php
    ├── customer.php
    ├── report.php
    ├── reminder.php
    └── quick_add.php
```

---

## 🔑 TRANSLATION KEYS (Most Used)

### Common (common.php)

| Key         | ID          | EN        |
| ----------- | ----------- | --------- |
| `dashboard` | Dasbor      | Dashboard |
| `vehicles`  | Kendaraan   | Vehicles  |
| `add_new`   | Tambah Baru | Add New   |
| `save`      | Simpan      | Save      |
| `cancel`    | Batal       | Cancel    |
| `delete`    | Hapus       | Delete    |
| `search`    | Cari        | Search    |
| `filter`    | Filter      | Filter    |

### Vehicle (vehicle.php)

| Key             | ID         | EN            |
| --------------- | ---------- | ------------- |
| `license_plate` | Plat Nomor | License Plate |
| `brand`         | Merek      | Brand         |
| `model`         | Model      | Model         |
| `type`          | Tipe       | Type          |
| `fuel_type`     | Jenis BBM  | Fuel Type     |
| `odometer`      | Odometer   | Odometer      |

### Quick Add (quick_add.php)

| Key           | ID         | EN          |
| ------------- | ---------- | ----------- |
| `fuel_fill`   | Pengisian  | Fuel Fill   |
| `maintenance` | Layanan    | Maintenance |
| `expense`     | Biaya      | Expense     |
| `income`      | Pendapatan | Income      |

---

## ➕ MENAMBAH TRANSLATION BARU

### Step 1: Edit File Translation

```php
// resources/lang/id/vehicle.php
return [
    // ... existing keys
    'insurance_date' => 'Tanggal Asuransi',  // ← NEW
];

// resources/lang/en/vehicle.php
return [
    // ... existing keys
    'insurance_date' => 'Insurance Date',    // ← NEW
];
```

### Step 2: Gunakan di Blade

```blade
<label>{{ __('vehicle.insurance_date') }}</label>
```

### Done! ✅

---

## 🔧 TECHNICAL COMPONENTS

| File                   | Purpose                  |
| ---------------------- | ------------------------ |
| `LocaleController.php` | Handle switch bahasa     |
| `SetLocale.php`        | Middleware set bahasa    |
| `bootstrap/app.php`    | Register middleware      |
| `routes/web.php`       | Route `/locale/{locale}` |
| `config/app.php`       | Default locale: 'id'     |

---

## 🐛 TROUBLESHOOTING

### Translation tidak berubah?

```bash
php artisan config:clear
php artisan cache:clear
```

### Translation key tidak ditemukan?

-   Check typo: `common.dashboard` bukan `common.dashbord`
-   Check file ada: `resources/lang/id/common.php`
-   Check key ada di kedua bahasa (id & en)

### Session tidak tersimpan?

-   Check `.env`: `SESSION_DRIVER=file`
-   Check permission: `storage/framework/sessions/`

---

## 📖 FULL DOCUMENTATION

Untuk panduan lengkap:

-   **Developer Guide**: `MULTI_LANGUAGE_GUIDE.md`
-   **Summary**: `MULTI_LANGUAGE_SUMMARY.md`
-   **Demo**: Open `http://localhost:8000/multi-language-demo.html`

---

## ⚡ CHEAT SHEET

```blade
<!-- Menu / Navigation -->
{{ __('common.dashboard') }}
{{ __('common.vehicles') }}
{{ __('common.customers') }}
{{ __('common.reports') }}

<!-- Actions -->
{{ __('common.add') }}
{{ __('common.edit') }}
{{ __('common.delete') }}
{{ __('common.save') }}
{{ __('common.cancel') }}

<!-- Status -->
{{ __('common.active') }}
{{ __('common.inactive') }}
{{ __('common.completed') }}

<!-- Messages -->
{{ __('common.success') }}
{{ __('common.error') }}
{{ __('common.created_successfully') }}

<!-- Forms -->
{{ __('common.required_fields') }}
{{ __('common.select_option') }}

<!-- Vehicle -->
{{ __('vehicle.license_plate') }}
{{ __('vehicle.brand') }}
{{ __('vehicle.type') }}

<!-- Customer -->
{{ __('customer.name') }}
{{ __('customer.phone') }}
{{ __('customer.email') }}

<!-- Report -->
{{ __('report.total_revenue') }}
{{ __('report.export_pdf') }}
```

---

## 🎨 UI LOCATION

```
┌─────────────────────────────────────┐
│  SIDEBAR                            │
│                                     │
│  🏠 Dashboard                       │
│  ➕ Tambah Baru                     │
│  🔔 Pengingat                       │
│  📊 Laporan                         │
│  🚗 Kendaraan                       │
│  👥 Pelanggan                       │
│  ⚙️  Pengaturan                     │
│                                     │
│  ──────────────────────────         │
│                                     │
│  Bahasa / Language                  │
│  ┌────────┬────────┐                │
│  │ 🇮🇩 ID │ 🇬🇧 EN │  ← HERE!      │
│  └────────┴────────┘                │
└─────────────────────────────────────┘
```

---

**Created:** 2025-10-22
**Version:** 1.0
**Status:** ✅ Production Ready
