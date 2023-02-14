<?php

namespace App\Modules\Workspace;

use App\Modules\AttendanceService\AttendanceService;
use App\Modules\Department\Department;
use App\Modules\EmployeeType\EmployeeType;
use App\Modules\JobDetail\JobDetail;
use App\Modules\Profile\Profile;
use App\Modules\Role\Role;
use App\Modules\User\User;
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
        'is_active',
        'logo',
        'cover',
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
        'description' => 'string',
        'is_active' => 'boolean',
        'logo' => 'string',
        'cover' => 'string',
        'created_by_user' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // /**
    //  * Get the user that owns the Workspace
    //  *
    //  * @return BelongsTo
    //  */
    // public function createdByUser(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by_user');
    // }

    // /** 
    //  * Get the user that owns the Workspace
    //  *
    //  * @return BelongsToMany
    //  */
    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'user_workspace');
    // }

    // /**
    //  * Get workspace's projects
    //  * 
    //  * @return BelongsToMany
    //  */
    // public function projects(): HasMany
    // {
    //     return $this->hasMany(Project::class);
    // }


    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user');
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
     * Get workspace's employee types
     * 
     * @return BelongsToMany
     */
    public function employeeTypes(): BelongsToMany
    {
        return $this->belongsToMany(EmployeeType::class, 'workspace_employee_type');
    }

    /**
     * Get workspace's departments
     * 
     * return HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get workspace's job details
     * 
     * @return HasMany
     */
    public function jobDetails(): HasMany
    {
        return $this->hasMany(JobDetail::class);
    }

    /**
     * Get workspace's profile
     * 
     * @return HasMany
     */
    public function userProfiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function attendanceServices()
    {
        return $this->belongsToMany(
            AttendanceService::class,
            'attendance_service_workspace',
            'workspace_id',
            'attendance_service_id'
        );
    }
}
