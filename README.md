# 🏔️ OFYS - Outdoor For Your Soul

> **Outdoor Activity Booking Platform** - Connecting adventure seekers with local outdoor activity providers across Malaysia

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![jQuery](https://img.shields.io/badge/jQuery-3.7.1-0769AD?style=for-the-badge&logo=jquery&logoColor=white)](https://jquery.com)

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [User Roles](#-user-roles)
- [WhatsApp Integration](#-whatsapp-integration)
- [API Documentation](#-api-documentation)
- [Color Scheme](#-color-scheme)
- [Project Structure](#-project-structure)
- [Development](#-development)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🌟 Overview

**OFYS (Outdoor For Your Soul)** is a comprehensive web-based booking platform that bridges the gap between outdoor activity providers and adventure enthusiasts in Malaysia. The platform enables:

- 🏕️ **Customers** to discover and book outdoor activities
- 🎯 **Providers** to list and manage their activities
- 👨‍💼 **Admins** to oversee the entire platform

Built with modern web technologies and a focus on user experience, OFYS provides a seamless booking experience with real-time communication through WhatsApp integration.

---

## ✨ Features

### 🎨 **Modern UI/UX Design**
- **SaaS-Style Interface** - Professional, commercial-grade design
- **Role-Based Theming** - Distinct color schemes for each user type
- **Responsive Design** - Optimized for mobile, tablet, and desktop
- **Smooth Animations** - Engaging user experience with CSS animations
- **Dark Mode Ready** - Prepared for future dark mode implementation

### 👥 **Multi-Role System**
- **Guest Access** - Browse activities without registration
- **Customer Dashboard** - Manage bookings and profile
- **Provider Portal** - Create and manage activities
- **Admin Panel** - Complete platform management

### 🏕️ **Activity Management**
- **Advanced Filtering** - Search by location, type, price range
- **Grid/List Views** - Toggle between display modes
- **Real-Time Search** - Instant results as you type
- **Image Galleries** - Multiple images per activity
- **Detailed Information** - Duration, location, pricing, descriptions

### 💬 **WhatsApp Integration**
- **Live Chat Interface** - Manage customer conversations
- **Message Management** - Fetch and reply to WhatsApp messages
- **AI Chatbot Training** - Keyword-based auto-responses
- **BuzzBridge API** - Integration with WhatsApp Web.js service
- **Real-Time Updates** - AJAX-powered messaging

### 📊 **Admin Dashboard**
- **Analytics & Statistics** - Track users, bookings, revenue
- **User Management** - Manage customers and providers
- **Booking Management** - Monitor and update booking status
- **Activity Oversight** - Review and approve activities
- **Export Functionality** - Excel and CSV data export

### 🔌 **Developer Tools**
- **API Documentation** - Embedded Swagger UI for all APIs
- **Integration Hub** - WhatsApp Web.js and N8N configuration
- **Webhook Management** - Configure external integrations
- **Database Tools** - Migration and seeding utilities

---

## 🛠️ Tech Stack

### **Backend**
- **Framework**: Laravel 12.0
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0
- **ORM**: Eloquent
- **Authentication**: Laravel Sanctum

### **Frontend**
- **Templating**: Blade (Server-side)
- **CSS Framework**: Tailwind CSS 4.0
- **JavaScript**: jQuery 3.7.1
- **Build Tool**: Vite 6.0
- **Icons**: Font Awesome 6.5

### **Third-Party Integrations**
- **WhatsApp**: BuzzBridge API (WhatsApp Web.js)
- **Automation**: N8N Workflow Automation
- **Export**: SheetJS (Excel), Native CSV
- **API Docs**: Swagger UI 5.10

### **Development Tools**
- **Version Control**: Git
- **Package Manager**: Composer, NPM
- **Testing**: PHPUnit
- **Code Style**: PSR-12

---

## 📸 Screenshots

### Guest Pages (Yellow/Blue Theme)
- **Home Page**: Hero section with auto-rotating images and marketing text
- **Activities Page**: Advanced filtering with grid/list view toggle
- **Activity Details**: Comprehensive information with image gallery

### Provider Portal (Teal/Emerald Theme)
- **Dashboard**: Activity statistics and recent bookings
- **Activity Management**: Create, edit, and manage listings
- **Booking Management**: View and update booking status

### Admin Panel (Purple/Indigo Theme)
- **Dashboard**: System-wide analytics with animated stat cards
- **User Management**: Manage customers and providers
- **WhatsApp Messages**: Full chat interface with AI chatbot
- **API Documentation**: Embedded Swagger UI for all endpoints

---

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer 2.x
- Node.js 18.x or higher
- MySQL 8.0 or higher
- Git

### Step 1: Clone Repository
```bash
git clone https://github.com/mrpixel04/ofys.git
cd ofys
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Setup
```bash
# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ofys
DB_USERNAME=root
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### Step 5: Storage Link
```bash
# Create symbolic link for storage
php artisan storage:link
```

### Step 6: Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### Step 7: Start Server
```bash
# Start Laravel development server
php artisan serve

# Access application at http://localhost:8000
```

---

## 👥 User Roles

### 🌐 **Guest** (No Authentication)
- Browse all activities
- View activity details
- Search and filter activities
- Register as Customer or Provider

### 🎒 **Customer** (role: `customer`)
- All Guest features
- Book activities
- Manage bookings
- Update profile
- View booking history

**Default Credentials**:
```
Email: customer@example.com
Password: password
```

### 🏕️ **Provider** (role: `PROVIDER`)
- Create and manage activities
- View bookings for their activities
- Update activity status
- Manage shop information
- View earnings

**Default Credentials**:
```
Email: tombak@gmail.com
Password: Passw0rd123
```

### 👨‍💼 **Admin** (role: `ADMIN`)
- Full system access
- Manage all users
- Approve/reject activities
- Monitor all bookings
- View analytics
- WhatsApp message management
- System configuration

**Default Credentials**:
```
Email: admin@gmail.com
Password: Passw0rd123
```

---

## 💬 WhatsApp Integration

OFYS integrates with **BuzzBridge** (https://buzzbridge.aplikasi-io.com) for WhatsApp messaging capabilities.

### Features
- ✅ Fetch messages from BuzzBridge API
- ✅ Reply to customers directly from admin panel
- ✅ Train AI chatbot with keyword-based responses
- ✅ Real-time message synchronization
- ✅ WhatsApp-style chat interface
- ✅ Conversation search and filtering

### Configuration
1. Navigate to **Admin Panel → Developers → Integration**
2. Enter BuzzBridge API credentials:
   - API URL: `https://buzzbridge.aplikasi-io.com/api`
   - API Key: Your BuzzBridge API key
   - Webhook Secret: Your webhook secret
3. Click **"Fetch QR Code"** to connect WhatsApp
4. Scan QR code with WhatsApp mobile app
5. Start managing messages!

### API Requirements
See [BUZZBRIDGE_INTEGRATION.md](BUZZBRIDGE_INTEGRATION.md) for complete API specification that BuzzBridge must implement.

---

## 📚 API Documentation

OFYS provides comprehensive API documentation through embedded Swagger UI.

### Access API Docs
1. Login as Admin
2. Navigate to **Developers → API Documentation**
3. Browse endpoints for:
   - **Admin API** - Administrative operations
   - **Customer API** - Customer-facing operations
   - **Provider API** - Provider operations

### API Endpoints
- `GET /api/admin/dashboard` - Get dashboard statistics
- `GET /api/admin/providers` - List all providers
- `GET /api/admin/customers` - List all customers
- `GET /api/admin/bookings` - List all bookings
- `POST /api/customer/bookings` - Create new booking
- `GET /api/provider/activities` - Get provider's activities
- And many more...

---

## 🎨 Color Scheme

OFYS uses a **role-based color system** for clear visual distinction:

### Guest Pages (Public)
- **Primary**: Yellow `#EAB308` (bg-yellow-500)
- **Secondary**: Blue `#2563EB` (bg-blue-600)
- **Accent**: Gray `#6B7280` (text-gray-600)

### Provider Portal
- **Primary**: Teal `#14B8A6` (bg-teal-600)
- **Secondary**: Emerald `#10B981` (bg-emerald-500)
- **Accent**: Teal-50 `#F0FDFA` (bg-teal-50)

### Admin Panel
- **Primary**: Purple `#7C3AED` (bg-purple-600)
- **Secondary**: Indigo `#6366F1` (bg-indigo-600)
- **Accent**: Gray `#374151` (text-gray-700)

---

## 📁 Project Structure

```
ofys/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Customer/       # Customer controllers
│   │   │   ├── Provider/       # Provider controllers
│   │   │   └── Guest/          # Public controllers
│   │   └── Middleware/         # Custom middleware
│   └── Models/                 # Eloquent models
│       ├── User.php
│       ├── Activity.php
│       ├── Booking.php
│       ├── WhatsAppMessage.php
│       └── ChatbotResponse.php
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin views
│   │   ├── customer/           # Customer views
│   │   ├── provider/           # Provider views
│   │   ├── guest/              # Public views
│   │   └── layouts/            # Layout templates
│   ├── css/                    # Stylesheets
│   └── js/                     # JavaScript files
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
├── public/
│   ├── images/                 # Public images
│   └── storage/                # Symlink to storage
├── storage/
│   └── app/
│       └── public/             # User uploads
├── CLAUDE.md                   # AI session memory
├── AGENTS.md                   # Development guidelines
├── BUZZBRIDGE_INTEGRATION.md   # WhatsApp API spec
└── README.md                   # This file
```

---

## 💻 Development

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ActivityTest
```

### Code Style
```bash
# Check code style
./vendor/bin/phpcs

# Fix code style
./vendor/bin/phpcbf
```

### Database Management
```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh database
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
# Clear all caches
php artisan optimize:clear

# Or individually
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 🔧 Configuration

### WhatsApp Integration
Configure in `.env`:
```env
WHATSAPP_API_URL=https://buzzbridge.aplikasi-io.com/api
WHATSAPP_API_KEY=your_api_key_here
WHATSAPP_WEBHOOK_SECRET=your_webhook_secret
```

### N8N Integration
Configure in `.env`:
```env
N8N_API_URL=https://your-n8n.com/api/v1
N8N_API_KEY=your_n8n_api_key
N8N_WEBHOOK_URL=https://your-n8n.com/webhook
```

### Email Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ofys.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 📊 Database Schema

### Core Tables
- `users` - All user accounts (customers, providers, admins)
- `activities` - Activity listings
- `activity_lots` - Activity time slots
- `bookings` - Customer bookings
- `shop_infos` - Provider shop information

### WhatsApp Tables
- `whatsapp_messages` - All WhatsApp messages
- `chatbot_responses` - AI chatbot training data
- `whatsapp_sessions` - WhatsApp QR code sessions

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add comments for complex logic
- Update documentation when needed
- Test your changes thoroughly

---

## 📝 Documentation

- **[CLAUDE.md](CLAUDE.md)** - AI session memory and progress tracking
- **[AGENTS.md](AGENTS.md)** - Complete development guidelines for AI assistants
- **[BUZZBRIDGE_INTEGRATION.md](BUZZBRIDGE_INTEGRATION.md)** - WhatsApp API integration specification
- **[PROMPT1.md](PROMPT1.md)** - Quick start prompt for AI assistants

---

## 🐛 Known Issues

- ⚠️ Register page returns 500 error (to be fixed)
- 🚧 Mobile responsiveness needs improvement on some admin pages
- 🔄 Real-time notifications not yet implemented

---

## 🗺️ Roadmap

### Phase 1 (Completed ✅)
- [x] User authentication system
- [x] Activity browsing and filtering
- [x] Booking system
- [x] Admin dashboard
- [x] Provider portal
- [x] WhatsApp integration
- [x] API documentation

### Phase 2 (In Progress 🚧)
- [ ] Payment gateway integration (Stripe/PayPal)
- [ ] Email notifications
- [ ] SMS notifications
- [ ] Review and rating system
- [ ] Advanced analytics

### Phase 3 (Planned 📅)
- [ ] Mobile app (React Native)
- [ ] Real-time notifications (Pusher)
- [ ] Multi-language support
- [ ] Dark mode
- [ ] Progressive Web App (PWA)

---

## 📄 License

This project is proprietary software. All rights reserved.

**Copyright © 2025 OFYS - Outdoor For Your Soul**

Unauthorized copying, modification, distribution, or use of this software, via any medium, is strictly prohibited without explicit permission from the copyright holder.

---

## 👨‍💻 Development Team

- **Lead Developer**: [Your Name]
- **UI/UX Designer**: [Designer Name]
- **Project Manager**: [PM Name]

---

## 📞 Support

For support, email support@ofys.com or join our Slack channel.

---

## 🙏 Acknowledgments

- Laravel Framework Team
- Tailwind CSS Team
- jQuery Team
- BuzzBridge API Team
- All contributors and testers

---

## 📈 Project Status

**Current Version**: 1.0.0  
**Status**: Active Development  
**Last Updated**: October 5, 2025  
**Branch**: `feature/final-fix-for-production-admin-userlevel-05102025_1235PM`

---

## 🌟 Star History

If you find this project useful, please consider giving it a star ⭐

---

**Made with ❤️ in Malaysia** 🇲🇾
