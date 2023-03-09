<?php

namespace App\Modules\JobDetail;

use App\Modules\Department\Department;
use App\Modules\EmployeeType\EmployeeType;
use App\Modules\Profile\Profile;
use App\Modules\Role\Role;
use App\Modules\Shift\Shift;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class JobDetail extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'job_details';

    protected $fillable = [
        'title',
        'description',
        'employee_type_id',
        'role_id',
        'department_id',
        'workspace_id',
        'profile_id',
        'shift_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_global' => 'boolean',
    ];

    /**
     * Get the employee type that owns the JobDetail
     * 
     * @return BelongsTo
     */
    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    /**
     * Get the role that owns the JobDetail
     * 
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the department that owns the JobDetail
     * 
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the workspace that owns the JobDetail
     * 
     * @return BelongsTo
     */
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Get the profile that owns the JobDetail
     * 
     * @return BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
