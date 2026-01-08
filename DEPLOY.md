# 🚀 OFYS Deployment Guide

> **Quick deployment script for cPanel production server**

---

## 📋 Prerequisites

Before deploying, make sure:
- ✅ All changes are committed and pushed to GitHub
- ✅ You have SSH/Terminal access to cPanel
- ✅ Production `.env` file is configured correctly

---

## 🔧 One-Time Setup (Do This Once)

### 1. Upload the Deployment Script

After pulling code for the first time, make the script executable:

```bash
cd ~/public_html/ofys
chmod +x deploy.sh
```

### 2. Verify Script Exists

```bash
ls -la deploy.sh
```

You should see: `-rwxr-xr-x` (executable permissions)

---

## 🎯 How to Deploy (Every Time You Have Updates)

### Step 1: Navigate to Project Directory
```bash
cd ~/public_html/ofys
```

### Step 2: Pull Latest Code from GitHub
```bash
git pull origin main
```

Expected output:
```
From https://github.com/your-repo/ofys
 * branch            main       -> FETCH_HEAD
Updating abc1234..def5678
Fast-forward
 app/Http/Controllers/Customer/PaymentController.php | 10 +++++-----
 2 files changed, 5 insertions(+), 5 deletions(-)
```

### Step 3: Run Deployment Script
```bash
bash deploy.sh
```

or simply:

```bash
./deploy.sh
```

---

## 📊 What the Script Does

The `deploy.sh` script will:

1. **Install Dependencies** 🔧
   - Runs: `composer install --no-dev --optimize-autoloader`
   - Installs production-ready PHP packages

2. **Clear Config Cache** 🧹
   - Runs: `php artisan config:clear`
   - Removes old configuration cache

3. **Cache Config** ⚙️
   - Runs: `php artisan config:cache`
   - Caches configuration for performance

4. **Cache Routes** 🛣️
   - Runs: `php artisan route:cache`
   - Caches all routes for faster routing

5. **Cache Views** 👁️
   - Runs: `php artisan view:cache`
   - Pre-compiles Blade templates

6. **Set Permissions** 🔐
   - Runs: `chmod -R 755 storage bootstrap/cache`
   - Ensures proper file permissions

Each step shows:
- ✅ **Green checkmark** = Success
- ❌ **Red X** = Failed (script stops)
- ℹ️ **Yellow info** = Information

---

## 📺 Example Output

```bash
========================================
🚀 OFYS DEPLOYMENT STARTED
========================================

Started at: 2025-12-12 10:30:45

========================================
📦 STEP 1: Installing Composer Dependencies
========================================

Installing dependencies from lock file
Package operations: 0 installs, 0 updates, 0 removals
Generating optimized autoload files
✓ Composer dependencies installed successfully

========================================
🧹 STEP 2: Clearing Configuration Cache
========================================

Configuration cache cleared successfully.
✓ Configuration cache cleared

========================================
⚙️  STEP 3: Caching Configuration
========================================

Configuration cached successfully.
✓ Configuration cached successfully

========================================
🛣️  STEP 4: Caching Routes
========================================

Routes cached successfully.
✓ Routes cached successfully

========================================
👁️  STEP 5: Caching Views
========================================

Blade templates cached successfully.
✓ Views cached successfully

========================================
🔐 STEP 6: Setting Directory Permissions
========================================

✓ Permissions set successfully (755)

========================================
✅ DEPLOYMENT COMPLETED SUCCESSFULLY
========================================

Finished at: 2025-12-12 10:31:12

🎉 Your application is now deployed!

Next steps:
  1. Visit your website to verify changes
  2. Check Laravel logs if any issues: tail -f storage/logs/laravel.log
  3. Monitor error logs in cPanel
```

---

## 🚨 Troubleshooting

### Script Permission Denied
```bash
bash: ./deploy.sh: Permission denied
```

**Fix:**
```bash
chmod +x deploy.sh
```

### Composer Not Found
```bash
composer: command not found
```

**Fix:** Use full path or alias
```bash
/usr/local/bin/composer install --no-dev --optimize-autoloader
# or
php composer.phar install --no-dev --optimize-autoloader
```

### Artisan Command Failed
```bash
PHP Fatal error: Class not found
```

**Fix:** Regenerate autoload
```bash
composer dump-autoload
```

### Permission Issues
```bash
chmod: Permission denied
```

**Fix:** Use sudo (if available) or contact hosting support
```bash
sudo chmod -R 755 storage bootstrap/cache
```

---

## 🔄 Complete Workflow (Recommended)

```bash
# 1. Navigate to project
cd ~/public_html/ofys

# 2. Check current branch
git branch

# 3. Pull latest changes
git pull origin main

# 4. Run deployment script
bash deploy.sh

# 5. Verify deployment
curl -I https://gooutdoor.asia

# 6. Check logs (optional)
tail -n 50 storage/logs/laravel.log
```

---

## ⚡ Quick Deploy (All-in-One Command)

If the script is already executable, you can run everything in one line:

```bash
cd ~/public_html/ofys && git pull origin main && bash deploy.sh
```

---

## 📝 Important Notes

- ⚠️ **Always pull before deploying** - Ensures you have latest code
- ⚠️ **Backup before deploying** - Create backup if making major changes
- ⚠️ **Check .env file** - Ensure `APP_URL=https://gooutdoor.asia`
- ⚠️ **Run migrations** - Add `php artisan migrate --force` if database changes
- ⚠️ **Clear cache** - Script handles this automatically

---

## 🛡️ Production Safety Checklist

Before deploying to production:

- [ ] All changes tested locally
- [ ] Git branch is `main` (not development branch)
- [ ] Database migrations reviewed (if any)
- [ ] `.env` file has correct production values
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production` in .env

---

## 📞 Need Help?

If deployment fails:

1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Check cPanel error logs
3. Verify file permissions: `ls -la storage/`
4. Test manually: `php artisan config:clear`

---

## 🎓 Learning Resources

**What is chmod +x?**
- Makes a file executable
- `+x` = add execute permission
- Required for running shell scripts

**What does bash deploy.sh do?**
- `bash` = run the script using bash shell
- `deploy.sh` = the script file name
- Alternative: `./deploy.sh` (requires executable permission)

**What is git pull?**
- Downloads latest changes from GitHub
- Updates your code to match the repository
- Always run before deploying

---

**Made with ❤️ for easy deployment** 🚀

