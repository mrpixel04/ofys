#!/bin/bash

# Script to fix Vite manifest errors on eastbizz.com/ofys
echo "Starting Vite manifest fix for ofys..."

# Go to the application root directory
cd /home/eastbizzcom/public_html/ofys

# Create a proper .env file for production if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    # Set proper values
    sed -i 's|APP_ENV=.*|APP_ENV=production|g' .env
    sed -i 's|APP_DEBUG=.*|APP_DEBUG=false|g' .env
    sed -i 's|APP_URL=.*|APP_URL=https://eastbizz.com/ofys|g' .env
    # Generate app key if needed
    php artisan key:generate
fi

# 1. Verify vite.config.js is correct
echo "Checking for Vite configuration..."
if [ -f vite.config.js ]; then
    echo "Vite configuration exists, updating..."
    cat > vite.config.js << 'EOL'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: '/ofys/build/',
    build: {
        manifest: true,
        outDir: 'public/build',
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            publicDirectory: 'public',
        }),
        tailwindcss(),
    ],
});
EOL
fi

# 2. Create the build directory if it doesn't exist
mkdir -p public/build

# 3. Create a minimal manifest.json file
echo "Creating minimal manifest.json..."
cat > public/build/manifest.json << 'EOL'
{
  "resources/css/app.css": {
    "file": "assets/app-BTFOwWE6.css",
    "src": "resources/css/app.css",
    "isEntry": true
  },
  "resources/js/app.js": {
    "file": "assets/app-BPKtxCGZ.js",
    "name": "app",
    "src": "resources/js/app.js",
    "isEntry": true
  }
}
EOL

# 4. Create the assets directory
mkdir -p public/build/assets

# 5. Copy the asset files from the deployment if they exist
if [ -f public/build.zip ]; then
    echo "Extracting assets from build.zip..."
    unzip -o public/build.zip -d public/tmp_build
    if [ -d public/tmp_build/build/assets ]; then
        cp -r public/tmp_build/build/assets/* public/build/assets/
    fi
    rm -rf public/tmp_build
fi

# 6. If we don't have asset files, create minimal ones
if [ ! -f public/build/assets/app-BTFOwWE6.css ]; then
    echo "Creating placeholder CSS file..."
    cat > public/build/assets/app-BTFOwWE6.css << 'EOL'
/* Placeholder CSS file */
EOL
fi

if [ ! -f public/build/assets/app-BPKtxCGZ.js ]; then
    echo "Creating placeholder JS file..."
    cat > public/build/assets/app-BPKtxCGZ.js << 'EOL'
// Placeholder JavaScript file
EOL
fi

# 7. Fix permissions
echo "Setting correct permissions..."
find public/build -type d -exec chmod 755 {} \;
find public/build -type f -exec chmod 644 {} \;

# 8. Clear Laravel cache
if [ -f artisan ]; then
    echo "Clearing application cache..."
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    php artisan route:clear
fi

echo "Fix completed. Please check if the Vite errors are resolved."
echo "If not, please check the Laravel error log at storage/logs/laravel.log"
