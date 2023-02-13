<?php

namespace App\Modules\UserAttendanceMeta;

use App\Modules\JobDetail\JobDetail;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAttendanceMeta extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'user_attendance_meta';

    protected $fillable = [
        'clock_in',
        'clock_out',
        'workspace_id',
        'job_detail_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function jobDetail(): BelongsTo
    {
        return $this->belongsTo(JobDetail::class);
    }
}
