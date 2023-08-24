<?php

namespace Asyncdeveloper\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'asyncdeveloper');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'asyncdeveloper');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/currency-exchange-rate.php', 'currency-exchange-rate');

        // Register the service the package provides.
        $this->app->singleton('currency-exchange-rate', function ($app) {
            return new CurrencyExchangeRate;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['currency-exchange-rate'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/currency-exchange-rate.php' => config_path('currency-exchange-rate.php'),
        ], 'currency-exchange-rate.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/asyncdeveloper'),
        ], 'currency-exchange-rate.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/asyncdeveloper'),
        ], 'currency-exchange-rate.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/asyncdeveloper'),
        ], 'currency-exchange-rate.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
