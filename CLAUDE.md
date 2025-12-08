# CLAUDE.md

> **Last Updated**: December 8, 2025
> **Current Branch**: `develop/fixing-landing-page`
> **Status**: Language switching fully working on all guest pages

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

---

## Project Overview

**OFYS** = Outdoor Activity Booking Platform (Laravel 12)

### Tech Stack
- **Backend**: Laravel 12, PHP 8.2+, MySQL
- **Frontend**: Blade + jQuery 3.7.1 + Tailwind CSS 4.0
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

1. **Language Switching Fixed** - EN/BM toggle now works on all guest pages
   - Fixed SetLocale middleware registration in `bootstrap/app.php`
   - Updated LanguageController to store locale in session + cookie
   - Updated header/footer with translation keys

2. **Home Page Translations** - `simple-welcome.blade.php`
   - Hero section, marketing text, stats counters
   - Search form labels and placeholders
   - Featured Activities, Our Features, Popular Destinations sections
   - JavaScript messages (No results, Clear Filters)

3. **Activities Page Translations** - `activities/index.blade.php`
   - Hero section, search bar, filter labels
   - Sort options, results counter
   - Activity cards (Starting from, View Details)
   - Empty state messages

4. **Activity Detail Page Translations** - `activities/show.blade.php`
   - Breadcrumb navigation
   - All static labels (Description, Duration, Pricing, etc.)
   - Booking card (Book Now, Price, Share)
   - Safety guidelines, location info

5. **Navigation Menu Redesign**
   - Better padding and spacing (`px-4 py-2`)
   - Rounded pill-style buttons
   - Hover effects with smooth transitions
   - Professional SaaS-style look

6. **JSON Translation Files Updated**
   - `resources/lang/en.json` - 340+ keys
   - `resources/lang/ms.json` - Full Bahasa Melayu translations

---

## Key Files Modified

```
resources/views/guest/simple-welcome.blade.php
resources/views/guest/activities/index.blade.php
resources/views/guest/activities/show.blade.php
resources/views/layouts/partials/header.blade.php
resources/lang/en.json
resources/lang/ms.json
bootstrap/app.php
app/Http/Controllers/LanguageController.php
```

---

## Known Issues

- Register page has 500 error (needs investigation)

---

## Example Prompts for Next Session

```
"Continue fixing the register page 500 error"
"Add translations to the customer dashboard pages"
"Add translations to the booking flow pages"
"Fix any remaining untranslated text on guest pages"
```

