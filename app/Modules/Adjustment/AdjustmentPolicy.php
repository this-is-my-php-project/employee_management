<?php

namespace App\Modules\Adjustment;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class AdjustmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Adjustment.
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
     * Determine whether the user can view the Adjustment.
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
     * Determine whether the user can create Adjustment.
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
     * Determine whether the user can delete the Workspace.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewWorkspaceAdjustment(User $user, string $workspaceId)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isWorkspaceOwner($workspaceId)) {
            return true;
        }
    }
}
