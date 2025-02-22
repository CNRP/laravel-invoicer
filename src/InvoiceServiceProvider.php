<?php

namespace CNRP\InvoicePackage;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
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

        Livewire::component('invoice-creator', \CNRP\InvoicePackage\Components\CreateInvoice::class);
        Livewire::component('invoice-items', \CNRP\InvoicePackage\Components\InvoiceItems::class);

        \Illuminate\Support\Facades\Blade::component('invoice::components.invoice-modal', 'invoice-modal');
        \Illuminate\Support\Facades\Blade::component('invoice::components.invoice-input-field', 'invoice-input-field');
        \Illuminate\Support\Facades\Blade::component('invoice::components.invoice-preview', 'invoice-preview');
        \Illuminate\Support\Facades\Blade::component('invoice::components.invoice-items', 'invoice-items');



    }
}
