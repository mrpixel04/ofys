#!/bin/bash

# OFYS - Deployment Preparation Script
# This script prepares your Laravel application for shared hosting deployment

echo "🚀 OFYS Deployment Preparation Script"
echo "======================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Step 1: Export Database
echo -e "${YELLOW}📦 Step 1: Export Database${NC}"
echo "Please export your database manually:"
echo "1. Open phpMyAdmin: http://localhost/phpmyadmin"
echo "2. Select 'dbofys' database"
echo "3. Click 'Export' tab"
echo "4. Choose 'Custom' method"
echo "5. Select all tables"
echo "6. Click 'Go' and save as: dbofys_backup_$(date +%Y%m%d).sql"
echo ""
read -p "Press Enter when database export is complete..."

# Step 2: Clean up unnecessary files
echo -e "${YELLOW}🧹 Step 2: Cleaning up unnecessary files${NC}"
rm -rf node_modules/
rm -rf storage/logs/*.log
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
echo -e "${GREEN}✓ Cleanup complete${NC}"
echo ""

# Step 3: Create deployment archive
echo -e "${YELLOW}📦 Step 3: Creating deployment archive${NC}"
ARCHIVE_NAME="ofys_production_$(date +%Y%m%d_%H%M%S).zip"

zip -r "$ARCHIVE_NAME" . \
  -x "*.git*" \
  -x "node_modules/*" \
  -x "storage/logs/*" \
  -x "storage/framework/cache/*" \
  -x "storage/framework/sessions/*" \
  -x "storage/framework/views/*" \
  -x ".env" \
  -x "*.sh" \
  -x "tests/*" \
  -x ".DS_Store"

echo -e "${GREEN}✓ Archive created: $ARCHIVE_NAME${NC}"
echo ""

# Step 4: Create production .env template
echo -e "${YELLOW}📝 Step 4: Creating production .env template${NC}"
cat > .env.production.template << 'EOF'
APP_NAME=OFYS
APP_ENV=production
APP_KEY=base64:SfLbvGKUNkdG4VC1EIU/j6aa+y/v2GQv8A50/lRLx/w=
APP_DEBUG=false
APP_URL=https://gooutdoor.asia

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

# ⚠️ UPDATE THESE WITH YOUR PRODUCTION DATABASE CREDENTIALS
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_dbofys
DB_USERNAME=yourusername_dbofys_user
DB_PASSWORD=YOUR_STRONG_PASSWORD_HERE

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=.gooutdoor.asia

CACHE_STORE=file
QUEUE_CONNECTION=sync

# ⚠️ UPDATE MAIL SETTINGS
MAIL_MAILER=smtp
MAIL_HOST=mail.gooutdoor.asia
MAIL_PORT=587
MAIL_USERNAME=noreply@gooutdoor.asia
MAIL_PASSWORD=YOUR_EMAIL_PASSWORD
MAIL_FROM_ADDRESS="noreply@gooutdoor.asia"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=tls

# ⚠️ UPDATE BILLPLZ SETTINGS (PRODUCTION CREDENTIALS)
BILLPLZ_API_KEY=your_production_api_key_here
BILLPLZ_API_URL=https://www.billplz.com/api
BILLPLZ_COLLECTION_ID=your_collection_id_here
BILLPLZ_X_SIGNATURE_KEY=your_x_signature_key_here

# WhatsApp Integration
WHATSAPP_API_URL=https://buzzbridge.aplikasi-io.com/api
WHATSAPP_API_KEY=your_whatsapp_api_key
WHATSAPP_WEBHOOK_URL=https://gooutdoor.asia/api/webhooks/whatsapp
WHATSAPP_SECRET_KEY=your_secret_key
WHATSAPP_QR_ENDPOINT=/qr

# N8N Integration
N8N_API_URL=https://your-n8n-instance.com/api
N8N_WEBHOOK_URL=https://your-n8n-instance.com/webhook
N8N_API_KEY=your_n8n_api_key
N8N_WORKFLOW_ID=your_workflow_id

VITE_APP_NAME="${APP_NAME}"
EOF

echo -e "${GREEN}✓ Production .env template created${NC}"
echo ""

# Step 5: Display deployment checklist
echo -e "${YELLOW}📋 Deployment Checklist${NC}"
echo "=================================="
echo ""
echo "Files Ready:"
echo "  ✓ $ARCHIVE_NAME (upload this to server)"
echo "  ✓ .env.production.template (configure on server)"
echo "  ✓ .htaccess.production (rename to .htaccess on server)"
echo "  ✓ index.php.production (rename to index.php on server)"
echo "  ✓ DEPLOYMENT_GUIDE.md (follow this guide)"
echo ""
echo "Next Steps:"
echo "  1. Upload $ARCHIVE_NAME to your server"
echo "  2. Extract files outside public_html (e.g., /home/yourusername/ofys)"
echo "  3. Move public/* files to public_html/"
echo "  4. Copy .htaccess.production to public_html/.htaccess"
echo "  5. Copy index.php.production to public_html/index.php"
echo "  6. Create .env file on server using .env.production.template"
echo "  7. Import database using phpMyAdmin"
echo "  8. Create storage symlink"
echo "  9. Set file permissions (755 for dirs, 644 for files)"
echo "  10. Clear caches: php artisan cache:clear"
echo ""
echo -e "${GREEN}✅ Deployment preparation complete!${NC}"
echo ""
echo "📖 For detailed instructions, see: DEPLOYMENT_GUIDE.md"
echo ""
