# 📖 Panduan Testing Lengkap - Step by Step

## 🎯 Cara Menggunakan Panduan Ini

Baca setiap bagian dengan teliti, ikuti langkah-langkahnya, dan catat hasil testing Anda. Gunakan TESTING_CHECKLIST.md untuk mencentang setiap test yang sudah dilakukan.

---

## 🚀 PERSIAPAN SEBELUM TESTING

### Langkah 1: Start Server

```bash
# Buka terminal/command prompt
# Navigate ke folder project
cd E:\WebProgramming\rajablindvan\vehicle-dashboard

# Jalankan server
php artisan serve
```

**Yang Harus Terlihat:**

```
INFO  Server running on [http://127.0.0.1:8000].
```

### Langkah 2: Buka Browser

-   Buka Chrome/Firefox/Edge
-   Ketik URL: `http://127.0.0.1:8000/login`
-   Tekan Enter

### Langkah 3: Siapkan Tools

-   Notepad/Text Editor untuk catat bugs
-   TESTING_CHECKLIST.md untuk centang progress
-   Test credentials (lihat di bawah)

---

## 📋 SECTION 1: AUTHENTICATION SYSTEM

### 🔐 1.1 Testing Login Page Design

**Apa Yang Ditest:** Tampilan halaman login

**Langkah-langkah:**

1. Buka `http://127.0.0.1:8000/login`
2. **Periksa elemen-elemen berikut:**

    ✅ **Logo Raja Blind Van**

    - Lihat bagian atas halaman
    - Harus ada icon van/shuttle
    - Text "Raja Blind Van" terlihat

    ✅ **Background Gradient Ungu**

    - Background halaman berwarna gradasi ungu (purple)
    - Terlihat menarik dan modern

    ✅ **Form Login**

    - Ada field "Email"
    - Ada field "Password"
    - Ada checkbox "Remember Me"
    - Ada tombol "Login"

    ✅ **Password Toggle**

    - Lihat icon mata di sebelah kanan field password
    - Klik icon mata
    - Password berubah dari "••••" menjadi text biasa
    - Klik lagi, kembali menjadi "••••"

**Cara Catat:**

-   Jika semua OK → Centang di checklist
-   Jika ada masalah → Tulis di "Notes":
    ```
    Logo tidak muncul / Background warna salah / dll
    ```

---

### 🚪 1.2 Testing Login Process

**Apa Yang Ditest:** Proses login sampai masuk dashboard

**Langkah-langkah:**

**Test 1: Login dengan Super Admin**

1. Masukkan credentials:
    ```
    Email: admin@rajablindvan.com
    Password: admin123
    ```
2. **Jangan centang** "Remember Me" dulu
3. Klik tombol **"Login"**

**Yang Harus Terjadi (Perhatikan dengan Seksama!):**

📌 **Step 1: Loading Animation (2 detik pertama)**

-   Layar berubah ke **background ungu**
-   Ada **emoji van 🚐** yang muncul
-   Van **bergerak dari kiri ke kanan** layar
-   Ada text "Loading Dashboard..."
-   Text berkedip/animasi

✅ **Cek:** Animasi smooth? Tidak patah-patah?

📌 **Step 2: Redirect ke Dashboard**

-   Setelah ~2 detik, otomatis pindah ke dashboard
-   URL berubah jadi `http://127.0.0.1:8000/dashboard`

📌 **Step 3: Welcome Message**

-   Di bagian atas dashboard, ada **alert hijau**
-   Text: **"Welcome back, Super Administrator!"**
-   Alert punya icon check ✓
-   Alert **hilang otomatis** setelah 3-5 detik

✅ **Cek:** Message muncul? Hilang otomatis?

**Jika Ada Masalah:**

-   Login gagal → Cek: apakah email/password benar?
-   Tidak ada animasi → Catat: "Loading animation tidak muncul"
-   Error muncul → Screenshot error, catat pesannya
-   Welcome message tidak ada → Catat: "Welcome message tidak tampil"

---

### 👤 1.3 Testing User Info Bar

**Apa Yang Ditest:** Informasi user di sidebar

**Lokasi:** Bagian **atas sidebar** (menu sebelah kiri)

**Langkah-langkah:**

1. Setelah login, lihat **sidebar kiri**
2. Di bagian atas sidebar, ada kotak info user

**Yang Harus Terlihat:**

📌 **Avatar Circle (Lingkaran)**

-   Ada lingkaran warna di bagian atas
-   Di dalam lingkaran ada huruf **"S"** (dari Super)
-   Warna background lingkaran: Ungu atau warna cerah

📌 **Nama User**

-   Text: **"Super Administrator"**
-   Warna text: Hitam atau abu gelap
-   Font: Sedang/bold

📌 **Email User**

-   Text: **"admin@rajablindvan.com"**
-   Warna text: Abu-abu
-   Font: Lebih kecil dari nama

📌 **Role Badge**

-   Ada label badge: **"Super Admin"**
-   Background badge: **GRADASI UNGU** (purple gradient)
-   Text badge: Putih
-   Badge bentuk rounded (sudut melengkung)

**Cara Test:**

```
✅ Avatar ada? → Ya/Tidak
✅ Initial "S" terlihat? → Ya/Tidak
✅ Nama benar? → Super Administrator
✅ Email benar? → admin@rajablindvan.com
✅ Badge warna ungu? → Ya/Tidak
✅ Text badge: "Super Admin"? → Ya/Tidak
```

**Contoh Jika Error:**

-   "Avatar tidak muncul, hanya kotak kosong"
-   "Role badge warna merah, seharusnya ungu"
-   "Nama tidak muncul, hanya email"

---

### 🚪 1.4 Testing Logout Modal

**Apa Yang Ditest:** Popup konfirmasi saat logout

**Langkah-langkah:**

**Test 1: Membuka Modal**

1. Lihat menu sidebar (kiri)
2. Scroll ke bawah (jika perlu)
3. Cari menu **"Logout"** (biasanya paling bawah)
4. **Klik** tombol Logout

**Yang Harus Terjadi:**

