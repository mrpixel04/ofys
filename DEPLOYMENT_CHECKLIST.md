# OFYS Deployment Checklist for Shared Hosting

## Pre-deployment Steps
1. Make sure your shared hosting supports PHP 8.1+ and has the required PHP extensions:
   - BCMath
   - Ctype
   - Fileinfo
   - JSON
   - Mbstring
   - OpenSSL
   - PDO (with required database driver)
   - Tokenizer
   - XML

2. Set up a database on your shared hosting (MySQL or MariaDB recommended)

## Deployment Steps
1. Upload the ZIP file contents to your shared hosting (public_html or www folder)

2. Configure the .env file:
   - Copy the .env.example file to .env if it doesn't exist
   - Update the database connection details
   - Set APP_ENV=production
   - Set APP_DEBUG=false
   - Update mail configuration for your hosting

3. Install composer dependencies:
   ```
   composer install --optimize-autoloader --no-dev
   ```

4. Generate application key:
   ```
   php artisan key:generate
   ```

5. Run database migrations:
   ```
   php artisan migrate
   ```

6. Create symbolic link for storage:
   ```
   php artisan storage:link
   ```

7. Optimize Laravel:
   ```
   php artisan optimize
   php artisan view:cache
   php artisan config:cache
   php artisan route:cache
   ```

8. Update directory permissions:
   - storage/ directory should be writable (755 or 775)
   - bootstrap/cache directory should be writable (755 or 775)

## Shared Hosting Specific
1. If your hosting uses cPanel, you may need to modify the document root to point to the 'public' folder

2. Create or modify .htaccess in the root directory if needed:
   ```
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```

3. Ensure storage/app/public is writable for file uploads

4. Check if your hosting provider supports Laravel's scheduler. If so, set up a cron job:
   ```
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## Post-deployment Checks
1. Test the login and registration functionality
2. Verify that all routes work correctly
3. Check file upload functionality
4. Test email sending if applicable
