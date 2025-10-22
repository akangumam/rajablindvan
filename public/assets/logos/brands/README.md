# Brand Logos Assets

## 📁 Struktur Folder

```
public/assets/logos/brands/
├── default.svg          # Logo default untuk brand yang tidak terdaftar
├── toyota.svg           # Logo Toyota
├── honda.svg            # Logo Honda
├── daihatsu.svg         # Logo Daihatsu
├── mitsubishi.svg       # Logo Mitsubishi
├── suzuki.svg           # Logo Suzuki
├── nissan.svg           # Logo Nissan
└── [brand-name].svg     # Logo brand lainnya
```

## 📋 Cara Menambah Logo Baru

### 1. Format File

-   **Rekomendasi:** SVG (Scalable Vector Graphics)
-   **Alternatif:** PNG dengan background transparent
-   **Ukuran:** 24x24px optimal

### 2. Naming Convention

-   Format: `[nama-brand-lowercase].svg`
-   Contoh: `hyundai.svg`, `kia.svg`, `bmw.svg`

### 3. Langkah Penambahan

1. Simpan logo dengan nama sesuai brand (lowercase)
2. Tempatkan di folder `public/assets/logos/brands/`
3. Logo akan otomatis muncul di aplikasi

## 🎨 Spesifikasi Logo

### SVG (Recommended)

```svg
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <!-- Logo content here -->
</svg>
```

### PNG

-   Ukuran: 24x24px (atau 48x48px untuk retina)
-   Background: Transparent
-   Format: PNG-24

## 🔧 Implementation

Logo akan diambil otomatis menggunakan:

```php
// Di Vehicle Model
$vehicle->getBrandLogoUrl()

// Di Blade Template
<img src="{{ $vehicle->getBrandLogoUrl() }}" alt="{{ $vehicle->brand }}">
```

## 📝 Brand yang Sudah Tersedia

✅ **Toyota** - Logo oval dengan tiga lingkaran
✅ **Honda** - Logo "H" dengan background merah
✅ **Daihatsu** - Logo diamond biru
✅ **Mitsubishi** - Logo triangle merah
✅ **Suzuki** - Logo "S" dengan background biru
✅ **Nissan** - Logo circle dengan square center
✅ **Default** - Logo generic untuk brand lainnya

## 🚀 Cara Mengganti Logo

1. **Replace existing:** Ganti file dengan nama yang sama
2. **Add new brand:** Tambah file baru dengan nama brand
3. **Update default:** Ganti file `default.svg`

Logo akan langsung update tanpa perlu restart server!
