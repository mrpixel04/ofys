# 🤖 AI AGENTS - OFYS Development Guide

> **For**: Any AI Assistant (Claude, ChatGPT, Copilot, etc.)  
> **Purpose**: Quick onboarding and development guidelines for OFYS project  
> **Last Updated**: October 4, 2025 (Evening Session)

---

## 📢 RECENT SESSION UPDATES

### October 4, 2025 - Evening Session
**What was completed:**
1. ✅ **Documentation System** - Created CLAUDE.md, AGENTS.md, and PROMPT1.md for AI session continuity
2. ✅ **User Authentication Fixed** - Reset ADMIN & PROVIDER passwords (both: `Passw0rd123`)
3. ✅ **Activities Page Redesigned** - Fixed styling to match home page (yellow/blue theme)
4. ✅ **Image Display Fixed** - Activities now show images correctly using `storage/` path
5. ✅ **Code Cleanup** - Removed unnecessary `.sh` and `.md` files
6. ✅ **Controller Fixes** - Added missing imports in HomeController

**Color Scheme Standardization:**
- ✅ Guest pages: Yellow/Blue theme (consistent branding)
- ✅ Provider pages: Teal/Emerald theme (distinct provider identity)
- ✅ Admin pages: To be standardized (future task)

**Important Notes:**
- All guest-facing pages should use **yellow (#EAB308)** and **blue (#2563EB)** colors
- Provider pages use **teal (#14B8A6)** and **emerald (#10B981)** colors
- Images are stored in `storage/` and accessed via `asset('storage/...')`

---

## 📖 PROJECT QUICK START

### What is OFYS?
**OFYS** = **Outdoor Activity Booking Platform**

A Laravel 12 web application that connects:
- **Customers** who want to book outdoor activities
- **Providers** who offer outdoor activities
- **Admins** who manage the platform

### Project Type
- Multi-role web application
- E-commerce/booking platform
- B2C and B2B functionality

---

## 🏗️ ARCHITECTURE OVERVIEW

### Tech Stack
```
Backend:
- Laravel 12 (PHP Framework)
- MySQL Database
- Eloquent ORM

Frontend:
- Blade Templates (Server-side)
- jQuery 3.7.1 (Client interactions)
- Tailwind CSS 4.0 (Styling)
- Vite 6.0 (Build tool)

Removed:
- ❌ Livewire 3.6 (converted to Blade)
- ❌ Alpine.js (converted to jQuery)
```

### Development Environment
- **Local**: XAMPP (Apache + MySQL)
- **Version Control**: Git
- **Deployment**: Shared hosting ready

---

## 📂 PROJECT STRUCTURE

### Provider UI Pattern (New)
- Provider views extend `layouts.provider.simple-app`, which exposes `breadcrumbs`, `header_subtitle`, and `header_actions` sections so every surface renders with the same header shell.
- Use the shared breadcrumb include at `resources/views/layouts/partials/breadcrumbs.blade.php` whenever adding provider navigation trails.
- Keep provider-facing components on the teal/emerald palette introduced in this refactor (cards, badges, CTAs) for visual consistency.

### Directory Organization (Role-Based)

**Controllers** (`app/Http/Controllers/`)
```
Admin/          # Admin management
Customer/       # Customer operations
Provider/       # Provider management
Guest/          # Public/guest access
```

**Views** (`resources/views/`)
```
admin/          # Admin dashboard & management
customer/       # Customer dashboard & bookings
provider/       # Provider dashboard & activities
guest/          # Public pages (home, activities, auth)
shared/         # Shared layouts & components
```

**Models** (`app/Models/`)
```
User.php        # All user types
Activity.php    # Activity listings
ActivityLot.php # Activity time slots
Booking.php     # Customer bookings
ShopInfo.php    # Provider shop details
```

---

## 👥 USER ROLES & PERMISSIONS

### Role Hierarchy
```
Admin > Provider > Customer > Guest
```

### Guest (role = null or 'guest')
- **Can**: Browse activities, view details, register/login
- **Cannot**: Book activities, access dashboards
- **Routes**: `/`, `/activities`, `/login`, `/register`

### Customer (role = 'customer')
- **Can**: Book activities, manage bookings, edit profile
- **Cannot**: Create activities, access provider features
- **Routes**: `/customer/*`

### Provider (role = 'provider')
- **Can**: Create activities, manage listings, view bookings
- **Cannot**: Access admin features, book activities
- **Routes**: `/provider/*`

### Admin (role = 'admin')
- **Can**: Everything - manage users, activities, bookings, settings
- **Cannot**: Nothing (full access)
- **Routes**: `/admin/*`

---

## 🔐 AUTHENTICATION & AUTHORIZATION

### Middleware Structure
```php
// Guest only (login/register)
'middleware' => ['guest']

// Authenticated users only
'middleware' => ['auth']

// Role-specific
'middleware' => ['auth', 'role:customer']
'middleware' => ['auth', 'role:provider']
'middleware' => ['auth', 'role:admin']
```

### User Model Relationships
```php
User hasMany Bookings      (for customers)
User hasOne ShopInfo       (for providers)
User hasMany Activities    (for providers via ShopInfo)
```

---

## 🛠️ DEVELOPMENT GUIDELINES

### When Creating New Features

#### 1. Identify User Role
```
Who will use this feature?
→ Admin? → app/Http/Controllers/Admin/
→ Provider? → app/Http/Controllers/Provider/
→ Customer? → app/Http/Controllers/Customer/
→ Public? → app/Http/Controllers/Guest/
```

#### 2. Create Controller
```php
namespace App\Http\Controllers\{Role};

use App\Http\Controllers\Controller;

class YourController extends Controller
{
    public function index()
    {
        return view('{role}.your-view');
    }
}
```

#### 3. Create View
```
resources/views/{role}/your-view.blade.php

Extend appropriate layout:
@extends('shared.layouts.{role}')
```

#### 4. Add Route
```php
// routes/web.php
Route::middleware(['auth', 'role:{role}'])->group(function () {
    Route::get('/{role}/path', [YourController::class, 'method'])
        ->name('{role}.route.name');
});
```

---

## 🎨 FRONTEND DEVELOPMENT

### Design System & Color Palette

**IMPORTANT: Follow role-based color schemes**

#### Guest Pages (Public)
```css
Primary: Yellow (#EAB308, bg-yellow-500)
Secondary: Blue (#2563EB, bg-blue-600)
Accent: Gray (#6B7280, text-gray-600)

Usage:
- Buttons: bg-yellow-500 hover:bg-yellow-600
- Links: text-blue-600 hover:text-blue-800
- Badges: bg-yellow-500 text-white
- Price: text-yellow-600
```

#### Provider Pages
```css
Primary: Teal (#14B8A6, bg-teal-600)
Secondary: Emerald (#10B981, bg-emerald-500)
Accent: Teal-50 (#F0FDFA, bg-teal-50)

Usage:
- Buttons: bg-teal-600 hover:bg-teal-700
- Cards: border-teal-100
- Badges: bg-teal-50 text-teal-700
- Icons: text-teal-500
```

#### Admin Pages
```css
Primary: Indigo (#4F46E5, bg-indigo-600)
Secondary: Purple (#9333EA, bg-purple-600)
Accent: Gray (#374151, text-gray-700)

Usage:
- Buttons: bg-indigo-600 hover:bg-indigo-700
- Status badges: Various colors
- Alerts: bg-red-50, bg-green-50
```

### Image Handling
```blade
{{-- Correct way to display activity images --}}
@if($activity->images && count($activity->images) > 0)
    <img src="{{ asset('storage/' . $activity->images[0]) }}" 
         alt="{{ $activity->name }}" 
         class="w-full h-full object-cover">
@else
    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
        <span class="text-gray-500">No Image</span>
    </div>
@endif

{{-- DON'T use cover_image_url (doesn't exist) --}}
{{-- ❌ $activity->cover_image_url --}}
```

### Blade Templates
```blade
{{-- Layouts --}}
@extends('shared.layouts.app')

{{-- Components --}}
@include('shared.components.navbar')

{{-- Sections --}}
@section('content')
    <!-- Your content -->
@endsection
```

### jQuery Usage (NOT Alpine.js!)
```javascript
// Use jQuery for interactions
$(document).ready(function() {
    $('#element').on('click', function() {
        // Your code
    });
});

// NO Alpine.js directives!
// ❌ x-data, x-on, x-show, etc.
```

### Tailwind CSS
```html
<!-- Use utility classes with role-based colors -->
<div class="bg-yellow-500 text-white p-4 rounded-lg">
    Guest Content (Yellow theme)
</div>

<div class="bg-teal-600 text-white p-4 rounded-lg">
    Provider Content (Teal theme)
</div>
```

---

## 🗄️ DATABASE CONVENTIONS

### Table Naming
```
users           # All user types
activities      # Activity listings
activity_lots   # Activity time slots
bookings        # Customer bookings
shop_infos      # Provider shop details
```

### Migration Best Practices
```php
// Foreign keys
$table->foreignId('user_id')->constrained()->onDelete('cascade');

// Enums for roles
$table->enum('role', ['admin', 'customer', 'provider'])->default('customer');

// Timestamps
$table->timestamps();
$table->softDeletes(); // If needed
```

---

## 🧪 TESTING CHECKLIST

### Before Committing Code
- [ ] Test the specific feature/page
- [ ] Check browser console for JS errors
- [ ] Verify no Livewire/Alpine.js references
- [ ] Test on different user roles (if applicable)
- [ ] Check responsive design (mobile/tablet/desktop)
- [ ] Verify database queries are optimized
- [ ] Check for N+1 query problems

### Manual Testing Routes
```
GET /                   # Home page
GET /activities         # Activity listings
GET /login             # Login page
GET /register          # Register page (⚠️ Currently 500 error)
GET /customer/dashboard # Customer dashboard
GET /provider/dashboard # Provider dashboard
GET /admin/dashboard   # Admin dashboard
```

---

## 🚫 COMMON MISTAKES TO AVOID

### ❌ DON'T DO THIS
```php
// Using old Livewire components
use Livewire\Component;

// Using Alpine.js in views
<div x-data="{ open: false }">

// Wrong namespace
namespace App\Http\Controllers; // Missing role subfolder

// Hardcoded paths
return view('livewire.old-component');

// Direct queries in views
{{ App\Models\User::all() }}
```

### ✅ DO THIS INSTEAD
```php
// Use pure Blade + jQuery
use App\Http\Controllers\Controller;

// Use jQuery
<div id="toggle-element">

// Correct namespace
namespace App\Http\Controllers\Provider;

// Use role-based paths
return view('provider.dashboard');

// Pass data from controller
return view('provider.dashboard', ['users' => $users]);
```

---

## 📦 DEPENDENCIES

### Composer (PHP)
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0"
    }
}
```

### NPM (JavaScript)
```json
{
    "devDependencies": {
        "vite": "^6.0",
        "tailwindcss": "^4.0"
    }
}
```

---

## 🔄 WORKFLOW

### Starting Development
```bash
# Start MySQL (XAMPP)
# Start Apache (XAMPP)

