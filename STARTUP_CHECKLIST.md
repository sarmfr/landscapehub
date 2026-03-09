# 🚀 LandScapeHub - Quick Start Checklist

## Pre-Setup Verification

- [ ] XAMPP installed and running (Apache + MySQL)
- [ ] Composer installed globally
- [ ] PHP 8.2+ installed
- [ ] MySQL 5.7+ running
- [ ] Internet connection (for Composer downloads)

---

## Step 1: Database Setup (5 minutes)

### 1.1 Create Database
- [ ] Open phpMyAdmin: http://localhost/phpmyadmin
- [ ] Click "New" button (bottom left)
- [ ] Database name: `landscapehub`
- [ ] Charset: `utf8mb4_unicode_ci`
- [ ] Click "Create"

### 1.2 Import Database Schema
- [ ] Click on `landscapehub` database
- [ ] Click "Import" tab (top menu)
- [ ] Click "Choose File"
- [ ] Navigate to: `c:\xampp\htdocs\landscapehub\database\landscapehub.sql`
- [ ] Click "Import" button (bottom)
- [ ] Wait for confirmation message ✓

**Status**: Database ready!

---

## Step 2: Install Laravel Framework (10 minutes)

### 2.1 Open Terminal/CMD
- [ ] Press `Win + R`
- [ ] Type: `cmd`
- [ ] Press Enter

### 2.2 Navigate to Project
```bash
cd c:\xampp\htdocs\landscapehub
```

### 2.3 Install Dependencies
```bash
composer create-project laravel/laravel . --force
```

This will:
- Download Laravel 11
- Install all dependencies
- Create necessary directories
- Take 5-10 minutes

**Wait for completion message**: "Application ready! Build something amazing."

### 2.4 Generate App Key
```bash
php artisan key:generate
```

You should see: `Application key set successfully.`

**Status**: Laravel installed!

---

## Step 3: Verify Installation (2 minutes)

### 3.1 Check Files
- [ ] Verify `vendor/` folder exists (large folder ~200MB)
- [ ] Verify `.env` file has `APP_KEY=base64:...`
- [ ] Check `config/` folder has files

### 3.2 Clear Cache
```bash
php artisan cache:clear
```

---

## Step 4: Run Application (1 minute)

### 4.1 Start Development Server
```bash
php artisan serve
```

You should see:
```
Laravel development server started: http://127.0.0.1:8000
```

### 4.2 Open in Browser
- [ ] Visit: http://localhost:8000
- [ ] Should see LandScapeHub homepage
- [ ] All styling and content should display

**Status**: Application running!

---

## Step 5: Test Key Features (5 minutes)

### 5.1 Homepage
- [ ] Visit: http://localhost:8000
- [ ] See featured products ✓
- [ ] See popular services ✓
- [ ] See navigation menu ✓

### 5.2 Registration
- [ ] Click "Register" or "Become Vendor"
- [ ] Fill in form (name, email, phone)
- [ ] Select "Customer" or "Vendor"
- [ ] Create account
- [ ] Should redirect to home or setup page

### 5.3 Login as Admin
- [ ] Click "Login"
- [ ] Email: `admin@landscapehub.com`
- [ ] Password: `password`
- [ ] Should show logged in status
- [ ] Hamburger/menu shows "Logout"

### 5.4 Admin Dashboard
- [ ] Visit: http://localhost:8000/admin/dashboard
- [ ] See statistics (Users, Vendors, Revenue)
- [ ] See charts and graphs
- [ ] Should display data

### 5.5 Browse Products
- [ ] Click "Shop Products"
- [ ] See product grid
- [ ] Click "View All" for full listing
- [ ] See filtering options

### 5.6 Browse Services
- [ ] Click "Browse Services"
- [ ] See service listings
- [ ] Click service for details
- [ ] See service information

### 5.7 Shopping Cart
- [ ] Add product to cart
- [ ] View cart (click 🛒 icon)
- [ ] See items and total
- [ ] Can adjust quantity

**Status**: All features working!

---

## Step 6: Customize (Optional)

### 6.1 Edit Configuration
Edit `.env` file:
```
APP_NAME=LandScapeHub
APP_DEBUG=true (local dev only)
DB_DATABASE=landscapehub
DB_USERNAME=root
DB_PASSWORD=
```

