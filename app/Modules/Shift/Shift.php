<?php

namespace App\Modules\Shift;

use App\Modules\AttendanceService\AttendanceService;
use App\Modules\JobDetail\JobDetail;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'shifts';

    protected $fillable = [
        'name',
        'clock_in',
        'clock_out',
        'attendance_service_id',
        'workspace_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function attendanceService()
    {
        return $this->belongsTo(AttendanceService::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function jobDetails()
    {
        return $this->hasMany(JobDetail::class);
    }
}
