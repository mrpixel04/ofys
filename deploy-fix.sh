#!/bin/bash
# Fix permissions for Laravel deployment

# Create required directories
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env file from .env.example"
fi

echo "Permission fix completed. Make sure to set the proper database credentials in the .env file."
echo "Then run: php artisan key:generate && php artisan migrate"
