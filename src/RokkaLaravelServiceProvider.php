<?php

namespace Rokka\RokkaLaravel;

use Illuminate\Support\ServiceProvider;

class RokkaLaravelServiceProvider extends ServiceProvider
{
    public const ALIAS = 'rokka';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/../config/rokka.php' => config_path('rokka.php'),
            ], 'config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rokka.php', 'rokka');

        // Register the service the package provides.
        $this->app->singleton(self::ALIAS, function ($app) {
            return new RokkaLaravel;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [self::ALIAS];
    }
}
