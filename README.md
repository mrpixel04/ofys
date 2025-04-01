# One For Your Soul (OFYS)

OFYS is a comprehensive booking platform for outdoor and adventure activities in Malaysia, connecting activity providers with adventure seekers.

## About OFYS

One For Your Soul (OFYS) is a Laravel-based web application that serves as a marketplace for outdoor and adventure activities. The platform supports three main user roles:

- **Admin**: Manage providers, customers, bookings, and platform settings
- **Providers**: Create business profiles, list activities, manage bookings
- **Customers**: Browse activities, make bookings, manage their profiles

Key features include:
- User registration and authentication with role-based access
- Provider profiles with business information
- Activity listings with detailed information and pricing
- Booking management system with various status tracking
- Multilingual support (English and Malay)
- Responsive design for all device sizes

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL or equivalent database
- Node.js and NPM

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/mrpixel04/ofys.git
   cd ofys
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create a copy of the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the .env file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ofys
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. Run database migrations and seed initial data:
   ```bash
   php artisan migrate
   php artisan db:seed --class=AdminUserSeeder
   ```

8. Link storage directory:
   ```bash
   php artisan storage:link
   ```

9. Start the development server:
   ```bash
   source project-aliases.sh
   startit
   ```

This will start both the Laravel server and Vite for frontend asset compilation.

## Development Workflow

### Git Workflow

We follow a feature branch workflow for this project. Here's how to contribute:

1. Make sure your local repository is up-to-date:
   ```bash
   git checkout main
   git pull origin main
   ```

2. Create a new branch for your feature or bug fix:
   ```bash
   git checkout -b feature/your-feature-name
   # Or for bug fixes:
   # git checkout -b fix/bug-description
   ```

3. Make your changes and commit them with descriptive messages:
   ```bash
   git add .
   git commit -m "Add clear description of your changes"
   ```

4. Push your changes to the remote repository:
   ```bash
   git push origin feature/your-feature-name
   ```

5. Create a Pull Request (PR) on GitHub:
   - Go to the repository on GitHub
   - Click "Compare & pull request"
   - Add a clear title and description for your changes
   - Submit the pull request

### Pull Request Guidelines

When creating a Pull Request, please:

- Use a clear, descriptive title
- Include a detailed description of changes
- Reference any related issues
- Add screenshots for UI changes if applicable
- Ensure all tests pass
- Request review from relevant team members

### Branching Strategy

- `main`: Production-ready code
- `dev`: Latest development changes
- `feature/*`: New features
- `fix/*`: Bug fixes
- `hotfix/*`: Urgent production fixes

## Project Structure

The project follows Laravel's standard structure with role-based organization:

- `/app/Http/Controllers/Admin`: Admin-specific controllers
- `/app/Http/Controllers/Provider`: Provider-specific controllers 
- `/app/Http/Controllers/Customer`: Customer-specific controllers
- `/app/Http/Controllers/Auth`: Authentication controllers

## Project Shortcut Commands

This project includes custom command shortcuts to speed up your development workflow.

### Available Shortcuts

| Shortcut | Full Command |
|----------|--------------|
| pa-c     | php artisan optimize:clear |
| pa-s     | php artisan serve |
| c        | clear |
| nrd      | npm run dev |
| stopit   | Kill both "php artisan serve" and "npm run dev" processes |
| startit  | Start both "php artisan serve" and "npm run dev" processes |

### How to Use Shortcuts

1. Open your terminal in the project's root directory
2. Run this command:
   ```
   source project-aliases.sh
   ```
3. Now you can use the shortcuts in that terminal session

⚠️ **Note**: These shortcuts only work in the terminal session where you've run the source command. If you open a new terminal window, you'll need to run it again.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
