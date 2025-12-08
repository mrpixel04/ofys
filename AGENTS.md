# AGENTS.md - AI Development Guide

> **Last Updated**: December 8, 2025
> **Purpose**: Quick reference for AI assistants working on OFYS

---

## Project Quick Start

**OFYS** = Outdoor Activity Booking Platform (Laravel 12, Malaysia-based)

**Production URL:** https://gooutdoor.asia

### Development Commands
```bash
php artisan serve          # Start Laravel
npm run dev               # Start Vite
php artisan optimize:clear # Clear all caches
php artisan migrate       # Run migrations
```

### Test Credentials
- Admin: `admin@gmail.com` / `Passw0rd123`
- Provider: `tombak@gmail.com` / `Passw0rd123`
- Customer: `customer@gmail.com` / `Passw0rd123`

---

## Architecture

### Tech Stack
- Laravel 12 + PHP 8.2+ + MySQL
- Blade + jQuery 3.7.1 + Tailwind CSS 4.0
- Billplz Payment Gateway (Malaysian)
- **NO Livewire or Alpine.js** - converted to jQuery

### Role-Based Organization
```
Controllers: app/Http/Controllers/{Admin,Customer,Provider,Guest}/
Views: resources/views/{admin,customer,provider,guest}/
Models: User, Activity, ActivityLot, Booking, Payment, ShopInfo
```

### Color Schemes (IMPORTANT)
| Role | Primary | Secondary |
|------|---------|-----------|
| Guest | Yellow `#EAB308` | Blue `#2563EB` |
| Provider | Teal `#14B8A6` | Emerald `#10B981` |
| Admin | Purple `#7C3AED` | Indigo `#6366F1` |

---

## Code Conventions

### Image Display
```blade
@if($activity->images && count($activity->images) > 0)
    <img src="{{ asset('storage/' . $activity->images[0]) }}" alt="{{ $activity->name }}">
@endif
```

### jQuery (NOT Alpine.js)
```javascript
$(document).ready(function() {
    $('#element').on('click', function() {
        // handler
    });
});
```

### Translations
```blade
{{ __('Your text here') }}
```
Files: `resources/lang/en.json`, `resources/lang/ms.json`

---

## Payment System

### Models
- `Booking` - booking details (user, activity, date, participants)
- `Payment` - payment details (bill_id, status, amount, gateway_response)

### Payment Flow
1. Customer creates booking → status: `pending`
2. Initiate payment → redirects to Billplz
3. Customer pays → Billplz callback/return
4. Payment confirmed → booking status: `confirmed`

### Key Files
```
app/Models/Payment.php
app/Services/BillplzService.php
app/Http/Controllers/Customer/PaymentController.php
```

---

## Latest Session (December 8, 2025)

### Completed
1. **Payment System Refactored** - Separated payments table from bookings
2. **Payment UI** - Receipt & status pages with yellow/blue palette
3. **Dashboard Tabs** - Reordered: Bookings → Settings → Profile
4. **Header Dropdown** - Fixed z-index for all pages
5. **Missing Components** - Created nav-link, dropdown-link, etc.
6. **Production Deploy** - Deployed to gooutdoor.asia

### Files Modified
- `app/Models/Payment.php` (NEW)
- `app/Http/Controllers/Customer/PaymentController.php`
- `resources/views/customer/payment/*.blade.php`
- `resources/views/customer/dashboard.blade.php`
- `resources/views/layouts/partials/header.blade.php`

---

## Deployment (cPanel)

```bash
cd ~/public_html/ofys && git pull origin main && composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && chmod -R 755 storage bootstrap/cache && cp -r public/build/* ../build/
```

See `STEP_TO_DEPLOY.md` for detailed steps.

---

## Known Issues

- Register page 500 error (needs investigation)

---

## Routes Reference

| Route | Description |
|-------|-------------|
| `/` | Home page |
| `/activities` | Activity listings |
| `/activities/{id}` | Activity detail |
| `/login`, `/register` | Auth pages |
| `/language/{locale}` | Language switch (en/ms) |
| `/customer/*` | Customer dashboard |
| `/provider/*` | Provider dashboard |
| `/admin/*` | Admin dashboard |
| `/payment/*` | Payment pages |

---

## Example Prompts for Next Session

```
"Fix the register page 500 error"
"Add Bahasa Melayu translations to customer dashboard"
"Test payment flow on production"
"Add email notifications for bookings"
```

---

## Quick Debugging

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Clear everything
php artisan optimize:clear

# Regenerate autoload
composer dump-autoload
```
