#!/bin/bash

# Set colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}Building assets for production...${NC}"
rm -rf public/build
npm run build

echo -e "${GREEN}Preparing files for deployment to eastbizz.com...${NC}"

# Create deployment directory if it doesn't exist
DEPLOY_DIR="./deployment-package"
rm -rf $DEPLOY_DIR
mkdir -p $DEPLOY_DIR

# Essential directories to copy
echo "Copying essential directories..."
cp -r app bootstrap config database public resources routes storage vendor $DEPLOY_DIR/

# Create storage symlink manually for shared hosting
mkdir -p $DEPLOY_DIR/public/storage
cp -r storage/app/public/* $DEPLOY_DIR/public/storage/

# Also create a top-level storage directory for direct URL access
mkdir -p $DEPLOY_DIR/storage
cp -r storage/app/public/* $DEPLOY_DIR/storage/

# Copy essential files
echo "Copying essential files..."
cp .htaccess $DEPLOY_DIR/
cp index.php $DEPLOY_DIR/
cp artisan $DEPLOY_DIR/
cp composer.json $DEPLOY_DIR/
cp composer.lock $DEPLOY_DIR/
cp vite.config.js $DEPLOY_DIR/
cp php.ini $DEPLOY_DIR/

# Make sure root .htaccess handles /public/ URLs correctly
echo "Ensuring .htaccess handles /public/ URLs..."
if ! grep -q "RewriteRule \^public/" $DEPLOY_DIR/.htaccess; then
    sed -i'' -e '/RewriteEngine On/a\
    # Redirect /public/ URLs to remove the public prefix\
    RewriteRule ^public/(.*)$ /$1 [L,R=301]' $DEPLOY_DIR/.htaccess
fi

# Copy debugging scripts
cp public/simple-test.php $DEPLOY_DIR/public/
cp public/path-test.php $DEPLOY_DIR/public/
cp public/asset-proxy.php $DEPLOY_DIR/public/

# Ensure JS/CSS fallbacks exist
echo "Ensuring legacy asset paths work..."
mkdir -p $DEPLOY_DIR/public/css
mkdir -p $DEPLOY_DIR/public/js

# Also create files at the root level for direct access
mkdir -p $DEPLOY_DIR/css
mkdir -p $DEPLOY_DIR/js

# Create the fallback files
CSS_HASH=$(grep -o 'app-[a-zA-Z0-9]*\.css' public/build/manifest.json | head -1)
JS_HASH=$(grep -o 'app-[a-zA-Z0-9]*\.js' public/build/manifest.json | head -1)

# Create app.css files
echo "/* Redirect to real CSS file */
@import url('../build/assets/${CSS_HASH}');" > $DEPLOY_DIR/public/css/app.css

echo "/* Root CSS asset loader */
@import url('/build/assets/${CSS_HASH}');" > $DEPLOY_DIR/css/app.css

# Create app.js files
echo "// Redirect to real JS file
(function() {
    const script = document.createElement('script');
    script.src = '/build/assets/${JS_HASH}';
    document.head.appendChild(script);
    console.log('JS asset loader executed from public/js/app.js');
})();" > $DEPLOY_DIR/public/js/app.js

echo "// Redirect to real JS file
(function() {
    const script = document.createElement('script');
    script.src = '/build/assets/${JS_HASH}';
    document.head.appendChild(script);
    console.log('JS asset loader executed from /js/app.js');
})();" > $DEPLOY_DIR/js/app.js

# Update asset-proxy.php with correct hashes
echo "Updating asset proxy with correct file hashes..."
if [ -f "$DEPLOY_DIR/public/asset-proxy.php" ]; then
    sed -i'.bak' "s/app-[a-zA-Z0-9]*\.js/$JS_HASH/g" $DEPLOY_DIR/public/asset-proxy.php
    sed -i'.bak' "s/app-[a-zA-Z0-9]*\.css/$CSS_HASH/g" $DEPLOY_DIR/public/asset-proxy.php
    rm -f $DEPLOY_DIR/public/asset-proxy.php.bak
fi

# Ensure all assets are within public folder
echo "Ensuring proper public directory structure..."
DEPLOY_PUBLIC="$DEPLOY_DIR/public"

# Move any root assets to public folder
if [ -d "$DEPLOY_DIR/build" ]; then
    echo "Moving /build to /public/build..."
    mkdir -p $DEPLOY_PUBLIC/build
    cp -r $DEPLOY_DIR/build/* $DEPLOY_PUBLIC/build/
    rm -rf $DEPLOY_DIR/build
fi

if [ -d "$DEPLOY_DIR/js" ]; then
    echo "Moving /js to /public/js..."
    mkdir -p $DEPLOY_PUBLIC/js
    cp -r $DEPLOY_DIR/js/* $DEPLOY_PUBLIC/js/
    rm -rf $DEPLOY_DIR/js
fi

if [ -d "$DEPLOY_DIR/css" ]; then
    echo "Moving /css to /public/css..."
    mkdir -p $DEPLOY_PUBLIC/css
    cp -r $DEPLOY_DIR/css/* $DEPLOY_PUBLIC/css/
    rm -rf $DEPLOY_DIR/css
fi

# Set up htaccess to route through public
echo "Setting up .htaccess to force public path..."
cat > $DEPLOY_DIR/.htaccess << 'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Force all asset requests to go through /public/
    RewriteRule ^build/(.*)$ /public/build/$1 [L,R=301]
    RewriteRule ^js/(.*)$ /public/js/$1 [L,R=301]
    RewriteRule ^css/(.*)$ /public/css/$1 [L,R=301]
    RewriteRule ^storage/(.*)$ /public/storage/$1 [L,R=301]

    # Send all non-asset requests to index.php
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOL

# Copy compiled assets
echo "Ensuring compiled assets are included..."
mkdir -p $DEPLOY_PUBLIC/build
cp -r public/build/* $DEPLOY_PUBLIC/build/

# Copy and rename .env.production to .env
echo "Setting up environment file..."
cp .env.production $DEPLOY_DIR/.env

# Create necessary directories with proper permissions
echo "Setting up storage permissions..."
mkdir -p $DEPLOY_DIR/storage/framework/{sessions,views,cache}
mkdir -p $DEPLOY_DIR/storage/logs
touch $DEPLOY_DIR/storage/logs/laravel.log

# Create a zip file
echo "Creating deployment zip file..."
ZIP_FILE="eastbizz-deployment-$(date +%Y%m%d-%H%M%S).zip"
(cd $DEPLOY_DIR && zip -r ../$ZIP_FILE .)

echo -e "${GREEN}Deployment package created: $ZIP_FILE${NC}"
echo -e "${GREEN}Upload all contents of the zip file to your hosting root directory.${NC}"
