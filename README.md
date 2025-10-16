# Google Maps Package for Laravel

A comprehensive Laravel package providing Google Maps geocoding features with address history management. This package offers a complete solution for integrating Google Maps Places API, Geocoding API, and managing user address histories.

## Features

- ✅ **Google Maps Geocoding**
  - Place autocomplete
  - Address geocoding (address → coordinates)
  - Reverse geocoding (coordinates → address)
  - Place details lookup
  
- ✅ **Address History Management**
  - Store user address histories
  - Automatic cleanup of old addresses
  - Full CRUD operations with authorization
  - Coordinate storage and management

- ✅ **Seamless Integration**
  - Auto-discovery for Laravel 11+
  - Auto-registering routes under `/api/v1`
  - Configurable middleware and throttling
  - Migration for removing old address column from users table

- ✅ **Production Ready**
  - Policy-based authorization
  - Form request validation
  - Resource transformers
  - Comprehensive error handling

## Requirements

- PHP 8.2 or higher
- Laravel 11.0 or higher
- Google Maps API key with the following APIs enabled:
  - Maps JavaScript API
  - Places API
  - Geocoding API

## Installation

### Step 1: Install via Composer

Install the package via Composer:

```bash
composer require sukailabs/googlemaps
```

**Note:** The package is available as a public repository on GitHub: [SukaiLabs/laravel-google-maps-api](https://github.com/SukaiLabs/laravel-google-maps-api)

### Step 2: Publish Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=googlemaps-config
```

This will create `config/googlemaps.php` in your Laravel application.

### Step 2.1: Publish Translations (Optional)

If you want to customize the translation files, publish them:

```bash
php artisan vendor:publish --tag=googlemaps-translations
```

This will publish translation files to `lang/vendor/googlemaps/` for English, French, and Arabic.

The package includes built-in translations for:
- API error messages
- Validation messages
- Address history messages
- Field labels

**Supported languages:**
- English (`en`)
- French (`fr`)
- Arabic (`ar`)

### Step 3: Configure Google Maps API Key

Add your Google Maps API key to your `.env` file:

```env
GOOGLE_MAPS_API_KEY=your-api-key-here
GOOGLE_MAPS_DEFAULT_LANGUAGE=en
```

### Step 4: Run Migrations

Run the migrations to create the `address_histories` table and optionally remove the `address` column from the `users` table:

```bash
php artisan migrate
```

**Note:** The package includes a migration that will automatically remove the `address` column from your `users` table if it exists, as address management is now handled through the `address_histories` table.

### Step 5: Done! 🎉

The package is now fully installed and configured. All routes are automatically registered under `/api/v1`.

## Configuration

The configuration file (`config/googlemaps.php`) provides the following options:

```php
return [
    // Your Google Maps API key
    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    // Default language for API responses
    'default_language' => env('GOOGLE_MAPS_DEFAULT_LANGUAGE', 'en'),

    // Address history settings
    'address_history' => [
        'max_per_user' => env('GOOGLE_MAPS_MAX_ADDRESSES_PER_USER', 20),
        'auto_delete_old' => env('GOOGLE_MAPS_AUTO_DELETE_OLD_ADDRESSES', true),
    ],

    // Route configuration
    'routes' => [
        'enabled' => env('GOOGLE_MAPS_ROUTES_ENABLED', true),
        'prefix' => 'api/v1',
        'geo_middleware' => ['api'],
        'address_history_middleware' => ['api', 'auth:sanctum', 'verified', 'approved'],
    ],
];
```

## API Endpoints

### Geocoding Endpoints (No Auth Required)

#### 1. Autocomplete

Get place suggestions based on user input.

**Endpoint:** `GET /api/v1/geo/autocomplete`

**Parameters:**
- `input` (required): Search query (min: 2, max: 120 characters)
- `language` (optional): Response language (en, fr, ar)

**Example:**
```bash
curl "https://your-domain.com/api/v1/geo/autocomplete?input=paris"
```

**Response:**
```json
{
  "predictions": [
    {
      "description": "Paris, France",
      "place_id": "ChIJD7fiBh9u5kcRYJSMaMOCCwQ"
    }
  ],
  "status": "OK"
}
```

#### 2. Geocode Address

Convert an address to coordinates.

**Endpoint:** `GET /api/v1/geo/geocode`

**Parameters:**
- `address` (required): Address to geocode (min: 3, max: 255 characters)
- `language` (optional): Response language (en, fr, ar)

**Example:**
```bash
curl "https://your-domain.com/api/v1/geo/geocode?address=Eiffel+Tower+Paris"
```

**Response:**
```json
{
  "results": [
    {
      "formatted_address": "Champ de Mars, 5 Av. Anatole France, 75007 Paris, France",
      "latitude": 48.8583701,
      "longitude": 2.2944813,
      "place_id": "ChIJLU7jZClu5kcR4PcOOO6p3I0",
      "types": ["tourist_attraction", "point_of_interest", "establishment"]
    }
  ],
  "status": "OK"
}
```

#### 3. Reverse Geocode

Convert coordinates to addresses.

**Endpoint:** `GET /api/v1/geo/reverse`

**Parameters:**
- `lat` (required): Latitude (-90 to 90)
- `lng` (required): Longitude (-180 to 180)
- `language` (optional): Response language (en, fr, ar)

**Example:**
```bash
curl "https://your-domain.com/api/v1/geo/reverse?lat=48.8583701&lng=2.2944813"
```

#### 4. Place Details

Get detailed information about a place.

**Endpoint:** `GET /api/v1/geo/place-details`

**Parameters:**
- `place_id` (required): Google Place ID
- `language` (optional): Response language (en, fr, ar)

**Example:**
```bash
curl "https://your-domain.com/api/v1/geo/place-details?place_id=ChIJD7fiBh9u5kcRYJSMaMOCCwQ"
```

### Address History Endpoints (Auth Required)

#### 1. List Address Histories

Get all addresses for the authenticated user.

**Endpoint:** `GET /api/v1/address-histories`

**Headers:**
- `Authorization: Bearer {token}`

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "address": "Home - 123 Main St",
      "latitude": 48.8583701,
      "longitude": 2.2944813,
      "coordinates": {
        "latitude": 48.8583701,
        "longitude": 2.2944813
      },
      "created_at": "2024-01-15T10:30:00.000000Z",
      "updated_at": "2024-01-15T10:30:00.000000Z"
    }
  ]
}
```

#### 2. Store Address History

Save a new address for the authenticated user.

**Endpoint:** `POST /api/v1/address-histories`

**Headers:**
- `Authorization: Bearer {token}`
- `Content-Type: application/json`

**Body:**
```json
{
  "address": "Work - 456 Office Blvd",
  "latitude": 48.8566,
  "longitude": 2.3522
}
```

**Response:** (201 Created)
```json
{
  "data": {
    "id": 2,
    "address": "Work - 456 Office Blvd",
    "latitude": 48.8566,
    "longitude": 2.3522,
    "coordinates": {
      "latitude": 48.8566,
      "longitude": 2.3522
    },
    "created_at": "2024-01-15T11:00:00.000000Z",
    "updated_at": "2024-01-15T11:00:00.000000Z"
  }
}
```

#### 3. Show Address History

Get a specific address by ID.

**Endpoint:** `GET /api/v1/address-histories/{id}`

**Headers:**
- `Authorization: Bearer {token}`

#### 4. Delete Address History

Delete a specific address.

**Endpoint:** `DELETE /api/v1/address-histories/{id}`

**Headers:**
- `Authorization: Bearer {token}`

**Response:** (204 No Content)

## Rate Limiting

The package includes sensible rate limiting defaults:

- **Autocomplete:** 30 requests per minute
- **Geocode:** 30 requests per minute
- **Reverse Geocode:** 60 requests per minute
- **Place Details:** 30 requests per minute
- **Address History Index:** 60 requests per minute
- **Address History Store:** 30 requests per minute
- **Address History Show:** 60 requests per minute
- **Address History Delete:** 20 requests per minute

## Usage in Code

### Using the Actions Directly

You can use the actions directly in your code:

```php
use SukaiLabs\GoogleMaps\Actions\GeocodeAction;
use SukaiLabs\GoogleMaps\Http\Requests\GeocodeRequest;

// In a controller or service
public function geocodeAddress(GeocodeRequest $request, GeocodeAction $action)
{
    $result = $action->execute($request);
    return $result;
}
```

### Working with Address History

```php
use SukaiLabs\GoogleMaps\Models\AddressHistory;

// Get user's addresses
$addresses = AddressHistory::forUser(auth()->id())
    ->latest()
    ->get();

// Create a new address
$address = AddressHistory::create([
    'user_id' => auth()->id(),
    'address' => 'Home',
    'latitude' => 48.8583701,
    'longitude' => 2.2944813,
]);

// Auto-deletion of old addresses
// If max_per_user is set to 20 and auto_delete_old is true,
// the oldest address will be automatically deleted when creating the 21st address
```

## Customization

### Disabling Routes

If you want to register routes manually, disable auto-registration in your `.env`:

```env
GOOGLE_MAPS_ROUTES_ENABLED=false
```

Then register routes manually in your `routes/api.php`:

```php
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    require base_path('packages/googlemaps/routes/geo.php');
    
    Route::middleware(['auth:sanctum'])->group(function () {
        require base_path('packages/googlemaps/routes/address-history.php');
    });
});
```

### Customizing Middleware

You can customize middleware in the config file or via environment variables:

```env
# Customize middleware for address history routes
GOOGLE_MAPS_ADDRESS_HISTORY_MIDDLEWARE=api,auth:sanctum,custom-middleware
```

### Customizing Address Limits

Control how many addresses each user can store:

```env
# Maximum addresses per user (0 = unlimited)
GOOGLE_MAPS_MAX_ADDRESSES_PER_USER=50

# Auto-delete old addresses when limit reached
GOOGLE_MAPS_AUTO_DELETE_OLD_ADDRESSES=true
```

### Customizing Translations

The package includes built-in translations for English, French, and Arabic. To customize translations:

1. **Publish the translation files:**
```bash
php artisan vendor:publish --tag=googlemaps-translations
```

2. **Edit the translation files** in `lang/vendor/googlemaps/{locale}/googlemaps.php`

3. **Available translation keys:**
   - `googlemaps::googlemaps.messages.*` - API messages and errors
   - `googlemaps::googlemaps.validation.*` - Validation error messages
   - `googlemaps::googlemaps.fields.*` - Field labels
   - `googlemaps::googlemaps.status.*` - Status messages
   - `googlemaps::googlemaps.address_history.*` - Address history messages

**Example usage in your code:**
```php
// Use package translations
__('googlemaps::googlemaps.messages.address_saved')

// Override in your app's lang files
// Create: lang/en/googlemaps.php
return [
    'messages' => [
        'address_saved' => 'Your custom message',
    ],
];
```

**Supported languages out of the box:**
- 🇬🇧 English (`en`)
- 🇫🇷 French (`fr`)
- 🇸🇦 Arabic (`ar`)

All validation messages and API responses are automatically translated based on your application's locale.

## Database Schema

### address_histories Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users table |
| address | varchar(255) | Address label/description |
| latitude | decimal(10,8) | Latitude coordinate |
| longitude | decimal(11,8) | Longitude coordinate |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:**
- `user_id, created_at` (composite index)
- `latitude, longitude` (composite index)

## Security

- All address history endpoints require authentication
- Policy-based authorization ensures users can only access their own addresses
- Form request validation on all inputs
- Rate limiting to prevent API abuse
- Secure coordinate storage with proper precision

## Testing

The package is designed to work seamlessly with Laravel's testing tools. You can mock HTTP responses for testing:

```php
use Illuminate\Support\Facades\Http;

Http::fake([
    'maps.googleapis.com/*' => Http::response([
        'results' => [...],
        'status' => 'OK'
    ], 200)
]);
```

## Troubleshooting

### Google Maps API Key Not Working

1. Ensure the API key is correctly set in `.env`
2. Verify the following APIs are enabled in Google Cloud Console:
   - Maps JavaScript API
   - Places API
   - Geocoding API
3. Check API key restrictions and quotas

### Routes Not Registering

1. Clear route cache: `php artisan route:clear`
2. Check if routes are enabled in config: `GOOGLE_MAPS_ROUTES_ENABLED=true`
3. Verify the service provider is loaded: `php artisan config:clear`

### Migration Issues

If the migration fails when removing the address column:
1. The migration checks if the column exists before removing it
2. You can safely run the migration even if the column doesn't exist
3. To rollback: `php artisan migrate:rollback`

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

Visit the repository: [SukaiLabs/laravel-google-maps-api](https://github.com/SukaiLabs/laravel-google-maps-api)

## Support

- **Issues:** [GitHub Issues](https://github.com/SukaiLabs/laravel-google-maps-api/issues)
- **Discussions:** [GitHub Discussions](https://github.com/SukaiLabs/laravel-google-maps-api/discussions)
- **Documentation:** [README](https://github.com/SukaiLabs/laravel-google-maps-api#readme)

## License

This package is open-source software licensed under the [MIT license](LICENSE.md).

Copyright (c) 2025 Sukai Labs

---

**Package Version:** 1.0.0  
**Laravel Version:** ^11.0  
**PHP Version:** ^8.2
