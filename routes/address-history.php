<?php

use SukaiLabs\GoogleMaps\Http\Controllers\AddressHistoryController;
use Illuminate\Support\Facades\Route;

Route::controller(AddressHistoryController::class)->prefix('/address-histories')->group(function () {
    Route::get('/', 'index')->middleware('throttle:60,1,address-histories.index'); // List user's address histories
    Route::post('/', 'store')->middleware('throttle:30,1,address-histories.store'); // Create new address history

    Route::prefix('/{addressHistory}')->group(function () {
        Route::get('/', 'show')->middleware('throttle:60,1,address-histories.show'); // Show specific address history
        Route::delete('/', 'destroy')->middleware('throttle:20,1,address-histories.destroy'); // Delete address history
    });
});
