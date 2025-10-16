<?php

namespace Cyna\GoogleMaps\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutocompleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gate by throttle + auth middleware externally if needed
    }

    public function rules(): array
    {
        return [
            'input' => 'required|string|min:2|max:120',
            'language' => 'sometimes|string|in:en,fr,ar',
        ];
    }

    public function messages(): array
    {
        return [
            'input.required' => __('googlemaps::googlemaps.validation.input.required'),
            'input.min' => __('googlemaps::googlemaps.validation.input.min', ['min' => 2]),
            'input.max' => __('googlemaps::googlemaps.validation.input.max', ['max' => 120]),
            'language.in' => __('googlemaps::googlemaps.validation.language.in', ['values' => 'en, fr, ar']),
        ];
    }
}
