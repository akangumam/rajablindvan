# Scripts Translasi Bahasa Indonesia - Settings Pages

## 📋 Daftar Scripts

### 1. **run-all-translations.ps1** (MASTER SCRIPT)

Script utama yang menjalankan semua perbaikan dengan urutan yang benar.

**Cara Menggunakan:**

```powershell
powershell -ExecutionPolicy Bypass -File .\run-all-translations.ps1
```

**Apa yang dilakukan:**

-   Menjalankan translasi text ke Bahasa Indonesia
-   Memperbaiki route names dan CSS classes
-   Memperbaiki routes yang mungkin rusak

---

### 2. **update-settings-to-indonesian.ps1**

Mengubah semua text user-facing ke Bahasa Indonesia.

**Contoh perubahan:**

-   "Settings" → "Pengaturan"
-   "Apps Format" → "Format Aplikasi"
-   "Save" → "SIMPAN"
-   "Cancel" → "BATAL"

---

### 3. **fix-routes-and-classes.ps1**

Mengembalikan route names dan CSS classes ke format asli.

**Contoh perbaikan:**

-   `route('Pengaturan.format')` → `route('settings.format')`
-   `class="Pengaturan-page-sidebar"` → `class="settings-page-sidebar"`

---

### 4. **fix-all-routes.ps1**

Memperbaiki routes yang mungkin rusak karena translasi.

**Contoh perbaikan:**

-   `route('settings.format.SIMPAN')` → `route('settings.format.store')`
-   `route('settings.Investor.index')` → `route('settings.investors.index')`

---

## 🚀 Quick Start

Jika Anda ingin mentranslasi semua halaman settings, cukup jalankan:

```powershell
powershell -ExecutionPolicy Bypass -File .\run-all-translations.ps1
```

---

## ⚠️ Catatan Penting

**Yang DIUBAH ke Bahasa Indonesia:**

-   ✅ Text content untuk user (menu, button, label, dll)
-   ✅ Modal titles dan messages
-   ✅ Confirmation dialogs
-   ✅ Success/Error messages

**Yang TETAP Bahasa Inggris (Technical):**

-   ✅ Route names: `settings.format`, `settings.locations`, dll
-   ✅ CSS classes: `settings-page-sidebar`, `place-list-item`, dll
-   ✅ JavaScript function names
-   ✅ Variable names dan attribute names

---

## 📁 File yang Ditranslasi

-   ✅ account.blade.php
-   ✅ expense-types.blade.php
-   ✅ file-storage.blade.php
-   ✅ format.blade.php
-   ✅ income-types.blade.php
-   ✅ index.blade.php
-   ✅ locations.blade.php
-   ✅ payment-methods.blade.php
-   ✅ service-types.blade.php

---

## 🔧 Troubleshooting

### Error: "Route [settings.XXX.SIMPAN] not defined"

**Solusi:** Jalankan `fix-all-routes.ps1`

### Error: "Route [Pengaturan.format] not defined" atau "Route [Pengaturan.locations.update] not defined"

**Solusi:** Jalankan `fix-all-routes.ps1` (sudah termasuk dalam master script)

### CSS tidak berfungsi / layout rusak

**Solusi:** Jalankan `fix-routes-and-classes.ps1`

### Mengembalikan semua ke kondisi awal

```bash
git checkout resources/views/settings/
```

---

## 📝 Best Practice

Ini adalah **best practice** dalam development:

-   **User-facing text** → Bahasa Indonesia (untuk user)
-   **Technical identifiers** → Bahasa Inggris (untuk code stability)

Pemisahan ini memastikan:

-   Code tetap maintainable
-   Routes tidak berubah
-   CSS classes konsisten
-   JavaScript berfungsi normal
-   User mendapat pengalaman dalam Bahasa Indonesia

---

_Last updated: November 6, 2025_
