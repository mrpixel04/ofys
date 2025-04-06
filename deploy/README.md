# OFYS Admin Section Deployment

This zip file contains the admin section of the OFYS (Outdoor Fun Youth Sports) application. Follow these steps to deploy it to your shared hosting environment.

## Deployment Steps

1. **Upload the zip file** to your server using FTP or the hosting control panel
2. **Extract the zip file** in your hosting directory
3. **Configure environment variables**:
   - Copy `.env.example` to `.env`
   - Configure your database credentials
   - Set `APP_URL` to your website URL
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false` (for production)

4. **Set up the database**:
   - Create a new database if you don't have one
   - Run migrations: `php artisan migrate`
   - Seed the admin user: `php artisan db:seed --class=AdminUserSeeder`

5. **Set storage permissions**:
   - Run `php artisan storage:link` to create the symbolic link
   - Ensure the `storage` directory is writable (chmod 755 or 775)

6. **Clear caches**:
   - Run `php artisan config:cache`
   - Run `php artisan route:cache`
   - Run `php artisan view:cache`

## Admin Features Implemented

- Admin dashboard with statistics
- Provider management (view, create, edit, delete)
- Activity management (view, create, edit, delete)
- Special handling for camping/glamping lots
- Activity image management
- Status toggling for activities

## Admin Login

Default admin credentials (unless changed in the seeder):
- Email: admin@example.com
- Password: password

## Support

If you encounter any issues during deployment, please check the Laravel logs in `storage/logs/laravel.log`.

## Next Steps

The provider user level functionality will be implemented next, followed by the customer user level. 