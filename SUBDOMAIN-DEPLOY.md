# Laravel Deployment Guide for Subdomain Hosting

This guide explains how to deploy the Laravel application to your shared hosting at https://ofys.eastbizz.com.

## Deployment Steps

1. **Prepare the deployment package**:
   Run the deployment script locally:
   ```
   chmod +x deploy-subdomain.sh
   ./deploy-subdomain.sh
   ```
   This will:
   - Build the Vite assets with `npm run build`
   - Create a deployment package file: `ofys-subdomain-deployment.zip`

2. **Upload to your hosting**:
   - Log in to your cPanel on your shared hosting
   - Navigate to the file manager for your subdomain: `https://ofys.eastbizz.com`
   - Upload the `ofys-subdomain-deployment.zip` file
   - Extract the ZIP file in the root directory of your subdomain

3. **Set up the database**:
   - Create a database using cPanel
   - Update the database credentials in the `.env` file:
     ```
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=[your_database_name]
     DB_USERNAME=[your_database_username]
     DB_PASSWORD=[your_database_password]
     ```

4. **Run database migrations**:
   - Use phpMyAdmin or your hosting's database tool to import the database schema
   - If your hosting allows shell access, you could try:
     ```
     php artisan migrate
     ```

5. **Configure permissions**:
   - Use cPanel's File Manager to ensure the following directories are writable:
     - `storage/` (and all subdirectories)
     - `bootstrap/cache/`
   - If necessary, chmod directories to 755 and files to 644

6. **Test your application** by visiting: `https://ofys.eastbizz.com`

## Troubleshooting

If you encounter issues:

1. **404 Errors**: Ensure .htaccess files are properly uploaded and your hosting supports mod_rewrite

2. **500 Errors**: Check the Laravel error logs in `storage/logs/laravel.log`

3. **Blank Pages**: Make sure PHP settings are compatible with Laravel requirements

4. **Missing Assets**: Verify that the Vite assets were built successfully and copied to the public/build directory

5. **Database Connection Issues**: Double-check your database credentials in the .env file

## Maintenance

For future updates:

1. Make changes to your local development environment
2. Run the deployment script again: `./deploy-subdomain.sh`
3. Upload and extract the new ZIP file

## Important Notes

- The storage directory symlink is manually created since artisan commands cannot be run directly on shared hosting
- Remember to update your production database credentials in `.env`
- If your hosting provider requires specific PHP settings, you may need to create a custom php.ini file 
