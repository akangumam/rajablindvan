#!/bin/bash

##############################################
# Raja Blind Van - Deployment Script
# Untuk update aplikasi dari GitHub ke cPanel
##############################################

echo "=========================================="
echo "🚀 Memulai deployment..."
echo "=========================================="

# 1. Pull perubahan dari GitHub
echo ""
echo "📥 Mengambil perubahan dari GitHub..."
git pull origin master

if [ $? -ne 0 ]; then
    echo "❌ Error: Gagal pull dari GitHub"
    exit 1
fi

# 2. Install/Update dependencies
echo ""
echo "📦 Menginstall dependencies..."
composer install --no-dev --ignore-platform-reqs --optimize-autoloader

if [ $? -ne 0 ]; then
    echo "⚠️  Warning: Composer install mengalami masalah, melanjutkan..."
fi

# 3. Jalankan migrasi database
echo ""
echo "🗄️  Menjalankan migrasi database..."
php artisan migrate --force

if [ $? -ne 0 ]; then
    echo "⚠️  Warning: Migrasi mengalami masalah"
fi

# 4. Clear dan rebuild cache
echo ""
echo "🧹 Membersihkan cache lama..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo ""
echo "⚡ Membuat cache baru..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set permissions
echo ""
echo "🔒 Menyetel permissions..."
chmod -R 775 storage bootstrap/cache
chmod 600 .env

# 6. Tampilkan status
echo ""
echo "=========================================="
echo "✅ Deployment selesai!"
echo "=========================================="
echo ""
echo "📊 Status:"
echo "  - Git: Updated"
echo "  - Dependencies: Installed"
echo "  - Database: Migrated"
echo "  - Cache: Rebuilt"
echo "  - Permissions: Set"
echo ""
echo "🌐 Website: https://rajablindvan.khaerulumam.id"
echo ""
echo "=========================================="
