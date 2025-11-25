# 🚀 Update Production Server - Raja Blind Van Dashboard

**Last Update:** 25 November 2025, 16:35 WIB  
**Status:** QA Testing Complete - Ready to Deploy  
**New Files Added:** 4 QA documentation files

---

## 📋 What's New in This Update

### QA Documentation Added ✅
- `QA_SUMMARY.md` - Quick testing results summary
- `QA_REPORT_25NOV2025.md` - Full detailed QA report
- `QA_RESULTS_MATRIX.md` - Test results matrix
- `POST_QA_ACTION_ITEMS.md` - Future improvement items

### Files Updated
- Maintenance views consistency improvements

### Testing Summary
- ✅ 45 test cases executed
- ✅ 93.3% pass rate
- ✅ 0 critical bugs
- ✅ Production ready approved

---

## 🔧 How to Update Production Server

### Method 1: Via SSH (Recommended)

#### Step 1: Login ke hosting via SSH
```bash
ssh username@your-hosting-server.com
```

#### Step 2: Navigate ke directory aplikasi
```bash
cd /path/to/rajablindvan/vehicle-dashboard
# Contoh: cd ~/public_html/rajablindvan
# Atau: cd /var/www/html/rajablindvan
```

#### Step 3: Pull update dari GitHub
```bash
git pull origin master
```

#### Step 4: Clear cache Laravel (PENTING!)
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

#### Step 5: Optimize untuk production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Step 6: Update composer dependencies (jika ada perubahan)
```bash
composer install --optimize-autoloader --no-dev
```

#### Step 7: Update permissions (jika diperlukan)
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
# Sesuaikan 'www-data' dengan user web server Anda
```

#### Step 8: Verify
- Buka website di browser
- Test login
- Check semua menu berfungsi

---

### Method 2: Via cPanel File Manager (Alternative)

#### Step 1: Login ke cPanel

#### Step 2: Buka "Git Version Control"
1. Pilih repository: `vehicle-dashboard`
2. Click "Pull or Deploy"
3. Click "Update from Remote"
4. Confirm pull

#### Step 3: Clear cache via cPanel Terminal
- Buka "Terminal" di cPanel
- Jalankan commands:
```bash
cd public_html/rajablindvan  # sesuaikan path
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### Method 3: Manual FTP Upload (Tidak Disarankan)

**Hanya gunakan jika Git tidak tersedia:**

1. Download 4 file QA dari repository:
   - QA_SUMMARY.md
   - QA_REPORT_25NOV2025.md
   - QA_RESULTS_MATRIX.md
   - POST_QA_ACTION_ITEMS.md

2. Upload via FTP ke root directory aplikasi

3. Upload perubahan maintenance views:
   - resources/views/maintenances/create.blade.php
   - resources/views/maintenances/edit.blade.php
   - resources/views/maintenances/index.blade.php

4. Clear cache via hosting control panel terminal

---

## ⚠️ Important Notes

### Before Update
- [ ] Backup database current
- [ ] Backup files current (optional tapi disarankan)
- [ ] Pastikan tidak ada user yang sedang input data penting

### During Update
- [ ] Pilih waktu low traffic (malam/dini hari)
- [ ] Pastikan koneksi internet stabil

### After Update
- [ ] Test login dengan semua role (Admin, Sales, Operation)
- [ ] Test CRUD operations (Create, Read, Update, Delete)
- [ ] Check error logs: `storage/logs/laravel.log`
- [ ] Verify no 500 errors

---

## 🔍 Verification Checklist

Setelah update, verify hal-hal berikut:

### Critical Tests
- [ ] Login berhasil (admin@rajablindvan.com)
- [ ] Dashboard loads tanpa error
- [ ] Customers page loads
- [ ] Vehicles page loads
- [ ] Orders page loads
- [ ] Reminders page loads
- [ ] Logout berfungsi

### RBAC Tests (Quick)
- [ ] Login sebagai Sales - tidak bisa akses Users menu ✅
- [ ] Login sebagai Sales - akses /users dapat 403 ✅

### Error Pages
- [ ] Buka URL yang tidak ada → 404 page muncul
- [ ] Akses unauthorized page → 403 page muncul

