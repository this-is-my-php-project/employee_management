<?php

namespace App\Modules\User;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\Workspace\Workspace;
use App\Modules\Role\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'status',
        'storage_id',
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
     * Get the roles that owns the user.
     * 
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role',);
    }

    /**
     * Get the workspace that owns the user.
     * 
     * @return BelongsToMany
     */
    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'user_workspace',);
    }


    /**
     * get all permissions of the user.
     */
    public function getPermissions(): array
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }

    /**
     * check if the user has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getPermissions());
    }

    /**
     * check if the user is super admin.
     */
    public function isSuperAdmin(): ?bool
    {
        return $this->roles()->where('parent_id', 0)->exists();
    }
}
