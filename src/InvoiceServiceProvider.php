<?php

namespace CNRP\InvoicePackage;

use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('invoice', function ($app) {
            return new Invoice();
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/invoice.php' => config_path('invoice.php'),
                __DIR__ . '/../resources/views' => resource_path('views/vendor/invoice'),
                __DIR__ . '/../resources/css' => resource_path('css'),

            ], 'invoice');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'invoice');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

    }
}
