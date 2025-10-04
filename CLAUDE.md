# 🤖 CLAUDE AI - OFYS Project Memory

> **Last Session Date**: October 5, 2025  
> **Current Branch**: `feature/final-checking-n-ready-to-production`  
> **Status**: Provider UI polish in progress

---

## 🎯 LAST SESSION SUMMARY

### What We Did
1. ✅ **Unified provider layout framing** – added breadcrumb and subtitle support to `layouts.provider.simple-app` and introduced a shared breadcrumb partial.
2. ✅ **Standardized provider palette** – refreshed dashboard, bookings, activities, shop info, profile, and booking detail views to use the teal/emerald theme and consistent CTA styling.
3. ✅ **Synced provider experiences** – aligned simple/advanced activity and profile screens, tightened password modals, and ensured upload previews follow the same design language.
4. ✅ **Delivered full activity editing** – built a pre-filled edit form with image management, lot handling, and robust validation for provider updates.
5. ✅ **Activated profile modals & regression tests** – wired edit profile/change password flows, added media handling, and covered key scenarios with PHPUnit feature tests.

### Current Uncommitted Changes (Git Status)
```
modified:   AGENTS.md
modified:   CLAUDE.md
modified:   app/Http/Controllers/Provider/ProviderController.php
modified:   app/Models/Activity.php
modified:   resources/js/provider.js
modified:   resources/views/layouts/provider/simple-app.blade.php
modified:   resources/views/provider/activities.blade.php
modified:   resources/views/provider/activities/create.blade.php
modified:   resources/views/provider/activities/edit.blade.php
modified:   resources/views/provider/activities/view.blade.php
modified:   resources/views/provider/booking-details.blade.php
modified:   resources/views/provider/bookings.blade.php
modified:   resources/views/provider/dashboard.blade.php
modified:   resources/views/provider/profile.blade.php
modified:   resources/views/provider/shop-info.blade.php
modified:   resources/views/provider/show-booking.blade.php
modified:   resources/views/provider/simple-activities.blade.php
modified:   resources/views/provider/simple-booking-details.blade.php
modified:   resources/views/provider/simple-profile.blade.php
modified:   resources/views/provider/view-activity.blade.php
modified:   routes/web.php
new file:   resources/views/layouts/partials/breadcrumbs.blade.php
new file:   tests/Feature/Provider/ActivityManagementTest.php
new file:   tests/Feature/Provider/ProfileManagementTest.php
```
```
untracked:  database/seeders/ResetPasswordSeeder.php (pre-existing; untouched this session)
```

### 🔴 STOPPED HERE - AWAITING INSTRUCTIONS
**Current Focus**: Provider activity & profile enhancements ready for stakeholder review
- Activity edit form, lot management, and profile modals are live with automated coverage.
- Awaiting UX feedback or additional provider feature requirements before extending controllers further.

---

## 📊 PROJECT OVERVIEW

**OFYS** = **Outdoor Activity Booking Platform**
- Connects customers with outdoor activity providers
- Laravel-based web application with role-based access

### Key Statistics
- **Laravel Version**: 12
- **Database**: MySQL (XAMPP for local development)
- **Frontend**: Blade + jQuery + Tailwind CSS 4.0
- **Build Tool**: Vite 6.0

---

## 👥 USER ROLES (4 Types)

### 1. 🌐 Guest (Public)
- Browse activities
- View activity details
- Access login/registration
- View legal pages (Terms, Privacy)

### 2. 🛒 Customer
- Book activities
- View/manage bookings
- Profile management
- Personal dashboard

### 3. 🏢 Provider
- Create/manage activities
- View provider bookings
- Dashboard & analytics
- Profile settings

### 4. 👑 Admin
- System overview & statistics
- Manage customers & providers
- System-wide booking management
- Platform configuration

---

## 📁 FILE STRUCTURE (Role-Based Organization)

### Controllers (`app/Http/Controllers/`)
```
Controllers/
├── Admin/
│   ├── AdminController.php
│   ├── BookingController.php
│   └── CustomerController.php
├── Customer/
│   ├── BookingController.php
│   └── CustomerController.php
├── Guest/
│   ├── ActivityController.php
│   ├── AuthController.php
│   └── HomeController.php
├── Provider/
│   └── ProviderController.php        ⚠️ CURRENTLY WORKING ON THIS
└── Controller.php
```

