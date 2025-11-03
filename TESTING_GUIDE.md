# 🧪 Testing Guide - Raja Blind Van Dashboard

## Test Credentials

### 1. Super Administrator

-   Email: `admin@rajablindvan.com`
-   Password: `admin123`
-   Role: `super_admin`
-   Access: Full access to all features

### 2. Administrator

-   Email: `admin2@rajablindvan.com`
-   Password: `admin123`
-   Role: `admin`
-   Access: Can manage users and most features

### 3. Manager

-   Email: `manager@rajablindvan.com`
-   Password: `manager123`
-   Role: `manager`
-   Access: Can manage vehicles, orders, customers (no user management)

### 4. Operator

-   Email: `operator@rajablindvan.com`
-   Password: `operator123`
-   Role: `operator`
-   Access: Can create orders and view data (limited edit)

### 5. Viewer

-   Email: `viewer@rajablindvan.com`
-   Password: `viewer123`
-   Role: `viewer`
-   Access: Read-only access

---

## 📋 Testing Checklist

## 1. Authentication System ✅

### Login Page

-   [ ] Akses `http://127.0.0.1:8000/login`
-   [ ] Form login tampil dengan design modern (purple gradient)
-   [ ] Logo Raja Blind Van tampil
-   [ ] Password toggle (show/hide) berfungsi
-   [ ] Remember me checkbox ada

### Login Process

-   [ ] Login dengan **super_admin** - berhasil
-   [ ] Loading animation (van driving) muncul setelah klik login
-   [ ] Redirect ke dashboard setelah login
-   [ ] Welcome message "Welcome back, [Name]!" tampil

### User Info Bar

-   [ ] Avatar dengan initial user tampil di atas sidebar
-   [ ] Nama dan email user tampil
-   [ ] Role badge tampil dengan warna yang benar:
    -   Super Admin: Purple gradient
    -   Admin: Pink gradient
    -   Manager: Blue gradient
    -   Operator: Green gradient
    -   Viewer: Orange gradient

### Logout

-   [ ] Klik tombol Logout di sidebar
-   [ ] Modal konfirmasi muncul dengan message "Apakah Anda yakin ingin keluar?"
-   [ ] Tombol "Batal" - menutup modal tanpa logout
-   [ ] Tombol "Ya, Logout" - berhasil logout dan redirect ke login page

---

## 2. Role-Based Access Control (RBAC) ✅

### Super Admin Access

-   [ ] Login sebagai super_admin
-   [ ] Menu "Users" **VISIBLE** di sidebar
-   [ ] Bisa akses `/users` route - success
-   [ ] Bisa create, edit, delete users
-   [ ] Bisa akses semua menu lainnya

### Admin Access

-   [ ] Login sebagai admin
-   [ ] Menu "Users" **VISIBLE** di sidebar
-   [ ] Bisa akses `/users` route - success
-   [ ] Bisa create, edit, delete users
-   [ ] Bisa akses semua menu lainnya

### Manager Access

-   [ ] Login sebagai manager
-   [ ] Menu "Users" **NOT VISIBLE** di sidebar
-   [ ] Akses langsung ke `/users` - **403 Forbidden** (should be blocked)
-   [ ] Bisa akses Vehicles, Customers, Orders, Reminders

### Operator Access

-   [ ] Login sebagai operator
-   [ ] Menu "Users" **NOT VISIBLE**
-   [ ] Akses langsung ke `/users` - **403 Forbidden**
-   [ ] Bisa akses Orders, Customers (limited)

### Viewer Access

-   [ ] Login sebagai viewer
-   [ ] Menu "Users" **NOT VISIBLE**
-   [ ] Akses langsung ke `/users` - **403 Forbidden**
-   [ ] Hanya bisa view data (no create/edit/delete buttons?)

---

## 3. Customers Module 🏢

### Index Page

-   [ ] Akses `/customers`
-   [ ] Search bar tampil di atas tabel
-   [ ] Table headers: #, Company Name, Company Address, PIC Name, Contact Number, Active, Actions
-   [ ] Data customers tampil dengan benar
-   [ ] Custom pagination tampil di bawah (Showing X to Y of Z results)

### Search Function

-   [ ] Search by company name - hasil benar
-   [ ] Search by PIC name - hasil benar
-   [ ] Search by contact number - hasil benar
-   [ ] Clear search button (X) - kembali ke semua data

### Create Customer

-   [ ] Klik "ADD NEW" button
-   [ ] Form create tampil dengan 4 fields:
    -   Company Name \*
    -   Company Address \*
    -   PIC Name \*
    -   Contact Number \*
-   [ ] All fields required - validation error muncul jika kosong
-   [ ] Submit form - customer berhasil dibuat
-   [ ] Redirect ke index dengan success message

### Edit Customer

-   [ ] Klik icon edit (pencil) di action column
-   [ ] Form edit tampil dengan data ter-populate
-   [ ] Update data - berhasil
-   [ ] Redirect ke index dengan success message

### Delete Customer

-   [ ] Klik icon delete (trash)
-   [ ] Confirmation dialog muncul
-   [ ] Konfirmasi delete - customer berhasil dihapus
-   [ ] Success message tampil

---

## 4. Orders Module 📦

### Index Page

