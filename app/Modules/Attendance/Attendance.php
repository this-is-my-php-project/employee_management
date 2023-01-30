<?php

namespace App\Modules\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
        'user_id',
        'workspace_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'start_date' => 'string',
        'end_date' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
        'status' => 'boolean',
        'user_id' => 'integer',
        'workspace_id' => 'integer',
    ];

    /**
     * Get the user that owns the attendance.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Modules\User\User');
    }

    /**
     * Get the workspace that owns the attendance.
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo('App\Modules\Workspace\Workspace');
    }
}