-   Layar sedikit **gelap** (overlay)
-   **Popup modal** muncul di tengah layar
-   Modal punya:
    -   Header warna **ungu gradient**
    -   Icon warning ⚠️
    -   Title: **"Konfirmasi Logout"**
    -   Pesan: **"Apakah Anda yakin ingin keluar?"**
    -   Sub-pesan: "Anda akan keluar dari sistem..."
    -   2 tombol:
        -   Tombol **"Batal"** (warna abu-abu)
        -   Tombol **"Ya, Logout"** (warna merah)

**Test 2: Tombol Batal**

1. Klik tombol **"Batal"**
    - Modal **menutup** (hilang)
    - Masih tetap di dashboard (tidak logout)
    - Bisa klik menu lain normal

**Test 3: Tombol Ya, Logout**

1. Klik **Logout** lagi
2. Kali ini klik **"Ya, Logout"**
    - Modal menutup
    - **Redirect** ke halaman login
    - URL: `http://127.0.0.1:8000/login`
    - Tidak bisa akses dashboard lagi (session cleared)

**Test 4: Coba Akses Dashboard Setelah Logout**

1. Di address bar, ketik: `http://127.0.0.1:8000/dashboard`
2. Tekan Enter
    - Harus **redirect** ke login lagi
    - Tidak bisa masuk dashboard

**Checklist:**

```
✅ Modal muncul saat klik Logout?
✅ Modal ada 2 tombol?
✅ Klik Batal → Modal tutup, tidak logout?
✅ Klik Ya Logout → Redirect ke login?
✅ Session cleared? (tidak bisa balik ke dashboard)
```

---

### 🔄 1.5 Testing Remember Me

**Apa Yang Ditest:** Fitur "Ingat Saya"

**Test 1: TANPA Remember Me**

1. Login dengan:
    ```
    Email: admin@rajablindvan.com
    Password: admin123
    Remember Me: JANGAN DICENTANG ❌
    ```
2. Klik Login → Masuk dashboard
3. **Tutup browser sepenuhnya** (close semua tab dan window)
4. **Buka browser lagi**
5. Ketik: `http://127.0.0.1:8000/dashboard`

    **Expected:** Harus redirect ke login (tidak remembered)

**Test 2: DENGAN Remember Me**

1. Login lagi dengan:
    ```
    Email: admin@rajablindvan.com
    Password: admin123
    Remember Me: CENTANG ✅
    ```
2. Klik Login → Masuk dashboard
3. **Tutup browser sepenuhnya**
4. **Buka browser lagi**
5. Ketik: `http://127.0.0.1:8000/dashboard`

    **Expected:** Langsung masuk dashboard (masih login)

**Checklist:**

```
✅ Tanpa Remember Me → Harus login ulang setelah tutup browser?
✅ Dengan Remember Me → Masih login setelah tutup browser?
```

---

## 🔐 SECTION 2: ROLE-BASED ACCESS CONTROL

### 🎯 Konsep RBAC

Ada 5 role dengan hak akses berbeda:

1. **Super Admin** → Bisa semua
2. **Admin** → Bisa kelola users + hampir semua
3. **Manager** → TIDAK bisa kelola users
4. **Operator** → Akses terbatas
5. **Viewer** → Hanya bisa lihat (read-only)

### 👑 2.1 Testing Super Admin Access

**Tujuan:** Memastikan Super Admin bisa akses SEMUA

**Langkah:**

1. **Login sebagai Super Admin:**

    ```
    Email: admin@rajablindvan.com
    Password: admin123
    ```

2. **Cek Sidebar Menu:**

    - Lihat menu di sidebar kiri
    - **HARUS ADA** menu "Users" 📋
    - Lokasi: biasanya setelah menu Customers atau Locations

3. **Test Akses Users:**

    - Klik menu **"Users"**
    - Halaman harus **terbuka normal**
    - URL: `http://127.0.0.1:8000/users`
    - Tidak ada error
    - Lihat list users
    - Ada tombol **"ADD NEW"**

4. **Test Akses Menu Lain:**
   Klik satu per satu:

    - Dashboard ✓
    - Vehicles ✓
    - Customers ✓
    - Orders ✓
    - Reminders ✓
    - Reports ✓

    **Semua harus bisa dibuka**, tidak ada error 403

5. **Cek Role Badge:**
    - Lihat user info di atas sidebar
    - Badge text: **"Super Admin"**
    - Badge color: **Ungu/Purple gradient**

**Checklist:**

```
✅ Menu "Users" VISIBLE?
✅ Bisa klik dan buka halaman Users?
✅ Bisa akses semua menu lain?
✅ Tidak ada halaman error 403?
✅ Role badge benar (Super Admin, ungu)?
```

---

### 👨‍💼 2.2 Testing Admin Access

**Tujuan:** Admin juga bisa kelola users (sama seperti Super Admin)

**Langkah:**

1. **Logout** dari Super Admin (klik Logout → Ya, Logout)

2. **Login sebagai Admin:**

    ```
    Email: admin2@rajablindvan.com
    Password: admin123
    ```

3. **Cek Sidebar:**

    - Menu "Users" **HARUS ADA** juga ✅

4. **Test Akses Users:**

    - Klik "Users" → Harus bisa buka
    - Bisa create, edit, delete users

5. **Cek Role Badge:**
    - Badge text: **"Admin"**
    - Badge color: **Pink/Merah muda gradient**

**Checklist:**

```
✅ Menu "Users" VISIBLE?
✅ Bisa akses halaman Users?
✅ Badge: "Admin" dengan warna pink?
```

---

### 👔 2.3 Testing Manager Access (PENTING!)

**Tujuan:** Manager TIDAK boleh kelola users

**Langkah:**

1. **Logout** dari Admin

2. **Login sebagai Manager:**

    ```
    Email: manager@rajablindvan.com
    Password: manager123
    ```

3. **❗ CEK SIDEBAR (INI YANG PENTING):**

    - Scroll semua menu dari atas ke bawah
    - Menu "Users" **TIDAK BOLEH ADA** ❌
    - Hanya ada: Dashboard, Vehicles, Customers, Orders, Reminders, Reports

