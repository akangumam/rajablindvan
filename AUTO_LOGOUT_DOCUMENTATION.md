# Auto Logout on Tab Close - Documentation

## Overview

Fitur auto-logout telah diimplementasikan untuk meningkatkan keamanan aplikasi. Ketika user menutup tab browser, mereka akan otomatis ter-logout dan harus login kembali ketika membuka aplikasi di tab baru.

## Cara Kerja

### 1. **Session Tracking dengan sessionStorage**

-   Setiap tab memiliki `sessionStorage` yang independen
-   Saat user login, aplikasi menyimpan flag `userAuthenticated` di `sessionStorage`
-   Saat tab baru dibuka, jika tidak ada flag ini, user dianggap logout

### 2. **Multi-Tab Management dengan localStorage**

-   `localStorage` digunakan untuk komunikasi antar tab
-   Flag `shouldBeLoggedIn` melacak apakah user seharusnya login
-   Saat semua tab ditutup, flag ini di-clear

### 3. **Event Listeners**

#### `pagehide` Event

```javascript
window.addEventListener("pagehide", function (e) {
    if (!e.persisted) {
        // Kirim logout request dengan sendBeacon
        navigator.sendBeacon("/logout", formData);
    }
});
```

-   Mendeteksi saat halaman benar-benar ditutup
-   Menggunakan `navigator.sendBeacon()` untuk kirim request logout yang reliable

#### `beforeunload` Event

```javascript
window.addEventListener("beforeunload", function (e) {
    // Track tab yang sedang closing
    closingTabs[tabId] = Date.now();
});
```

-   Menandai tab yang sedang dalam proses closing
-   Membedakan antara refresh dan close

#### `storage` Event

```javascript
window.addEventListener("storage", function (e) {
    if (e.key === "forceLogout" && e.newValue === "true") {
        window.location.href = "/login";
    }
});
```

-   Sinkronisasi logout antar tab
-   Jika satu tab logout, semua tab lain juga logout

### 4. **Tab ID Tracking**

Setiap tab memiliki unique ID yang disimpan di `sessionStorage`:

```javascript
const tabId = sessionStorage.getItem("tabId") || Date.now().toString();
sessionStorage.setItem("tabId", tabId);
```

## Skenario Penggunaan

### ✅ Skenario 1: User menutup tab

1. User login di tab A
2. User menutup tab A
3. Event `pagehide` triggered → logout request dikirim
4. User membuka tab baru → redirect ke login

### ✅ Skenario 2: User refresh halaman

1. User login di tab A
2. User refresh (F5 atau Ctrl+R)
3. `beforeunload` triggered tapi `load` event juga triggered
4. Tab ID di-clear dari `closingTabs`
5. User tetap login ✓

### ✅ Skenario 3: Multi-tab

1. User login di tab A dan B
2. User menutup tab A
3. Tab B tetap login
4. `shouldBeLoggedIn` masih `true` karena tab B aktif
5. User menutup tab B
6. Logout request dikirim
7. User buka tab baru → harus login

### ✅ Skenario 4: Normal logout

1. User klik logout button
2. `localStorage.setItem('shouldBeLoggedIn', 'false')`
3. `sessionStorage.clear()`
4. Logout form submitted
5. Redirect ke login page

### ✅ Skenario 5: Browser crash atau force close

1. Browser crash/force quit
2. `pagehide` event triggered (jika sempat)
3. sessionStorage otomatis cleared by browser
4. User buka browser lagi → harus login

## File yang Dimodifikasi

### 1. `resources/views/layouts/drivvo.blade.php`

**Perubahan:**

-   Menambahkan script auto-logout di bagian bawah layout
-   Update fungsi `confirmLogout()` untuk clear localStorage
-   Implementasi tab tracking dan event listeners

**Lokasi:** Baris 1224-1358

### 2. `resources/views/auth/login.blade.php`

**Perubahan:**

-   Clear localStorage saat halaman login dibuka
-   Set flag `shouldBeLoggedIn` saat form login disubmit

**Lokasi:** Baris 438-454

## Testing

### Manual Testing Steps:

#### Test 1: Tab Close

1. Login ke aplikasi
2. Tutup tab (klik X)
3. Buka tab baru
4. Akses aplikasi
5. **Expected:** Redirect ke halaman login

#### Test 2: Page Refresh

1. Login ke aplikasi
2. Refresh halaman (F5)
3. **Expected:** Tetap login, tidak redirect

