#!/bin/bash

# OFYS Deployment Script
# Usage: bash deploy.sh
# Description: Runs all deployment commands with colored output

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print section headers
print_header() {
    echo -e "\n${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}\n"
}

# Function to print success
print_success() {
    echo -e "${GREEN}✓ $1${NC}\n"
}

# Function to print error
print_error() {
    echo -e "${RED}✗ $1${NC}\n"
}

# Function to print info
print_info() {
    echo -e "${YELLOW}ℹ $1${NC}\n"
}

# Start deployment
print_header "🚀 OFYS DEPLOYMENT STARTED"
echo -e "Started at: $(date '+%Y-%m-%d %H:%M:%S')\n"

# Step 1: Composer Install
print_header "📦 STEP 1: Installing Composer Dependencies"
if composer install --no-dev --optimize-autoloader; then
    print_success "Composer dependencies installed successfully"
else
    print_error "Composer install failed"
    exit 1
fi

# Step 2: Clear Config Cache
print_header "🧹 STEP 2: Clearing Configuration Cache"
if php artisan config:clear; then
    print_success "Configuration cache cleared"
else
    print_error "Failed to clear config cache"
    exit 1
fi

# Step 3: Cache Config
print_header "⚙️  STEP 3: Caching Configuration"
if php artisan config:cache; then
    print_success "Configuration cached successfully"
else
    print_error "Failed to cache configuration"
    exit 1
fi

# Step 4: Cache Routes
print_header "🛣️  STEP 4: Caching Routes"
if php artisan route:cache; then
    print_success "Routes cached successfully"
else
    print_error "Failed to cache routes"
    exit 1
fi

# Step 5: Cache Views
print_header "👁️  STEP 5: Caching Views"
if php artisan view:cache; then
    print_success "Views cached successfully"
else
    print_error "Failed to cache views"
    exit 1
fi

# Step 6: Set Permissions
print_header "🔐 STEP 6: Setting Directory Permissions"
if chmod -R 755 storage bootstrap/cache; then
    print_success "Permissions set successfully (755)"
else
    print_error "Failed to set permissions"
    exit 1
fi

# Optional: Copy build assets (uncomment if needed)
# print_header "📁 STEP 7: Copying Build Assets"
# if [ -d "public/build" ]; then
#     if cp -r public/build/* ../build/ 2>/dev/null; then
#         print_success "Build assets copied to parent directory"
#     else
#         print_info "Could not copy build assets (may not be needed)"
#     fi
# else
#     print_info "No build directory found (skipping)"
# fi

# Summary
print_header "✅ DEPLOYMENT COMPLETED SUCCESSFULLY"
echo -e "Finished at: $(date '+%Y-%m-%d %H:%M:%S')\n"
echo -e "${GREEN}🎉 Your application is now deployed!${NC}\n"
echo -e "${YELLOW}Next steps:${NC}"
echo -e "  1. Visit your website to verify changes"
echo -e "  2. Check Laravel logs if any issues: tail -f storage/logs/laravel.log"
echo -e "  3. Monitor error logs in cPanel\n"

