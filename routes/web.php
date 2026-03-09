<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Vendor\ProfileController as VendorProfileController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\ServiceController as VendorServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/products/{slug}', [HomeController::class, 'showProduct'])->name('products.show');
Route::get('/services/{slug}', [HomeController::class, 'showService'])->name('services.show');

// Auth routes
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout']); // Fallback for accidental GET requests

Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Cart routes
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Booking routes
Route::get('/services/{service}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/services/{service}/book', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my')->middleware('auth');

// Auth dependent routes (Orders, Profile, Reviews)
Route::middleware('auth')->group(function () {
    // Order routes
    Route::get('/orders', [OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/payment', [OrderController::class, 'payment'])->name('order.payment');
    Route::post('/orders/{order}/payment', [OrderController::class, 'processPayment'])->name('order.payment.process');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Review Routes
    Route::get('/reviews/product/{product}', [ReviewController::class, 'createProductReview'])->name('reviews.product');
    Route::get('/reviews/service/{service}', [ReviewController::class, 'createServiceReview'])->name('reviews.service');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Quote Routes (Customer)
    Route::resource('quotes', \App\Http\Controllers\QuoteController::class);
    Route::post('/quotes/responses/{response}/accept', [\App\Http\Controllers\QuoteController::class, 'acceptResponse'])->name('quotes.accept');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Vendor Management
    Route::resource('vendors', AdminVendorController::class);
    Route::put('/vendors/{vendor}/approve', [AdminVendorController::class, 'approve'])->name('vendors.approve');
    Route::post('/vendors/{vendor}/reject', [AdminVendorController::class, 'reject'])->name('vendors.reject');
    Route::post('/vendors/{vendor}/suspend', [AdminVendorController::class, 'suspend'])->name('vendors.suspend');
    Route::post('/vendors/{vendor}/reactivate', [AdminVendorController::class, 'reactivate'])->name('vendors.reactivate');

    // User Management
    Route::resource('users', AdminUserController::class);

    // Category Management
    Route::resource('categories', AdminCategoryController::class);

    // Content/Product Moderation
    Route::resource('products', AdminProductController::class)->only(['index', 'show', 'destroy']);
    Route::post('/products/{product}/status', [AdminProductController::class, 'updateStatus'])->name('products.status');
});

// Vendor routes
Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'vendor'])->group(function () {
    Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile/create', [VendorProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [VendorProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [VendorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [VendorProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [VendorProfileController::class, 'show'])->name('profile.show');

    // Product Management
    Route::resource('products', VendorProductController::class);
    Route::delete('/products/{product}/image/{image}', [VendorProductController::class, 'deleteImage'])->name('products.deleteImage');

    // Service Management
    Route::resource('services', VendorServiceController::class);
    Route::delete('/products/{product}/image/{image}', [VendorProductController::class, 'deleteImage'])->name('products.deleteImage');

    // Quote Management (Vendor)
    Route::get('/quotes', [\App\Http\Controllers\Vendor\QuoteController::class, 'index'])->name('quotes.index');
    Route::get('/quotes/responses', [\App\Http\Controllers\Vendor\QuoteController::class, 'myResponses'])->name('quotes.responses');
    Route::get('/quotes/{quote}', [\App\Http\Controllers\Vendor\QuoteController::class, 'show'])->name('quotes.show');
    Route::post('/quotes/{quote}/respond', [\App\Http\Controllers\Vendor\QuoteController::class, 'storeResponse'])->name('quotes.respond');
});

// Payment API / Webhook Routes (Ready for Plugin)
Route::prefix('payments')->name('payments.')->group(function () {
    Route::post('/callback', [\App\Http\Controllers\OrderController::class, 'handlePaymentCallback'])->name('callback');
    Route::any('/webhook', [\App\Http\Controllers\OrderController::class, 'handlePaymentWebhook'])->name('webhook');
});
