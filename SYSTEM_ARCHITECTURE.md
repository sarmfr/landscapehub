# 🏗️ LandScapeHub - System Architecture

## System Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                        LANDSCAPEHUB PLATFORM                     │
│                    (Multi-Vendor Marketplace)                    │
└─────────────────────────────────────────────────────────────────┘

                          ┌──────────────────┐
                          │   USERS/ROLES    │
                          └──────────────────┘
                                  │
                    ┌─────────────┼─────────────┐
                    │             │             │
              ┌─────────┐   ┌──────────┐  ┌──────────┐
              │  Admin  │   │  Vendor  │  │ Customer │
              └─────────┘   └──────────┘  └──────────┘
                    │             │             │
            [View Analytics]  [Manage Shop]  [Browse/Buy]
            [Approve Vendors] [Track Earnings] [Book Services]
            [Set Commission]  [View Bookings]  [Review Items]
```

---

## Data Model (Entity Relationship)

```
┌─────────────┐         ┌──────────────┐
│   USERS     │────────→│  VENDORS     │
├─────────────┤         ├──────────────┤
│ id (PK)     │         │ id (PK)      │
│ name        │         │ user_id (FK) │
│ email       │         │ business_name│
│ password    │         │ location     │
│ role        │         │ approval_... │
│ phone       │         │ commission.. │
└─────────────┘         └──────────────┘
      │                        │
      │                        ├────────────────────┐
      │                        │                    │
      │              ┌─────────────────┐  ┌──────────────┐
      │              │  PRODUCTS       │  │  SERVICES    │
      │              ├─────────────────┤  ├──────────────┤
      │              │ id (PK)         │  │ id (PK)      │
      │              │ vendor_id (FK)  │  │ vendor_id(FK)│
      │              │ category_id(FK) │  │ category_id..│
      │              │ name            │  │ name         │
      │              │ price           │  │ pricing_type │
      │              │ stock           │  │ price        │
      │              │ rating          │  │ rating       │
      │              └─────────────────┘  └──────────────┘
      │                    │                    │
      │                    │                    │
      │          ┌──────────────────┐  ┌────────────────┐
      │          │ PRODUCT_IMAGES   │  │  BOOKINGS      │
      │          ├──────────────────┤  ├────────────────┤
      │          │ id (PK)          │  │ id (PK)        │
      │          │ product_id (FK)  │  │ service_id(FK) │
      │          │ image_path       │  │ user_id (FK)   │
      │          │ is_primary       │  │ vendor_id (FK) │
      │          └──────────────────┘  │ booking_date   │
      │                                │ status         │
      │                                └────────────────┘
      │
      ├─────────────────────────────────────┐
      │                                     │
  ┌──────────┐                      ┌────────────┐
  │ ORDERS   │                      │ CATEGORIES │
  ├──────────┤                      ├────────────┤
  │ id (PK)  │                      │ id (PK)    │
  │ user_id..│                      │ name       │
  │ total... │                      │ slug       │
  │ status   │                      │ type       │
  │ payment..│                      │ icon       │
  └──────────┘                      └────────────┘
      │
      └─→ ORDER_ITEMS
          ├ id (PK)
          ├ order_id (FK)
          ├ product_id (FK)
          ├ quantity
          └ price

┌─────────┐
│ REVIEWS │
├─────────┤
│ id (PK) │
│ user_id │
│ vendor.. │
│ product.│
│ service.│
│ rating  │
│ comment │
└─────────┘

┌────────────────┐
│ QUOTES         │
├────────────────┤
│ id (PK)        │
│ user_id (FK)   │
│ location       │
│ description    │
│ status         │
└────────────────┘
      │
      └─→ QUOTE_RESPONSES
          ├ id (PK)
          ├ quote_id (FK)
          ├ vendor_id (FK)
          ├ quoted_price
          └ status
```

---

## Application Flow - Customer Purchase

```
┌──────────┐
│  START   │
└──────────┘
     │
     ▼
┌────────────────────────┐
│  Browse Products       │
│  (HomeController)      │
└────────────────────────┘
     │
     ▼
┌────────────────────────┐
│  View Product Details  │
│  (HomeController)      │
└────────────────────────┘
     │
     ▼
