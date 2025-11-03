# DEPLOYMENT GUIDE - DOMAINESIA HOSTING

## ✅ Pre-Deployment Checklist

### Project Requirements:

-   ✅ Laravel 10 (Compatible with PHP 8.1+)
-   ✅ SQLite Database (Portable, tidak perlu MySQL)
-   ✅ Bootstrap 5 Frontend
-   ✅ Font Awesome Icons
-   ✅ No external dependencies

### Domainesia Requirements:

-   PHP 8.1 or higher
-   Composer installed
-   SSH access (recommended)
-   cPanel access

---

## 📦 Step 1: Persiapan Project

### 1.1 Update Environment Configuration

Buat file `.env.production` untuk production:

```env
APP_NAME="Rajablindvan Fleet Management"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=/path/to/production/database/database.sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Email Configuration (Domainesia SMTP)
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 1.2 Optimize Laravel untuk Production

```bash
# Di local, jalankan commands ini:
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Generate APP_KEY baru untuk production
php artisan key:generate --show
```

### 1.3 Bersihkan File Development

Hapus file-file yang tidak perlu:

```
- cleanup_users.php
- check_users.php
- check_users_updated.php
- tests/
- .git/ (optional, bisa di-exclude saat upload)
```

---

## 🚀 Step 2: Upload ke Domainesia

### Method 1: Via cPanel File Manager (Mudah)

1. **Login ke cPanel Domainesia**

    - URL: https://panel.domainesia.com
    - Masuk dengan kredensial Anda

2. **Compress Project**

    ```bash
    # Di local, compress project (exclude node_modules & .git)
    zip -r rajablindvan.zip . -x "node_modules/*" -x ".git/*" -x "storage/logs/*"
    ```

3. **Upload via File Manager**

    - Buka File Manager di cPanel
    - Navigate ke `public_html` atau folder domain Anda
    - Upload `rajablindvan.zip`
    - Extract file zip

4. **Set Folder Structure**
    ```
    /home/username/
    ├── rajablindvan/          (Laravel project root)
    │   ├── app/
    │   ├── config/
    │   ├── database/
    │   ├── public/            (Laravel public folder)
    │   ├── resources/
    │   ├── routes/
    │   └── vendor/
    └── public_html/           (Web root - point to Laravel public/)
        ├── index.php -> ../rajablindvan/public/index.php
        ├── .htaccess -> ../rajablindvan/public/.htaccess
        └── assets -> ../rajablindvan/public/...
    ```

### Method 2: Via SSH/FTP (Recommended)

```bash
# 1. Upload via FTP/SFTP
# Host: ftp.yourdomain.com atau IP server
# Username: cpanel_username
# Password: cpanel_password
# Port: 21 (FTP) atau 22 (SFTP)

# 2. Connect via SSH
ssh username@yourdomain.com

# 3. Navigate to project
cd ~/rajablindvan

# 4. Install dependencies
composer install --optimize-autoloader --no-dev

# 5. Set permissions
chmod -R 755 storage bootstrap/cache
chmod 644 .env

# 6. Run migrations
php artisan migrate --force
php artisan db:seed --class=SuperAdminSeeder

# 7. Clear & optimize cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## ⚙️ Step 3: Konfigurasi cPanel

### 3.1 Setup PHP Version

1. Buka **MultiPHP Manager** di cPanel
2. Pilih domain Anda
3. Set PHP version ke **8.1** atau **8.2**

### 3.2 Setup Document Root

1. Buka **Domains** atau **Addon Domains**
2. Edit domain Anda
3. Set Document Root ke: `/home/username/rajablindvan/public`

### 3.3 Setup .htaccess (Public Folder)

File: `public/.htaccess`

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Protect .env file
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# Disable directory browsing
Options -Indexes

# PHP Settings (if needed)
<IfModule mod_php7.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value max_execution_time 300
    php_value max_input_time 300
</IfModule>
```

### 3.4 Setup Database SQLite

```bash
# Via SSH
cd ~/rajablindvan/database
touch database.sqlite
chmod 664 database.sqlite

# Update .env
DB_CONNECTION=sqlite
DB_DATABASE=/home/username/rajablindvan/database/database.sqlite
```

### 3.5 Set File Permissions

```bash
# Via SSH
cd ~/rajablindvan
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
chmod 600 .env
```

---

## 🔧 Step 4: Post-Deployment Configuration

### 4.1 Generate APP_KEY

```bash
php artisan key:generate
```

### 4.2 Run Migrations & Seeders

```bash
php artisan migrate --force
php artisan db:seed --class=SuperAdminSeeder
```

### 4.3 Clear All Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Then cache again
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4.4 Setup Cron Jobs (Optional - untuk scheduled tasks)

Di cPanel → Cron Jobs, tambahkan:

```
* * * * * cd /home/username/rajablindvan && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔒 Step 5: Security Hardening

