# 🚀 OFYS - Shared Hosting Deployment Guide

**Domain**: gooutdoor.asia  
**Server Type**: Shared Hosting (cPanel/DirectAdmin)  
**Date**: October 6, 2025

---

## 📋 PRE-DEPLOYMENT CHECKLIST

- [ ] Database backup created
- [ ] All code committed to Git
- [ ] `.env` file configured for production
- [ ] File permissions checked
- [ ] `.htaccess` files ready
- [ ] Storage directory linked

---

## 🗄️ STEP 1: EXPORT DATABASE FROM LOCAL

### Using phpMyAdmin (XAMPP)

1. **Open phpMyAdmin**
   - URL: `http://localhost/phpmyadmin`
   - Login with your credentials

2. **Select Database**
   - Click on `dbofys` database in the left sidebar

3. **Export Database**
   - Click the **"Export"** tab at the top
   - Select **"Custom"** export method
   - **Format**: SQL
   - **Tables**: Select all tables
   - **Structure**:
     - ✅ Add DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT / TRIGGER
     - ✅ Add CREATE TABLE
     - ✅ Add IF NOT EXISTS
   - **Data**:
     - ✅ Complete inserts
     - ✅ Extended inserts (faster)
   - Click **"Go"** button
   - Save file as: `dbofys_backup_20251006.sql`

### Using Command Line (Alternative)

```bash
# Navigate to XAMPP MySQL bin directory
cd /Applications/XAMPP/xamppfiles/bin

# Export database
./mysqldump -u root -p dbofys > ~/Desktop/dbofys_backup_20251006.sql

# Enter password when prompted (empty for default XAMPP)
```

---

## 📤 STEP 2: UPLOAD FILES TO SHARED HOSTING

### Shared Hosting Directory Structure

```
/home/yourusername/
├── public_html/              ← Your domain root (gooutdoor.asia)
│   ├── .htaccess             ← Root .htaccess (NEW)
│   ├── index.php             ← Laravel entry point (from public/)
│   ├── build/                ← Vite assets
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── storage/              ← Symlink to ../ofys/storage/app/public
│   └── favicon.ico
│
└── ofys/                     ← Laravel application (OUTSIDE public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env                  ← Production environment file
    ├── artisan
    └── composer.json
```

### Upload Steps

1. **Compress Your Laravel Project**
   ```bash
   # In your local project directory
   cd /Users/mrpixel/Documents/ofys/ofys
   
   # Create archive (exclude unnecessary files)
   zip -r ofys_production.zip . \
     -x "*.git*" \
     -x "node_modules/*" \
     -x "storage/logs/*" \
     -x "storage/framework/cache/*" \
     -x "storage/framework/sessions/*" \
     -x "storage/framework/views/*" \
     -x ".env"
   ```

2. **Upload via FTP/cPanel File Manager**
   - Upload `ofys_production.zip` to `/home/yourusername/`
   - Extract the zip file
   - Rename extracted folder to `ofys`

3. **Move Public Files**
   - Copy everything from `/home/yourusername/ofys/public/` 
   - Paste to `/home/yourusername/public_html/`
   - Delete the `/home/yourusername/ofys/public/` folder

---

## 🗄️ STEP 3: IMPORT DATABASE TO PRODUCTION

### Using cPanel phpMyAdmin

1. **Login to cPanel**
   - URL: `https://gooutdoor.asia:2083` or provided by your host
   - Enter your cPanel credentials

2. **Open phpMyAdmin**
   - Find "Databases" section
   - Click "phpMyAdmin"

3. **Create Database** (if not exists)
   - Click "Databases" tab
   - Database name: `yourusername_dbofys` (or similar)
   - Click "Create"

4. **Create Database User** (if not exists)
   - Go back to cPanel → MySQL Databases
   - Create user: `yourusername_dbofys_user`
   - Set strong password: (save this!)
   - Add user to database with ALL PRIVILEGES

5. **Import SQL File**
   - In phpMyAdmin, select your database
   - Click "Import" tab
   - Click "Choose File"
   - Select `dbofys_backup_20251006.sql`
   - Click "Go"
   - Wait for import to complete (may take 1-2 minutes)

6. **Verify Import**
   - Check that all tables are present:
     - `users`, `activities`, `bookings`, `activity_lots`
     - `shop_infos`, `whatsapp_messages`, `chatbot_responses`
     - `whatsapp_sessions`, etc.

