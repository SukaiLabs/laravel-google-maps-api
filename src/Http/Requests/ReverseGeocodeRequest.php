<?php

namespace SukaiLabs\GoogleMaps\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReverseGeocodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'language' => 'sometimes|string|in:en,fr,ar',
        ];
    }

    public function messages(): array
    {
        return [
            'lat.required' => __('googlemaps::googlemaps.validation.lat.required'),
            'lat.between' => __('googlemaps::googlemaps.validation.lat.between', ['min' => -90, 'max' => 90]),
            'lng.required' => __('googlemaps::googlemaps.validation.lng.required'),
            'lng.between' => __('googlemaps::googlemaps.validation.lng.between', ['min' => -180, 'max' => 180]),
            'language.in' => __('googlemaps::googlemaps.validation.language.in', ['values' => 'en, fr, ar']),
        ];
    }
}
