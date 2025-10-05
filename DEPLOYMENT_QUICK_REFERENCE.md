# 🚀 OFYS - Quick Deployment Reference

**Domain**: gooutdoor.asia  
**Date**: October 6, 2025

---

## 📦 QUICK START (5 Steps)

### 1️⃣ Export Database (Local)
```bash
# Open phpMyAdmin: http://localhost/phpmyadmin
# Select: dbofys → Export → Custom → Go
# Save as: dbofys_backup_20251006.sql
```

### 2️⃣ Prepare Files (Local)
```bash
cd /Users/mrpixel/Documents/ofys/ofys
./prepare-deployment.sh
# This creates: ofys_production_YYYYMMDD_HHMMSS.zip
```

### 3️⃣ Upload to Server
```
Upload to: /home/yourusername/
Extract to: /home/yourusername/ofys/
Move public/* to: /home/yourusername/public_html/
```

### 4️⃣ Configure Server
```bash
# Create .env file
nano /home/yourusername/ofys/.env
# Copy from .env.production.template and update credentials

# Update index.php
cp /home/yourusername/ofys/index.php.production /home/yourusername/public_html/index.php

# Update .htaccess
cp /home/yourusername/ofys/.htaccess.production /home/yourusername/public_html/.htaccess

# Create storage symlink
cd /home/yourusername/public_html
ln -s /home/yourusername/ofys/storage/app/public storage

# Set permissions
cd /home/yourusername/ofys
chmod -R 775 storage bootstrap/cache
```

### 5️⃣ Import Database & Test
```
# cPanel → phpMyAdmin
# Select database → Import → Choose file → Go

# Test site: https://gooutdoor.asia
# Login: admin@gmail.com / Passw0rd123
```

---

## 🗂️ Server Directory Structure

```
/home/yourusername/
├── public_html/              ← gooutdoor.asia points here
│   ├── .htaccess            ← From .htaccess.production
│   ├── index.php            ← From index.php.production
│   ├── build/               ← From ofys/public/build/
│   ├── css/                 ← From ofys/public/css/
│   ├── js/                  ← From ofys/public/js/
│   ├── images/              ← From ofys/public/images/
│   ├── storage/             ← Symlink to ../ofys/storage/app/public
│   └── favicon.ico
│
└── ofys/                    ← Laravel app (OUTSIDE public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env                 ← Production config
    └── artisan
```

---

## ⚙️ Production .env (Quick Copy)

```env
APP_NAME=OFYS
APP_ENV=production
APP_KEY=base64:SfLbvGKUNkdG4VC1EIU/j6aa+y/v2GQv8A50/lRLx/w=
APP_DEBUG=false
APP_URL=https://gooutdoor.asia

LOG_LEVEL=error

# ⚠️ UPDATE THESE
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=yourusername_dbofys
DB_USERNAME=yourusername_dbofys_user
DB_PASSWORD=YOUR_PASSWORD_HERE

SESSION_DOMAIN=.gooutdoor.asia

# ⚠️ UPDATE MAIL
MAIL_HOST=mail.gooutdoor.asia
MAIL_USERNAME=noreply@gooutdoor.asia
MAIL_PASSWORD=YOUR_EMAIL_PASSWORD

# ⚠️ UPDATE BILLPLZ (PRODUCTION)
BILLPLZ_API_KEY=your_production_key
BILLPLZ_API_URL=https://www.billplz.com/api
BILLPLZ_COLLECTION_ID=your_collection_id
BILLPLZ_X_SIGNATURE_KEY=your_signature_key
```

---

## 🔧 Essential Commands

### Clear Caches
```bash
cd /home/yourusername/ofys
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Check Logs
```bash
tail -f /home/yourusername/ofys/storage/logs/laravel.log
```

### Fix Permissions
```bash
cd /home/yourusername/ofys
chmod -R 775 storage bootstrap/cache
chown -R yourusername:yourusername .
```

---

## 🔒 Security Checklist

- [ ] `APP_DEBUG=false` in .env
- [ ] Strong database password
- [ ] HTTPS enabled (SSL)
- [ ] `.env` outside public_html
- [ ] File permissions: 644 (files), 755 (dirs)
- [ ] Storage: 775 permissions
- [ ] Billplz X-Signature enabled
- [ ] Backups configured

---

## 🐛 Common Issues & Fixes

### 500 Error
```bash
# Check logs
tail -f /home/yourusername/ofys/storage/logs/laravel.log

# Clear caches
php artisan cache:clear && php artisan config:clear

# Check permissions
chmod -R 775 storage bootstrap/cache
```

### Database Connection Failed
```
# Verify .env credentials
# Check database exists in phpMyAdmin
# Verify user has ALL PRIVILEGES
```

### Images Not Loading
```bash
# Recreate storage symlink
cd /home/yourusername/public_html
rm -rf storage
ln -s /home/yourusername/ofys/storage/app/public storage
```

### CSS/JS Not Loading
```
# Check .htaccess exists in public_html
# Clear browser cache
# Verify file permissions (644)
```

---

## 📞 Test URLs

After deployment, test these:

- ✅ Homepage: `https://gooutdoor.asia`
- ✅ Login: `https://gooutdoor.asia/login`
- ✅ Activities: `https://gooutdoor.asia/activities`
- ✅ Admin: `https://gooutdoor.asia/admin/dashboard`
- ✅ Register: `https://gooutdoor.asia/register`

---

## 🎯 Post-Deployment

1. **Test Payment**
   - Create test booking
   - Test Billplz sandbox payment

2. **Configure Billplz Webhook**
   - URL: `https://gooutdoor.asia/payment/callback`
   - Enable X-Signature

3. **Set Up Cron Job**
   ```
   * * * * * cd /home/yourusername/ofys && php artisan schedule:run >> /dev/null 2>&1
   ```

4. **Enable Backups**
   - cPanel → Backup → Configure

5. **Monitor Logs**
   - Check daily for errors
   - Set up log rotation

---

## 📚 Full Documentation

For detailed step-by-step instructions, see:
**DEPLOYMENT_GUIDE.md**

---

**Good luck! 🚀**
