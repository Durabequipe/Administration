<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the video can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list videos');
    }

    /**
     * Determine whether the video can view the model.
     */
    public function view(User $user, Video $model): bool
    {
        return $user->hasPermissionTo('view videos');
    }

    /**
     * Determine whether the video can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create videos');
    }

    /**
     * Determine whether the video can update the model.
     */
    public function update(User $user, Video $model): bool
    {
        return $user->hasPermissionTo('update videos');
    }

    /**
     * Determine whether the video can delete the model.
     */
    public function delete(User $user, Video $model): bool
    {
        return $user->hasPermissionTo('delete videos');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete videos');
    }

    /**
     * Determine whether the video can restore the model.
     */
    public function restore(User $user, Video $model): bool
    {
        return false;
    }

    /**
     * Determine whether the video can permanently delete the model.
     */
    public function forceDelete(User $user, Video $model): bool
    {
        return false;
    }
}
