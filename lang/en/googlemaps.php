<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps Package - English Translations
    |--------------------------------------------------------------------------
    */

    // General Messages
    'messages' => [
        'api_key_not_configured' => 'Google Maps API key is not configured',
        'failed_to_fetch_suggestions' => 'Failed to fetch autocomplete suggestions',
        'failed_to_geocode' => 'Failed to geocode address',
        'failed_to_reverse_geocode' => 'Failed to reverse geocode coordinates',
        'failed_to_fetch_place_details' => 'Failed to fetch place details',
        'google_api_error' => 'Google Places API error',
        'address_saved' => 'Address saved successfully',
        'address_updated' => 'Address updated successfully',
        'address_deleted' => 'Address deleted successfully',
        'unauthorized' => 'You are not authorized to perform this action',
    ],

    // Validation Messages
    'validation' => [
        'input' => [
            'required' => 'Search input is required',
            'min' => 'Search input must be at least :min characters',
            'max' => 'Search input must not exceed :max characters',
        ],
        'address' => [
            'required' => 'Address is required',
            'min' => 'Address must be at least :min characters',
            'max' => 'Address must not exceed :max characters',
        ],
        'latitude' => [
            'required' => 'Latitude is required',
            'numeric' => 'Latitude must be a number',
            'between' => 'Latitude must be between :min and :max',
        ],
        'longitude' => [
            'required' => 'Longitude is required',
            'numeric' => 'Longitude must be a number',
            'between' => 'Longitude must be between :min and :max',
        ],
        'place_id' => [
            'required' => 'Place ID is required',
            'string' => 'Place ID must be a string',
            'max' => 'Place ID must not exceed :max characters',
        ],
        'language' => [
            'in' => 'Language must be one of: :values',
        ],
        'lat' => [
            'required' => 'Latitude is required',
            'between' => 'Latitude must be between :min and :max',
        ],
        'lng' => [
            'required' => 'Longitude is required',
            'between' => 'Longitude must be between :min and :max',
        ],
    ],

    // Field Labels
    'fields' => [
        'address' => 'Address',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'place_id' => 'Place ID',
        'language' => 'Language',
        'input' => 'Search Input',
        'coordinates' => 'Coordinates',
        'formatted_address' => 'Formatted Address',
    ],

    // Status Messages
    'status' => [
        'ok' => 'OK',
        'zero_results' => 'No results found',
        'over_query_limit' => 'Query limit exceeded',
        'request_denied' => 'Request denied',
        'invalid_request' => 'Invalid request',
        'unknown_error' => 'Unknown error occurred',
    ],

    // Address History
    'address_history' => [
        'title' => 'Address History',
        'empty' => 'No saved addresses',
        'limit_reached' => 'Maximum number of addresses reached',
        'created' => 'Address created successfully',
        'updated' => 'Address updated successfully',
        'deleted' => 'Address deleted successfully',
        'not_found' => 'Address not found',
    ],
];
