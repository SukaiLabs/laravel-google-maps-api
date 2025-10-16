<?php

/*
|--------------------------------------------------------------------------
| Google Maps Package - Usage Examples
|--------------------------------------------------------------------------
|
| This file contains practical examples of how to use the Google Maps
| package in your Laravel application.
|
*/

namespace App\Examples;

use Cyna\GoogleMaps\Models\AddressHistory;
use Cyna\GoogleMaps\Actions\GeocodeAction;
use Cyna\GoogleMaps\Actions\AutocompleteAction;
use Cyna\GoogleMaps\Http\Requests\GeocodeRequest;
use Illuminate\Support\Facades\Auth;

class GoogleMapsExamples
{
    /**
     * Example 1: Get user's saved addresses
     */
    public function getUserAddresses()
    {
        $addresses = AddressHistory::forUser(Auth::id())
            ->latest()
            ->get();

        return $addresses->map(function ($address) {
            return [
                'id' => $address->id,
                'label' => $address->address,
                'coordinates' => $address->coordinates,
            ];
        });
    }

    /**
     * Example 2: Save a new address for the user
     */
    public function saveUserAddress(string $label, float $lat, float $lng)
    {
        return AddressHistory::create([
            'user_id' => Auth::id(),
            'address' => $label,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);
    }

    /**
     * Example 3: Get the most recent address
     */
    public function getLastUsedAddress()
    {
        return AddressHistory::forUser(Auth::id())
            ->latest()
            ->first();
    }

    /**
     * Example 4: Delete old addresses (keep only last 10)
     */
    public function cleanupOldAddresses()
    {
        $addresses = AddressHistory::forUser(Auth::id())
            ->oldest()
            ->skip(10)
            ->get();

        foreach ($addresses as $address) {
            $address->delete();
        }
    }

    /**
     * Example 5: Find addresses near a location
     */
    public function findNearbyAddresses(float $lat, float $lng, float $radiusKm = 5)
    {
        // Simple distance calculation (not precise for large distances)
        $latRange = $radiusKm / 111; // 1 degree ≈ 111km
        $lngRange = $radiusKm / (111 * cos(deg2rad($lat)));

        return AddressHistory::forUser(Auth::id())
            ->whereBetween('latitude', [$lat - $latRange, $lat + $latRange])
            ->whereBetween('longitude', [$lng - $lngRange, $lng + $lngRange])
            ->get();
    }

    /**
     * Example 6: Check if address already exists
     */
    public function addressExists(string $label): bool
    {
        return AddressHistory::forUser(Auth::id())
            ->where('address', 'like', "%{$label}%")
            ->exists();
    }

    /**
     * Example 7: Update an address label
     */
    public function updateAddressLabel(int $addressId, string $newLabel)
    {
        $address = AddressHistory::forUser(Auth::id())->findOrFail($addressId);

        // Check authorization
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $address->update(['address' => $newLabel]);
        return $address;
    }

    /**
     * Example 8: Get address statistics
     */
    public function getAddressStats()
    {
        $userId = Auth::id();

        return [
            'total_addresses' => AddressHistory::forUser($userId)->count(),
            'oldest_address' => AddressHistory::forUser($userId)->oldest()->first(),
            'newest_address' => AddressHistory::forUser($userId)->latest()->first(),
        ];
    }

    /**
     * Example 9: Batch create addresses
     */
    public function batchCreateAddresses(array $addresses)
    {
        $created = [];

        foreach ($addresses as $address) {
            $created[] = AddressHistory::create([
                'user_id' => Auth::id(),
                'address' => $address['label'],
                'latitude' => $address['lat'],
                'longitude' => $address['lng'],
            ]);
        }

        return $created;
    }

    /**
     * Example 10: Export user addresses to array
     */
    public function exportAddresses()
    {
        return AddressHistory::forUser(Auth::id())
            ->get()
            ->map(fn($addr) => [
                'label' => $addr->address,
                'latitude' => (float) $addr->latitude,
                'longitude' => (float) $addr->longitude,
                'saved_at' => $addr->created_at->toIso8601String(),
            ])
            ->toArray();
    }
}

/*
|--------------------------------------------------------------------------
| Controller Integration Examples
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use Cyna\GoogleMaps\Models\AddressHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Example: Get user's favorite locations
     */
    public function favorites()
    {
        $addresses = AddressHistory::forUser(Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'favorites' => $addresses->map(fn($addr) => [
                'id' => $addr->id,
                'name' => $addr->address,
                'lat' => (float) $addr->latitude,
                'lng' => (float) $addr->longitude,
            ])
        ]);
    }

    /**
     * Example: Quick save current location
     */
    public function quickSaveLocation(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        $address = AddressHistory::create([
            'user_id' => Auth::id(),
            'address' => $validated['label'],
            'latitude' => $validated['lat'],
            'longitude' => $validated['lng'],
        ]);

        return response()->json([
            'message' => 'Location saved successfully',
            'address' => $address,
        ], 201);
    }
}

/*
|--------------------------------------------------------------------------
| Frontend Integration Examples (JavaScript/Vue/React)
|--------------------------------------------------------------------------
*/

/*
// Example 1: Autocomplete Component
async function searchPlaces(query) {
    const response = await fetch(`/api/v1/geo/autocomplete?input=${encodeURIComponent(query)}`);
    const data = await response.json();
    return data.predictions;
}

// Example 2: Get coordinates from address
async function geocodeAddress(address) {
    const response = await fetch(`/api/v1/geo/geocode?address=${encodeURIComponent(address)}`);
    const data = await response.json();
    return data.results[0];
}

// Example 3: Reverse geocode (get address from coordinates)
async function reverseGeocode(lat, lng) {
    const response = await fetch(`/api/v1/geo/reverse?lat=${lat}&lng=${lng}`);
    const data = await response.json();
    return data.results[0];
}

// Example 4: Save address to history
async function saveAddress(token, label, lat, lng) {
    const response = await fetch('/api/v1/address-histories', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify({
            address: label,
            latitude: lat,
            longitude: lng,
        }),
    });
    return await response.json();
}

// Example 5: Get user's saved addresses
async function getUserAddresses(token) {
    const response = await fetch('/api/v1/address-histories', {
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    });
    const data = await response.json();
    return data.data;
}

// Example 6: Delete saved address
async function deleteAddress(token, addressId) {
    const response = await fetch(`/api/v1/address-histories/${addressId}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    });
    return response.status === 204;
}

// Example 7: Complete address selection flow
async function handleAddressSelection(userInput, token) {
    // 1. Get autocomplete suggestions
    const suggestions = await searchPlaces(userInput);

    // 2. User selects a suggestion (in your UI)
    const selectedPlaceId = suggestions[0].place_id;

    // 3. Get full place details
    const response = await fetch(`/api/v1/geo/place-details?place_id=${selectedPlaceId}`);
    const placeDetails = await response.json();

    // 4. Save to address history
    await saveAddress(
        token,
        placeDetails.formatted_address,
        placeDetails.geometry.location.lat,
        placeDetails.geometry.location.lng
    );

    return placeDetails;
}
*/
