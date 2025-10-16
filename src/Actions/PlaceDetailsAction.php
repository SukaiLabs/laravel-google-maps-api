<?php

namespace SukaiLabs\GoogleMaps\Actions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use SukaiLabs\GoogleMaps\Http\Requests\PlaceDetailsRequest;

class PlaceDetailsAction
{
    public function execute(PlaceDetailsRequest $request): array
    {
        $apiKey = Config::get('googlemaps.api_key');

        if (!$apiKey) {
            if (app()->environment('testing')) {
                $apiKey = 'test-key'; // bypass for tests with Http::fake()
            } else {
                return ['message' => __('googlemaps::googlemaps.messages.api_key_not_configured')];
            }
        }

        $language = $request->input('language', Config::get('googlemaps.default_language', app()->getLocale()));

        $resp = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $request->input('place_id'),
            'key' => $apiKey,
            'language' => $language,
            'fields' => 'place_id,name,formatted_address,geometry,types,address_components,international_phone_number,website,rating,user_ratings_total,opening_hours,photos',
        ]);

        if ($resp->failed()) {
            return ['message' => __('googlemaps::googlemaps.messages.failed_to_fetch_place_details')];
        }

        $data = $resp->json();

        if (isset($data['status']) && $data['status'] !== 'OK') {
            return [
                'message' => __('googlemaps::googlemaps.messages.google_api_error'),
                'status' => $data['status'] ?? null,
                'error_message' => $data['error_message'] ?? null,
            ];
        }

        $result = $data['result'] ?? [];

        return [
            'place_id' => $result['place_id'] ?? null,
            'name' => $result['name'] ?? null,
            'formatted_address' => $result['formatted_address'] ?? null,
            'geometry' => [
                'location' => [
                    'lat' => $result['geometry']['location']['lat'] ?? null,
                    'lng' => $result['geometry']['location']['lng'] ?? null,
                ],
            ] ?? null,
            'types' => $result['types'] ?? [],
            'address_components' => $result['address_components'] ?? [],
            'international_phone_number' => $result['international_phone_number'] ?? null,
            'website' => $result['website'] ?? null,
            'rating' => $result['rating'] ?? null,
            'user_ratings_total' => $result['user_ratings_total'] ?? null,
            'opening_hours' => $result['opening_hours'] ?? null,
            'photos' => collect($result['photos'] ?? [])->map(fn($photo) => [
                'photo_reference' => $photo['photo_reference'] ?? null,
                'width' => $photo['width'] ?? null,
                'height' => $photo['height'] ?? null,
            ])->take(5)->values(),
            'status' => $data['status'] ?? null,
        ];
    }
}
