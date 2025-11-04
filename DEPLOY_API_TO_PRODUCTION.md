# Deploy Laravel API to Production Server

## Server: rajafleet.khaerulumam.id

### 1. SSH ke Server Production

```bash
ssh user@rajafleet.khaerulumam.id
```

### 2. Navigate ke Project Directory

```bash
cd /path/to/vehicle-dashboard
# atau
cd /home/username/public_html/vehicle-dashboard
```

### 3. Pull Latest Changes dari GitHub

```bash
git pull origin master
```

### 4. Install/Update Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

### 5. Install Laravel Sanctum (jika belum)

```bash
composer require laravel/sanctum
```

### 6. Publish Sanctum Config

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 7. Run Migration untuk Personal Access Tokens Table

```bash
php artisan migrate
```

### 8. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 9. Optimize untuk Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 10. Set Correct Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 11. Update .env Production

Pastikan `.env` di production punya setting ini:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rajafleet.khaerulumam.id

# Database production settings
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_production_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Sanctum
SANCTUM_STATEFUL_DOMAINS=rajafleet.khaerulumam.id
SESSION_DOMAIN=.khaerulumam.id
```

### 12. Verify API Routes Loaded

```bash
php artisan route:list --path=api
```

Harus muncul:

```
POST   api/v1/login
GET    api/v1/me
GET    api/v1/dashboard
GET    api/v1/dashboard/monthly-revenue
GET    api/v1/vehicles
GET    api/v1/vehicles/{id}
...dst
```

### 13. Test API via cURL

```bash
# Test dari server
curl -X GET https://rajafleet.khaerulumam.id/api/v1/test -H "Accept: application/json"

# Test login
curl -X POST https://rajafleet.khaerulumam.id/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@rajablindvan.com","password":"password"}'
```

---

## Troubleshooting

### Issue 1: 404 Not Found pada /api/v1/\*

**Penyebab:** Routes belum di-load atau cache lama

**Solusi:**

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan route:cache
```

### Issue 2: CORS Error dari Flutter

**Penyebab:** Laravel belum allow cross-origin requests

**Solusi:** Edit `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'], // atau specify domain Flutter
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### Issue 3: Sanctum Token Tidak Valid

**Penyebab:** Migration belum jalan atau User model belum update

**Solusi:**

```bash
# Check migration
php artisan migrate:status

# Check User model punya HasApiTokens trait
grep -n "HasApiTokens" app/Models/User.php
```

### Issue 4: 500 Internal Server Error

**Penyebab:** Permission atau config error

**Solusi:**

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Set correct permissions
chmod -R 755 storage
chown -R www-data:www-data storage
```

---

## Quick Deploy Script

Buat file `deploy_api.sh`:

```bash
#!/bin/bash
echo "🚀 Deploying API to Production..."

# Pull latest code
git pull origin master

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache

# Fix permissions
chmod -R 755 storage bootstrap/cache

echo "✅ Deployment complete!"
echo "📋 Verifying routes..."
php artisan route:list --path=api
```

Jalankan:

```bash
chmod +x deploy_api.sh
./deploy_api.sh
```

---

## API Testing URLs (Production)

```
Base URL: https://rajafleet.khaerulumam.id/api/v1

POST   /login
GET    /me
GET    /dashboard
GET    /dashboard/monthly-revenue
GET    /vehicles
GET    /vehicles/{id}
GET    /vehicles/{id}/rentals
GET    /vehicles/{id}/maintenances
GET    /rentals
GET    /rentals/active
GET    /rentals/{id}
POST   /logout
```

---

## Notes

-   Jangan lupa backup database sebelum migrate
-   Test di development dulu sebelum deploy production
-   Monitor `storage/logs/laravel.log` untuk error
-   Pastikan `bootstrap/app.php` sudah include API routes registration
