# CLAUDE.md

> **Last Updated**: December 8, 2025
> **Current Branch**: `main`
> **Status**: Payment system refactored + Deployed to production

---

## Quick Start for New AI Session

```bash
# Start development
php artisan serve
npm run dev

# Clear caches
php artisan optimize:clear
```

**Test Credentials:**
- Admin: `admin@gmail.com` / `Passw0rd123`
- Provider: `tombak@gmail.com` / `Passw0rd123`
- Customer: `customer@gmail.com` / `Passw0rd123`

**Production URL:** https://gooutdoor.asia

---

## Project Overview

**OFYS** = Outdoor Activity Booking Platform (Laravel 12)

### Tech Stack
- **Backend**: Laravel 12, PHP 8.2+, MySQL
- **Frontend**: Blade + jQuery 3.7.1 + Tailwind CSS 4.0
- **Payment**: Billplz Payment Gateway (Malaysian)
- **NO Livewire or Alpine.js** - use jQuery only

### Role-Based Structure
```
Controllers: app/Http/Controllers/{Admin,Customer,Provider,Guest}/
Views: resources/views/{admin,customer,provider,guest}/
```

### Color Schemes
- **Guest**: Yellow `#EAB308` / Blue `#2563EB`
- **Provider**: Teal `#14B8A6` / Emerald `#10B981`
- **Admin**: Purple `#7C3AED` / Indigo `#6366F1`

---

## Latest Session (December 8, 2025)

### Completed Tasks

1. **Payment System Refactored**
   - Created dedicated `payments` table (separated from bookings)
   - New `Payment` model with status methods
   - Updated `BillplzService` to work with Payment model
   - Fixed PaymentController routes

2. **Payment UI/UX Improvements**
   - Redesigned receipt page (yellow/blue palette)
   - Redesigned payment status page with timeline
   - Print function prints only receipt (not browser UI)
   - Professional modern design

3. **Customer Dashboard**
   - Reordered tabs: Bookings → Settings → Profile
   - Added icons to tabs

4. **Header Dropdown Fix**
   - Fixed z-index issue (dropdown now works on all pages)

5. **Missing Components Created**
   - `application-logo.blade.php`
   - `nav-link.blade.php`
   - `dropdown-link.blade.php`
   - `responsive-nav-link.blade.php`

6. **Deployed to Production**
   - Shared hosting via cPanel terminal
   - All migrations run successfully
   - Assets copied to public_html

---

## Key Files Modified

```
# Payment System
app/Models/Payment.php (NEW)
database/migrations/2025_12_08_100000_create_payments_table.php (NEW)
app/Http/Controllers/Customer/PaymentController.php
app/Models/Booking.php
app/Services/BillplzService.php

# Views
resources/views/customer/payment/receipt.blade.php
resources/views/customer/payment/status.blade.php
resources/views/customer/payment/success.blade.php
resources/views/customer/payment/failed.blade.php
resources/views/customer/dashboard.blade.php
resources/views/layouts/partials/header.blade.php

# Components
resources/views/components/application-logo.blade.php
resources/views/components/nav-link.blade.php
resources/views/components/dropdown-link.blade.php
resources/views/components/responsive-nav-link.blade.php

# Deployment Docs
STEP_TO_DEPLOY.md
DEPLOY-SHARED-HOSTING.md
```

---

## Deployment (cPanel Terminal)

```bash
# Quick Deploy (All-in-One)
cd ~/public_html/ofys && git pull origin main && composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && chmod -R 755 storage bootstrap/cache && cp -r public/build/* ../build/
```

See `STEP_TO_DEPLOY.md` for detailed steps.

---

## Billplz Payment Configuration

```env
# Sandbox (Testing)
BILLPLZ_API_KEY=your_sandbox_key
BILLPLZ_API_URL=https://www.billplz-sandbox.com/api
BILLPLZ_COLLECTION_ID=your_collection_id
BILLPLZ_X_SIGNATURE_KEY=your_signature_key

# Production
BILLPLZ_API_URL=https://www.billplz.com/api
```

---

## Known Issues

- Register page has 500 error (needs investigation)

---

## Example Prompts for Next Session

```
"Fix the register page 500 error"
"Add translations to the customer dashboard pages"
"Test payment flow on production"
"Add email notifications for bookings"
```
