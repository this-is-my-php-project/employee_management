<?php

namespace App\Modules\InvitationUrl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationUrl extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'invitation_urls';

    protected $fillable = [
        'workspace_id',
        'department_id',
        'expires',
        'signature',
        'url',
        'is_expired',
        'is_used',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