4. **Test Direct Access (Sangat Penting!):**

    - Di address bar, ketik langsung: `http://127.0.0.1:8000/users`
    - Tekan Enter

    **YANG HARUS TERJADI:**

    - **TIDAK bisa** masuk halaman Users
    - Muncul **halaman error 403**
    - Title: **"403 - Access Denied"**
    - Icon shield ungu
    - Pesan: "Maaf, Anda tidak memiliki izin..."
    - Info user: Menampilkan nama dan role Manager

5. **Test Tombol di 403 Page:**

    - Klik **"Back to Dashboard"** → Kembali ke dashboard
    - Atau klik **"Go Back"** → Kembali ke halaman sebelumnya

6. **Test Akses Menu Lain:**

    - Vehicles → Harus bisa ✅
    - Customers → Harus bisa ✅
    - Orders → Harus bisa ✅
    - Reminders → Harus bisa ✅

7. **Cek Role Badge:**
    - Badge text: **"Manager"**
    - Badge color: **Biru/Blue gradient**

**Ini Test Paling Penting Untuk RBAC!**

```
✅ Menu "Users" TIDAK TERLIHAT (hidden)?
✅ Akses direct URL /users → Muncul 403?
✅ Halaman 403 custom (bukan Laravel default)?
✅ Bisa akses menu lain (Vehicles, Customers, dll)?
✅ Badge: "Manager" dengan warna biru?
```

**Jika Gagal:**

-   Menu "Users" masih terlihat → Bug! Catat: "Menu Users masih visible untuk Manager"
-   Bisa akses /users → Bug Kritis! Catat: "Manager bisa akses /users, seharusnya 403"
-   403 page tidak muncul → Catat: "403 page tidak custom"

---

### 💼 2.4 Testing Operator Access

**Tujuan:** Operator akses lebih terbatas lagi

**Langkah:**

1. Logout, login sebagai:

    ```
    Email: operator@rajablindvan.com
    Password: operator123
    ```

2. **Cek Sidebar:**

    - Menu "Users" **TIDAK ADA** ❌

3. **Test Direct Access:**

    - Ketik: `http://127.0.0.1:8000/users`
    - Harus muncul **403 page**

4. **Cek Akses Terbatas:**

    - Bisa akses Orders ✅
    - Bisa akses Customers ✅
    - Mungkin tidak bisa edit/delete (cek ini)

5. **Role Badge:**
    - Text: **"Operator"**
    - Color: **Hijau/Green gradient**

**Checklist:**

```
✅ Menu "Users" tidak ada?
✅ Direct access /users → 403?
✅ Badge hijau "Operator"?
```

---

### 👁️ 2.5 Testing Viewer Access

**Tujuan:** Viewer hanya bisa lihat (read-only)

**Langkah:**

1. Logout, login sebagai:

    ```
    Email: viewer@rajablindvan.com
    Password: viewer123
    ```

2. **Cek Sidebar:**

    - Menu "Users" **TIDAK ADA** ❌

3. **Test Direct Access:**

    - Ketik: `http://127.0.0.1:8000/users`
    - Harus **403 page**

4. **Test Read-Only:**

    - Buka halaman Customers
    - **Cek:** Apakah tombol "ADD NEW" ada?
    - **Cek:** Apakah tombol Edit/Delete terlihat?
    - Jika tidak ada → Berarti read-only ✅

5. **Role Badge:**
    - Text: **"Viewer"**
    - Color: **Orange/Oranye gradient**

**Checklist:**

```
✅ Menu "Users" tidak ada?
✅ Direct access /users → 403?
✅ Tidak bisa edit/delete? (buttons hidden)
✅ Badge orange "Viewer"?
```

---

## 🏢 SECTION 3: CUSTOMERS MODULE

### 📄 3.1 Testing Customers Index Page

**Tujuan:** Halaman list customers berfungsi dengan baik

**Login sebagai:** Super Admin atau Admin (untuk full access)

**Langkah:**

1. Klik menu **"Customers"** di sidebar
2. Atau ketik: `http://127.0.0.1:8000/customers`

**Yang Harus Terlihat:**

📌 **Search Bar (Bagian Atas)**

-   Ada kotak search dengan icon 🔍
-   Placeholder text: "Search by company name, PIC name..."
-   Ada icon X untuk clear search

📌 **Tombol ADD NEW (Kanan Atas)**

-   Tombol berwarna ungu atau outline ungu
-   Text: "ADD NEW"
-   Uppercase

📌 **Tabel Customers**

-   Table headers:

    -   # (nomor urut)
    -   Company Name
    -   Company Address
    -   PIC Name
    -   Contact Number
    -   Active (status)
    -   Actions (edit & delete icons)

-   Jika ada data:

    -   Data tampil dalam rows
    -   Setiap row punya icon edit (✏️) dan delete (🗑️)

-   Jika belum ada data:
    -   Tampil "No data" atau tabel kosong

📌 **Pagination (Bagian Bawah)**

-   Jika data > 20:
    -   Ada pagination bar
    -   Text: "Showing 1 to 20 of X results"
    -   Tombol Previous/Next
    -   Page numbers (1, 2, 3...)

**Checklist:**

```
✅ Page loads tanpa error?
✅ Search bar ada?
✅ Tombol ADD NEW ada?
✅ Table headers benar?
✅ Jika ada data → tampil dengan benar?
✅ Icon edit dan delete ada di Actions column?
```

---

### ➕ 3.2 Testing Create Customer

**Tujuan:** Bisa menambah customer baru

**Langkah Detail:**

**Step 1: Buka Form Create**

1. Di halaman Customers index
2. Klik tombol **"ADD NEW"** (kanan atas)
3. URL berubah: `http://127.0.0.1:8000/customers/create`
4. Halaman form terbuka

**Step 2: Periksa Form**
Form harus punya 4 fields:

1. **Company Name** (Nama Perusahaan)

    - Ada icon 🏢 di sebelah kiri
    - Ada tanda **bintang merah \*** (required)
    - Placeholder: "Enter company name"

