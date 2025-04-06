# Laravel Deployment Guide for Shared Hosting

This guide provides detailed instructions for deploying the OFYS Laravel application to a shared hosting environment.

## Pre-Deployment Preparation

1. **Check hosting requirements**:
   - PHP 8.1+ 
   - MySQL 5.7+ or MariaDB 10.3+
   - Composer support (or ability to upload vendor directory)
   - mod_rewrite enabled for Apache

## Deployment Steps

### Step 1: Prepare Your Files

1. Extract the `ofys-admin-section.zip` file on your local machine
2. Make sure the `.env.example` file is included
3. If your hosting doesn't support Composer, run `composer install --optimize-autoloader --no-dev` locally

### Step 2: Upload Files

#### Option 1: Upload to Root Directory
If your hosting allows setting the document root to a subdirectory:

1. Upload all files to your hosting root
2. Set the document root to the `public` folder

#### Option 2: Modified Structure for Standard Hosting
If you can't change document root:

1. Upload all files except those in `public` to a directory outside web root (e.g., `ofys_app`)
2. Upload contents of `public` directory to your web root (e.g., `public_html`)
3. Edit `index.php` in the web root to update paths:
   ```php
   require __DIR__.'/../ofys_app/vendor/autoload.php';
   $app = require_once __DIR__.'/../ofys_app/bootstrap/app.php';
   ```

### Step 3: Configure Environment

1. Rename `.env.example` to `.env`
2. Update database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
3. Set production-specific settings:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   ```

### Step 4: Storage Configuration

1. Create symbolic link for storage (if your hosting supports it):
   ```
   php artisan storage:link
   ```
   
   If symlinks aren't supported, manually copy the storage directory or edit `config/filesystems.php` 
   to use absolute paths.

2. Set proper permissions:
   ```
   chmod -R 755 storage bootstrap/cache
   ```

### Step 5: Database Setup

1. Import database schema using phpMyAdmin or hosting control panel
2. Run migrations (if you have SSH access):
   ```
   php artisan migrate
   ```
   Alternatively, export SQL from your local development environment and import it.

3. Seed the admin user:
   ```
   php artisan db:seed --class=AdminUserSeeder
   ```

### Step 6: Optimization

1. Generate application key (if not already set):
   ```
   php artisan key:generate
   ```

2. Cache configuration (if you have SSH access):
   ```
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Troubleshooting Common Issues

### 500 Server Errors
- Check the Laravel log file in `storage/logs/laravel.log`
- Ensure `.htaccess` file is uploaded and mod_rewrite is enabled
- Check file permissions on `storage` and `bootstrap/cache` directories

### Unable to Write to Storage
- Check permissions on the `storage` directory
- Ensure the web server user has write access

### Database Connection Issues
- Verify your database credentials in `.env`
- Check if your hosting requires a specific hostname instead of 'localhost'

### White Screen / No Error Messages
- Enable error display temporarily in `index.php`:
  ```php
  ini_set('display_errors', 1);
  ```

## Additional Resources

- [Laravel Deployment Documentation](https://laravel.com/docs/10.x/deployment)
- Contact your hosting provider for specific server configuration details 