┌────────────────────────┐     ┌──────────────────────┐
│  Add to Cart           │────→│  CartController:add  │
│  (CartController)      │     │  Store in Session    │
└────────────────────────┘     └──────────────────────┘
     │
     ▼
┌────────────────────────┐     ┌──────────────────────┐
│  View Cart             │────→│  CartController:view │
│  (CartController)      │     │  Display Items       │
└────────────────────────┘     └──────────────────────┘
     │
     ▼
┌────────────────────────┐     ┌──────────────────────┐
│  Checkout              │────→│ CartController:      │
│  (CartController)      │     │ checkout             │
└────────────────────────┘     │ Create Order         │
     │                         │ Calculate Commission │
     ▼                         └──────────────────────┘
┌────────────────────────┐
│  M-Pesa Payment        │
│  (Future: PaymentCtrl) │
└────────────────────────┘
     │
     ▼
┌────────────────────────┐
│  Order Confirmed       │
│  Vendor Notified       │
└────────────────────────┘
     │
     ▼
┌──────────┐
│   END    │
└──────────┘
```

---

## Application Flow - Service Booking

```
┌──────────┐
│  START   │
└──────────┘
     │
     ▼
┌────────────────────────┐
│  Browse Services       │
│  (HomeController)      │
└────────────────────────┘
     │
     ▼
┌────────────────────────┐
│  View Service Details  │
│  (HomeController)      │
└────────────────────────┘
     │
     ▼
┌────────────────────────┐     ┌──────────────────────┐
│  Book Service          │────→│ BookingController:   │
│  (BookingController)   │     │ create (show form)   │
└────────────────────────┘     └──────────────────────┘
     │
     ▼
┌────────────────────────┐     ┌──────────────────────┐
│  Fill Booking Form     │────→│ BookingController:   │
│  Date, Location, Desc  │     │ store (save booking) │
└────────────────────────┘     └──────────────────────┘
     │
     ▼
┌────────────────────────┐
│  Booking Created       │
│  Status: Pending       │
└────────────────────────┘
     │
     ▼
┌────────────────────────┐
│  Vendor Reviews        │
│  (VendorDashCtrl)      │
│  Approves/Rejects      │
└────────────────────────┘
     │
     ├──→ ┌─────────────┐
     │    │ REJECTED    │
     │    └─────────────┘
     │
     └──→ ┌─────────────┐
          │ APPROVED    │
          │ Payment Due │
          └─────────────┘
               │
               ▼
          ┌─────────────┐
          │  Payment    │
          │  (M-Pesa)   │
          └─────────────┘
               │
               ▼
          ┌─────────────┐
          │ Confirmed   │
          └─────────────┘
               │
               ▼
          ┌──────────┐
          │   END    │
          └──────────┘
```

---

## Route Structure

```
┌─────────────────────────────────────────────────────┐
│                   WEB ROUTES (web.php)              │
└─────────────────────────────────────────────────────┘

PUBLIC ROUTES
├── GET  / (home)
├── GET  /products (listing)
├── GET  /products/{slug} (detail)
├── GET  /services (listing)
└── GET  /services/{slug} (detail)

AUTHENTICATION
├── GET  /login (LoginController@showForm)
├── POST /login (LoginController@login)
├── POST /logout (LoginController@logout)
├── GET  /register (RegisterController@showForm)
└── POST /register (RegisterController@register)

SHOPPING CART
├── GET  /cart (CartController@view)
├── POST /cart/add (CartController@add)
├── POST /cart/remove (CartController@remove)
└── POST /cart/checkout (CartController@checkout)

SERVICE BOOKINGS
├── POST /services/{service}/book (BookingController@store)
├── GET  /bookings/{booking} (BookingController@show)
└── GET  /my-bookings (BookingController@myBookings)

ADMIN (Protected by AdminMiddleware)
└── /admin
    └── GET /dashboard (AdminDashboard@index)

VENDOR (Protected by VendorMiddleware)
└── /vendor
    └── GET /dashboard (VendorDashboard@index)