---

## ⚙️ STEP 4: CONFIGURE ENVIRONMENT FILE

### Create Production `.env` File

```bash
# Connect via SSH or use cPanel File Manager
cd /home/yourusername/ofys

# Create .env file
nano .env
```

### Production `.env` Configuration

```env
APP_NAME=OFYS
APP_ENV=production
APP_KEY=base64:SfLbvGKUNkdG4VC1EIU/j6aa+y/v2GQv8A50/lRLx/w=
APP_DEBUG=false
APP_URL=https://gooutdoor.asia

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# ⚠️ UPDATE THESE WITH YOUR PRODUCTION DATABASE CREDENTIALS
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_dbofys
DB_USERNAME=yourusername_dbofys_user
DB_PASSWORD=your_strong_password_here

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.gooutdoor.asia

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync

CACHE_STORE=file

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# ⚠️ UPDATE MAIL SETTINGS FOR PRODUCTION
MAIL_MAILER=smtp
MAIL_HOST=mail.gooutdoor.asia
MAIL_PORT=587
MAIL_USERNAME=noreply@gooutdoor.asia
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS="noreply@gooutdoor.asia"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=tls

# ⚠️ UPDATE BILLPLZ SETTINGS (USE PRODUCTION CREDENTIALS)
BILLPLZ_API_KEY=your_production_api_key_here
BILLPLZ_API_URL=https://www.billplz.com/api
BILLPLZ_COLLECTION_ID=your_collection_id_here
BILLPLZ_X_SIGNATURE_KEY=your_x_signature_key_here

# WhatsApp Integration (BuzzBridge)
WHATSAPP_API_URL=https://buzzbridge.aplikasi-io.com/api
WHATSAPP_API_KEY=your_whatsapp_api_key
WHATSAPP_WEBHOOK_URL=https://gooutdoor.asia/api/webhooks/whatsapp
WHATSAPP_SECRET_KEY=your_secret_key
WHATSAPP_QR_ENDPOINT=/qr

# N8N Integration
N8N_API_URL=https://your-n8n-instance.com/api
N8N_WEBHOOK_URL=https://your-n8n-instance.com/webhook
N8N_API_KEY=your_n8n_api_key
N8N_WORKFLOW_ID=your_workflow_id

VITE_APP_NAME="${APP_NAME}"
```

**IMPORTANT**: 
- Replace `yourusername` with your actual cPanel username
- Replace all passwords with your actual credentials
- Set `APP_DEBUG=false` for production
- Use `https://` for APP_URL

---

## 🔧 STEP 5: CONFIGURE .HTACCESS FILES

### Root .htaccess (public_html/.htaccess)

Create this file at `/home/yourusername/public_html/.htaccess`:

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

    # Redirect Trailing Slashes If Not A Folder
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

# PHP settings
<IfModule mod_php.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value memory_limit 256M
    php_value max_execution_time 300
    php_flag display_errors Off
    php_flag log_errors On
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Enable Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Cache Control
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Prevent access to sensitive files
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

<FilesMatch "\.(env|log|sql)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### Update index.php

Edit `/home/yourusername/public_html/index.php`:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../ofys/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../ofys/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../ofys/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

---

## 🔗 STEP 6: CREATE STORAGE SYMLINK

### Via SSH (Recommended)

```bash
# Connect via SSH
ssh yourusername@gooutdoor.asia

# Navigate to public_html
cd /home/yourusername/public_html

# Remove existing storage directory if exists
rm -rf storage

# Create symlink
ln -s /home/yourusername/ofys/storage/app/public storage

# Verify symlink
ls -la storage
```

### Via cPanel File Manager (Alternative)

1. Go to cPanel → File Manager
2. Navigate to `public_html`
3. Delete `storage` folder if exists
4. Use terminal or contact hosting support to create symlink

---

## 🔐 STEP 7: SET FILE PERMISSIONS

### Via SSH

```bash
# Navigate to Laravel root
cd /home/yourusername/ofys

# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Set storage and cache permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (replace 'yourusername' with your actual username)
chown -R yourusername:yourusername .
```

### Via cPanel File Manager

1. Right-click on `storage` folder → Change Permissions
2. Set to `775` (rwxrwxr-x)
3. Check "Recurse into subdirectories"
4. Repeat for `bootstrap/cache`

---

## 🧹 STEP 8: CLEAR CACHES

### Via SSH

