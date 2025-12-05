# Deployment Guide - Auto Logout Feature

## 🚀 Deploy ke Hosting

### **Problem:** Berhasil di lokal, tapi gagal di hosting

### **Root Causes:**

1. ❌ File `auto-logout.js` belum ter-upload
2. ❌ Browser cache masih load file lama
3. ❌ Asset path tidak resolve
4. ❌ HTTPS requirement untuk sendBeacon

---

## ✅ Deployment Checklist

### **Step 1: Verify File Upload**

Pastikan file berikut ter-upload ke hosting:

```
public/
└── js/
    └── auto-logout.js  ← File baru (v2.1.0)

resources/
└── views/
    ├── layouts/
    │   └── drivvo.blade.php  ← Updated
    └── auth/
        └── login.blade.php  ← Updated
```

**Cara Check:**

1. SSH/FTP ke hosting
2. Navigate ke `public/js/`
3. Verify `auto-logout.js` exists
4. Check file size (should be ~9KB)

---

### **Step 2: Clear Browser Cache**

Di browser production:

```
1. Ctrl + Shift + Delete (Chrome/Firefox)
2. Pilih "Cached images and files"
3. Clear data
4. Hard refresh: Ctrl + F5
```

Atau gunakan **Incognito Mode** untuk test tanpa cache.

---

### **Step 3: Add Cache Busting**

Update reference di `drivvo.blade.php`:

```blade
<!-- OLD (might be cached) -->
<script src="{{ asset('js/auto-logout.js') }}"></script>

<!-- NEW (with version parameter) -->
<script src="{{ asset('js/auto-logout.js') }}?v={{ time() }}"></script>
```

Ini force browser untuk load file baru setiap kali.

---

### **Step 4: Check Asset Path di Hosting**

Buka browser console (F12) di hosting, check for errors:

```
Failed to load resource: .../js/auto-logout.js 404 (Not Found)
```

Jika ada error 404:

1. File tidak ter-upload ❌
2. Path salah ❌

**Fix:** Upload file ke `public/js/auto-logout.js`

---

### **Step 5: Verify HTTPS**

`sendBeacon` requires HTTPS di production.

Check URL hosting:

-   ✅ `https://yourdomain.com` - GOOD
-   ❌ `http://yourdomain.com` - BAD

Jika HTTP, enable SSL certificate di hosting.

---

## 🔧 Quick Deploy Commands

### **Via Git (Recommended)**

```bash
# Di local
git add public/js/auto-logout.js
git add resources/views/layouts/drivvo.blade.php
git add resources/views/auth/login.blade.php
git commit -m "Fix auto-logout navigation issue (v2.1.0)"
git push origin main

# Di hosting (SSH)
cd /path/to/your/app
git pull origin main
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### **Via FTP/Upload**

**Files to Upload:**

1. **`public/js/auto-logout.js`** (NEW)

    - Upload to: `public/js/`
    - Make sure overwrite existing file

2. **`resources/views/layouts/drivvo.blade.php`**

    - Upload to: `resources/views/layouts/`
    - Overwrite existing

3. **`resources/views/auth/login.blade.php`**
    - Upload to: `resources/views/auth/`
    - Overwrite existing

---

### **Clear Laravel Cache**

After upload, run these commands via SSH:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

Or via Artisan web interface (if available):

```
https://yourdomain.com/artisan/cache:clear
https://yourdomain.com/artisan/view:clear
```

---

## 🐛 Troubleshooting

### **Issue 1: Still logging out pada navigation**

**Check:**

1. Open browser console (F12)
2. Go to Sources/Debugger tab
3. Open `auto-logout.js`
4. Check version number at top (should be 2.1.0)

**If version is old:**

-   Clear browser cache
-   Hard refresh (Ctrl + F5)
-   Try Incognito mode

---

### **Issue 2: File not found (404)**

**Solution:**

```bash
# Via SSH
cd /path/to/your/app
ls -l public/js/auto-logout.js

