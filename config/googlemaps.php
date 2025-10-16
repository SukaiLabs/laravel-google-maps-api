<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Your Google Maps API key for accessing the Google Maps Platform services.
    | You can get your API key from: https://console.cloud.google.com/apis/credentials
    |
    | Make sure to enable the following APIs:
    | - Maps JavaScript API
    | - Places API
    | - Geocoding API
    |
    */

    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | The default language for Google Maps API responses.
    | Supported values: 'en', 'fr', 'ar', or any ISO 639-1 language code.
    |
    */

    'default_language' => env('GOOGLE_MAPS_DEFAULT_LANGUAGE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Address History Settings
    |--------------------------------------------------------------------------
    |
    | Configure address history behavior.
    |
    */

    'address_history' => [
        // Maximum number of addresses to store per user (0 = unlimited)
        'max_per_user' => env('GOOGLE_MAPS_MAX_ADDRESSES_PER_USER', 20),

        // Automatically delete old addresses when limit is reached
        'auto_delete_old' => env('GOOGLE_MAPS_AUTO_DELETE_OLD_ADDRESSES', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how the package routes are registered.
    |
    */

    'routes' => [
        // Enable or disable route registration
        'enabled' => env('GOOGLE_MAPS_ROUTES_ENABLED', true),

        // API prefix (will be registered under /api/v1/...)
        'prefix' => 'api/v1',

        // Middleware applied to geo routes (without auth)
        'geo_middleware' => ['api'],

        // Middleware applied to address history routes (with auth)
        'address_history_middleware' => ['api', 'auth:sanctum', 'verified', 'approved'],
    ],
];
