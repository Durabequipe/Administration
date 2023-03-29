<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Interact;
use Illuminate\Auth\Access\HandlesAuthorization;

class InteractPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the interact can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list interacts');
    }

    /**
     * Determine whether the interact can view the model.
     */
    public function view(User $user, Interact $model): bool
    {
        return $user->hasPermissionTo('view interacts');
    }

    /**
     * Determine whether the interact can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create interacts');
    }

    /**
     * Determine whether the interact can update the model.
     */
    public function update(User $user, Interact $model): bool
    {
        return $user->hasPermissionTo('update interacts');
    }

    /**
     * Determine whether the interact can delete the model.
     */
    public function delete(User $user, Interact $model): bool
    {
        return $user->hasPermissionTo('delete interacts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete interacts');
    }

    /**
     * Determine whether the interact can restore the model.
     */
    public function restore(User $user, Interact $model): bool
    {
        return false;
    }

    /**
     * Determine whether the interact can permanently delete the model.
     */
    public function forceDelete(User $user, Interact $model): bool
    {
        return false;
    }
}