### Views (`resources/views/`)
```
views/
├── admin/          # Admin-only pages
├── customer/       # Customer-only pages
├── provider/       # Provider-only pages (CURRENT FOCUS)
│   ├── activities/
│   │   └── create.blade.php          ⚠️ MODIFIED - UNCOMMITTED
│   ├── partials/
│   ├── dashboard.blade.php
│   └── profile.blade.php
├── guest/          # Public pages
└── shared/         # Shared components & layouts
```

### Models (`app/Models/`)
- `Activity.php` - Activity listings
- `ActivityLot.php` - Activity time slots/lots
- `Booking.php` - Customer bookings
- `ShopInfo.php` - Provider shop information
- `User.php` - All users (Admin, Customer, Provider)

---

## 🔧 MAJOR REFACTORING COMPLETED

### What Was Changed
1. ✅ **Removed Livewire 3.6** - Converted to pure Blade templates
2. ✅ **Removed Alpine.js** - Converted to jQuery
3. ✅ **Role-based organization** - Separated files by user roles
4. ✅ **Updated all routes** - Match new controller locations
5. ✅ **Updated all namespaces** - Match new directory structure

### Why It Was Done
- Simplify frontend dependencies
- Better code organization
- Clearer separation of concerns
- Easier maintenance and debugging

---

## ✅ COMPLETED TASKS

- [x] Livewire components removed
- [x] Alpine.js directives removed
- [x] `@livewireStyles` removed from layouts
- [x] Controllers organized by role
- [x] Views organized by role
- [x] Routes updated
- [x] Namespaces updated
- [x] Home page working (200 OK)
- [x] Activities page working (200 OK)
- [x] Login page working (200 OK)
- [x] Unnecessary `.sh` and `.md` files deleted
- [x] Documentation consolidated
- [x] Provider UI refreshed with breadcrumbs + teal/emerald palette (Oct 2025)

---

## ⚠️ KNOWN ISSUES

### High Priority
- [ ] **Register page has 500 error** - Needs investigation
- [ ] Provider functionality changes in progress

### Cleanup Pending
- [ ] Remove `_cleanup/` directory (after testing)
- [ ] Delete `_livewire_removed` files (after verification)
- [ ] Update hardcoded paths referencing old structure

---

## 🚀 NEXT STEPS (Priority Order)

1. **IMMEDIATE**: QA provider flows (dashboard → bookings → activities → profile) to validate layout and palette changes.
2. Address any remaining provider functionality updates once UX is approved (e.g., edit/delete flows, booking management tweaks).
3. Fix register page 500 error.
4. Test all user flows (login, registration, booking).
5. Clean up `_cleanup/` directory and remove `_livewire_removed` files after verification.
6. Deploy to production.

---

## 💡 DEVELOPMENT GUIDELINES

### When Adding New Features
1. Follow role-based organization
2. Place controllers in appropriate role directory
3. Organize views by user access level
4. Use `shared/` for reusable components
5. Use jQuery for frontend interactions (no Alpine.js/Livewire)
6. Follow Laravel 12 best practices

### File Naming Conventions
- `guest.*` - Public/guest pages
- `customer.*` - Customer-only pages
- `provider.*` - Provider-only pages
- `admin.*` - Admin-only pages
- `shared.*` - Shared components

---

## 🔍 QUICK REFERENCE

### Important Directories
- Controllers: `/app/Http/Controllers/{Role}/`
- Views: `/resources/views/{role}/`
- Models: `/app/Models/`
- Routes: `/routes/web.php`
- Assets: `/public/`

### Technology Stack
- **Backend**: Laravel 12, MySQL, Eloquent
- **Frontend**: Blade, jQuery 3.7.1, Tailwind CSS 4.0
- **Build**: Vite 6.0
- **Dev Environment**: XAMPP (MySQL)

---

## 📝 NOTES FOR NEXT SESSION

- Review the refreshed provider UI in-browser; adjust spacing or copy based on stakeholder feedback.
- Confirm whether controller logic changes are required for provider flows (none updated yet).
- Register page 500 error remains unresolved.
- `_cleanup/` and `_livewire_removed` directories still pending deletion after QA.

## 🆕 ISSUES / NOTES

- Breadcrumb include (`resources/views/layouts/partials/breadcrumbs.blade.php`) is now the standard for provider navigation trails.
- `database/seeders/ResetPasswordSeeder.php` remains untracked from prior work; decide whether to commit or remove later.
- Run `vendor/bin/phpunit` to execute the new provider regression suite.

---

**🔄 Always update this file at the end of each session!**

*Last updated: October 4, 2025 - Session ended awaiting provider functionality instructions*
