# Laravel 12 Deployment Checklist

## Pre-Deployment Checks
1. ✅ Ensure you have PHP 8.2+ on your hosting (use php-info.php to verify)
2. ✅ Ensure all required PHP extensions are available (see php-info.php)
3. ✅ Confirm database credentials in .env.production are correct
4. ✅ Confirm mail settings in .env.production are correct

## Deployment Process
1. Upload the deployment package contents to your hosting root directory
2. Rename .env.production to .env
3. Set proper file permissions:
   - chmod 755 for directories
   - chmod 644 for files
   - chmod 755 for artisan and any executable scripts
4. Point your web server's document root to the `public` folder
5. If needed, modify .htaccess file to handle URL rewrites correctly

## Post-Deployment Steps
1. Run database migrations (if possible via SSH): `php artisan migrate --force`
   - If SSH is not available, manually import database schema 
2. Clear application cache: `php artisan optimize:clear`
3. Generate optimized files: `php artisan optimize`
4. Test crucial functionality:
   - Check the homepage loads correctly
   - Test any forms or interactive elements
   - Verify database connections work
   - Check error logging is working

## Troubleshooting Common Issues
1. **500 Server Error**:
   - Check PHP version (must be 8.2+)
   - Verify all required PHP extensions are installed
   - Check file permissions
   - Review error logs
   
2. **404 Not Found for Routes**:
   - Ensure .htaccess is correctly configured
   - Check that mod_rewrite is enabled on your server
   - Verify the web server is properly pointing to the public directory

3. **Database Connection Issues**:
   - Verify database credentials in .env file
   - Confirm database user has proper permissions
   - Check database server is accessible from your hosting

4. **Mail Sending Failures**:
   - Verify SMTP credentials
   - Check mail server allows connections from your hosting
   - Test mail functionality in isolation

## Shared Hosting Specific Notes
1. Some shared hosts require a specific directory structure. If needed:
   - Put all Laravel files except public/ in a private directory
   - Move public/ files to your public_html or www folder
   - Update index.php to reflect the new path to your Laravel installation

2. If your host provides a control panel:
   - Use it to create and manage your database
   - Set up cron jobs for scheduled tasks
   - Configure domain and subdomain settings

## Maintenance Recommendations
1. Set up regular backups of both code and database
2. Install monitoring tools to alert you of downtime
3. Regularly check for Laravel security updates 
