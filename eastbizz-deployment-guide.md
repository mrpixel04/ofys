# Eastbizz.com Deployment Guide

This guide provides instructions for deploying the website directly to the main domain **eastbizz.com**.

## Pre-Deployment Checks

1. Ensure you have PHP 8.2+ on your hosting
2. Verify all required PHP extensions are available
3. Confirm database credentials in `.env.production` are correct
4. Ensure the website is configured to use the main domain in all files

## Deployment Steps

1. **Prepare the deployment package**:
   ```bash
   ./prepare-deploy.sh
   ```
   This will create a zip file named `eastbizz-deployment-YYYYMMDD-HHMMSS.zip`

2. **Upload to hosting**:
   - Extract all contents to the root directory of your hosting account
   - Ensure all files are in the correct locations

3. **Configure environment**:
   - Rename `.env.production` to `.env` (if not already done)
   - Verify APP_URL is set to `https://eastbizz.com`
   - Confirm database credentials are correct

4. **Set file permissions**:
   ```bash
   chmod 755 artisan
   find . -type d -exec chmod 755 {} \;
   find . -type f -exec chmod 644 {} \;
   ```

5. **Set up storage**:
   - Ensure `public/storage` exists and contains the necessary files
   - If not, run the storage sync script:
   ```
   https://eastbizz.com/storage-sync.php?key=12345
   ```

6. **Database setup**:
   - If you have SSH access: `php artisan migrate --force`
   - Otherwise, use the database management tool provided by your hosting to import the latest database schema

## Testing

After deploying, verify the following:

1. Website loads correctly at https://eastbizz.com
2. All pages work without errors
3. Images and assets load properly
4. Forms and interactive elements work as expected
5. Database operations work correctly

## Troubleshooting

If you encounter issues:

1. Check the Laravel log at `storage/logs/laravel.log`
2. Verify .htaccess files are correctly set up in both root and public directories
3. Ensure your hosting server has the right PHP version and extensions
4. Check that database credentials are correct
5. Verify all URLs in the application are using the main domain

## Important Notes

- The application is now configured to use the main domain directly (eastbizz.com)
- All links and references have been updated from ofys.eastbizz.com to eastbizz.com
- The storage configuration has been adjusted to work with the main domain setup 
