<?php

namespace App\Modules\AttendanceService;

use App\Modules\AttendanceService\Constants\AttendanceServiceConstants;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceService extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'attendance_services';

    protected $fillable = [
        'name',
        'description',
        'icon',
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

    public function workspaces()
    {
        $workspace = $this->belongsToMany(
            Workspace::class,
            'attendance_service_workspace',
            'attendance_service_id',
            'workspace_id'
        );

        return $workspace;
    }

    public static function getAttendanceService()
    {
        return self::where('id', AttendanceServiceConstants::ATTENDANCE_SERVICE['id'])->first();
    }
}