-   [ ] Akses `/orders`
-   [ ] Search bar tampil
-   [ ] Data orders tampil dengan vehicle dan customer info
-   [ ] Custom pagination berfungsi

### Search Function

-   [ ] Search by vehicle name - hasil benar
-   [ ] Search by license plate - hasil benar
-   [ ] Search by customer name - hasil benar
-   [ ] Clear search berfungsi

### Create Order

-   [ ] Klik "ADD NEW"
-   [ ] Form tampil dengan semua fields
-   [ ] Dropdown vehicle dan customer ter-load
-   [ ] Submit - order berhasil dibuat

### Edit Order

-   [ ] Edit button berfungsi
-   [ ] Data ter-populate
-   [ ] Update berhasil

### Delete Order

-   [ ] Delete dengan confirmation
-   [ ] Berhasil dihapus

---

## 5. Reminders Module 🔔

### Index Page

-   [ ] Akses `/reminders`
-   [ ] Vehicle selector dropdown tampil
-   [ ] Pilih vehicle - reminders untuk vehicle tersebut tampil
-   [ ] Search bar berfungsi
-   [ ] Custom pagination berfungsi

### Search Function

-   [ ] Search by title
-   [ ] Search by category
-   [ ] Search by notes
-   [ ] Clear search

### Create Reminder

-   [ ] Klik "ADD NEW" (setelah pilih vehicle)
-   [ ] Form tampil dengan fields lengkap:
    -   Title \*
    -   Category \*
    -   Due Date \*
    -   Due Odometer
    -   Alert Days Before
    -   Estimated Cost
    -   Recurring Interval
    -   Description
    -   Notes
-   [ ] Submit - reminder berhasil dibuat
-   [ ] Redirect dengan success message

### Edit Reminder

-   [ ] Klik edit button
-   [ ] Form tampil dengan data ter-populate
-   [ ] Checkbox "Mark as Completed" ada
-   [ ] Update berhasil
-   [ ] Status badge berubah jika di-mark completed

### Delete Reminder

-   [ ] Delete dengan confirmation
-   [ ] Berhasil dihapus dengan success message

---

## 6. Dashboard 📊

### Main Dashboard

-   [ ] Akses `/dashboard`
-   [ ] Statistik cards tampil (vehicles, customers, orders, dll)
-   [ ] Grafik/chart tampil dengan benar
-   [ ] Recent activities tampil
-   [ ] Responsive di mobile

---

## 7. Reports 📈

### Reports Index

-   [ ] Akses `/reports`
-   [ ] Filter options tampil
-   [ ] Generate report berfungsi

### PDF Export

-   [ ] Download PDF berhasil
-   [ ] Format PDF rapi dan readable

### Excel Export

-   [ ] Download Excel berhasil
-   [ ] Data lengkap di Excel

---

## 8. UI/UX Testing 🎨

### Responsive Design

-   [ ] Desktop view - layout rapi
-   [ ] Tablet view - layout menyesuaikan
-   [ ] Mobile view - sidebar collapsible

### Loading & Animations

-   [ ] Loading animation (van) smooth
-   [ ] Page transitions smooth
-   [ ] No lag atau freeze

### Forms

-   [ ] All input fields accessible
-   [ ] Error messages jelas
-   [ ] Success messages tampil
-   [ ] Form validation bekerja

### Navigation

-   [ ] Sidebar menu berfungsi
-   [ ] Active menu highlighted
-   [ ] Breadcrumbs (jika ada) benar

---

## 9. Error Handling ⚠️

### Invalid Routes

-   [ ] Akses route tidak ada - 404 page (perlu dibuat custom?)
-   [ ] Akses route tanpa permission - 403 page (perlu dibuat custom?)

### Form Errors

-   [ ] Validation errors tampil dengan jelas
-   [ ] Error tidak crash aplikasi

### Database Errors

-   [ ] Foreign key constraint - handled dengan baik
-   [ ] Duplicate entry - error message jelas

---

## 10. Security Testing 🔒

### Authentication

-   [ ] Tidak bisa akses halaman tanpa login - redirect ke /login
-   [ ] Session management berfungsi
-   [ ] Remember me berfungsi
-   [ ] Logout membersihkan session

### Authorization

-   [ ] Role middleware berfungsi
-   [ ] User tidak bisa akses route di luar permission
-   [ ] Direct URL access blocked untuk unauthorized user

### CSRF Protection

-   [ ] Form tanpa @csrf - error
-   [ ] Form dengan @csrf - berhasil

---

## 🐛 Bugs Found

### Critical Bugs

(Akan diisi saat testing)

### Minor Bugs

(Akan diisi saat testing)

### UI Issues

(Akan diisi saat testing)

---

## ✅ Testing Summary

**Testing Date:** [Tanggal Testing]
**Tester:** [Nama Tester]
**Environment:** Local Development (http://127.0.0.1:8000)

### Overall Status

-   [ ] All Critical Features Working
-   [ ] Minor Bugs Documented
-   [ ] Ready for Production

### Next Steps

1. Fix critical bugs
2. Fix minor bugs
3. Create custom error pages (403, 404)
4. Final testing round
5. Deploy to production

---

## 📝 Notes

(Catatan tambahan selama testing)