2. **Company Address** (Alamat Perusahaan)

    - Textarea (kotak besar, bisa multiline)
    - Ada tanda **\*** (required)
    - Placeholder: "Enter company address"

3. **PIC Name** (Person In Charge)

    - Ada icon 👤 di sebelah kiri
    - Ada tanda **\*** (required)
    - Placeholder: "Enter PIC name"

4. **Contact Number** (Nomor Telepon)
    - Ada icon 📞 di sebelah kiri
    - Ada tanda **\*** (required)
    - Placeholder: "Enter contact number"

Ada 2 tombol:

-   **Save** (hijau/ungu)
-   **Cancel** (abu-abu)

**Step 3: Test Validation (Form Kosong)**

1. **JANGAN isi** form apapun
2. Klik tombol **"Save"**

    **Yang harus terjadi:**

    - Form **TIDAK submit**
    - Muncul **error messages** di bawah tiap field
    - Error text berwarna merah
    - Pesan seperti:
        - "The company name field is required."
        - "The company address field is required."
        - "The PIC name field is required."
        - "The contact number field is required."

**Step 4: Test Validation (Sebagian Diisi)**

1. Isi hanya Company Name: "PT Test"
2. Biarkan field lain kosong
3. Klik "Save"

    **Yang harus terjadi:**

    - Masih muncul error untuk 3 field lain
    - Error message jelas

**Step 5: Test Success (Isi Lengkap)**

1. Isi semua field dengan data test:

    ```
    Company Name: PT Test Transport Indonesia
    Company Address: Jl. Raya Test No. 123, Jakarta Selatan
    PIC Name: Budi Santoso
    Contact Number: 081234567890
    ```

2. Klik tombol **"Save"**

    **Yang harus terjadi:**

    - **Redirect** ke halaman Customers index
    - URL: `http://127.0.0.1:8000/customers`
    - Muncul **success message** (alert hijau)
    - Text: "Customer successfully added!" atau serupa
    - Alert ada icon ✓
    - **Customer baru tampil** di tabel
    - Data yang tampil sesuai dengan yang diinput

**Step 6: Verifikasi Data**

1. Scroll tabel, cari "PT Test Transport Indonesia"
2. Cek data di row tersebut:
    - Company Name: PT Test Transport Indonesia ✓
    - Company Address: Jl. Raya Test... ✓
    - PIC Name: Budi Santoso ✓
    - Contact: 081234567890 ✓
    - Active: Yes/True ✓
    - Actions: Ada icon edit & delete ✓

**Checklist:**

```
✅ Form create terbuka?
✅ Ada 4 fields yang benar?
✅ Semua fields marked required (*)?
✅ Submit kosong → Muncul validation error?
✅ Error messages jelas?
✅ Isi lengkap & submit → Success?
✅ Redirect ke index?
✅ Success message muncul?
✅ Data baru tampil di tabel?
✅ Data yang tampil sesuai input?
```

---

### 🔍 3.3 Testing Search Customers

**Tujuan:** Search bisa filter data dengan benar

**Persiapan:** Pastikan ada beberapa customer di database

**Test 1: Search by Company Name**

1. Di halaman Customers index
2. Klik kotak search
3. Ketik: **"Test"**
4. Tekan Enter atau tunggu beberapa detik

    **Yang harus terjadi:**

    - Tabel **auto-filter**
    - Hanya customer dengan company name mengandung "Test" yang muncul
    - Customer lain hilang dari tabel
    - URL berubah: `...customers?search=Test`

**Test 2: Search by PIC Name**

1. Clear search (klik icon X)
2. Ketik: **"Budi"**

    **Yang harus terjadi:**

    - Hanya customer dengan PIC name "Budi" yang tampil

**Test 3: Search by Contact Number**

1. Clear search
2. Ketik: **"0812"**

    **Yang harus terjadi:**

    - Customer dengan nomor telepon mengandung "0812" tampil

**Test 4: Search Tidak Ada**

1. Clear search
2. Ketik: **"XXXXXX999"** (data yang tidak ada)

    **Yang harus terjadi:**

    - Tabel kosong atau message "No results found"
    - Tidak ada customer tampil

**Test 5: Clear Search**

1. Klik icon **X** di search box

    **Yang harus terjadi:**

    - Search box kosong
    - **Semua customer tampil kembali**
    - Tabel kembali normal

**Checklist:**

```
✅ Search by company name → Filter correct?
✅ Search by PIC name → Filter correct?
✅ Search by contact → Filter correct?
✅ Search tidak ada → Empty table?
✅ Clear search → All data kembali?
✅ Search instant atau perlu Enter?
```

---

### 📄 3.4 Testing Pagination

**Syarat:** Harus ada lebih dari 20 customers

**Jika Belum Punya 20 Customers:**

-   Skip test ini, atau
-   Buat dummy data dulu (bisa manual atau seeder)

**Langkah:**

1. Di halaman Customers, scroll ke bawah
2. Lihat **pagination bar** di bawah tabel

**Yang Harus Ada:**

📌 **Info Text (Kiri)**

-   Text: "Showing 1 to 20 of X results"
-   X = total customers

📌 **Navigation (Kanan)**

-   Tombol **Previous** (atau icon ◀)
-   Page numbers: **1, 2, 3, ...**
-   Tombol **Next** (atau icon ▶)

**Test Navigation:**

**Test 1: Page 1 (Current)**

-   Tombol Previous: **Disabled** (abu-abu, tidak bisa diklik)
-   Page "1": **Active** (highlighted, warna ungu)
-   Tombol Next: **Enabled** (bisa diklik)

**Test 2: Klik Next**

1. Klik tombol **Next**
    - Pindah ke page 2
    - Tabel reload, tampil data 21-40
    - Page "2" jadi **active**
    - URL berubah: `...customers?page=2`

**Test 3: Klik Page Number**

1. Klik angka **3**
    - Langsung jump ke page 3
    - Tampil data 41-60
    - Page "3" active

**Test 4: Klik Previous**

