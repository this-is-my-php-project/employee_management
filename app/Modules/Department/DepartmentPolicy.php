<?php

namespace App\Modules\Department;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Department.
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
     * Determine whether the user can view the Department.
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
     * Determine whether the user can create Department.
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
     * Determine whether the user can update the Department.
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
     * Determine whether the user can delete the Department.
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
     * Determine whether the user can restore the Department.
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
     * Determine whether the user can permanently delete the Department.
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
