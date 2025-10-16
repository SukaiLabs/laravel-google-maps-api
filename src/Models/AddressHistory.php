<?php

namespace SukaiLabs\GoogleMaps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class AddressHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the user that owns the address history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Config::get('auth.providers.users.model', 'App\\Models\\User'));
    }

    /**
     * Scope to get addresses for a specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get a formatted display string for the address.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->address;
    }

    /**
     * Get coordinates as an array.
     */
    public function getCoordinatesAttribute(): array
    {
        return [
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-delete old addresses when limit is reached
        static::creating(function ($addressHistory) {
            $maxPerUser = Config::get('googlemaps.address_history.max_per_user', 20);
            $autoDeleteOld = Config::get('googlemaps.address_history.auto_delete_old', true);

            if ($maxPerUser > 0 && $autoDeleteOld) {
                $count = static::where('user_id', $addressHistory->user_id)->count();

                if ($count >= $maxPerUser) {
                    // Delete the oldest address(es) to make room
                    static::where('user_id', $addressHistory->user_id)
                        ->oldest()
                        ->limit($count - $maxPerUser + 1)
                        ->delete();
                }
            }
        });
    }
}
