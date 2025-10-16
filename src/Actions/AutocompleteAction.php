<?php

namespace Cyna\GoogleMaps\Actions;

use Illuminate\Support\Facades\Http;
use Cyna\GoogleMaps\Http\Requests\AutocompleteRequest;

class AutocompleteAction
{
    public function execute(AutocompleteRequest $request): array
    {
        $apiKey = config('googlemaps.api_key');

        if (!$apiKey) {
            if (app()->environment('testing')) {
                $apiKey = 'test-key'; // bypass for tests with Http::fake()
            } else {
                return ['message' => __('googlemaps::googlemaps.messages.api_key_not_configured')];
            }
        }

        $language = $request->input('language', config('googlemaps.default_language', app()->getLocale()));

        $resp = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            'input' => $request->input('input'),
            'key' => $apiKey,
            'language' => $language,
        ]);

        if ($resp->failed()) {
            return ['message' => __('googlemaps::googlemaps.messages.failed_to_fetch_suggestions')];
        }

        $data = $resp->json();

        return [
            'predictions' => collect($data['predictions'] ?? [])->map(fn($p) => [
                'description' => $p['description'] ?? null,
                'place_id' => $p['place_id'] ?? null,
            ])->take(10)->values(),
            'status' => $data['status'] ?? null,
        ];
    }
}