1. Dari page 3, klik **Previous**
    - Kembali ke page 2
    - Data 21-40 tampil

**Test 5: Last Page**

1. Klik page terakhir (misal page 5)
    - Tombol Next: **Disabled**
    - Tombol Previous: **Enabled**
    - Info: "Showing 81 to 95 of 95 results" (contoh)

**Test 6: Pagination dengan Search**

1. Dari page manapun, ketik search: "Test"
    - Pagination **update** sesuai hasil search
    - Jika hasil < 20: pagination hilang
    - Jika hasil > 20: pagination ada, tapi untuk filtered data

**Checklist:**

```
✅ Pagination bar ada (jika > 20 data)?
✅ Info "Showing X to Y of Z" benar?
✅ Page numbers tampil?
✅ Tombol Next berfungsi?
✅ Tombol Previous berfungsi?
✅ Klik page number → Jump ke page itu?
✅ Page 1: Previous disabled?
✅ Last page: Next disabled?
✅ Pagination dengan search update correct?
```

---

### ✏️ 3.5 Testing Edit Customer

**Tujuan:** Bisa mengubah data customer yang sudah ada

**Langkah:**

**Step 1: Buka Form Edit**

1. Di halaman Customers index
2. Cari customer "PT Test Transport Indonesia" (yang tadi dibuat)
3. Di column **Actions**, klik icon **✏️ (Edit)**
4. Redirect ke form edit
5. URL: `http://127.0.0.1:8000/customers/{id}/edit`

**Step 2: Periksa Form**

-   Form sama seperti Create
-   **TAPI** semua field sudah **ter-isi** (pre-filled) dengan data existing:
    ```
    Company Name: PT Test Transport Indonesia
    Company Address: Jl. Raya Test No. 123, Jakarta Selatan
    PIC Name: Budi Santoso
    Contact Number: 081234567890
    ```

**Step 3: Ubah Data**

1. Ubah Company Name jadi: **"PT Test Transport UPDATED"**
2. Biarkan field lain tetap sama
3. Klik **"Save"**

    **Yang harus terjadi:**

    - **Redirect** ke Customers index
    - **Success message**: "Customer successfully updated!"
    - Di tabel, company name sekarang: **"PT Test Transport UPDATED"**
    - Data lain tetap sama

**Step 4: Verifikasi Perubahan**

1. Cari lagi customer yang baru diubah
2. Cek:
    - Company Name: PT Test Transport UPDATED ✓
    - Address, PIC, Contact: Tidak berubah ✓

**Checklist:**

```
✅ Klik icon edit → Form edit terbuka?
✅ Form ter-isi dengan data existing?
✅ Bisa ubah data?
✅ Submit → Redirect ke index?
✅ Success message muncul?
✅ Perubahan tersimpan di tabel?
✅ Data yang tidak diubah tetap sama?
```

---

### 🗑️ 3.6 Testing Delete Customer

**Tujuan:** Bisa menghapus customer

**⚠️ HATI-HATI:** Delete akan menghapus data permanent!

**Langkah:**

**Step 1: Klik Delete**

1. Di halaman Customers index
2. Cari customer test yang tadi dibuat
3. Di column **Actions**, klik icon **🗑️ (Delete)**

    **Yang harus terjadi:**

    - **Popup confirmation** muncul (browser confirm dialog)
    - Message: "Are you sure you want to delete this customer?"
    - Ada 2 pilihan: **Cancel** dan **OK**

**Step 2: Test Cancel**

1. Klik **Cancel**
    - Dialog hilang
    - Customer **TIDAK dihapus**
    - Masih ada di tabel

**Step 3: Test Delete (Sebenarnya)**

1. Klik icon delete lagi
2. Kali ini klik **OK**

    **Yang harus terjadi:**

    - Dialog hilang
    - Page **reload**
    - **Success message**: "Customer successfully deleted!"
    - Customer **hilang dari tabel**

**Step 4: Verifikasi Deleted**

1. Scroll seluruh tabel
2. Search dengan nama customer → **Tidak ketemu**
3. Customer benar-benar terhapus

**Checklist:**

```
✅ Klik delete → Confirmation dialog muncul?
✅ Dialog punya message yang jelas?
✅ Klik Cancel → Customer TIDAK dihapus?
✅ Klik OK → Customer dihapus?
✅ Success message muncul?
✅ Customer hilang dari tabel?
✅ Data benar-benar terhapus (tidak muncul lagi)?
```

---

## 📦 SECTION 4: ORDERS MODULE

_(Mirip dengan Customers, tapi untuk Orders)_

### 4.1-4.5: Same Pattern

Test dengan cara yang sama seperti Customers:

-   Index page
-   Create order
-   Search orders
-   Edit order
-   Delete order

**Perbedaan:**

-   Orders punya dropdown untuk **select Vehicle**
-   Orders punya dropdown untuk **select Customer**
-   Fields lebih banyak (tanggal, harga, dll)

**Key Points to Test:**

```
✅ Dropdown vehicles ter-load?
✅ Dropdown customers ter-load?
✅ Bisa pilih vehicle dan customer?
✅ Date picker berfungsi?
✅ Calculation otomatis? (jika ada)
✅ Search by vehicle name works?
✅ Search by customer name works?
```

---

## 🔔 SECTION 5: REMINDERS MODULE

### 5.1 Testing Vehicle Selection (UNIK!)

**Perbedaan Reminders:** Harus pilih vehicle dulu

**Langkah:**

**Step 1: Buka Reminders**

1. Klik menu **Reminders**
2. URL: `http://127.0.0.1:8000/reminders`

**Yang harus terlihat:**

-   **Dropdown "Select Vehicle"** di bagian atas
-   **Empty state** message: "Select Vehicle to view reminders"
-   **Tidak ada** reminders tampil dulu

**Step 2: Klik Vehicle Dropdown**

1. Klik tombol dropdown "Select Vehicle"

    **Yang harus terjadi:**

    - **Modal popup** muncul
    - Title: "Select Vehicle"
    - List vehicles tampil:
        - Logo brand (Toyota, Honda, dll)
        - Nama vehicle
        - Model vehicle
    - Setiap vehicle punya icon ▶ (chevron right)

