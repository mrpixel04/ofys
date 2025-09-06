# OFYS Project Structure Documentation

## Overview
This document outlines the reorganized file structure of the OFYS project after removing Livewire/Alpine.js dependencies and organizing files by user roles and functionality.

## Directory Structure

### Controllers (`app/Http/Controllers/`)
```
Controllers/
├── Admin/
│   ├── AdminController.php          # Main admin dashboard and management
│   ├── BookingController.php        # Admin booking management
│   └── CustomerController.php       # Admin customer management
├── Customer/
│   ├── BookingController.php        # Customer booking operations
│   └── CustomerController.php       # Customer profile and account
├── Guest/
│   ├── ActivityController.php       # Public activity listings and details
│   ├── AuthController.php           # Login, registration, logout
│   └── HomeController.php           # Home page and public content
├── Provider/
│   └── ProviderController.php       # Provider dashboard and management
└── Controller.php                   # Base controller class
```

### Views (`resources/views/`)
```
views/
├── admin/                          # Admin-only pages
│   ├── bookings/                   # Booking management views
│   ├── providers/                  # Provider management views
│   ├── settings/                   # Admin settings
│   ├── dashboard.blade.php         # Admin dashboard
│   ├── customers.blade.php         # Customer list
│   ├── providers.blade.php         # Provider list
│   └── simple-*.blade.php          # Simplified admin views
├── customer/                       # Customer-only pages
│   ├── bookings/                   # Customer booking views
│   ├── dashboard.blade.php         # Customer dashboard
│   ├── profile.blade.php           # Customer profile
│   └── account.blade.php           # Account settings
├── provider/                       # Provider-only pages
│   ├── activities/                 # Activity management
│   ├── partials/                   # Reusable provider components
│   ├── dashboard.blade.php         # Provider dashboard
│   ├── profile.blade.php           # Provider profile
│   └── simple-*.blade.php          # Simplified provider views
├── guest/                          # Public/guest pages
│   ├── activities/                 # Public activity listings
│   ├── auth/                       # Login and registration
│   ├── legal/                      # Terms and privacy pages
│   ├── about.blade.php             # About page
│   ├── contact.blade.php           # Contact page
│   ├── home.blade.php              # Home page
│   └── simple-welcome.blade.php    # Main landing page
├── shared/                         # Shared components and layouts
│   ├── components/                 # Reusable Blade components
│   ├── layouts/                    # Layout templates
│   └── sections/                   # Page sections
└── _cleanup/                       # Removed Livewire files (for cleanup)
    └── livewire/                   # Old Livewire components
```

### Models (`app/Models/`)
```
Models/
├── Activity.php                    # Activity model
├── ActivityLot.php                 # Activity lot model
├── Booking.php                     # Booking model
├── ShopInfo.php                    # Shop/provider info model
└── User.php                        # User model
```

### Routes (`routes/`)
```
routes/
├── web.php                         # Web routes (updated for new structure)
├── api.php                         # API routes
└── console.php                     # Console routes
```

## Key Changes Made

### 1. Livewire/Alpine.js Removal
- ✅ Removed all Livewire components and converted to pure Blade/jQuery
- ✅ Removed Alpine.js directives from all templates
- ✅ Removed `@livewireStyles` from all layouts
- ✅ Updated `composer.json` to remove Livewire dependency
- ✅ Cleaned up `AppServiceProvider.php`

### 2. File Organization
- ✅ Organized views by user role: `admin/`, `customer/`, `provider/`, `guest/`
- ✅ Organized controllers by user role: `Admin/`, `Customer/`, `Provider/`, `Guest/`
- ✅ Moved shared components to `shared/` directory
- ✅ Created `_cleanup/` directory for removed Livewire files

### 3. Route Updates
- ✅ Updated all route imports to match new controller locations
- ✅ Updated view references in routes to match new structure
- ✅ Fixed include paths in Blade templates

### 4. Controller Updates
- ✅ Updated namespaces for all moved controllers
- ✅ Updated view references in controllers
- ✅ Enhanced controller methods to handle filtering and pagination

## User Role Structure

### Guest (Public) Pages
- **Home**: Landing page with activity listings
- **Activities**: Browse and search activities
- **Auth**: Login and registration
- **Legal**: Terms of service and privacy policy
- **About/Contact**: Company information

### Customer Pages
- **Dashboard**: Personal activity dashboard
- **Bookings**: View and manage bookings
- **Profile**: Account settings and preferences

### Provider Pages
- **Dashboard**: Provider management dashboard
- **Activities**: Create and manage activities
- **Bookings**: View provider bookings
- **Profile**: Provider account settings

### Admin Pages
- **Dashboard**: System overview and statistics
- **Customers**: Manage customer accounts
- **Providers**: Manage provider accounts
- **Bookings**: System-wide booking management
- **Settings**: System configuration

## Technology Stack

### Backend
- **Laravel 12**: PHP framework
- **MySQL**: Database (via XAMPP for local development)
- **Eloquent ORM**: Database interactions

### Frontend
- **Blade Templates**: Server-side templating
- **jQuery 3.7.1**: Client-side interactions
- **Tailwind CSS 4.0**: Styling framework
- **Vite 6.0**: Build tool

### Removed Dependencies
- ❌ Livewire 3.6 (converted to Blade/jQuery)
- ❌ Alpine.js (converted to jQuery)

## File Naming Conventions

### Livewire Removed Files
All removed Livewire files are suffixed with `_livewire_removed` for easy identification and cleanup:
- `*_livewire_removed.php` - Removed Livewire component classes
- `*_livewire_removed.blade.php` - Removed Livewire view files

### View Organization
- `guest.*` - Public/guest accessible pages
- `customer.*` - Customer-only pages
- `provider.*` - Provider-only pages
- `admin.*` - Admin-only pages
- `shared.*` - Shared components and layouts

## Maintenance Notes

### Cleanup Tasks
1. **Remove `_cleanup/` directory** when confident all functionality works
2. **Delete `_livewire_removed` files** after thorough testing
3. **Update any remaining hardcoded paths** that reference old structure

### Development Guidelines
1. **New features** should follow the user role organization
2. **Controllers** should be placed in appropriate role directories
3. **Views** should be organized by user access level
4. **Shared components** should go in `shared/` directory

## Testing Status
- ✅ Home page (200 OK)
- ✅ Activities page (200 OK)
- ✅ Login page (200 OK)
- ⚠️ Register page (500 Error - needs investigation)
- ✅ All `@livewireStyles` removed
- ✅ Livewire/Alpine.js dependencies removed

## Next Steps
1. Fix remaining register page error
2. Test all user flows (login, registration, booking)
3. Clean up `_cleanup/` directory
4. Update any remaining documentation
5. Deploy to production environment

---
*Last updated: [Current Date]*
*Project: OFYS - Outdoor Activity Booking Platform*
