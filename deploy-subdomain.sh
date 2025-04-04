#!/bin/bash

# Build Vite assets first
echo "Building Vite assets..."
npm run build

# Create deployment directory
echo "Creating deployment package..."
rm -rf deployment
mkdir -p deployment

# Copy necessary files
cp -r app deployment/
cp -r bootstrap deployment/
cp -r config deployment/
cp -r database deployment/
cp -r lang deployment/ 2>/dev/null || echo "No lang directory found, skipping..."
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
echo "Creating storage symlink..."
mkdir -p deployment/public/storage
cp -r storage/app/public/* deployment/public/storage/ 2>/dev/null || echo "No public storage files found, creating empty directory..."

# Copy built assets
echo "Copying built assets..."
cp -r public/build deployment/public/

# Set permissions
echo "Setting file permissions..."
find deployment -type f -exec chmod 644 {} \;
find deployment -type d -exec chmod 755 {} \;
chmod 755 deployment/artisan

# Create .htaccess for subdomain setup
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

# Create main .htaccess for root-level redirect
cat > deployment/.htaccess << 'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOL

# Create zip file
echo "Creating zip archive..."
cd deployment
zip -r ../ofys-subdomain-deployment.zip .
cd ..

echo "Deployment package created: ofys-subdomain-deployment.zip"
echo "Upload this package to your shared hosting at https://ofys.eastbizz.com"
echo "After uploading, extract the zip file in the main directory of your subdomain."