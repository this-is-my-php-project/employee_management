<?php

namespace App\Modules\User;

use App\Modules\Profile\Profile;
use App\Modules\Role\Constants\RoleConstants;
use App\Modules\Role\Role;
use App\Modules\Workspace\Workspace;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'is_active',
        'avatar',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get profiles.
     * 
     * @return HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin == true;
    }

    public function isWorkspaceOwner(string|int $workspace_id)
    {
        $userWorkspace = Workspace::where('created_by_user', $this->id)
            ->where('id', $workspace_id)
            ->first();

        if (empty($userWorkspace)) {
            return false;
        }

        $userWorkspace = $userWorkspace->created_by_user;
        if ($this->id == $userWorkspace) {
            return true;
        }
    }

    /**
     * Check if user is admin.
     * 
     * @param string|int $workspace_id
     * @return bool
     */
    public function is_admin(string|int $workspace_id)
    {
        $profile = Profile::where('user_id', $this->id)->where('workspace_id', $workspace_id)->first();
        $role_id = $profile->jobDetail->role_id;
        $role = Role::find($role_id);

        if ($role->key == RoleConstants::ADMIN['key']) {
            return true;
        }

        return false;
    }

    /**
     * Check if user is manager.
     * 
     * @param string|int $workspace_id
     * @return bool
     */
    public function is_manager(string|int $workspace_id)
    {
        $profile = Profile::where('user_id', $this->id)->where('workspace_id', $workspace_id)->first();
        $role_id = $profile->jobDetail->role_id;
        $role = Role::find($role_id);

        if ($role->key == RoleConstants::MANAGER['key']) {
            return true;
        }

        return false;
    }

    /**
     * Check if user is member.
     * 
     * @param string|int $workspace_id
     * @return bool
     */
    public function is_member(string|int $workspace_id)
    {
        $profile = Profile::where('user_id', $this->id)->where('workspace_id', $workspace_id)->first();
        $role_id = $profile->jobDetail->role_id;
        $role = Role::find($role_id);

        if ($role->key == RoleConstants::MEMBER['key']) {
            return true;
        }

        return false;
    }
}
