#!/bin/bash

# Script to fix 404 errors on eastbizz.com/ofys
echo "Starting 404 error fix for ofys..."

# Go to the application root directory
cd /home/your_cpanel_username/public_html/ofys

# 1. Verify and fix .htaccess files
echo "Checking .htaccess files..."

# Check main .htaccess
if [ ! -f .htaccess ]; then
    echo "Creating main .htaccess..."
    cat > .htaccess << 'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOL
    chmod 644 .htaccess
fi

# Check public/.htaccess
if [ ! -f public/.htaccess ]; then
    echo "Creating public/.htaccess..."
    cat > public/.htaccess << 'EOL'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOL
    chmod 644 public/.htaccess
fi

# 2. Fix directory permissions
echo "Setting correct permissions..."
find storage -type d -exec chmod 755 {} \;
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type d -exec chmod 755 {} \;
chmod 755 bootstrap/cache

# 3. Verify storage symlink
echo "Checking storage symlink..."
if [ ! -L public/storage ]; then
    echo "Creating storage symlink manually..."
    mkdir -p public/storage
    cp -r storage/app/public/* public/storage/
fi

# 4. Clear Laravel cache if possible
if [ -f artisan ]; then
    echo "Clearing application cache..."
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    php artisan route:clear
fi

# 5. Check if .env exists and has proper APP_URL
if [ -f .env ]; then
    APP_URL_SET=$(grep "APP_URL=https://eastbizz.com/ofys" .env)
    if [ -z "$APP_URL_SET" ]; then
        echo "Setting proper APP_URL in .env..."
        sed -i 's|APP_URL=.*|APP_URL=https://eastbizz.com/ofys|g' .env
    fi
fi

echo "Fix completed. Please check if the 404 errors are resolved."
echo "If not, please check the Laravel error log at storage/logs/laravel.log"