# In project directory
php artisan serve       # Start Laravel server
npm run dev            # Start Vite dev server
```

### Making Changes
1. Read CLAUDE.md for context
2. Make your changes following role-based structure
3. Test thoroughly
4. Update CLAUDE.md with progress
5. Commit with clear message

### Git Workflow
```bash
# Check status
git status

# Stage changes
git add .

# Commit with descriptive message
git commit -m "feat: Add provider activity management"

# Push to branch
git push origin feature/your-feature
```

---

## 📚 KEY FILES TO KNOW

### Configuration
- `config/app.php` - Application settings
- `config/database.php` - Database configuration
- `config/auth.php` - Authentication settings

### Core Files
- `routes/web.php` - All web routes
- `app/Http/Kernel.php` - Middleware registration
- `app/Providers/AppServiceProvider.php` - Service providers

### Frontend
- `resources/views/shared/layouts/` - Layout templates
- `resources/css/app.css` - Tailwind CSS imports
- `resources/js/app.js` - jQuery imports
- `tailwind.config.js` - Tailwind configuration
- `vite.config.js` - Vite build configuration

---

## 🐛 DEBUGGING TIPS

### Laravel Debugging
```php
// Debug variables
dd($variable);
dump($variable);

// Query logging
\DB::enableQueryLog();
// Run queries
dd(\DB::getQueryLog());

