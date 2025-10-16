<?php

namespace Cyna\GoogleMaps\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Cyna\GoogleMaps\Http\Requests\AutocompleteRequest;
use Cyna\GoogleMaps\Http\Requests\ReverseGeocodeRequest;
use Cyna\GoogleMaps\Http\Requests\GeocodeRequest;
use Cyna\GoogleMaps\Http\Requests\PlaceDetailsRequest;
use Cyna\GoogleMaps\Actions\AutocompleteAction;
use Cyna\GoogleMaps\Actions\ReverseGeocodeAction;
use Cyna\GoogleMaps\Actions\GeocodeAction;
use Cyna\GoogleMaps\Actions\PlaceDetailsAction;

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
