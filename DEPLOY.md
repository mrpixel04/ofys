# Laravel 12 Deployment Guide for Shared Hosting

This guide explains how to deploy the Laravel 12 application to shared hosting at https://eastbizz.com/ofys.

## Pre-deployment Steps (already completed)

1. Built the Vite assets: `npm run build`
2. Created a production-ready .env file: `.env.production`
3. Generated a deployment package: `ofys-deployment.zip`

## Deployment Instructions

1. Log in to your shared hosting control panel.

2. Navigate to the file manager for the directory: `https://eastbizz.com/ofys`

3. Upload the `ofys-deployment.zip` file to this directory.

4. Extract the ZIP file in the `ofys` directory.

5. Set up the database:
   - Create a database using your hosting control panel
   - Update the database credentials in the `.env` file:
     ```
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=[your_database_name]
     DB_USERNAME=[your_database_username]
     DB_PASSWORD=[your_database_password]
     ```

6. Run database migrations through phpMyAdmin or the hosting's database tool:
   - Import the database schema if you have a SQL dump
   - Or, if your hosting allows shell access, run:
     ```
     php artisan migrate
     ```

7. Configure permissions:
   - Ensure `storage` and `bootstrap/cache` directories are writable (chmod 755)
   - Files should be 644

8. Test your application by visiting: `https://eastbizz.com/ofys`

## Troubleshooting

If you encounter issues:

1. Check the Laravel error logs in `storage/logs/laravel.log`
2. Verify .htaccess files are properly uploaded and configured
3. Ensure your hosting supports PHP 8.2+ and the required extensions
4. Contact your hosting provider if you need assistance with server configuration

## Maintenance

For future updates:

1. Make changes to your local development environment
2. Build assets with `npm run build`
3. Run the deployment script again: `./deploy.sh`
4. Upload and extract the new ZIP file

## Important Notes

- The storage symlink is manually created since artisan commands cannot be run directly on shared hosting
- The `.htaccess` files are configured for subdirectory installation
- Remember to update your production database credentials in `.env` 