### 6.2 Edit Brand Name
- Products view: `resources/views/`
- Update title: `<title>Your Brand</title>`
- Update logo: Change "LandScapeHub" text

### 6.3 Add Sample Data
Run in terminal (when Laravel CLI works):
```bash
php artisan db:seed
```

---

## Step 7: Troubleshooting

### Issue: "Database connection refused"
**Solution:**
1. Verify MySQL is running in XAMPP
2. Check credentials in `.env`
3. Confirm database name is `landscapehub`

### Issue: "Class not found" errors
**Solution:**
```bash
composer dump-autoload
```

### Issue: Permission denied on Windows
**Solution:**
- Run Command Prompt as Administrator
- Retry commands

### Issue: Port 8000 already in use
**Solution:**
```bash
php artisan serve --port=8001
# Then visit http://localhost:8001
```

### Issue: Blank white page
**Solution:**
1. Check `php artisan serve` is running
2. Check browser console for errors (F12)
3. Review Laravel logs in `storage/logs/`

### Issue: Images not loading
**Solution:**
- This is expected - use placeholder emojis for now
- Implement image upload later

---

## Next Development Steps

### Phase 1: Essential (Week 1-2)
- [ ] Implement vendor profile creation
- [ ] Add vendor approval system
- [ ] Create product management system
- [ ] Add service management

### Phase 2: Cart & Payment (Week 3-4)
- [ ] Improve checkout flow
- [ ] Integrate M-Pesa payment
- [ ] Implement payment callback
- [ ] Calculate commission automatically

### Phase 3: Bookings (Week 5)
- [ ] Implement booking approval
- [ ] Payment for services
- [ ] Booking notifications

### Phase 4: Polish (Week 6-8)
- [ ] Email notifications
- [ ] Advanced search
- [ ] User profiles
- [ ] Testing
- [ ] Deployment

---

## Important Files Reference

| File | Purpose |
|------|---------|
| `.env` | Configuration (DB, API keys) |
| `routes/web.php` | All URL routes |
| `app/Models/` | Database models |
| `app/Http/Controllers/` | Business logic |
| `resources/views/` | HTML templates |
| `database/landscapehub.sql` | Database schema |
| `README.md` | Full documentation |
| `PROJECT_SUMMARY.md` | Feature overview |

---

## Useful Artisan Commands

```bash
# Create new controller
php artisan make:controller YourController

# Create model with migration
php artisan make:model Product -m

# Run migrations
php artisan migrate

# Clear cache
php artisan cache:clear

# View all routes
php artisan route:list

# Create seeder
php artisan make:seeder ProductSeeder

# Run seeders
php artisan db:seed
```

---

## Development Tips

1. **Use Tinker for testing**:
   ```bash
   php artisan tinker
   # Then: User::all() or Product::count()
   ```

2. **Check logs**:
   ```
   storage/logs/laravel.log
   ```

3. **Debug code**:
   ```php
   dd($variable); // Dump and Die
   dump($variable); // Just dump
   ```

4. **Keep terminal running**:
   - Don't close the `php artisan serve` terminal
   - It must stay running while developing

---

## Success Checklist

- ✅ Database created and populated
- ✅ Laravel installed
- ✅ Application can start (`php artisan serve`)
- ✅ Homepage loads at http://localhost:8000
- ✅ Can register new user
- ✅ Can login as admin
- ✅ Admin dashboard shows data
- ✅ Products can be browsed
- ✅ Products can be added to cart
- ✅ All pages load without errors

---

## Performance Notes

- Initial setup: ~15-20 minutes
- First run is slow (Composer downloads)
- Subsequent runs are faster
- Composer is only needed if adding packages
- Development server: Single user/low traffic

---

## Ready to Code!

Your LandScapeHub MVP foundation is ready for development!

**Next Action**: 
1. Keep `php artisan serve` running
2. Edit files in your IDE
3. Refresh browser to see changes
4. Follow the "Next Development Steps" above

---

**Happy Coding! 🌿**

Questions or issues? Check the README.md and XAMPP_SETUP_GUIDE.md files.
