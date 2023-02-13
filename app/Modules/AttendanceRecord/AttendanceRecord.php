<?php

namespace App\Modules\AttendanceRecord;

use App\Modules\Profile\Profile;
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
        'date',
        'note',
        'profile_id',
        'workspace_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function profile()
    {
        return $this->belongsToMany(Profile::class);
    }
}
