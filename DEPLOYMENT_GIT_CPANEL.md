# 🚀 OFYS - Git Deployment via cPanel (EASIEST METHOD!)

**Domain**: gooutdoor.asia  
**Method**: Git Version Control in cPanel  
**Date**: October 6, 2025

---

## ✨ WHY USE GIT DEPLOYMENT?

**Benefits:**
- ✅ **No manual file upload** - Deploy with one click
- ✅ **Automatic updates** - Pull latest changes easily
- ✅ **Version control** - Rollback if needed
- ✅ **Faster deployment** - No FTP/File Manager needed
- ✅ **Professional workflow** - Industry standard

---

## 📋 PREREQUISITES

Before starting, ensure:
- [ ] Your code is pushed to GitHub
- [ ] cPanel has "Git™ Version Control" feature
- [ ] You have SSH access (optional but recommended)
- [ ] Database is ready (create in cPanel first)

---

## 🎯 STEP-BY-STEP DEPLOYMENT

### STEP 1: Push Your Code to GitHub

```bash
# In your local project directory
cd /Users/mrpixel/Documents/ofys/ofys

# Check current branch
git branch

# Make sure all changes are committed
git status

# If you have uncommitted changes, commit them
git add .
git commit -m "Ready for production deployment"

# Push to GitHub
git push origin feature/production_prepared_payment-gateway-done-05102025_1720PM

# Or push to main branch
git checkout main
git merge feature/production_prepared_payment-gateway-done-05102025_1720PM
git push origin main
```

---

### STEP 2: Create Database in cPanel

**Before cloning the repository, create your database:**

1. **Login to cPanel**
   - URL: `https://gooutdoor.asia:2083`

2. **Go to MySQL Databases**
   - Find "Databases" section
   - Click "MySQL Databases"

3. **Create Database**
   - Database name: `yourusername_dbofys`
   - Click "Create Database"

4. **Create Database User**
   - Username: `yourusername_dbofys_user`
   - Password: (generate strong password - SAVE THIS!)
   - Click "Create User"

5. **Add User to Database**
   - Select user: `yourusername_dbofys_user`
   - Select database: `yourusername_dbofys`
   - Check "ALL PRIVILEGES"
   - Click "Add"

6. **Save Credentials**
   ```
   Database Name: yourusername_dbofys
   Database User: yourusername_dbofys_user
   Database Password: [YOUR_PASSWORD_HERE]
   Database Host: localhost
   ```

---

### STEP 3: Clone Repository via cPanel Git

1. **Login to cPanel**
   - URL: `https://gooutdoor.asia:2083`

2. **Find Git™ Version Control**
   - Look in "Files" section (as shown in your screenshot)
   - Click "Git™ Version Control"

3. **Create New Repository**
   - Click "Create" button

4. **Fill in Repository Details**
   ```
   Clone URL: https://github.com/mrpixel04/ofys.git
   
   Repository Path: /home/yourusername/ofys
   (This will be OUTSIDE public_html)
   
   Repository Name: ofys
   
   Branch: main
   (or your production branch name)
   ```

5. **Click "Create"**
   - cPanel will clone your repository
   - Wait for completion (may take 1-2 minutes)

---

### STEP 4: Configure Repository Settings

After cloning, you'll see your repository listed:

1. **Click "Manage" on your repository**

2. **Note the Repository Path**
   - Should be: `/home/yourusername/ofys`

3. **Enable "Pull or Deploy"** (if available)
   - This allows easy updates

---

### STEP 5: Set Up File Structure

**Option A: Using cPanel File Manager**

1. **Go to File Manager**
   - Navigate to `/home/yourusername/ofys/public/`

2. **Copy Public Files**
   - Select ALL files in `/home/yourusername/ofys/public/`
   - Copy them

3. **Paste to public_html**
   - Navigate to `/home/yourusername/public_html/`
   - Paste all files
   - Overwrite if asked

4. **Update index.php**
   - Edit `/home/yourusername/public_html/index.php`
   - Change paths to point to `../ofys/` (see below)

**Option B: Using SSH (Recommended)**

```bash
# Connect via SSH
ssh yourusername@gooutdoor.asia

# Navigate to home directory
cd ~

# Copy public files to public_html
cp -r ofys/public/* public_html/

# Update index.php (see next step)
nano public_html/index.php
```

---

### STEP 6: Update index.php

