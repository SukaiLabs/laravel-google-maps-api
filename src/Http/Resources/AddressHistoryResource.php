<?php

namespace SukaiLabs\GoogleMaps\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'coordinates' => $this->coordinates,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
