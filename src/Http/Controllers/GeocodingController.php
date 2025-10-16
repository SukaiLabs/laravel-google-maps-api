<?php

namespace SukaiLabs\GoogleMaps\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use SukaiLabs\GoogleMaps\Http\Requests\AutocompleteRequest;
use SukaiLabs\GoogleMaps\Http\Requests\ReverseGeocodeRequest;
use SukaiLabs\GoogleMaps\Http\Requests\GeocodeRequest;
use SukaiLabs\GoogleMaps\Http\Requests\PlaceDetailsRequest;
use SukaiLabs\GoogleMaps\Actions\AutocompleteAction;
use SukaiLabs\GoogleMaps\Actions\ReverseGeocodeAction;
use SukaiLabs\GoogleMaps\Actions\GeocodeAction;
use SukaiLabs\GoogleMaps\Actions\PlaceDetailsAction;

class GeocodingController extends Controller
{
    /**
     * Autocomplete place names.
     */
    public function autocomplete(AutocompleteRequest $request, AutocompleteAction $action): JsonResponse
    {
        return response()->json($action->execute($request));
    }

    /**
     * Reverse geocode lat/lng to addresses.
     */
    public function reverseGeocode(ReverseGeocodeRequest $request, ReverseGeocodeAction $action): JsonResponse
    {
        return response()->json($action->execute($request));
    }

    /**
     * Geocode address string to coordinates.
     */
    public function geocode(GeocodeRequest $request, GeocodeAction $action): JsonResponse
    {
        return response()->json($action->execute($request));
    }

    /**
     * Get place details by place ID.
     */
    public function placeDetails(PlaceDetailsRequest $request, PlaceDetailsAction $action): JsonResponse
    {
        return response()->json($action->execute($request));
    }
}
