<?php

namespace Cyna\GoogleMaps\Policies;

use Cyna\GoogleMaps\Models\AddressHistory;
use Illuminate\Auth\Access\Response;

class AddressHistoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return true; // Users can view their own addresses
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, AddressHistory $addressHistory): bool
    {
        return $user->id === $addressHistory->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return true; // Users can create addresses
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, AddressHistory $addressHistory): bool
    {
        return $user->id === $addressHistory->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, AddressHistory $addressHistory): bool
    {
        return $user->id === $addressHistory->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, AddressHistory $addressHistory): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, AddressHistory $addressHistory): bool
    {
        return false;
    }
}
