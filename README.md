# LandScapeHub - Laravel 11 Marketplace

A multi-vendor landscaping marketplace platform built with Laravel 11, MySQL, and Tailwind CSS.

## Features

### User Roles
- **Admin**: Approve vendors, view analytics, manage platform
- **Vendor**: List products/services, manage inventory, track earnings
- **Customer**: Browse, purchase products, book services

### Core Features
- Product catalog with multiple images
- Service booking system
- Shopping cart and checkout
- M-Pesa payment integration
- Commission-based revenue model
- Vendor review and rating system
- Quote request system
- Admin analytics dashboard
- Vendor analytics

## Tech Stack

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade + Tailwind CSS
- **Charts**: Chart.js
- **Payment**: M-Pesa Daraja API

## Project Structure

```
landscapehub/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   └── Vendor/
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── config/
└── public/
```

## Database Schema

### Core Tables
- **users**: User accounts (admin, vendor, customer)
- **vendors**: Vendor profiles and business info
- **categories**: Product and service categories
- **products**: Landscaping products with inventory
- **product_images**: Product images (supports multiple)
- **services**: Landscaping services
- **orders**: Purchase orders
- **order_items**: Items in each order
- **bookings**: Service booking requests
- **reviews**: Product and service reviews
- **quotes**: Custom quote requests
- **quote_responses**: Vendor responses to quotes

## Installation

### Prerequisites
- PHP 8.2+
- MySQL 5.7+
- Composer
- Apache/Nginx with mod_rewrite

### Setup Steps

1. **Clone/Extract Project**
```bash
cd c:\xampp\htdocs\landscapehub
```

2. **Create Database**
```bash
# Open phpMyAdmin at http://localhost/phpmyadmin
# Create new database named 'landscapehub'
```

3. **Create Tables**
```bash
# Run migrations (once Laravel CLI is set up)
php artisan migrate

# Or manually import the migration files as SQL
```

4. **Configure .env**
Already created with default settings. Update:
```
DB_DATABASE=landscapehub
DB_USERNAME=root
DB_PASSWORD=

MPESA_CONSUMER_KEY=your-key
MPESA_CONSUMER_SECRET=your-secret
MPESA_PASSKEY=your-passkey
MPESA_SHORTCODE=your-shortcode
```

5. **Generate App Key** (when Laravel CLI is available)
```bash
php artisan key:generate
```

## Development

### Admin Account
Create admin user through phpMyAdmin or seeder:
```sql
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('Admin', 'admin@landscapehub.com', '$2y$10$...', 'admin', NOW(), NOW());
```

### Routes

#### Public
- `/` - Homepage
- `/products` - Product listing
- `/services` - Service listing
- `/login` - User login
- `/register` - User registration

#### Customer
- `/cart` - Shopping cart
- `/my-bookings` - My service bookings

#### Vendor
- `/vendor/dashboard` - Vendor dashboard

#### Admin
- `/admin/dashboard` - Admin dashboard

## Commission System

Default: 10% commission on all product sales

Example:
- Product Price: 10,000 KES
- Commission (10%): 1,000 KES
- Vendor Receives: 9,000 KES

Configurable in `.env`:
```
COMMISSION_RATE=10
```

## User Guide

### For Customers
1. Register as "Customer"
2. Browse products and services
3. Add products to cart and checkout
4. Pay via M-Pesa
5. Book services directly
6. Leave reviews

### For Vendors
1. Register as "Vendor"
2. Create business profile
3. Wait for admin approval
4. Add products with images
5. Add services with pricing
6. View earnings and analytics
7. Respond to service bookings

### For Admin
1. Login with admin account
2. View dashboard with analytics
3. Approve/reject vendors
4. View orders and revenue
5. Manage categories
6. View system reports

## M-Pesa Integration

### Setup
1. Register at [Safaricom Daraja](https://developer.safaricom.co.ke/)
2. Get Consumer Key and Consumer Secret
3. Generate Passkey
4. Add to .env:
```
MPESA_CONSUMER_KEY=your-key
MPESA_CONSUMER_SECRET=your-secret
MPESA_PASSKEY=your-passkey
MPESA_SHORTCODE=your-shortcode
```

### Payment Flow
1. User initiates checkout
2. STK Push sent to user's phone
3. User enters M-Pesa PIN
4. Callback URL verifies transaction
5. Order status updated to "completed"
6. Commission automatically calculated

## Security

- Password hashing with bcrypt
- CSRF protection on all forms
- Input validation and sanitization
- File upload restrictions
- Role-based access control via middleware
- M-Pesa credentials stored in .env

## Performance Tips

- Database indexes on foreign keys
- Product image optimization
- Lazy loading of relationships
- Caching for frequently accessed data
- S3/Cloud storage for product images (future)

## Future Enhancements

### Phase 2
- Mobile app (Flutter)
- Real-time vendor chat
- AI Garden Design Preview
- Delivery partner integration

### Phase 3
- County-based vendor filtering
- Insurance options for services
- Video consultations
- Advanced analytics

## Support

For issues or questions:
- Email: support@landscapehub.co.ke
- Help Center: Coming soon

## License

Private - LandScapeHub 2026

## Deployment

### To Wasmer Edge
1. Use a MySQL-compatible database and a Wasmer volume for uploaded media
2. Copy `app.yaml.example` to `app.yaml` and set your Wasmer `owner` and app `name`
3. Copy `.env.wasmer.example` into your own deployment env file and fill in real values
4. Generate an app key with `php artisan key:generate --show`
5. Add the production values to Wasmer secrets
6. Run `wasmer deploy`
7. Run database migrations on the production database
8. Confirm login, cart, checkout, and vendor flows work before replacing mock payments

See [WASMER_DEPLOY.md](/C:/xampp/htdocs/landscapehub/WASMER_DEPLOY.md) for the detailed Wasmer notes and [PRE_DEPLOY_CHECKLIST.md](/C:/xampp/htdocs/landscapehub/PRE_DEPLOY_CHECKLIST.md) for the Wasmer release checklist.

---

**LandScapeHub** - Transforming Kenya's Landscaping Industry 🌿
