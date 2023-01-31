<?php

namespace App\Modules\Adjust;

use App\Modules\Attendance\Attendance;
use App\Modules\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adjust extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'adjusts';

    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
        'reason',
        'attendance_id',
        'user_id',
        'workspace_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'start_date' => 'string',
        'end_date' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
        'status' => 'boolean',
        'reason' => 'string',
        'attendance_id' => 'integer',
        'user_id' => 'integer',
        'workspace_id' => 'integer',
    ];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
