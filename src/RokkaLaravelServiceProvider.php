<?php

namespace Rokka\RokkaLaravel;

use Illuminate\Support\ServiceProvider;

class RokkaLaravelServiceProvider extends ServiceProvider
{
    const ALIAS = 'rokka';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/../config/rokka.php' => config_path('rokka.php'),
            ], 'rokka.config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rokka.php', 'rokka');

        // Register the service the package provides.
        $this->app->singleton('rokka', function ($app) {
            return new RokkaLaravel;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['rokka'];
    }
}