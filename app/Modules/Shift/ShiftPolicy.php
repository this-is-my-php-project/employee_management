<?php

namespace App\Modules\Shift;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class ShiftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Workspace.
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
     * Determine whether the user can view the Workspace.
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
     * Determine whether the user can create Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, string $workspaceId)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($workspaceId)) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, string $workspaceId)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($workspaceId)) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, string $workspaceId)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($workspaceId)) {
            return true;
        }
    }

    public function assignUser(User $user, string $workspaceId)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($workspaceId)) {
            return true;
        }
    }

    public function viewWorkspaceShifts(User $user, string $workspaceId)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($workspaceId)) {
            return true;
        }
    }
}
