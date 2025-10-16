<?php

namespace SukaiLabs\GoogleMaps\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeocodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'required|string|min:3|max:255',
            'language' => 'sometimes|string|in:en,fr,ar',
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => __('googlemaps::googlemaps.validation.address.required'),
            'address.min' => __('googlemaps::googlemaps.validation.address.min', ['min' => 3]),
            'address.max' => __('googlemaps::googlemaps.validation.address.max', ['max' => 255]),
            'language.in' => __('googlemaps::googlemaps.validation.language.in', ['values' => 'en, fr, ar']),
        ];
    }
}