**Step 3: Pilih Vehicle**

1. Klik salah satu vehicle (misal: "Avanza 2020")

    **Yang harus terjadi:**

    - Modal **tutup**
    - Dropdown berubah jadi nama vehicle: **"Avanza 2020"**
    - URL berubah: `...reminders?vehicle=1`
    - Reminders untuk vehicle itu **tampil** (jika ada)
    - Tombol **"ADD NEW"** muncul

**Checklist:**

```
✅ Initial state: Dropdown "Select Vehicle"?
✅ Initial state: Empty state message?
✅ Klik dropdown → Modal muncul?
✅ List vehicles tampil dengan logo?
✅ Pilih vehicle → Modal tutup?
✅ Dropdown update dengan vehicle name?
✅ Reminders untuk vehicle itu load?
✅ Tombol ADD NEW muncul?
```

---

### 5.3 Testing Create Reminder (LENGKAP!)

**Reminder punya banyak fields!**

**Langkah:**

**Step 1: Buka Form**

1. Pastikan sudah select vehicle
2. Klik **"ADD NEW"**
3. Form create terbuka

**Step 2: Periksa Semua Fields**

📌 **Required Fields (wajib):**

1. **Title** \*

    - Text input
    - Placeholder: "Example: Engine Oil Change"

2. **Category** \*

    - Dropdown select
    - Options: Service, Oil Change, Tax, Insurance, License, Inspection, Other

3. **Due Date** \*
    - Date picker
    - Format: DD/MM/YYYY atau YYYY-MM-DD

📌 **Optional Fields:** 4. **Due Odometer**

-   Number input
-   Placeholder: "Example: 50000"
-   Unit: km

5. **Alert Days Before**

    - Number input
    - Default: 7
    - Meaning: Alert berapa hari sebelum due date

6. **Estimated Cost**

    - Number input
    - Placeholder: "Example: 500000"
    - Unit: Rp

7. **Recurring Interval**

    - Dropdown select
    - Options: None, Weekly, Monthly, Quarterly, Semi-Annually, Yearly

8. **Description**

    - Textarea
    - Placeholder: "Enter reminder description..."

9. **Notes**
    - Textarea
    - Placeholder: "Additional notes..."

**Step 3: Test Minimal (Required Only)**

1. Isi hanya fields required:
    ```
    Title: Oil Change Test
    Category: Oil Change
    Due Date: [Pilih tanggal besok]
    ```
2. Biarkan optional kosong
3. Klik **"Save"**

    **Expected:**

    - Submit berhasil
    - Redirect ke index
    - Success message
    - Reminder baru tampil

**Step 4: Test Full (Semua Fields)**

1. Klik ADD NEW lagi
2. Isi **SEMUA** fields:
    ```
    Title: Complete Service Check
    Category: Service
    Due Date: [30 hari dari sekarang]
    Due Odometer: 50000
    Alert Days Before: 7
    Estimated Cost: 500000
    Recurring Interval: Quarterly
    Description: Full inspection and maintenance
    Notes: Don't forget tire rotation
    ```
3. Klik Save

    **Expected:**

    - Submit berhasil
    - Semua data tersimpan

**Step 5: Verifikasi Data di Table**

1. Di index, lihat reminder yang baru dibuat
2. Check:
    - Title: Complete Service Check ✓
    - Category badge tampil
    - Due date tampil
    - **Estimated cost tampil** (jika diisi): Rp 500.000 ✓
    - Status: Pending (badge kuning)

**Checklist:**

```
✅ Form punya 9 fields (3 required, 6 optional)?
✅ Required fields marked dengan *?
✅ Dropdown Category punya options?
✅ Date picker berfungsi?
✅ Recurring dropdown punya options?
✅ Submit minimal (required only) berhasil?
✅ Submit full (all fields) berhasil?
✅ Data tersimpan dengan benar?
✅ Estimated cost tampil di index?
```

---

### 5.6 Testing Edit Reminder + Mark as Completed

**Fitur Unik:** Bisa mark reminder sebagai "Completed"

**Langkah:**

**Step 1: Buka Edit**

1. Klik icon edit pada reminder
2. Form edit terbuka
3. Fields ter-isi dengan data existing

**Step 2: Cek Checkbox Completed**

-   Scroll ke bawah form
-   Ada **checkbox**: ☐ Mark as Completed
-   Initial: **Tidak tercentang** (untuk reminder pending)

**Step 3: Test Mark as Completed**

1. **Centang** checkbox "Mark as Completed" ✓
2. Ubah data lain jika perlu (optional)
3. Klik **"Save"**

    **Expected:**

    - Redirect ke index
    - Success message
    - Status badge reminder berubah:
        - Dari: **"Pending"** (badge kuning)
        - Ke: **"Completed"** (badge hijau)

**Step 4: Verifikasi**

1. Lihat reminder di table
2. Badge: **"Completed"** dengan warna hijau ✓

**Checklist:**

```
✅ Form edit punya checkbox "Mark as Completed"?
✅ Centang checkbox dan save → Berhasil?
✅ Status badge berubah jadi "Completed"?
✅ Badge warna hijau?
```

---

## ⚠️ SECTION 6: ERROR PAGES

### 6.1 Testing 404 Page

**Tujuan:** Test halaman untuk URL yang tidak ada

**Langkah:**

1. Di address bar, ketik: `http://127.0.0.1:8000/halaman-tidak-ada`
2. Tekan Enter

**Yang Harus Muncul:**

📌 **Custom 404 Page (Bukan Laravel Default!)**

-   Background putih/clean
-   Icon compass/navigation (pink gradient circle)
-   **Text besar: "404"** (pink gradient)
-   Title: **"Page Not Found"**
-   Message: "Oops! Halaman yang Anda cari tidak ditemukan..."
-   2 tombol:
    -   **"Back to Dashboard"** (pink)
    -   **"Go Back"** (outline)

📌 **Quick Links Section**

