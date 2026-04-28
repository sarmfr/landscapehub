<?php

namespace App\Providers;

use App\Services\Payments\MockPaymentGateway;
use Illuminate\Support\ServiceProvider;
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;
use LandscapeHub\Payments\MpesaDaraja\Services\DarajaGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGateway::class, function ($app) {
            if (config('payment.default') === 'mock') {
                return new MockPaymentGateway();
            }

            return $app->make(DarajaGateway::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