```bash
cd /home/yourusername/ofys

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Via cPanel Terminal (Alternative)

1. cPanel → Terminal
2. Run the same commands above

---

## ✅ STEP 9: VERIFY DEPLOYMENT

### Test Checklist

1. **Homepage**
   - Visit: `https://gooutdoor.asia`
   - Should load without errors
   - Check: Hero section, images, animations

2. **Login**
   - Visit: `https://gooutdoor.asia/login`
   - Test ADMIN: `admin@gmail.com` / `Passw0rd123`
   - Test PROVIDER: `tombak@gmail.com` / `Passw0rd123`

3. **Activities Page**
   - Visit: `https://gooutdoor.asia/activities`
   - Check: Activity listings, images, filters

4. **Admin Dashboard**
   - Login as admin
   - Check: Dashboard, Providers, Customers, Bookings

5. **Booking Flow**
   - Create a test booking
   - Check: Confirmation page, Billplz button

6. **Payment Test**
   - Use Billplz sandbox credentials
   - Test payment flow end-to-end

---

## 🐛 TROUBLESHOOTING

### Issue: 500 Internal Server Error

**Solution**:
```bash
# Check Laravel logs
cat /home/yourusername/ofys/storage/logs/laravel.log

# Check Apache error logs
tail -f /home/yourusername/logs/error_log
```

### Issue: Database Connection Failed

**Solution**:
- Verify database credentials in `.env`
- Test connection via phpMyAdmin
- Check if database user has correct privileges

### Issue: Images Not Loading

**Solution**:
```bash
# Verify storage symlink
ls -la /home/yourusername/public_html/storage

# Recreate symlink if needed
cd /home/yourusername/public_html
rm -rf storage
ln -s /home/yourusername/ofys/storage/app/public storage
```

### Issue: CSS/JS Not Loading

**Solution**:
- Clear browser cache
- Check `.htaccess` file
- Verify file permissions (644 for files, 755 for directories)
- Run: `php artisan config:clear && php artisan cache:clear`

### Issue: Session/Login Not Working

**Solution**:
```bash
# Check session directory permissions
chmod -R 775 /home/yourusername/ofys/storage/framework/sessions

# Clear sessions
rm -rf /home/yourusername/ofys/storage/framework/sessions/*
```

---

## 📝 POST-DEPLOYMENT TASKS

### 1. Configure Billplz Webhook

In Billplz Dashboard:
- Set Callback URL: `https://gooutdoor.asia/payment/callback`
- Enable X-Signature
- Test with sandbox

### 2. Configure Email

Test email sending:
```bash
php artisan tinker
Mail::raw('Test email', function($msg) {
    $msg->to('your@email.com')->subject('Test');
});
```

### 3. Set Up Cron Jobs

In cPanel → Cron Jobs:
```bash
# Laravel Scheduler (run every minute)
* * * * * cd /home/yourusername/ofys && php artisan schedule:run >> /dev/null 2>&1
```

### 4. Enable SSL Certificate

In cPanel:
- Go to "SSL/TLS Status"
- Enable AutoSSL for `gooutdoor.asia`
- Wait 5-10 minutes for certificate to be issued

### 5. Set Up Backups

Configure automatic backups:
- Database: Daily via cPanel
- Files: Weekly via cPanel
- Download backups locally monthly

---

## 🔒 SECURITY CHECKLIST

- [ ] `APP_DEBUG=false` in production
- [ ] Strong database password set
- [ ] `.env` file not accessible (outside public_html)
- [ ] HTTPS enabled (SSL certificate)
- [ ] File permissions correct (644/755)
- [ ] Directory browsing disabled
- [ ] Billplz X-Signature enabled
- [ ] Security headers configured
- [ ] Regular backups scheduled

---

## 📞 SUPPORT

If you encounter issues:

1. **Check Laravel Logs**
   - `/home/yourusername/ofys/storage/logs/laravel.log`

2. **Check Apache Logs**
   - cPanel → Errors → Error Log

3. **Contact Hosting Support**
   - For server-specific issues
   - For SSL certificate problems
   - For PHP version/extension issues

---

## 🎉 DEPLOYMENT COMPLETE!

Your OFYS application should now be live at:
**https://gooutdoor.asia**

Remember to:
- Test all functionality
- Monitor error logs
- Set up regular backups
- Keep Laravel and dependencies updated

**Good luck with your production deployment!** 🚀
