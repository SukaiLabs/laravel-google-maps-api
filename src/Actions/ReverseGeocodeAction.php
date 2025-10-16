<?php

namespace Cyna\GoogleMaps\Actions;

use Illuminate\Support\Facades\Http;
use Cyna\GoogleMaps\Http\Requests\ReverseGeocodeRequest;

class ReverseGeocodeAction
{
    public function execute(ReverseGeocodeRequest $request): array
    {
        $apiKey = config('googlemaps.api_key');

        if (!$apiKey) {
            if (app()->environment('testing')) {
                $apiKey = 'test-key';
            } else {
                return ['message' => __('googlemaps::googlemaps.messages.api_key_not_configured')];
            }
        }

        $language = $request->input('language', config('googlemaps.default_language', app()->getLocale()));

        $resp = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => $request->input('lat') . ',' . $request->input('lng'),
            'key' => $apiKey,
            'language' => $language,
        ]);

        if ($resp->failed()) {
            return ['message' => __('googlemaps::googlemaps.messages.failed_to_reverse_geocode')];
        }

        $data = $resp->json();

        return [
            'results' => $data['results'] ?? [],
            'status' => $data['status'] ?? null,
        ];
    }
}