# Should show file exists
# If not, upload the file
```

**Or verify via browser:**

```
https://yourdomain.com/js/auto-logout.js
```

Should show JavaScript code, not 404.

---

### **Issue 3: Script not loading**

**Check meta tags di HTML:**

View page source (Ctrl+U) and verify:

```html
<meta name="logout-url" content="/logout" />
<meta name="login-url" content="/login" />
```

And:

```html
<body data-user-authenticated="true"></body>
```

**If missing:**

-   Upload updated `drivvo.blade.php`
-   Clear view cache: `php artisan view:clear`

---

### **Issue 4: sendBeacon blocked**

**Check browser console for errors:**

```
sendBeacon blocked: HTTPS required
```

**Solution:**

-   Enable SSL/HTTPS di hosting
-   Or update logout method untuk fallback

---

## 🧪 Testing di Hosting

### **Test 1: Verify JavaScript Loaded**

```javascript
// Open browser console (F12)
// Type:
console.log("Auth:", document.querySelector("[data-user-authenticated]"));
console.log("Script loaded:", typeof sessionStorage !== "undefined");
```

---

### **Test 2: Check Storage**

```javascript
// After login, check:
console.log("Session Auth:", sessionStorage.getItem("sessionAuth"));
console.log("Tab Count:", localStorage.getItem("activeTabCount"));
console.log("Last Active:", localStorage.getItem("lastActiveTime"));
```

Should show:

-   sessionAuth: "true"
-   activeTabCount: "1" (or higher if multiple tabs)
-   lastActiveTime: timestamp

---

### **Test 3: Test Navigation**

1. Login
2. Click menu "Dashboard"
3. Check console:

```javascript
console.log("Navigating?", sessionStorage.getItem("isNavigating"));
```

Should show timestamp when navigating.

---

### **Test 4: Test Tab Close**

1. Login
2. Note tab count: `localStorage.getItem('activeTabCount')`
3. Close tab
4. Open new tab
5. Should redirect to login ✅

---

## 📦 Complete Upload Package

Create a deployment package with these files:

```
deploy-auto-logout/
├── public/
│   └── js/
│       └── auto-logout.js
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── drivvo.blade.php
│       └── auth/
│           └── login.blade.php
└── UPLOAD_INSTRUCTIONS.txt
```

---

## 🔒 Security Note

If using shared hosting without HTTPS:

**Alternative to sendBeacon:**

Edit `auto-logout.js`, replace `sendLogoutBeacon()`:

```javascript
function sendLogoutBeacon() {
    const logoutUrl =
        document.querySelector('meta[name="logout-url"]')?.content || "/logout";
    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.content || "";

    // Try sendBeacon first
    if (navigator.sendBeacon && window.location.protocol === "https:") {
        const formData = new FormData();
        formData.append("_token", csrfToken);
        navigator.sendBeacon(logoutUrl, formData);
    } else {
        // Fallback for HTTP
        try {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", logoutUrl, false); // Synchronous
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
            xhr.send("_token=" + encodeURIComponent(csrfToken));
        } catch (e) {
            // Ignore errors on unload
        }
    }
}
```

---

## ✅ Verification Checklist

After deployment, verify:

-   [ ] Login works
-   [ ] Click Dashboard menu → stays logged in ✅
-   [ ] Click History menu → stays logged in ✅
-   [ ] Click Reports menu → stays logged in ✅
-   [ ] Refresh page → stays logged in ✅
-   [ ] Close tab → logout ✅
-   [ ] Open new tab → must login again ✅
-   [ ] Normal logout works ✅
-   [ ] No console errors ✅

---

## 📞 Support

If still having issues, check:

1. **Browser Console (F12)** - Any errors?
2. **Network Tab** - Is `auto-logout.js` loading?
3. **Application Tab** - Check localStorage/sessionStorage
4. **Server Logs** - Any PHP errors?

---

**Version:** 2.1.0  
**Last Updated:** 2025-12-03  
**Status:** Production Ready ✅
