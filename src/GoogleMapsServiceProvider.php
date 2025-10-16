<?php

namespace SukaiLabs\GoogleMaps;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SukaiLabs\GoogleMaps\Models\AddressHistory;
use SukaiLabs\GoogleMaps\Policies\AddressHistoryPolicy;

class GoogleMapsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package config with application config
        $this->mergeConfigFrom(
            __DIR__.'/../config/googlemaps.php', 'googlemaps'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/googlemaps.php' => config_path('googlemaps.php'),
        ], 'googlemaps-config');

        // Publish and load migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'googlemaps-migrations');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publish and load translations
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/googlemaps'),
        ], 'googlemaps-translations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'googlemaps');

        // Register routes if enabled
        if (Config::get('googlemaps.routes.enabled', true)) {
            $this->registerRoutes();
        }

        // Register policies
        $this->registerPolicies();

        // Register commands if running in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                // Add custom commands here if needed
            ]);
        }
    }

    /**
     * Register the package routes.
     */
    protected function registerRoutes(): void
    {
        $prefix = Config::get('googlemaps.routes.prefix', 'api/v1');

        // Register Geo routes (without auth middleware)
        Route::prefix($prefix)
            ->middleware(Config::get('googlemaps.routes.geo_middleware', ['api']))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/geo.php');
            });

        // Register Address History routes (with auth middleware)
        Route::prefix($prefix)
            ->middleware(Config::get('googlemaps.routes.address_history_middleware', [
                'api',
                'auth:sanctum',
                'verified',
                'approved'
            ]))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/address-history.php');
            });
    }

    /**
     * Register the package policies.
     */
    protected function registerPolicies(): void
    {
        Gate::policy(AddressHistory::class, AddressHistoryPolicy::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}