#### Test 3: Multi-Tab

1. Login di tab A
2. Buka tab baru B (Ctrl+T) → akses aplikasi
3. **Expected:** Harus login lagi di tab B (karena sessionStorage berbeda)
4. Login di tab B
5. Tutup tab A
6. **Expected:** Tab B tetap login
7. Tutup tab B
8. Buka tab baru C
9. **Expected:** Harus login lagi

#### Test 4: Normal Logout

1. Login ke aplikasi
2. Klik tombol Logout
3. Konfirmasi logout
4. **Expected:** Redirect ke login
5. Klik Back button browser
6. **Expected:** Redirect ke login (tidak bisa kembali)

#### Test 5: Browser Back Button

1. Login ke aplikasi
2. Tutup tab
3. Buka tab baru
4. Akses aplikasi → redirect ke login
5. Login lagi
6. **Expected:** Login berhasil, masuk dashboard

## Browser Compatibility

| Browser       | Support    | Notes                            |
| ------------- | ---------- | -------------------------------- |
| Chrome 90+    | ✅ Full    | Semua features work              |
| Firefox 88+   | ✅ Full    | Semua features work              |
| Safari 14+    | ✅ Full    | `pagehide` well supported        |
| Edge 90+      | ✅ Full    | Chromium-based, full support     |
| Mobile Chrome | ✅ Full    | Works on mobile                  |
| Mobile Safari | ⚠️ Partial | Background tab behavior may vary |

## API yang Digunakan

### Navigator.sendBeacon()

```javascript
navigator.sendBeacon(url, data);
```

-   Mengirim POST request yang reliable saat page unload
-   Tidak blocking UI
-   Request tetap dikirim meskipun page sudah closing

### sessionStorage

```javascript
sessionStorage.setItem(key, value);
sessionStorage.getItem(key);
sessionStorage.clear();
```

-   Storage yang per-tab/per-window
-   Otomatis cleared saat tab ditutup
-   Tidak shared antar tab

### localStorage

```javascript
localStorage.setItem(key, value);
localStorage.getItem(key);
localStorage.removeItem(key);
```

-   Storage yang shared antar tab
-   Persisten sampai di-clear manual
-   Digunakan untuk koordinasi antar tab

## Security Considerations

### ✅ Keamanan yang Ditingkatkan:

1. **Prevents Session Hijacking:** Session otomatis expired saat tab ditutup
2. **No Persistent Sessions:** Tidak ada session yang persist setelah browser ditutup
3. **Multi-Device Safety:** Device lain tidak affected

### ⚠️ Perhatian:

1. **Shared Computer:** Jika beberapa user pakai komputer yang sama, pastikan selalu close tab
2. **Remember Me:** Fitur "Remember Me" di login masih work, tapi user tetap harus login setiap buka tab baru
3. **Session Timeout:** Combine dengan server-side session timeout untuk keamanan maksimal

## Troubleshooting

### Issue: User harus login terlalu sering

**Penyebab:** Script terlalu aggressive
**Solusi:** Adjust `shouldBeLoggedIn` logic untuk allow multi-tab

### Issue: Logout tidak triggered saat tab close

**Penyebab:** Browser tidak support `pagehide` atau blocked sendBeacon
**Solusi:** Check browser console, ensure logout endpoint accessible

### Issue: User stuck di login loop

**Penyebab:** localStorage corruption
**Solusi:** Clear browser data atau tambahkan reset button

## Future Improvements

1. **Grace Period:** Tambahkan grace period 30 detik sebelum force logout
2. **Session Warning:** Tampilkan warning "Session akan berakhir" sebelum logout
3. **Remember Me Enhancement:** Improve "Remember Me" untuk allow persistent session dengan option
4. **Activity Tracking:** Track user activity untuk auto-extend session
5. **Notification:** Kirim notification saat session akan expire

## Configuration

Untuk customize behavior, edit bagian ini di `drivvo.blade.php`:

```javascript
// Cleanup interval (default: 10 seconds)
setInterval(function() { ... }, 10000);

// Tab closing grace period (default: 5 seconds)
if (now - closingTabs[id] > 5000) { ... }
```

## Support

Jika ada masalah atau pertanyaan terkait fitur ini:

1. Check browser console untuk error messages
2. Test di incognito mode
3. Clear browser cache dan cookies
4. Verify CSRF token valid

---

**Created:** 2025-12-03  
**Last Updated:** 2025-12-03  
**Version:** 1.0.0
