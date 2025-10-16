<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps Package - French Translations
    |--------------------------------------------------------------------------
    */

    // General Messages
    'messages' => [
        'api_key_not_configured' => 'La clé API Google Maps n\'est pas configurée',
        'failed_to_fetch_suggestions' => 'Échec de la récupération des suggestions d\'autocomplétion',
        'failed_to_geocode' => 'Échec du géocodage de l\'adresse',
        'failed_to_reverse_geocode' => 'Échec du géocodage inversé des coordonnées',
        'failed_to_fetch_place_details' => 'Échec de la récupération des détails du lieu',
        'google_api_error' => 'Erreur de l\'API Google Places',
        'address_saved' => 'Adresse enregistrée avec succès',
        'address_updated' => 'Adresse mise à jour avec succès',
        'address_deleted' => 'Adresse supprimée avec succès',
        'unauthorized' => 'Vous n\'êtes pas autorisé à effectuer cette action',
    ],

    // Validation Messages
    'validation' => [
        'input' => [
            'required' => 'La saisie de recherche est requise',
            'min' => 'La saisie de recherche doit contenir au moins :min caractères',
            'max' => 'La saisie de recherche ne doit pas dépasser :max caractères',
        ],
        'address' => [
            'required' => 'L\'adresse est requise',
            'min' => 'L\'adresse doit contenir au moins :min caractères',
            'max' => 'L\'adresse ne doit pas dépasser :max caractères',
        ],
        'latitude' => [
            'required' => 'La latitude est requise',
            'numeric' => 'La latitude doit être un nombre',
            'between' => 'La latitude doit être entre :min et :max',
        ],
        'longitude' => [
            'required' => 'La longitude est requise',
            'numeric' => 'La longitude doit être un nombre',
            'between' => 'La longitude doit être entre :min et :max',
        ],
        'place_id' => [
            'required' => 'L\'ID du lieu est requis',
            'string' => 'L\'ID du lieu doit être une chaîne de caractères',
            'max' => 'L\'ID du lieu ne doit pas dépasser :max caractères',
        ],
        'language' => [
            'in' => 'La langue doit être l\'une des suivantes : :values',
        ],
        'lat' => [
            'required' => 'La latitude est requise',
            'between' => 'La latitude doit être entre :min et :max',
        ],
        'lng' => [
            'required' => 'La longitude est requise',
            'between' => 'La longitude doit être entre :min et :max',
        ],
    ],

    // Field Labels
    'fields' => [
        'address' => 'Adresse',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'place_id' => 'ID du lieu',
        'language' => 'Langue',
        'input' => 'Saisie de recherche',
        'coordinates' => 'Coordonnées',
        'formatted_address' => 'Adresse formatée',
    ],

    // Status Messages
    'status' => [
        'ok' => 'OK',
        'zero_results' => 'Aucun résultat trouvé',
        'over_query_limit' => 'Limite de requêtes dépassée',
        'request_denied' => 'Requête refusée',
        'invalid_request' => 'Requête invalide',
        'unknown_error' => 'Erreur inconnue',
    ],

    // Address History
    'address_history' => [
        'title' => 'Historique des adresses',
        'empty' => 'Aucune adresse enregistrée',
        'limit_reached' => 'Nombre maximum d\'adresses atteint',
        'created' => 'Adresse créée avec succès',
        'updated' => 'Adresse mise à jour avec succès',
        'deleted' => 'Adresse supprimée avec succès',
        'not_found' => 'Adresse introuvable',
    ],
];
