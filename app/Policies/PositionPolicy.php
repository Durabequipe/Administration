<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the position can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list positions');
    }

    /**
     * Determine whether the position can view the model.
     */
    public function view(User $user, Position $model): bool
    {
        return $user->hasPermissionTo('view positions');
    }

    /**
     * Determine whether the position can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create positions');
    }

    /**
     * Determine whether the position can update the model.
     */
    public function update(User $user, Position $model): bool
    {
        return $user->hasPermissionTo('update positions');
    }

    /**
     * Determine whether the position can delete the model.
     */
    public function delete(User $user, Position $model): bool
    {
        return $user->hasPermissionTo('delete positions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete positions');
    }

    /**
     * Determine whether the position can restore the model.
     */
    public function restore(User $user, Position $model): bool
    {
        return false;
    }

    /**
     * Determine whether the position can permanently delete the model.
     */
    public function forceDelete(User $user, Position $model): bool
    {
        return false;
    }
}
