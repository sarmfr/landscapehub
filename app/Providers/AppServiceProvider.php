<?php

namespace App\Providers;

use App\Services\Payments\MockPaymentGateway;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ViewServiceProvider;
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;
use LandscapeHub\Payments\MpesaDaraja\Services\DarajaGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Some Wasmer rollouts have loaded an incomplete provider set; ensure
        // the view binding exists so exception rendering and Blade work.
        if (!$this->app->bound('view')) {
            $this->app->register(ViewServiceProvider::class);
        }

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
