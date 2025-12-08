# AGENTS.md - AI Development Guide

> **Last Updated**: December 8, 2025
> **Purpose**: Quick reference for AI assistants working on OFYS

---

## Project Quick Start

**OFYS** = Outdoor Activity Booking Platform (Laravel 12, Malaysia-based)

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

---

## Architecture

### Tech Stack
- Laravel 12 + PHP 8.2+ + MySQL
- Blade + jQuery 3.7.1 + Tailwind CSS 4.0
- **NO Livewire or Alpine.js** - converted to jQuery

### Role-Based Organization
```
Controllers: app/Http/Controllers/{Admin,Customer,Provider,Guest}/
Views: resources/views/{admin,customer,provider,guest}/
Models: User, Activity, ActivityLot, Booking, ShopInfo
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

## Latest Session (December 8, 2025)

### Completed
1. **Language Switching** - EN/BM toggle fully working on all guest pages
2. **Home Page** - All static text translated
3. **Activities Page** - All static text translated
4. **Activity Detail Page** - All static text translated
5. **Navigation Menu** - Professional redesign with proper spacing
6. **JSON Files** - 340+ translation keys in both EN and MS

### Files Modified
- `resources/views/guest/simple-welcome.blade.php`
- `resources/views/guest/activities/index.blade.php`
- `resources/views/guest/activities/show.blade.php`
- `resources/views/layouts/partials/header.blade.php`
- `resources/lang/en.json` & `ms.json`

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

---

## Example Prompts for Next Session

```
"Fix the register page 500 error"
"Add Bahasa Melayu translations to customer dashboard"
"Add translations to the booking confirmation page"
"Update the footer with missing translations"
"Fix any untranslated text on the About or Contact pages"
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

