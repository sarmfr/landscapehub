<?php

namespace LandscapeHub\Payments\MpesaDaraja;

use Illuminate\Support\ServiceProvider;
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;
use LandscapeHub\Payments\MpesaDaraja\Services\DarajaClient;
use LandscapeHub\Payments\MpesaDaraja\Services\DarajaGateway;

class MpesaDarajaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mpesa-daraja.php', 'mpesa-daraja');

        $this->app->singleton(DarajaClient::class, fn ($app) => new DarajaClient($app['http']));
        $this->app->singleton(PaymentGateway::class, DarajaGateway::class);
        $this->app->alias(PaymentGateway::class, DarajaGateway::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/mpesa-daraja.php' => config_path('mpesa-daraja.php'),
        ], 'mpesa-daraja-config');
    }
}
