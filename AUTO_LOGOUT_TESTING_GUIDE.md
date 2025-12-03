# Auto Logout Feature - Quick Testing Guide

## Fitur yang Diimplementasikan

✅ **Auto-logout ketika semua tab browser ditutup**

-   User harus login ulang saat membuka tab baru setelah menutup semua tab

## Test Scenarios

### ✅ Test 1: Tab Close (Main Feature)

**Langkah:**

1. Login ke aplikasi di Chrome/Firefox
2. Pastikan dashboard terbuka dan berfungsi normal
3. Tutup tab (klik tombol X pada tab)
4. Buka tab baru
5. Akses aplikasi dengan URL yang sama

**Expected Result:**

-   ✅ Otomatis redirect ke halaman login
-   ✅ Harus login ulang untuk akses dashboard

---

### ✅ Test 2: Page Refresh (Should NOT Logout)

**Langkah:**

1. Login ke aplikasi
2. Refresh halaman dengan F5 atau Ctrl+R
3. Atau klik link navigasi internal

**Expected Result:**

-   ✅ Tetap login
-   ✅ Tidak redirect ke login
-   ✅ Dashboard masih accessible

---

### ✅ Test 3: Normal Logout

**Langkah:**

1. Login ke aplikasi
2. Klik tombol "Logout" di sidebar
3. Konfirmasi logout
4. Coba klik browser Back button

**Expected Result:**

-   ✅ Redirect ke halaman login
-   ✅ Cannot access dashboard dengan back button
-   ✅ LocalStorage cleared

---

### ✅ Test 4: Browser Close & Reopen

**Langkah:**

1. Login ke aplikasi
2. Tutup browser completely (semua window)
3. Buka browser lagi
4. Akses aplikasi

**Expected Result:**

-   ✅ Harus login ulang
-   ✅ Session cleared

---

### ⚠️ Test 5: Multiple Tabs (Known Behavior)

**Langkah:**

1. Login di Tab A
2. Buka Tab B (tab baru dengan Ctrl+T)
3. Akses aplikasi di Tab B

**Expected Result:**

-   ⚠️ **Tab B akan diminta login ulang** (ini by design)
-   Alasan: `sessionStorage` tidak shared antara tab
-   Setiap tab = session baru

**Workaround jika ini tidak diinginkan:**

-   Gunakan fitur "Duplicate Tab" atau buka link di tab baru dari aplikasi

---

## Troubleshooting

### Issue: Harus login terlalu sering

**Solusi:**

1. Check browser console (F12) untuk error
2. Pastikan JavaScript enabled
3. Clear browser cache & cookies
4. Test di Incognito mode

### Issue: Tidak auto-logout setelah tab ditutup

**Solusi:**

1. Pastikan file `public/js/auto-logout.js` exists
2. Check browser console untuk error loading script
3. Verify CSRF token valid
4. Check logout route accessible

### Issue: Stuck di halaman login

**Solusi:**

1. Clear localStorage: Buka DevTools (F12) → Application → Local Storage → Clear All
2. Clear sessionStorage juga
3. Refresh halaman login

---

## Developer Testing Checklist

-   [ ] Login works correctly
-   [ ] Tab close triggers logout
-   [ ] Page refresh maintains session
-   [ ] Normal logout works
-   [ ] Browser restart clears session
-   [ ] Cannot access dashboard after logout
-   [ ] Back button blocked after logout
-   [ ] localStorage cleaned on logout
-   [ ] sessionStorage works properly
-   [ ] CSRF token validated

---

## Technical Details

### Files Modified:

1. `resources/views/layouts/drivvo.blade.php`

    - Added meta tags for logout/login URLs
    - Added data attribute for auth status
    - Added script tag for auto-logout.js

2. `resources/views/auth/login.blade.php`

    - Added localStorage cleanup on load
    - Set flag on login submit

3. `public/js/auto-logout.js` (NEW)
    - Main auto-logout logic
    - Tab counting
    - Session management

### Browser Storage Used:

-   **sessionStorage:** Per-tab authentication flag
-   **localStorage:** Cross-tab coordination (tab count, last active time)

### API Used:

-   `navigator.sendBeacon()` - Reliable logout request on tab close
-   Storage Events - Cross-tab communication
-   `beforeunload` Event - Tab close detection

---

## Quick Debug Commands

### Check localStorage:

```javascript
// In browser console
console.log("Tab Count:", localStorage.getItem("activeTabCount"));
console.log("Last Active:", localStorage.getItem("lastActiveTime"));
console.log("Session Auth:", sessionStorage.getItem("sessionAuth"));
```

### Manual Cleanup:

```javascript
// In browser console
localStorage.clear();
sessionStorage.clear();
location.reload();
```

### Force Logout:

```javascript
// In browser console
localStorage.setItem("manualLogout", "true");
```

---

## Production Deployment

Before deploying to production:

1. ✅ Test on multiple browsers (Chrome, Firefox, Edge, Safari)
2. ✅ Test on mobile devices
3. ✅ Verify HTTPS working (sendBeacon requires HTTPS in production)
4. ✅ Monitor server logs for logout requests
5. ✅ Inform users about the new behavior

---

**Created:** 2025-12-03  
**Version:** 2.0.0 (Simplified)
