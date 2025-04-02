#!/bin/bash

# Create deployment directory
mkdir -p deployment

# Copy necessary files
cp -r app deployment/
cp -r bootstrap deployment/
cp -r config deployment/
cp -r database deployment/
cp -r lang deployment/
cp -r public deployment/
cp -r resources deployment/
cp -r routes deployment/
cp -r storage deployment/
cp -r vendor deployment/
cp .env.production deployment/.env
cp artisan deployment/
cp composer.json deployment/
cp composer.lock deployment/

# Create storage symlink manually since we can't run artisan on the server
mkdir -p deployment/public/storage
cp -r storage/app/public/* deployment/public/storage/

# Permissions
find deployment -type f -exec chmod 644 {} \;
find deployment -type d -exec chmod 755 {} \;
chmod 755 deployment/artisan

# Create .htaccess for subdirectory setup
cat > deployment/public/.htaccess << 'EOL'
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

# Create main .htaccess for subdirectory redirect
cat > deployment/.htaccess << 'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOL

# Create zip file
cd deployment
zip -r ../ofys-deployment.zip .
cd ..

echo "Deployment package created: ofys-deployment.zip"
echo "Upload this package to your shared hosting at https://eastbizz.com/ofys"
