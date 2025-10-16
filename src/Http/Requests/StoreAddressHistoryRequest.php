<?php

namespace Cyna\GoogleMaps\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressHistoryRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'address.required' => __('googlemaps::googlemaps.validation.address.required'),
            'address.max' => __('googlemaps::googlemaps.validation.address.max', ['max' => 255]),
            'latitude.required' => __('googlemaps::googlemaps.validation.latitude.required'),
            'latitude.numeric' => __('googlemaps::googlemaps.validation.latitude.numeric'),
            'latitude.between' => __('googlemaps::googlemaps.validation.latitude.between', ['min' => -90, 'max' => 90]),
            'longitude.required' => __('googlemaps::googlemaps.validation.longitude.required'),
            'longitude.numeric' => __('googlemaps::googlemaps.validation.longitude.numeric'),
            'longitude.between' => __('googlemaps::googlemaps.validation.longitude.between', ['min' => -180, 'max' => 180]),
        ];
    }
}