```

---

## Controller Organization

```
HomeController
    ├── index() → shows homepage with trending products/services
    ├── products() → lists all products with filters
    ├── services() → lists all services
    ├── showProduct() → shows product detail page
    └── showService() → shows service detail page

CartController
    ├── view() → displays shopping cart
    ├── add() → adds product to cart
    ├── remove() → removes product from cart
    └── checkout() → creates order from cart

BookingController
    ├── create() → shows booking form
    ├── store() → saves booking
    ├── show() → shows booking details
    └── myBookings() → lists user's bookings

Auth/LoginController
    ├── showForm() → shows login form
    ├── login() → authenticates user
    └── logout() → logs out user

Auth/RegisterController
    ├── showForm() → shows registration form
    └── register() → creates new user account

Admin/DashboardController
    └── index() → shows admin analytics dashboard

Vendor/DashboardController
    └── index() → shows vendor dashboard with stats
```

---

## Middleware Chain

```
HTTP Request
    │
    ├─→ web.php middleware stack
    │   ├─ Session
    │   ├─ CSRF
    │   └─ Other global middleware
    │
    ├─ Route matched
    │
    └─→ Route-specific middleware
        ├─ auth (if protected route)
        ├─ admin (if admin route)
        └─ vendor (if vendor route)
            │
            └─→ Controller Action
                │
                └─→ Response/View
```

---

## Database Transaction Flow

```
CREATE ORDER TRANSACTION:

1. Validate Cart Items
2. Calculate Total
3. Calculate Commission (10%)
4. Create Order Record
5. For Each Item:
   - Create OrderItem Record
   - Update Product Stock
6. Clear Session Cart
7. Return Order Confirmation
8. (Later) M-Pesa Callback:
   - Verify Payment
   - Update Order Status
   - Send Notifications
   - Release Commission
```

---

## File Structure by Function

```
MVC Pattern Implementation:

MODELS (app/Models/)
├── Database abstraction layer
├── Business rules
└── Relationships

VIEWS (resources/views/)
├── User interface
├── Blade templates
└── Frontend logic

CONTROLLERS (app/Http/Controllers/)
├── Request handling
├── Business logic orchestration
└── Response generation

ROUTES (routes/web.php)
├── URL mapping
├── Middleware binding
└── Route grouping

MIDDLEWARE (app/Http/Middleware/)
├── Request pre-processing
├── Authentication
└── Authorization
```

---

## Security Layers

```
Request Protection:
├── CSRF Token (Laravel default)
├── SQL Injection (Eloquent ORM)
├── XSS (Blade escaping)
└── Mass Assignment (Model $fillable)

Authentication:
├── Password Hashing (bcrypt)
├── Session Management
├── Role-Based Access
└── Middleware Guards

Authorization:
├── Admin Middleware
├── Vendor Middleware
└── Model-level checks
```

---

## Performance Considerations

```
Database:
├── Indexes on foreign keys
├── Eager loading relationships
├── Query optimization
└── Caching ready (config included)

Frontend:
├── Tailwind CSS (CDN)
├── Minimal JavaScript
├── Chart.js for analytics
└── Session-based cart (no DB hit per item)

Scalability:
├── Modular controller design
├── Loose coupling
├── Repository pattern ready
└── API routes ready for mobile app
```

---

## Deployment Architecture

```
┌──────────────┐
│ Wasmer Edge  │
├──────────────┤
│              │
├─ Laravel App
├─ MySQL DB
├─ File Storage
└─ SSL/HTTPS
    │
    ├─ Apache/Nginx
    ├─ PHP 8.2+
    ├─ Composer Dependencies
    └─ Production .env
```

---

## Future Expansion Points

```
Mobile App
    └─ API Routes Ready (can add api.php)

Real-time Features
    └─ Broadcasting ready (if implemented)

Background Jobs
    └─ Queue system ready (config/queue.php)

Email Notifications
    └─ Mail configuration ready

File Storage
    └─ S3 integration points

Caching
    └─ Redis integration points

API Authentication
    └─ Sanctum ready for token auth
```

---

**Architecture Complete!** ✅

This foundation supports:
- 🚀 Rapid development
- 📈 Scalability
- 🔒 Security
- 🎨 Clean code
- 📱 Future mobile app
- 🌐 International expansion