**Edit `/home/yourusername/public_html/index.php`:**

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Update these paths to point to your Git repository
if (file_exists($maintenance = __DIR__.'/../ofys/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../ofys/vendor/autoload.php';

(require_once __DIR__.'/../ofys/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

**Key Changes:**
- All paths use `../ofys/` instead of `../ofys-manual/`
- Points to your Git-cloned repository

---

### STEP 7: Create .htaccess in public_html

**Create/Edit `/home/yourusername/public_html/.htaccess`:**

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Redirect www to non-www
    RewriteCond %{HTTP_HOST} ^www\.gooutdoor\.asia [NC]
    RewriteRule ^(.*)$ https://gooutdoor.asia/$1 [L,R=301]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Disable directory browsing
Options -Indexes

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Frame-Options "SAMEORIGIN"
</IfModule>
```

---

### STEP 8: Create .env File

**Via cPanel File Manager or SSH:**

```bash
# Using SSH
cd /home/yourusername/ofys
nano .env
```

**Paste this configuration:**

```env
APP_NAME=OFYS
APP_ENV=production
APP_KEY=base64:SfLbvGKUNkdG4VC1EIU/j6aa+y/v2GQv8A50/lRLx/w=
APP_DEBUG=false
APP_URL=https://gooutdoor.asia

LOG_LEVEL=error

# ⚠️ USE YOUR DATABASE CREDENTIALS FROM STEP 2
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_dbofys
DB_USERNAME=yourusername_dbofys_user
DB_PASSWORD=YOUR_DATABASE_PASSWORD_HERE

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=.gooutdoor.asia

CACHE_STORE=file
QUEUE_CONNECTION=sync

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mail.gooutdoor.asia
MAIL_PORT=587
MAIL_USERNAME=noreply@gooutdoor.asia
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS="noreply@gooutdoor.asia"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=tls

# Billplz Production Settings
BILLPLZ_API_KEY=your_production_api_key
BILLPLZ_API_URL=https://www.billplz.com/api
BILLPLZ_COLLECTION_ID=your_collection_id
BILLPLZ_X_SIGNATURE_KEY=your_x_signature_key

# WhatsApp Integration
WHATSAPP_API_URL=https://buzzbridge.aplikasi-io.com/api
WHATSAPP_API_KEY=your_api_key
WHATSAPP_WEBHOOK_URL=https://gooutdoor.asia/api/webhooks/whatsapp
WHATSAPP_SECRET_KEY=your_secret_key
WHATSAPP_QR_ENDPOINT=/qr

VITE_APP_NAME="${APP_NAME}"
```

**Save and exit** (Ctrl+X, then Y, then Enter)

---

### STEP 9: Install Composer Dependencies

**Via SSH (Required):**

```bash
# Connect via SSH
ssh yourusername@gooutdoor.asia

# Navigate to repository
cd /home/yourusername/ofys

# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# If composer is not available, use:
php composer.phar install --optimize-autoloader --no-dev

# Or download composer first:
curl -sS https://getcomposer.org/installer | php
php composer.phar install --optimize-autoloader --no-dev
```

---

### STEP 10: Create Storage Symlink

```bash
# Still in SSH, navigate to public_html
cd /home/yourusername/public_html

# Remove existing storage folder if exists
rm -rf storage

# Create symlink
ln -s /home/yourusername/ofys/storage/app/public storage

# Verify symlink
ls -la storage
```

---

### STEP 11: Set File Permissions

```bash
# Set proper permissions
cd /home/yourusername/ofys

# Storage directory
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (replace 'yourusername' with your actual username)
chown -R yourusername:yourusername .
```

---

### STEP 12: Import Database

1. **Export Local Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Select `dbofys`
   - Click "Export" → "Go"
   - Save as `dbofys_backup.sql`

2. **Import to Production**
   - cPanel → phpMyAdmin
   - Select `yourusername_dbofys`
   - Click "Import"
   - Choose `dbofys_backup.sql`
   - Click "Go"

---

### STEP 13: Clear Caches & Optimize

```bash
# Via SSH
cd /home/yourusername/ofys

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### STEP 14: Test Your Site

Visit: **https://gooutdoor.asia**

**Test Checklist:**
- [ ] Homepage loads correctly
- [ ] Images display properly
- [ ] Login works (admin@gmail.com / Passw0rd123)
- [ ] Activities page loads
- [ ] Admin dashboard accessible
- [ ] Booking flow works
- [ ] Billplz payment test

---

## 🔄 UPDATING YOUR SITE (PULL CHANGES)

**When you make changes and push to GitHub:**

### Method 1: Via cPanel Git Interface

1. **Go to Git™ Version Control**
2. **Click "Manage" on your repository**
3. **Click "Pull or Deploy" tab**
4. **Click "Update from Remote"**
5. **Wait for completion**
6. **Clear caches** (via SSH):
   ```bash
   cd /home/yourusername/ofys
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

### Method 2: Via SSH (Faster)

```bash
# Connect via SSH
ssh yourusername@gooutdoor.asia

# Navigate to repository
cd /home/yourusername/ofys

# Pull latest changes
git pull origin main

# If you need to copy new public files
cp -r public/* /home/yourusername/public_html/

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Re-optimize
php artisan config:cache
php artisan route:cache
```

---

## 🎯 DEPLOYMENT WORKFLOW

```
Local Development
    ↓
git add .
git commit -m "Your changes"
git push origin main
    ↓
cPanel Git → Pull Changes
    ↓
Clear Laravel Caches
    ↓
Test on gooutdoor.asia
    ↓
✅ DONE!
```

---

## 🔐 SSH ACCESS SETUP (If Not Already Enabled)

1. **Enable SSH in cPanel**
   - cPanel → "SSH Access"
   - Click "Manage SSH Keys"
   - Generate new key or upload existing

2. **Connect via SSH**
   ```bash
   ssh yourusername@gooutdoor.asia
   # Enter password when prompted
   ```

3. **Alternative: Use cPanel Terminal**
   - cPanel → "Terminal"
   - Opens web-based terminal
   - No SSH client needed

---

## 🐛 TROUBLESHOOTING

### Issue: Git Clone Fails

**Solution:**
- Check if repository is public
- If private, add SSH key to GitHub:
  ```bash
  # Generate SSH key in cPanel
  ssh-keygen -t rsa -b 4096
  
  # Copy public key
  cat ~/.ssh/id_rsa.pub
  
  # Add to GitHub: Settings → SSH Keys
  ```

### Issue: Composer Not Found

**Solution:**
```bash
# Download composer
cd /home/yourusername/ofys
curl -sS https://getcomposer.org/installer | php

# Use it
php composer.phar install --optimize-autoloader --no-dev
```

### Issue: Permission Denied

**Solution:**
```bash
# Fix permissions
cd /home/yourusername/ofys
chmod -R 775 storage bootstrap/cache
chown -R yourusername:yourusername .
```

### Issue: 500 Internal Server Error

**Solution:**
```bash
# Check Laravel logs
tail -f /home/yourusername/ofys/storage/logs/laravel.log

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📊 COMPARISON: Git vs Manual Upload

| Feature | Git Deployment | Manual Upload |
|---------|---------------|---------------|
| **Speed** | ⚡ Fast (1-2 min) | 🐌 Slow (10-15 min) |
| **Updates** | ✅ One command | ❌ Re-upload all files |
| **Rollback** | ✅ Easy | ❌ Difficult |
| **Version Control** | ✅ Yes | ❌ No |
| **Professional** | ✅ Yes | ⚠️ Basic |
| **Automation** | ✅ Possible | ❌ Manual only |

---

## ✅ ADVANTAGES OF GIT DEPLOYMENT

1. **Faster Updates**
   - Just `git pull` instead of uploading 1000+ files

2. **Version Control**
   - Track all changes
   - Rollback if needed
   - See deployment history

3. **Team Collaboration**
   - Multiple developers can deploy
   - No file conflicts

4. **Automation Ready**
   - Can set up auto-deploy on push
   - CI/CD integration possible

5. **Professional Workflow**
   - Industry standard
   - Better for maintenance

---

## 🎉 FINAL CHECKLIST

After deployment via Git:

- [ ] Repository cloned to `/home/yourusername/ofys`
- [ ] Public files copied to `public_html`
- [ ] `index.php` updated with correct paths
- [ ] `.htaccess` created in `public_html`
- [ ] `.env` file created with production settings
- [ ] Composer dependencies installed
- [ ] Storage symlink created
- [ ] File permissions set (775 for storage)
- [ ] Database imported
- [ ] Caches cleared and optimized
- [ ] Site tested and working
- [ ] SSL certificate enabled
- [ ] Billplz webhook configured

---

## 📞 NEED HELP?

**Common Commands Reference:**

```bash
# Pull latest changes
cd /home/yourusername/ofys && git pull origin main

# Clear all caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear

# Re-optimize
php artisan config:cache && php artisan route:cache

# Check Laravel logs
tail -f storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache
```

---

## 🚀 YOU'RE READY!

Git deployment is the **BEST** way to deploy Laravel to shared hosting!

**Benefits:**
- ✅ Professional workflow
- ✅ Fast updates
- ✅ Easy rollback
- ✅ Version control
- ✅ No manual file uploads

**Your site will be live at: https://gooutdoor.asia** 🎉

---

**Good luck with your Git deployment!** 🚀
