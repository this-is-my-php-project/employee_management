<?php

namespace App\Modules\Role;

use App\Modules\User\User;
use Laravel\Passport\HasApiTokens;
use App\Modules\Workspace\Workspace;
use App\Modules\Permission\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'level',
        'parent_id',
        'created_by_workspace',
        'workspace_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'status' => 'boolean',
        'level' => 'integer',
        'parent_id' => 'integer',
        'workspace_id' => 'integer',
        'created_by_workspace' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get role creator.
     * 
     * @return BelongsTo
     */
    public function createdByWorkspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'created_by_workspace');
    }

    /**
     * Get users of the role.
     * 
     * @return BelongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_role',
            'role_id',
            'user_id'
        );
    }

    /**
     * Get role creator.
     * 
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): belongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permission',
        );
    }
}