---

## 🆘 Troubleshooting

### Issue: "Internal Server Error" setelah pull

**Solution:**
```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Re-cache untuk production
php artisan config:cache
php artisan route:cache
```

### Issue: "Permission denied" errors

**Solution:**
```bash
# Fix permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
```

### Issue: Changes tidak muncul

**Solution:**
```bash
# Hard refresh browser: Ctrl+Shift+R atau Ctrl+F5
# Atau clear cache Laravel:
php artisan view:clear
```

### Issue: Git pull conflicts

**Solution:**
```bash
# Lihat file yang conflict
git status

# Jika yakin ingin override dengan versi GitHub:
git fetch origin
git reset --hard origin/master

# PERINGATAN: ini akan hapus local changes!
```

---

## 📊 What Changed

### Files Added (4 new files)
```
ROOT/
├── POST_QA_ACTION_ITEMS.md     (NEW)
├── QA_REPORT_25NOV2025.md      (NEW)
├── QA_RESULTS_MATRIX.md        (NEW)
└── QA_SUMMARY.md               (NEW)
```

### Files Modified
```
resources/views/maintenances/
├── create.blade.php    (MODIFIED)
├── edit.blade.php      (MODIFIED)
└── index.blade.php     (MODIFIED)
```

### Impact
- **Database:** No changes ✅
- **Configuration:** No changes ✅
- **Dependencies:** No changes ✅
- **Frontend:** Minor maintenance view updates
- **Backend:** No logic changes ✅

**Risk Level:** 🟢 LOW (mostly documentation)

---

## 🎯 Quick Command Reference

### Full Update Sequence (Copy-Paste Ready)
```bash
# 1. Navigate to app directory
cd /path/to/your/rajablindvan

# 2. Pull latest code
git pull origin master

# 3. Clear all cache
php artisan cache:clear && php artisan config:clear && php artisan view:clear && php artisan route:clear

# 4. Optimize for production
php artisan config:cache && php artisan route:cache && php artisan view:cache

# 5. Done! Test the application
```

### Rollback (if needed)
```bash
# Get commit hash before update
git log --oneline -5

# Rollback to previous commit (replace HASH)
git reset --hard HASH
php artisan cache:clear
```

---

## 📞 Support

### Jika Ada Masalah

1. **Check error logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Check web server logs:**
   - Apache: `/var/log/apache2/error.log`
   - Nginx: `/var/log/nginx/error.log`

3. **Enable debug mode (HATI-HATI!):**
   ```bash
   # Di .env file (TEMPORARY, untuk troubleshooting)
   APP_DEBUG=true
   
   # Jangan lupa set kembali ke false setelah selesai!
   APP_DEBUG=false
   ```

4. **Contact developer** dengan info:
   - Error message
   - Screenshot
   - Laravel log file
   - Steps yang sudah dicoba

---

## ✅ Success Criteria

Update dianggap berhasil jika:
- [x] Website bisa diakses
- [x] Login berfungsi
- [x] Semua menu bisa dibuka
- [x] Tidak ada error 500
- [x] CRUD operations working
- [x] QA documents accessible (optional)

---

## 📅 Update History

| Date | Version | Changes | Status |
|------|---------|---------|--------|
| 25 Nov 2025 | v1.1 | Added QA documentation | ✅ Ready |
| - | - | Maintenance views update | ✅ Ready |

---

**Document Last Updated:** 25 November 2025, 16:35 WIB  
**Author:** Development Team  
**Next Update:** After implementing QA recommendations

---

## 🎓 Additional Resources

- **QA Report:** See `QA_REPORT_25NOV2025.md`
- **Quick Summary:** See `QA_SUMMARY.md`
- **Test Matrix:** See `QA_RESULTS_MATRIX.md`
- **Future Improvements:** See `POST_QA_ACTION_ITEMS.md`
- **Deployment Guide:** See `DEPLOYMENT_GUIDE.md`
- **Production Commands:** See `PRODUCTION-UPDATE-COMMANDS.txt`

---

**Good luck with the update! 🚀**
