# Deployment Steps - cPanel Terminal

## Quick Deploy (All-in-One)

```bash
cd ~/public_html/ofys && 

git pull origin main
 && 
 composer install --no-dev --optimize-autoloader 
 && 
 php artisan migrate --force 
 && 
 php artisan optimize:clear
  && 
  php artisan config:cache 
  && 
  php artisan route:cache 
  && 
  php artisan view:cache
   && 
   chmod -R 755 storage bootstrap/cache
    && 
    cp -r public/build/* ../build/
```

---

## Step-by-Step Deploy

### 1. Go to project folder
```bash
cd ~/public_html/ofys
```

### 2. Pull latest code
```bash
git stash && git pull origin main
```

### 3. Install dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 4. Run migrations
```bash
php artisan migrate --force
```

### 5. Clear and cache
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Set permissions
```bash
chmod -R 755 storage bootstrap/cache
```

### 7. Copy assets to public_html
```bash
cp -r public/build/* ../build/
```

### 8. Storage link (if images not showing)
```bash
php artisan storage:link
```

---

## If Styles/Assets Not Loading

```bash
cp -r ~/public_html/ofys/public/build/* ~/public_html/build/
```

## If Images Not Showing

```bash
php artisan storage:link
```

## Clear All Cache

```bash
php artisan optimize:clear
```
