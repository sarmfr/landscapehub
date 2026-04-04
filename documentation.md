# LandScapeHub Technical Documentation & Plugin Guide

This document provides a technical overview of the LandScapeHub platform and a detailed guide for developing payment plugins with integrated commission management.

---

## 1. System Architecture Overview

LandScapeHub is built using **Laravel 11**, leveraging a traditional MVC architecture with a service-oriented layer for external integrations (e.g., Payments).

### 1.1 Core Components
- **Framework**: Laravel 11.x
- **Frontend**: Blade Templating + Tailwind CSS
- **Authentication**: Custom Auth using Breeze/Jetstream-like patterns.
- **Service Layer**: 
    - `PaymentService`: Orchestrates all financial transactions and interacts with external provider plugins.
    - `SafeMailService`: Handles reliable email queuing for notifications.

### 1.2 User Roles & Permissions
The system operates on three primary roles, managed via the `role` column in the `users` table:
1. **Admin**: Manages vendors, categories, and monitors system performance.
2. **Vendor**: Lists products/services, manages their business profile, and tracks earnings.
3. **Customer**: Browses the marketplace, books services, and purchases products.

---

## 2. Database & Data Models

### 2.1 Key Tables
- **`users`**: Central account storage.
- **`vendors`**: Extended profiles for users with the `vendor` role.
    - `commission_rate`: The percentage (0-100) deducted from each sale for this specific vendor.
- **`products`**: Items available for purchase from vendors.
- **`orders`**: Transaction records for product purchases.
    - `total_amount`: The gross amount paid by the customer.
    - `commission_amount`: The portion calculated for the platform owner.
    - `vendor_amount`: The net balance allocated to the vendor.
- **`bookings`**: Service-specific requests (separate from product orders).

---

## 3. The Payment Flow (Plugin Perspective)

The payment system is designed to be extensible. A "plugin" is a concrete implementation of logic within or extending the `PaymentService`.

### 3.1 Order Lifecycle
1. **Checkout**: `CartController@checkout` creates an `Order` and calculates the financial splits based on the vendor's `commission_rate`.
2. **Initiation**: The customer clicks "Pay" on the order payment page, calling `PaymentService@initiate`.
3. **STK Push (Customer)**: The plugin triggers an STK Push to the customer's phone (e.g., Safaricom Daraja API).
4. **Verification (Asynchronous)**: The provider sends a webhook/callback to the platform.
5. **Completion**: Upon successful verification, the `Order` status is updated to `completed` and `payment_status` to `paid`.

### 3.2 Commission-Split Logic
The platform automatically handles the internal accounting of commissions. When an order is completed:
- `Order::total_amount` = `Order::commission_amount` + `Order::vendor_amount`.
- Plugins should focus on ensuring the `total_amount` is correctly authorized by the customer.

---

## 4. Plugin Development Guide

To develop a new payment plugin (e.g., for M-Pesa, Stripe, or Flutterwave), follow these steps:

### 4.1 Configuration
Add your provider credentials to `config/payment.php`:
```php
'providers' => [
    'mpesa' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        // ...
    ],
],
```

### 4.2 Extending the Service
Implement the core methods in `app/Services/PaymentService.php` or create a dedicated handler:

#### `initiate(Order $order)`
- **Goal**: Trigger the payment request.
- **Action**: Prepare the payload (account number, order amount, callback URL) and call the external API.
- **Return**: A status array or a redirect URL.

#### `handleWebhook(Request $request)`
- **Goal**: Process the callback from the provider.
- **Security**: Verify the signature or IP of the request.
- **Action**: Locate the order using the reference provided by the callback and update its status.

### 4.3 Webhook Endpoints
The following endpoints are reserved for payment providers:
- `POST /payments/callback`: For synchronous responses.
- `ANY /payments/webhook`: For asynchronous status updates (recommended).

> [!WARNING]
> Always use `Log::info()` within your plugin development to trace webhook payloads, as providers often send complex JSON structures.

---

## 5. Security & Best Practices

1. **Idempotency**: Ensure that repeated webhooks for the same transaction don't result in duplicate order updates.
2. **Environment**: Never hardcode API keys. Use `.env` variables.
3. **Validation**: Validate all incoming callback data before updating the database.
4. **Commission Integrity**: Always use the stored `commission_amount` from the `orders` table during reconciliation, as vendor rates might change over time.

---

*Document version: 1.0.0*
*Last updated: April 2026*
