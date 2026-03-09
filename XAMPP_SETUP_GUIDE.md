# LandScapeHub - XAMPP Setup Guide

This guide will help you set up LandScapeHub on your local XAMPP environment.

## Prerequisites

✅ XAMPP installed and running (PHP 8.2+, MySQL)
✅ Composer installed globally
✅ Text editor or IDE (VS Code recommended)

## Quick Setup (10 minutes)

### Step 1: Create Database

1. Open phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Click "New" database
3. Name: `landscapehub`
4. Charset: `utf8mb4_unicode_ci`
5. Click "Create"

### Step 2: Import Database Schema

1. Go to `landscapehub` database
2. Click "Import" tab
3. Click "Choose File"
4. Select: `c:\xampp\htdocs\landscapehub\database\landscapehub.sql`
5. Click "Import" (Go)

✅ Database is ready!

### Step 3: Install Laravel Framework

Open Command Prompt (cmd) or PowerShell in the landscapehub folder:

```bash
cd c:\xampp\htdocs\landscapehub
composer create-project laravel/laravel . --force
```

This will:
- Install all PHP dependencies
- Create necessary directories
- Install Laravel framework files

### Step 4: Generate App Key

```bash
php artisan key:generate
```

### Step 5: Run the Application

**Option A: Using PHP Built-in Server**
```bash
php artisan serve
```
Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

**Option B: Using XAMPP Apache**
1. Create a virtual host or access via: `http://localhost/landscapehub/public`
2. Make sure `mod_rewrite` is enabled in Apache

## Test the Installation

### Homepage
- [http://localhost:8000/](http://localhost:8000/)

### Login as Admin
- Email: `admin@landscapehub.com`
- Password: `password`
- URL: [http://localhost:8000/login](http://localhost:8000/login)

### Admin Dashboard
- [http://localhost:8000/admin/dashboard](http://localhost:8000/admin/dashboard)

### Register New Account
- [http://localhost:8000/register](http://localhost:8000/register)

## Project Structure

```
landscapehub/
├── app/                 # Application code
│   ├── Models/         # Database models
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
├── database/           # Migrations & schema
│   ├── migrations/
│   └── landscapehub.sql
├── resources/          # Frontend
│   └── views/         # Blade templates
├── routes/            # URL routes
│   └── web.php
├── config/            # Configuration
├── public/            # Entry point
├── .env               # Environment variables
└── README.md
```

## Configuration

### .env File

Located at: `c:\xampp\htdocs\landscapehub\.env`

```env
APP_NAME=LandScapeHub
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=landscapehub
DB_USERNAME=root
DB_PASSWORD=

MPESA_CONSUMER_KEY=your-key
MPESA_CONSUMER_SECRET=your-secret
```

## Development Commands

### Useful Artisan Commands

```bash
# Create a new controller
php artisan make:controller ProductController

# Create a new model with migration
php artisan make:model Product -m

# Create a migration
php artisan make:migration create_products_table

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan cache:clear

# View routes
php artisan route:list
```

## Troubleshooting

### Database Connection Error
- Check DB credentials in `.env` match phpMyAdmin
- Ensure MySQL is running in XAMPP
- Verify database name is `landscapehub`

### "Class not found" Error
```bash
composer dump-autoload
```

### Permission Denied (XAMPP Windows)
Run command prompt as Administrator before running php artisan commands

### Missing Views or Routes
Verify files are in correct directories:
- Controllers: `app/Http/Controllers/`
- Models: `app/Models/`
- Views: `resources/views/`

## Features to Test

### Public Features
- ✅ Browse products
- ✅ Browse services
- ✅ Register as customer or vendor
- ✅ Login with credentials

### Customer Features
- ✅ Add products to cart
- ✅ Checkout
- ✅ View bookings
- ✅ Leave reviews

### Vendor Features (after approval)
- ✅ View vendor dashboard
- ✅ Manage products (when implemented)
- ✅ Manage services (when implemented)
- ✅ View earnings

### Admin Features
- ✅ View admin dashboard
- ✅ See analytics and charts
- ✅ View top vendors
- ✅ View revenue

## Next Steps

1. **Implement Vendor Profile Creation**
   - Add form to create vendor business profile
   - Email admin for approval

2. **Product Management**
   - Add product creation form
   - Multiple image upload
   - Inventory management

3. **M-Pesa Integration**
   - Get API credentials from Safaricom
   - Implement payment gateway
   - Setup callback handling

4. **Service Booking**
   - Create booking approval system
   - Payment for service bookings
   - Review system

5. **Admin Approval System**
   - Vendor approval management
   - Commission rate configuration
   - User and order management

## File Locations

| File | Location |
|------|----------|
| Homepage | `resources/views/home.blade.php` |
| Database Schema | `database/landscapehub.sql` |
| Routes | `routes/web.php` |
| Models | `app/Models/` |
| Controllers | `app/Http/Controllers/` |
| Views | `resources/views/` |
| Config | `config/` |
| Environment | `.env` |

## Performance Tips

1. Use `php artisan serve` for development
2. Enable Laravel Tinker for debugging: `php artisan tinker`
3. Use `dd()` for debug output
4. Clear cache: `php artisan cache:clear`
5. Optimize auto-loading: `composer install --optimize-autoloader`

## Security Reminders

⚠️ **For Production:**
- Set `APP_DEBUG=false` in `.env`
- Use strong passwords
- Enable HTTPS
- Validate all user inputs
- Use environment variables for sensitive data
- Implement rate limiting
- Setup CORS properly

## Support & Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Chart.js**: https://www.chartjs.org/
- **MySQL Documentation**: https://dev.mysql.com/doc/

## Contact

For project updates and collaboration:
- Email: developer@landscapehub.co.ke
- Status: MVP Development

---

**Happy coding! 🌿**

Start building Kenya's leading landscaping marketplace!
