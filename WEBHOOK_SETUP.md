# GitHub Webhook Auto-Deploy Setup

**Zero-Touch Deployment!** Push ke GitHub → Otomatis deploy ke production!

## 🎯 Workflow

```
Local PC (You) → GitHub → Webhook → Server → Auto Deploy!
      ↓
   git push
      ↓
  (GitHub detects push)
      ↓
(Sends webhook to server)
      ↓
(Server auto: pull, cache, permissions)
      ↓
    ✅ DONE!
```

**NO cPanel login needed!** 🎉

---

## 📋 Setup (One-time)

### **Step 1: Generate Secret Token**

```bash
# Generate random secret token (run di local atau online)
openssl rand -hex 32
# Output: abc123def456... (copy this!)
```

Atau gunakan online: https://randomkeygen.com/

---

### **Step 2: Configure deploy.php**

Edit `public/deploy.php`, ubah line 15:

```php
// SEBELUM:
define('SECRET_TOKEN', 'CHANGE_THIS_TO_RANDOM_STRING');

// SESUDAH (ganti dengan token dari step 1):
define('SECRET_TOKEN', 'abc123def456...');  // Token Anda
```

---

### **Step 3: Deploy deploy.php ke Server**

```bash
# Commit & push
git add public/deploy.php
git commit -m "feat: Add webhook auto-deploy"
git push origin master

# LAST TIME pull manual di server:
cd ~/rajafleet.khaerulumam.id
git pull origin master
```

---

### **Step 4: Setup GitHub Webhook**

1. **Buka repository:** https://github.com/akangumam/rajablindvan

2. **Settings** → **Webhooks** → **Add webhook**

3. **Isi form:**

    ```
    Payload URL: https://rajafleet.khaerulumam.id/deploy.php
    Content type: application/json
    Secret: [paste token dari Step 1]

    Which events?
    ☑️ Just the push event

    ☑️ Active
    ```

4. **Add webhook** → Selesai!

---

### **Step 5: Test Webhook**

**Option A: Test Manual (Browser)**

```
https://rajafleet.khaerulumam.id/deploy.php?test=manual
```

**Option B: Test via Push**

```bash
# Buat perubahan kecil
echo "# Test webhook" >> README.md
git add README.md
git commit -m "test: Testing webhook deployment"
git push origin master

# ✨ Watch magic happen! Check GitHub webhook logs
```

---

## ✅ Setelah Setup - NEW WORKFLOW

### **❌ Cara Lama:**

```bash
# Local
git push origin master

# cPanel Terminal (Manual!)
cd ~/rajafleet.khaerulumam.id
git pull origin master
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **✅ Cara Baru (FULLY AUTOMATIC!):**

```bash
# Local - HANYA INI!
git push origin master

# ✨ Server otomatis:
#   - git pull
#   - composer install (jika perlu)
#   - config:cache
#   - route:cache
#   - view:cache
#   - fix permissions
#   - Done!
```

**NO cPanel login needed! EVER!** 🎉

---

## 📊 Monitor Deployment

### **Check Webhook Logs (GitHub):**

1. Repository → Settings → Webhooks
2. Klik webhook URL
3. Tab **Recent Deliveries**
4. Lihat status: ✅ Success atau ❌ Failed

### **Check Server Logs:**

```bash
# Via cPanel Terminal (optional)
tail -f ~/rajafleet.khaerulumam.id/storage/logs/deploy.log
```

---

## 🔧 Troubleshooting

### **Webhook Failed (GitHub shows red X):**

1. **Check URL accessible:**

    ```
    curl https://rajafleet.khaerulumam.id/deploy.php?test=manual
    ```

2. **Check secret token match:**

    - GitHub webhook secret = `deploy.php` SECRET_TOKEN

3. **Check file permissions:**
    ```bash
    chmod 644 ~/rajafleet.khaerulumam.id/public/deploy.php
    ```

### **Deployment Success but Changes Not Applied:**

```bash
# Check deploy log
tail -30 ~/rajafleet.khaerulumam.id/storage/logs/deploy.log

# Manual cache clear (one time)
cd ~/rajafleet.khaerulumam.id
php artisan optimize:clear
```

### **Git Pull Failed on Server:**

```bash
# Fix git ownership
cd ~/rajafleet.khaerulumam.id
git config --global --add safe.directory /home/srherba3/rajafleet.khaerulumam.id
```

---

## 🔒 Security Features

-   ✅ **Secret token validation** - GitHub must send correct secret
-   ✅ **Signature verification** - HMAC SHA256
-   ✅ **Branch protection** - Only master branch deployed
-   ✅ **Method validation** - Only POST allowed
-   ✅ **Detailed logging** - All actions logged
-   ✅ **Error handling** - Failed commands stop deployment

---

## 🎯 Benefits

| Feature          | Before                  | After                     |
| ---------------- | ----------------------- | ------------------------- |
| **Deploy steps** | 5 manual                | 1 automatic               |
| **Login cPanel** | Required                | Never!                    |
| **Deploy time**  | 2-3 minutes             | 10-20 seconds             |
| **Consistency**  | Manual (prone to error) | Always same               |
| **Monitoring**   | None                    | GitHub logs + server logs |

---

## 🚀 Advanced: Slack/Discord Notifications (Optional)

Add to `deploy.php` after successful deploy:

```php
// Notify Slack/Discord
function notifyDeploy($status, $pusher, $commits) {
    $webhook = 'YOUR_SLACK_WEBHOOK_URL';
    $data = [
        'text' => "🚀 Deploy {$status} by {$pusher} ({$commits} commits)"
    ];

    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

// Call after deployment
notifyDeploy('SUCCESS', $pusher, $commits);
```

---

## 📚 What's Next?

-   ✅ Push to GitHub → Auto deploy
-   ✅ Monitor via GitHub webhook logs
-   ✅ Check server logs if needed
-   ✅ Focus on coding, not deployment! 🎨

**Happy Coding! 🚀**
