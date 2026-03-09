<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Plugin
    |--------------------------------------------------------------------------
    |
    | Define your active payment plugin here. This is designed to be 
    | extensible via custom plugins later.
    |
    */
    'default' => env('PAYMENT_PROVIDER', 'mock'),

    'providers' => [
        'mpesa' => [
            'consumer_key' => env('MPESA_CONSUMER_KEY'),
            'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
            'short_code' => env('MPESA_SHORTCODE'),
            'passkey' => env('MPESA_PASSKEY'),
            'env' => env('MPESA_ENV', 'sandbox'),
        ],
        // Add more providers here
    ],

    'commission_rate' => env('PAYMENT_COMMISSION_RATE', 10),
];
