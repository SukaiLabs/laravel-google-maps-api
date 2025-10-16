<?php

namespace Cyna\GoogleMaps\Actions;

use Illuminate\Support\Facades\Http;
use Cyna\GoogleMaps\Http\Requests\GeocodeRequest;

class GeocodeAction
{
    public function execute(GeocodeRequest $request): array
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
            'address' => $request->input('address'),
            'key' => $apiKey,
            'language' => $language,
        ]);

        if ($resp->failed()) {
            return ['message' => __('googlemaps::googlemaps.messages.failed_to_geocode')];
        }

        $data = $resp->json();

        return [
            'results' => collect($data['results'] ?? [])->map(function ($r) {
                $loc = $r['geometry']['location'] ?? [];
                return [
                    'formatted_address' => $r['formatted_address'] ?? null,
                    'latitude' => $loc['lat'] ?? null,
                    'longitude' => $loc['lng'] ?? null,
                    'place_id' => $r['place_id'] ?? null,
                    'types' => $r['types'] ?? [],
                ];
            })->take(5)->values(),
            'status' => $data['status'] ?? null,
        ];
    }
}
