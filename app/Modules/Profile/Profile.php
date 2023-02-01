<?php

namespace App\Modules\Profile;

use App\Modules\JobDetail\JobDetail;
use App\Modules\User\User;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'profiles';

    protected $fillable = [
        'name',
        'alias',
        'avatar',
        'phone',
        'email',
        'job_detail_id',
        'user_id',
        'workspace_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobDetail()
    {
        return $this->belongsTo(JobDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
