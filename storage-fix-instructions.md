# Storage Link Fix for OFYS Production

This document explains how to fix the image loading issue on the production server.

## Problem

Images uploaded through the application are saved in `storage/app/public` but are not accessible via the web because the storage link is not working correctly on the shared hosting environment.

Current URLs are pointing to:
```
https://ofys.eastbizz.com/storage/activity_images/...
```

But the actual location of the files on the server is:
```
https://ofys.eastbizz.com/public/storage/activity_images/...
```

## Solution 1: Use the Helper Function (Already Implemented)

The application now includes a `storage_url()` helper function that automatically adjusts the URL based on the environment. The key views have been updated to use this function.

## Solution 2: Fix the Storage Link on the Server

### Option A: Run the Custom Artisan Command (Recommended)

We've created a custom artisan command to fix the storage link issue. Run one of these commands on your production server:

```bash
# Try standard symbolic link (may not work on shared hosting)
php artisan storage:fix-links

# Use hard copy method for shared hosting
php artisan storage:fix-links --hard-copy
```

The `--hard-copy` option will physically copy files instead of creating symbolic links, which is more compatible with shared hosting environments.

### Option B: Manual Symlink or Copy (Alternative)

If you don't want to use the command, you can manually:

1. SSH into your server
2. Navigate to your Laravel installation directory
3. Create a symbolic link (if supported):
```bash
ln -s /path/to/storage/app/public /path/to/public/storage
```

Or copy the files manually:
```bash
cp -r /path/to/storage/app/public/. /path/to/public/storage/
```

## Solution 3: Adjust .htaccess (Alternative)

You could also modify the `.htaccess` file in your public directory to redirect requests from `/storage` to `/public/storage`:

```apache
# Redirect /storage to /public/storage
RewriteRule ^storage/(.*)$ public/storage/$1 [L,R=301]
```

## Future Deployments

When uploading new deployments, make sure to either:

1. Run `php artisan storage:fix-links --hard-copy` after deploying
2. Include the `/public/storage` directory in your deployment package
3. Manually copy files from `storage/app/public` to `public/storage`

## Testing

After implementing one of these solutions, test by viewing an activity with images to confirm they load correctly. 
