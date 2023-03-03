<?php

namespace App\Modules\Adjustment;

use App\Modules\AdjustmentType\AdjustmentType;
use App\Modules\AttendanceRecord\AttendanceRecord;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adjustment extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'adjustments';

    protected $fillable = [
        'clock_in',
        'clock_out',
        'date',
        'adjustment_type_id',
        'attendance_record_id',
        'workspace_id',
    ];

    public function adjustmentType()
    {
        return $this->belongsTo(AdjustmentType::class);
    }

    public function attendanceRecord()
    {
        return $this->belongsTo(AttendanceRecord::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
