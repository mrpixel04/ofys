#!/bin/bash

# Set colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}Preparing files for deployment to shared hosting...${NC}"

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

# Copy essential files
echo "Copying essential files..."
cp .htaccess $DEPLOY_DIR/
cp index.php $DEPLOY_DIR/
cp artisan $DEPLOY_DIR/
cp composer.json $DEPLOY_DIR/
cp composer.lock $DEPLOY_DIR/
cp vite.config.js $DEPLOY_DIR/
cp php.ini $DEPLOY_DIR/

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