-   Ada section "Quick Links"
-   Grid dengan 6 links:
    -   Dashboard
    -   Vehicles
    -   Customers
    -   Orders
    -   Reminders
    -   Reports
-   Setiap link punya icon

**Test Buttons:**

1. Klik **"Back to Dashboard"**

    - Redirect ke dashboard ✓

2. Kembali ke 404 (ketik URL invalid lagi)
3. Klik **"Go Back"**

    - Browser go back (history.back) ✓

4. Klik salah satu Quick Link (misal: Vehicles)
    - Redirect ke halaman Vehicles ✓

**Checklist:**

```
✅ Muncul custom 404 page (bukan Laravel default)?
✅ Icon dan styling pink gradient?
✅ Text "404" besar dan jelas?
✅ Message helpful?
✅ 2 tombol ada dan berfungsi?
✅ Quick Links section ada?
✅ Quick Links clickable dan berfungsi?
✅ Design clean dan modern?
```

---

### 6.2 Testing 403 Page

**Tujuan:** Test halaman Access Denied

**Cara Trigger 403:**

1. **Login sebagai Manager**:

    ```
    Email: manager@rajablindvan.com
    Password: manager123
    ```

2. Di address bar, ketik langsung: `http://127.0.0.1:8000/users`
3. Tekan Enter

**Yang Harus Muncul:**

📌 **Custom 403 Page**

-   Icon shield (purple gradient circle)
-   **Text besar: "403"** (purple gradient)
-   Title: **"Access Denied"**
-   Message: "Maaf, Anda tidak memiliki izin untuk mengakses halaman ini..."
-   2 tombol:
    -   **"Back to Dashboard"** (purple)
    -   **"Go Back"** (outline)

📌 **User Info Box**

-   Ada section "Informasi Akses"
-   Info ditampilkan:
    -   **Anda login sebagai:** Manager (atau nama user)
    -   **Role Anda:** Manager
    -   Message: "Jika Anda merasa ini kesalahan, hubungi administrator"

**Test Buttons:**

1. Klik **"Back to Dashboard"**

    - Redirect ke dashboard ✓

2. Trigger 403 lagi, klik **"Go Back"**
    - Browser go back ✓

**Test dengan Role Lain:**

1. Logout, login sebagai **Operator**
2. Coba akses `/users` lagi
3. Harus muncul 403 juga
4. Info box update dengan role "Operator" ✓

**Checklist:**

```
✅ Trigger 403 berhasil (akses unauthorized route)?
✅ Muncul custom 403 page (bukan Laravel default)?
✅ Icon dan styling purple gradient?
✅ Text "403" besar dan jelas?
✅ Message jelas (Access Denied)?
✅ User info box tampil?
✅ Info menunjukkan current user dan role?
✅ 2 tombol berfungsi?
✅ Design consistent dengan 404 page?
```

---

## 🎨 SECTION 7: UI/UX TESTING

### 7.1 Desktop View

**Cara Test:**

1. Maximize browser window (full screen)
2. Resolusi: 1920x1080 atau 1366x768

**Yang Harus Dicek:**

📌 **Layout**

-   Sidebar lebar cukup (tidak terlalu sempit)
-   Content area lebar cukup (tidak cramped)
-   Tidak ada elemen yang terpotong
-   Tidak ada horizontal scrollbar

📌 **Tables**

-   Table fit dengan baik
-   Semua columns readable
-   Tidak ada text yang overflow
-   Column width proporsional

📌 **Forms**

-   Fields lebar cukup
-   Labels jelas
-   Buttons accessible
-   Spacing comfortable

📌 **Buttons & Icons**

-   Ukuran cukup besar (mudah diklik)
-   Spacing antar buttons cukup
-   Icons clear (tidak terlalu kecil)

**Checklist:**

```
✅ Sidebar width OK?
✅ Content area width OK?
✅ Tables readable?
✅ Forms comfortable?
✅ No horizontal scroll?
✅ No overlapping elements?
```

---

### 7.2 Tablet View

**Cara Test:**

1. **Resize browser:**
    - Width: ~768px (iPad portrait)
    - Atau gunakan DevTools (F12) → Toggle device toolbar → iPad

**Yang Harus Dicek:**

📌 **Sidebar Behavior**

-   Sidebar mungkin auto-collapse (hamburger menu)?
-   Atau tetap visible tapi lebih sempit?
-   Test: Bisa buka/tutup sidebar?

📌 **Content Area**

-   Content menyesuaikan width
-   Tables:
    -   Masih readable, atau
    -   Ada horizontal scroll (acceptable)

📌 **Forms**

-   Fields stack (vertical) atau tetap grid?
-   Masih usable

**Checklist:**

```
✅ Sidebar behavior OK di tablet?
✅ Content adjusts properly?
✅ Tables usable (scroll or fit)?
✅ Forms masih comfortable?
```

---

### 7.3 Mobile View

**Cara Test:**

1. **Resize browser:**
    - Width: ~375px (iPhone size)
    - Atau gunakan DevTools → iPhone 12/13

**Yang Harus Dicek:**

📌 **Sidebar**

-   Harus collapsible (hamburger menu)
-   Atau overlay sidebar (muncul dari kiri)

📌 **Content**

-   Full width (no sidebar visible permanently)
-   Cards/boxes stack vertically

📌 **Tables**

-   Horizontal scroll (expected)
-   Atau cards view (mobile-optimized)

📌 **Forms**

-   Fields full width
-   Stack vertically
-   Touch-friendly:
    -   Input height ≥ 44px (Apple guideline)
    -   Button height ≥ 44px
    -   Spacing cukup

📌 **Text**

-   Font size readable (min 14-16px)
-   Not too small

**Checklist:**

```
✅ Sidebar collapses to hamburger?
✅ Content full width?
✅ Tables scrollable atau responsive?
✅ Forms stack vertically?
✅ Buttons touch-friendly (≥ 44px)?
✅ Text readable (not too small)?
✅ No horizontal overflow (except tables)?
```

---

### 7.4 Animations & Transitions

**Yang Harus Dicek:**

📌 **Login Animation**