// View data
return view('test')->with('data', $data);
```

### Browser Console
```javascript
// Check for errors
console.log('Debug:', data);

// jQuery loaded?
console.log('jQuery version:', $.fn.jquery);
```

### Common Issues
```
Issue: 404 Not Found
→ Check route naming and controller method

Issue: 500 Internal Server Error
→ Check Laravel logs: storage/logs/laravel.log

Issue: View not found
→ Check view path matches role-based structure

Issue: Class not found
→ Run: composer dump-autoload
```

---

## 📋 QUICK REFERENCE COMMANDS

```bash
# Laravel
php artisan route:list          # List all routes
php artisan migrate             # Run migrations
php artisan db:seed             # Seed database
php artisan make:controller     # Create controller
php artisan make:model          # Create model
php artisan cache:clear         # Clear cache
php artisan config:clear        # Clear config cache
php artisan view:clear          # Clear view cache

# Composer
composer install                # Install dependencies
composer dump-autoload          # Regenerate autoload files

# NPM
npm install                     # Install dependencies
npm run dev                     # Development build
npm run build                   # Production build

# Git
git status                      # Check status
git log --oneline              # View commit history
git branch                      # List branches
```

---

## 🎯 PRIORITY FEATURES STATUS

### ✅ Completed
- Role-based architecture
- User authentication
- Activity browsing (guest)
- Home page, Activities page, Login page

### 🚧 In Progress
- Provider functionality
- Activity creation/management

### ⚠️ Known Issues
- Register page (500 error)

### 📅 Planned
- Booking system completion
- Payment integration
- Email notifications
- Admin analytics dashboard

---

## 💬 COMMUNICATION GUIDELINES

### When User Asks for Help
1. Read CLAUDE.md for session context
2. Read this file (AGENTS.md) for technical guidance
3. Search codebase before asking clarifications
4. Propose solutions, don't just ask questions
5. Update CLAUDE.md after completing tasks

### Code Style
- Follow PSR-12 PHP coding standards
- Use meaningful variable names
- Add comments for complex logic
- Keep methods small and focused

---

## 🔗 RELATED FILES

- **CLAUDE.md** - Session memory and progress tracking
- **PROJECT_STRUCTURE.md** - Detailed file structure (DEPRECATED - info merged here)
- **composer.json** - PHP dependencies
- **package.json** - JavaScript dependencies

---

*This is a living document. Update as the project evolves!*

**Last Updated**: October 4, 2025 (Evening Session)  
**Major Updates**: Added design system color palette, image handling guidelines, and recent session notes
