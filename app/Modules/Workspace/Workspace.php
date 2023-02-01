<?php

namespace App\Modules\Workspace;

use App\Modules\EmployeeType\EmployeeType;
use App\Modules\Role\Role;
use App\Modules\User\User;
use App\Modules\Project\Project;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Workspace extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'workspaces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by_user',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'title' => 'string',
        'description' => 'string',
        'status' => 'boolean',
        'created_by_user' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the Workspace
     *
     * @return BelongsTo
     */
    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user');
    }

    /** 
     * Get the user that owns the Workspace
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_workspace');
    }

    /**
     * Get workspace's projects
     * 
     * @return BelongsToMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get workspace's roles
     * 
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'workspace_role');
    }

    /**
     * Get workspace's meta
     * 
     * @return HasMany
     */
    public function meta(): HasMany
    {
        return $this->hasMany(\App\Modules\Meta\Meta::class);
    }

    public function employeeTypes(): BelongsToMany
    {
        return $this->belongsToMany(EmployeeType::class);
    }
}
