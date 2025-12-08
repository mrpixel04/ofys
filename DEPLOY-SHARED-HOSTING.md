# Deployment Guide - Shared Hosting (cPanel Terminal)

> **Last Updated:** December 8, 2025

---

## Deployment Steps

### 1. SSH into your cPanel Terminal and navigate to your project:
```bash
cd ~/public_html
# OR if your project is in a subfolder:
cd ~/your-domain-folder
```

### 2. Pull the latest code:
```bash
git pull origin feature/payment-system-improvements
# OR if merging to main first:
git pull origin main
```

### 3. Install PHP dependencies (if needed):
```bash
composer install --no-dev --optimize-autoloader
```

### 4. Set up environment:
```bash
# Copy .env if first time
cp .env.example .env

# Generate app key (first time only)
php artisan key:generate
```

### 5. Update your `.env` file with production settings:
```bash
nano .env
```

Change these values:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Billplz Production (get from Billplz dashboard)
BILLPLZ_API_KEY=your_production_key
BILLPLZ_API_URL=https://www.billplz.com/api
BILLPLZ_COLLECTION_ID=your_collection_id
BILLPLZ_X_SIGNATURE_KEY=your_signature_key
```

### 6. Run database migrations:
```bash
php artisan migrate --force
```

### 7. Optimize for production:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### 8. Set permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

---

## Important Notes

- **Build files are included** - No need to run `npm` on server
- **For Billplz Production** - Update API credentials in `.env` (remove `-sandbox` from URL)
- **Storage link** - Run `php artisan storage:link` for images to work

---

## Quick Commands Reference

### Clear all caches:
```bash
php artisan optimize:clear
```

### Re-cache after changes:
```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### Check Laravel version:
```bash
php artisan --version
```

### Check PHP version:
```bash
php -v
```

---

## Troubleshooting

### 500 Error after deployment:
```bash
chmod -R 755 storage bootstrap/cache
php artisan config:clear
```

### Images not showing:
```bash
php artisan storage:link
```

### Database migration issues:
```bash
php artisan migrate:status
php artisan migrate --force
```
