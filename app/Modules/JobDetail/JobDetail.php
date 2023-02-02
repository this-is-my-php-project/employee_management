<?php

namespace App\Modules\JobDetail;

use App\Modules\Department\Department;
use App\Modules\EmployeeType\EmployeeType;
use App\Modules\Role\Role;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobDetail extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'job_details';

    protected $fillable = [
        'title',
        'description',
        'employee_type_id',
        'role_id',
        'department_id',
        'workspace_id',
        'user_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_global' => 'boolean',
    ];

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
