<?php

namespace App\Modules\Shift;

use App\Modules\AttendanceRecord\AttendanceRecord;
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
        'clock_in',
        'clock_out',
        'name',
        'workspace_id',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function jobDetails()
    {
        return $this->hasMany(JobDetail::class);
    }
}
