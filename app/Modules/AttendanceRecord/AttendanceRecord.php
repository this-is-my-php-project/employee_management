<?php

namespace App\Modules\AttendanceRecord;

use App\Modules\Adjustment\Adjustment;
use App\Modules\Profile\Profile;
use App\Modules\Shift\Shift;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecord extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'attendance_records';

    protected $fillable = [
        'clock_in',
        'clock_out',
        'start_date',
        'profile_id',
        'shift_id',
        'workspace_id',
    ];

    public function adjustment()
    {
        return $this->hasOne(Adjustment::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
