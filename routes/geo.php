<?php

use Illuminate\Support\Facades\Route;
use Cyna\GoogleMaps\Http\Controllers\GeocodingController;

Route::prefix('geo')
    ->group(function () {
        Route::get('/autocomplete', [GeocodingController::class, 'autocomplete'])
            ->middleware('throttle:30,1,geo.autocomplete');
        Route::get('/reverse', [GeocodingController::class, 'reverseGeocode'])
            ->middleware('throttle:60,1,geo.reverse-geocode');
        Route::get('/geocode', [GeocodingController::class, 'geocode'])
            ->middleware('throttle:30,1,geo.geocode');
        Route::get('/place-details', [GeocodingController::class, 'placeDetails'])
            ->middleware('throttle:30,1,geo.place-details');
    });
