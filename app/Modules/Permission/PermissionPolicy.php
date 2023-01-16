<?php

namespace App\Modules\Permission;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return $user->can(Permission::VIEW_USER);
        return true;
    }

    /**
     * Determine whether the user can view the Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        // return $user->can(Permission::VIEW_USER->value);
        return true;
    }

    /**
     * Determine whether the user can create Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // return $user->can(Permission::CREATE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can update the Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        // return $user->can(Permission::UPDATE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can delete the Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        // return $user->can(Permission::DELETE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can restore the Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        // return $user->can(Permission::RESTORE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Permission.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        // return $user->can(Permission::FORCE_DELETE_USER->value);
        return true;
    }
}
