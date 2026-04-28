# M-Pesa Daraja Plugin for Laravel

Reusable Safaricom Daraja STK Push package for Kenyan Laravel applications, with support for:

- PayBill via `CustomerPayBillOnline`
- Till / Buy Goods via `CustomerBuyGoodsOnline`
- Access token generation
- STK push initiation
- STK push query
- Callback payload parsing

This package is a good fit for your `LandScapeHub` marketplace because it keeps the Daraja code in one place and lets your app stay focused on orders, carts, and vendor commissions.

## What This Plugin Handles

- Auth against Safaricom Daraja
- Phone normalization to Kenyan format
- Automatic selection of PayBill vs Till transaction type
- Safe parsing of STK callback metadata

## What Your App Still Owns

- Creating orders
- Saving checkout request IDs on orders
- Updating `payment_status` and `status`
- Sending customer and vendor notifications
- Exposing a public HTTPS callback URL

## Install Into LandscapeHub

From `C:\xampp\htdocs\landscapehub`, add a path repository and require the local package.

### 1. Update `composer.json`

Add this under `repositories`:

```json
[
    {
        "type": "path",
        "url": "../landscapeplugin"
    }
]
```

Then add this to `require`:

```json
{
    "landscapehub/mpesa-daraja-plugin": "*"
}
```

### 2. Install the package

```powershell
composer require landscapehub/mpesa-daraja-plugin:*
php artisan vendor:publish --tag=mpesa-daraja-config
```

### 3. Add environment variables

```dotenv
PAYMENT_PROVIDER=mpesa

MPESA_ENV=sandbox
MPESA_CONSUMER_KEY=
MPESA_CONSUMER_SECRET=
MPESA_PASSKEY=
MPESA_SHORTCODE=
MPESA_PARTY_B=
MPESA_BUSINESS_TYPE=paybill
MPESA_CALLBACK_URL=https://your-public-domain.com/payments/callback
```

Use:

- `MPESA_BUSINESS_TYPE=paybill` for a PayBill shortcode
- `MPESA_BUSINESS_TYPE=till` for a Till / Buy Goods number
- `MPESA_PARTY_B` when the receiving Till/shortcode differs from the displayed shortcode

## Recommended LandscapeHub Changes

Your current app has placeholder payment logic. Replace it with the plugin flow below.

### Order table

Add columns like:

- `checkout_request_id`
- `merchant_request_id`
- `payment_provider`
- `payment_payload`

Example migration:

```php
Schema::table('orders', function (Blueprint $table) {
    $table->string('payment_provider')->default('mpesa')->after('payment_status');
    $table->string('merchant_request_id')->nullable()->after('mpesa_reference');
    $table->string('checkout_request_id')->nullable()->after('merchant_request_id');
    $table->json('payment_payload')->nullable()->after('checkout_request_id');
});
```

### Payment service

Use the example at [examples/landscapehub/PaymentServiceExample.php](C:/xampp/htdocs/landscapeplugin/examples/landscapehub/PaymentServiceExample.php).

The key behavior change is:

- Do not mark the order as paid immediately after initiating STK
- Save `MerchantRequestID` and `CheckoutRequestID`
- Wait for the callback before setting `payment_status=completed`

### Callback controller

Use the example at [examples/landscapehub/CallbackControllerExample.php](C:/xampp/htdocs/landscapeplugin/examples/landscapehub/CallbackControllerExample.php).

### Order controller

Use the example at [examples/landscapehub/OrderControllerExample.php](C:/xampp/htdocs/landscapeplugin/examples/landscapehub/OrderControllerExample.php).

### Migration

Use the example at [examples/landscapehub/AddMpesaTrackingToOrdersTable.php](C:/xampp/htdocs/landscapeplugin/examples/landscapehub/AddMpesaTrackingToOrdersTable.php).

Safaricom should call a public route like:

```php
Route::post('/payments/callback', CallbackController::class)->name('payments.callback');
```

Return a JSON acknowledgement after processing:

```json
{
    "ResultCode": 0,
    "ResultDesc": "Accepted"
}
```

## Usage Example

```php
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;

class CheckoutController
{
    public function __construct(private readonly PaymentGateway $gateway)
    {
    }

    public function pay(Order $order)
    {
        $result = $this->gateway->initiateStkPush(
            phoneNumber: $order->mpesa_phone,
            amount: $order->total_amount,
            reference: $order->order_number,
            description: 'Landscape order',
            callbackUrl: route('payments.callback')
        );

        return $result->toArray();
    }
}
```

## Important Notes

- STK push requires a publicly reachable callback URL. `http://localhost` will not work in production or most sandbox callbacks.
- For local testing, use a public tunnel such as Ngrok or deploy to a reachable test environment.
- The package assumes Lipa na M-Pesa Online. If you want classic C2B validation/confirmation URLs for PayBill, that is a separate Daraja flow and can be added next.
- `AccountReference` and `TransactionDesc` are trimmed to Daraja-friendly lengths.

## Files

- [composer.json](C:/xampp/htdocs/landscapeplugin/composer.json)
- [config/mpesa-daraja.php](C:/xampp/htdocs/landscapeplugin/config/mpesa-daraja.php)
- [src/Services/DarajaClient.php](C:/xampp/htdocs/landscapeplugin/src/Services/DarajaClient.php)
- [src/Services/DarajaGateway.php](C:/xampp/htdocs/landscapeplugin/src/Services/DarajaGateway.php)
- [src/MpesaDarajaServiceProvider.php](C:/xampp/htdocs/landscapeplugin/src/MpesaDarajaServiceProvider.php)
