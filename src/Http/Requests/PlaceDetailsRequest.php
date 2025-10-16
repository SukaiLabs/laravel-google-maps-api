<?php

namespace Cyna\GoogleMaps\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'place_id' => 'required|string|max:255',
            'language' => 'sometimes|string|in:en,fr,ar',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'place_id.required' => __('googlemaps::googlemaps.validation.place_id.required'),
            'place_id.string' => __('googlemaps::googlemaps.validation.place_id.string'),
            'place_id.max' => __('googlemaps::googlemaps.validation.place_id.max', ['max' => 255]),
            'language.in' => __('googlemaps::googlemaps.validation.language.in', ['values' => 'en, fr, ar']),
        ];
    }
}