-   Van driving animation smooth (60fps)
-   No stuttering
-   Duration ~2 seconds (not too slow)

📌 **Modal Transitions**

-   Modal open: Smooth fade in + scale
-   Modal close: Smooth fade out
-   Overlay (background gelap): Smooth fade

📌 **Page Transitions**

-   Page change smooth (no flash)
-   Loading states (if any)

📌 **Hover Effects**

-   Buttons: Smooth color transition
-   Cards: Smooth shadow/lift effect
-   Icons: Smooth color change

📌 **Performance**

-   No lag
-   No jank (patah-patah)
-   Animations tidak block UI

**Checklist:**

```
✅ Login animation smooth?
✅ Modal open/close smooth?
✅ Page transitions smooth?
✅ Hover effects smooth?
✅ No lag/jank?
✅ Animations tidak terlalu lambat/cepat?
```

---

## 🔒 SECTION 8: SECURITY CHECKS

### 8.1 Unauthenticated Access

**Tujuan:** User yang belum login tidak bisa akses

**Langkah:**

1. **Logout** dari akun apapun (klik Logout)
2. Di address bar, coba akses:
    - `http://127.0.0.1:8000/dashboard`
    - `http://127.0.0.1:8000/customers`
    - `http://127.0.0.1:8000/vehicles`
    - `http://127.0.0.1:8000/users`

**Expected untuk SEMUA URL:**

-   **Redirect** otomatis ke `/login`
-   URL berubah jadi: `http://127.0.0.1:8000/login`
-   TIDAK bisa akses halaman tanpa login

**Checklist:**

```
✅ Semua protected routes redirect ke login?
✅ Tidak bisa bypass authentication?
```

---

### 8.2 Session Management

**Test 1: Session Persists**

1. Login normal (tanpa Remember Me)
2. Buka tab baru, ketik: `http://127.0.0.1:8000/dashboard`
3. Expected: Masih login (session active)

**Test 2: Session Cleared on Logout**

1. Logout
2. Browser back atau ketik dashboard URL
3. Expected: Redirect ke login (session cleared)

**Test 3: Session Timeout (Optional)**

-   Jika ada timeout setting
-   Login, tunggu X menit
-   Expected: Auto logout

**Checklist:**

```
✅ Session active selama login?
✅ Session cleared setelah logout?
✅ Cannot bypass by browser back?
```

---

### 8.3 CSRF Protection

**Cara Test (Advanced):**

1. Buka DevTools (F12)
2. Inspect form (misal: Create Customer)
3. Cari hidden input: `<input type="hidden" name="_token" value="...">`

**Expected:**

-   Semua form POST punya `@csrf` token
-   Form tanpa CSRF → Error 419 (Page Expired)

**Untuk testing biasa:**

-   Selama form berhasil submit → CSRF working ✓

**Checklist:**

```
✅ Forms punya CSRF token?
✅ Forms submit successfully?
```

---

## 🐛 CARA CATAT BUGS

### Template Bug Report

Saat menemukan bug, catat dengan format:

```
**BUG #[number]**
Severity: 🔴 Critical / 🟡 Medium / 🟢 Low

**Description:**
[Jelaskan masalahnya dengan singkat]

**Steps to Reproduce:**
1. [Langkah 1]
2. [Langkah 2]
3. [Langkah 3]

**Expected Result:**
[Apa yang seharusnya terjadi]

**Actual Result:**
[Apa yang benar-benar terjadi]

**Environment:**
- User Role: [Super Admin / Manager / dll]
- Page: [URL atau nama halaman]
- Browser: [Chrome / Firefox / dll]

**Screenshot/Error Message:**
[Jika ada]
```

### Contoh Bug Report

```
**BUG #001**
Severity: 🔴 Critical

**Description:**
Manager bisa akses halaman Users padahal seharusnya tidak boleh

**Steps to Reproduce:**
1. Login sebagai manager@rajablindvan.com
2. Ketik URL: http://127.0.0.1:8000/users
3. Tekan Enter

**Expected Result:**
Harus muncul halaman 403 Access Denied

**Actual Result:**
Halaman Users terbuka normal, bisa lihat list users

**Environment:**
- User Role: Manager
- Page: /users
- Browser: Chrome 120

**Screenshot:**
[Attach screenshot]
```

---

## ✅ TIPS TESTING

### Do's ✅

1. **Test secara sistematis** - Ikuti checklist
2. **Test one thing at a time** - Jangan skip
3. **Catat semua bugs** - Sekecil apapun
4. **Screenshot errors** - Dokumentasi penting
5. **Test dengan data real** - Jangan asal input
6. **Test edge cases** - Input aneh, kosong, dll
7. **Test semua browsers** - Chrome, Firefox, Edge

### Don'ts ❌

1. **Jangan skip test** - Karena "kayaknya OK"
2. **Jangan asumsikan** - Harus test nyata
3. **Jangan test sambil lain** - Focus!
4. **Jangan lupa catat** - Nanti lupa bugnya apa
5. **Jangan malas screenshot** - Bukti penting

---

## 🎯 PRIORITAS TESTING

### Must Test (Priority 1) - 1 jam

1. Authentication (login/logout)
2. RBAC (role access control)
3. Customers CRUD
4. Search functionality
5. Error pages (404, 403)

### Should Test (Priority 2) - 1 jam

6. Orders CRUD
7. Reminders CRUD
8. Pagination
9. Forms validation
10. UI Desktop

### Nice to Test (Priority 3) - 30 menit

11. UI Tablet & Mobile
12. Animations
13. Edge cases
14. Performance

**Total Time: ~2.5 jam untuk thorough testing**

---

## 🎉 SELESAI!

Anda sekarang punya panduan lengkap cara testing!

**Next Steps:**

1. Print atau buka panduan ini
2. Buka TESTING_CHECKLIST.md
3. Mulai testing section by section
4. Centang setiap test yang complete
5. Catat semua bugs
6. Report ke developer untuk fixing

**Good luck! 🚀**

Ingat: **Testing yang baik = Produk yang berkualitas!**