### 5.1 Update .env Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Secure session
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# HTTPS enforcement
FORCE_HTTPS=true
```

### 5.2 Force HTTPS (Optional)

Tambahkan di `public/.htaccess` sebelum RewriteEngine:

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

Atau di `app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    if (config('app.env') === 'production') {
        \URL::forceScheme('https');
    }
}
```

### 5.3 Protect Sensitive Files

Buat file `public/.htaccess` protection:

```apache
# Protect Laravel files
<FilesMatch "^(artisan|composer\.(json|lock)|package\.json|\.env)">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protect storage folder
RedirectMatch 403 ^/storage/
```

---

## 📧 Step 6: Setup Email (SMTP Domainesia)

### 6.1 Buat Email Account di cPanel

1. Buka **Email Accounts** di cPanel
2. Buat email: `noreply@yourdomain.com`
3. Set password

### 6.2 Update .env dengan SMTP Domainesia

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Rajablindvan Fleet"
```

### 6.3 Test Email

```bash
php artisan tinker
>>> Mail::raw('Test email from Rajablindvan', function($msg) {
       $msg->to('admin@rajablindvan.com')->subject('Test');
   });
```

---

## 🎯 Step 7: Testing Production

### 7.1 Test Checklist

-   [ ] Website dapat diakses via domain
-   [ ] Login Administrator berhasil (admin@rajablindvan.com)
-   [ ] Dashboard muncul dengan data
-   [ ] Create vehicle test
-   [ ] Create customer test
-   [ ] Create order test
-   [ ] Upload gambar vehicle test
-   [ ] PDF export test
-   [ ] Email notification test (jika sudah setup)

### 7.2 Common Issues & Solutions

**Issue 1: 500 Internal Server Error**

```bash
# Check error logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear

# Check permissions
chmod -R 775 storage bootstrap/cache
```

**Issue 2: Database connection failed**

```bash
# Check database file exists
ls -la database/database.sqlite

# Check permissions
chmod 664 database/database.sqlite

# Check .env path
DB_DATABASE=/absolute/path/to/database.sqlite
```

**Issue 3: CSS/JS not loading**

```bash
# Check public folder symlink
php artisan storage:link

# Check asset paths in .env
APP_URL=https://yourdomain.com

# Clear view cache
php artisan view:clear
```

**Issue 4: Blank page / White screen**

```bash
# Enable debug temporarily
APP_DEBUG=true

# Check logs
tail -100 storage/logs/laravel.log

# Fix: Usually permission issue
chmod -R 775 storage bootstrap/cache
```

---

## 📊 Step 8: Monitoring & Maintenance

### 8.1 Setup Log Monitoring

```bash
# Via SSH, check logs regularly
tail -f storage/logs/laravel.log

# Or setup logrotate
sudo nano /etc/logrotate.d/laravel
```

### 8.2 Database Backup (SQLite)

```bash
# Manual backup
cp database/database.sqlite database/backups/backup-$(date +%Y%m%d).sqlite

# Via cPanel Backup (recommended)
# cPanel → Backup → Download Home Directory
```

### 8.3 Setup Automatic Backups (cPanel)

1. Buka **Backup** di cPanel
2. Enable automatic backup
3. Set schedule (daily/weekly)
4. Set notification email

---

## 🎉 Final Checklist

Before Go Live:

-   [ ] ✅ PHP 8.1+ installed
-   [ ] ✅ Composer dependencies installed
-   [ ] ✅ .env configured for production
-   [ ] ✅ APP_KEY generated
-   [ ] ✅ Database migrated & seeded
-   [ ] ✅ File permissions set correctly
-   [ ] ✅ Document root points to /public
-   [ ] ✅ HTTPS enabled (SSL Certificate)
-   [ ] ✅ Email SMTP configured
-   [ ] ✅ Caches optimized
-   [ ] ✅ Debug mode OFF (APP_DEBUG=false)
-   [ ] ✅ Error logs working
-   [ ] ✅ Backup strategy in place
-   [ ] ✅ Test all 3 roles (Administrator, Sales, Operation)
-   [ ] ✅ Test all CRUD operations
-   [ ] ✅ Test file uploads
-   [ ] ✅ Test PDF exports

---

## 🆘 Support Domainesia

Jika ada masalah:

-   **Ticket Support**: https://my.domainesia.com/submitticket.php
-   **Live Chat**: https://www.domainesia.com
-   **WhatsApp**: +62 274 5305505
-   **Email**: cs@domainesia.com

---

## 📞 Quick Commands Reference

```bash
# Clear all caches
php artisan optimize:clear

# Optimize for production
php artisan optimize

# View logs
tail -f storage/logs/laravel.log

# Check Laravel version
php artisan --version

# Check routes
php artisan route:list

# Run migrations
php artisan migrate --force

# Create admin user
php artisan db:seed --class=SuperAdminSeeder
```

---

**Project Status**: ✅ READY FOR PRODUCTION DEPLOYMENT

**Last Updated**: October 31, 2025
