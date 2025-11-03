# Git Hooks for Automatic Deployment

Otomatis menjalankan perintah deployment setelah `git pull`.

## 📋 Setup (One-time di Server)

```bash
# 1. Masuk ke project directory
cd ~/rajafleet.khaerulumam.id

# 2. Jalankan setup script
bash .git-hooks/setup-hooks.sh
```

## ✅ Setelah Setup

**Sebelumnya (Manual):**
```bash
cd ~/rajafleet.khaerulumam.id
git pull origin master
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Sekarang (Otomatis):**
```bash
cd ~/rajafleet.khaerulumam.id
git pull origin master
# ✨ Cache otomatis jalan!
```

## 🔧 Yang Otomatis Dijalankan

Setelah `git pull`, hook akan otomatis:

1. ✅ **Check composer.lock** - Jika berubah, run `composer install`
2. ✅ **Clear cache** - config, route, view
3. ✅ **Cache ulang** - config, route, view
4. ✅ **Set permissions** - storage & bootstrap/cache

## 📝 Hook Files

- `.git-hooks/post-merge` - Script yang dijalankan setelah pull/merge
- `.git-hooks/setup-hooks.sh` - Script untuk install hooks
- `.git/hooks/post-merge` - Hook aktif (dibuat oleh setup script)

## 🔄 Update Hook

Jika ada perubahan di `.git-hooks/post-merge`:

```bash
# Re-run setup untuk update
bash .git-hooks/setup-hooks.sh
```

## ⚠️ Troubleshooting

**Hook tidak jalan?**

```bash
# Check apakah hook executable
ls -la .git/hooks/post-merge

# Jika tidak executable, chmod:
chmod +x .git/hooks/post-merge

# Test manual:
.git/hooks/post-merge
```

**Disable hook sementara:**

```bash
# Rename hook
mv .git/hooks/post-merge .git/hooks/post-merge.disabled

# Enable kembali
mv .git/hooks/post-merge.disabled .git/hooks/post-merge
```

## 🎯 Benefits

- ⚡ **Faster deployment** - 1 command instead of 4
- 🎯 **No missed steps** - Semua cache otomatis
- 🚀 **Consistent** - Sama setiap deploy
- 💚 **Developer friendly** - Tinggal git pull!

## 📚 Custom Hooks

Untuk tambah perintah lain, edit `.git-hooks/post-merge`:

```bash
# Contoh: Run migration otomatis
php artisan migrate --force

# Contoh: Restart queue worker
php artisan queue:restart
```

Lalu run `bash .git-hooks/setup-hooks.sh` untuk update.
