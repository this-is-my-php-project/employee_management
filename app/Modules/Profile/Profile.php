<?php

namespace App\Modules\Profile;

use App\Modules\JobDetail\JobDetail;
use App\Modules\User\User;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Profile extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'profiles';

    protected $fillable = [
        'name',
        'alias',
        'avatar',
        'phone',
        'email',
        'is_active',
        'user_id',
        'workspace_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the Profile
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the workspace that owns the Profile
     * 
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Get the jobDetail for the Profile
     * 
     * @return HasOne
     */
    public function jobDetail(): HasOne
    {
        return $this->hasOne(JobDetail::class);
    }

    public static function getProfile(string|int $workspace)
    {
        return self::where('workspace_id', $workspace)
            ->where('user_id', auth()->user()->id)
            ->first();
    }
}
