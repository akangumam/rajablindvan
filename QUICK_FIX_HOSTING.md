# 🚨 QUICK FIX - Auto Logout di Hosting

## Problem: Berhasil di lokal, gagal di hosting

---

## ✅ SOLUTION 1: Upload File Terbaru (PALING PENTING!)

### Via FTP/cPanel File Manager:

**Upload file ini (HARUS!):**

```
public/js/auto-logout.js  → Upload ke: public/js/
```

**Verify file uploaded:**

1. Buka browser
2. Access: `https://yourdomain.com/js/auto-logout.js`
3. Harus muncul JavaScript code (bukan 404)
4. Check di line 8: harus ada `@version 2.1.0`

---

## ✅ SOLUTION 2: Clear Cache

### Di Browser:

```
1. Ctrl + Shift + Delete
2. Clear "Cached images and files"
3. Ctrl + F5 (hard refresh)
```

### Atau Test di Incognito:

```
Ctrl + Shift + N (Chrome)
Ctrl + Shift + P (Firefox)
```

### Di Server (via SSH or cPanel Terminal):

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## ✅ SOLUTION 3: Verify Files Updated

### Check file `drivvo.blade.php`:

Line harus ada `?v=2.1.0`:

```blade
<script src="{{ asset('js/auto-logout.js') }}?v=2.1.0"></script>
```

### Upload jika belum:

```
resources/views/layouts/drivvo.blade.php → Upload ke: resources/views/layouts/
resources/views/auth/login.blade.php → Upload ke: resources/views/auth/
```

---

## 🧪 Quick Test

### Test 1: File Loaded?

1. Login ke aplikasi
2. F12 (Open DevTools)
3. Console tab
4. Ketik: `sessionStorage.getItem('sessionAuth')`
5. Harus return: `"true"`

### Test 2: Navigation Works?

1. Login
2. Klik menu Dashboard
3. Klik menu History
4. Harus TIDAK logout ✅

---

## 🐛 Masih Gagal?

### Debug di Browser Console (F12):

```javascript
// Check if script loaded
console.log(
    "Auth element:",
    document.querySelector("[data-user-authenticated]")
);

// Check version
fetch("/js/auto-logout.js")
    .then((r) => r.text())
    .then((t) =>
        console.log("Version:", t.includes("2.1.0") ? "2.1.0 ✓" : "OLD!")
    );

// Check storage
console.log({
    sessionAuth: sessionStorage.getItem("sessionAuth"),
    tabCount: localStorage.getItem("activeTabCount"),
    navigating: sessionStorage.getItem("isNavigating"),
});
```

---

## 📋 Files Checklist

Upload file-file ini ke hosting:

-   [ ] `public/js/auto-logout.js` (v2.1.0)
-   [ ] `resources/views/layouts/drivvo.blade.php` (with ?v=2.1.0)
-   [ ] `resources/views/auth/login.blade.php`

Verify:

-   [ ] Clear browser cache
-   [ ] Clear Laravel cache
-   [ ] Test navigation (harus TIDAK logout)
-   [ ] Test tab close (harus logout)

---

## 🎯 Quick Commands

### Clear Everything:

```bash
# Di server
php artisan cache:clear && php artisan view:clear && php artisan config:clear

# Di browser console
localStorage.clear(); sessionStorage.clear(); location.reload();
```

---

## 💡 Common Issues

| Issue                       | Solution                            |
| --------------------------- | ----------------------------------- |
| 404 pada auto-logout.js     | Upload file ke `public/js/`         |
| Masih logout saat klik menu | Clear browser cache + hard refresh  |
| File lama ter-load          | Update `?v=2.1.0` di blade template |
| HTTPS error                 | Pastikan SSL enabled                |

---

## 🆘 Last Resort

Jika semua gagal, coba ini:

```javascript
// Disable auto-logout sementara
// Edit drivvo.blade.php, comment out:
{{-- <script src="{{ asset('js/auto-logout.js') }}?v=2.1.0"></script> --}}

// Upload dulu, test aplikasi normal
// Lalu uncomment dan upload lagi
```

---

**Need Help?** Check `AUTO_LOGOUT_DEPLOYMENT.md` untuk detail lengkap.

**Last Updated:** 2025-12-03 | **Version:** 2.1.0
