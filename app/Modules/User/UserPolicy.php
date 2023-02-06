<?php

namespace App\Modules\User;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }
}
