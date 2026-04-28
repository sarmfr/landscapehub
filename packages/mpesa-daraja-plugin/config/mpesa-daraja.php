<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Daraja Environment
    |--------------------------------------------------------------------------
    |
    | Supported values: sandbox, production
    |
    */
    'environment' => env('MPESA_ENV', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | App Credentials
    |--------------------------------------------------------------------------
    */
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Lipa Na M-Pesa Online
    |--------------------------------------------------------------------------
    |
    | business_type controls the default transaction type:
    | - paybill => CustomerPayBillOnline
    | - till    => CustomerBuyGoodsOnline
    |
    */
    'business_type' => env('MPESA_BUSINESS_TYPE', 'paybill'),
    'short_code' => env('MPESA_SHORTCODE'),
    'party_b' => env('MPESA_PARTY_B', env('MPESA_SHORTCODE')),
    'passkey' => env('MPESA_PASSKEY'),
    'callback_url' => env('MPESA_CALLBACK_URL'),
    'transaction_type' => env('MPESA_TRANSACTION_TYPE'),

    /*
    |--------------------------------------------------------------------------
    | Request Tuning
    |--------------------------------------------------------------------------
    */
    'timeout' => (int) env('MPESA_TIMEOUT', 30),
    'connect_timeout' => (int) env('MPESA_CONNECT_TIMEOUT', 10),
    'token_cache_seconds' => (int) env('MPESA_TOKEN_CACHE_SECONDS', 3300),
];
