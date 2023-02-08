<?php

namespace App\Modules\InvitationUrl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class InvitationUrl extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'invitation_urls';

    protected $fillable = [
        'workspace_id',
        'department_id',
        'expires',
        'signature',
        'url',
        'force_expired',
        'used',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
