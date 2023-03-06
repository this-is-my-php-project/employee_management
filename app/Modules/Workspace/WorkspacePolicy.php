<?php

namespace App\Modules\Workspace;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class WorkspacePolicy
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
    public function view(User $user, string $id)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($id)) {
            return true;
        }
    }

    /**
     * Determine whether the user can create Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, string $id)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($id)) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, string $id)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($id)) {
            return true;
        }
    }
}
