<?php

namespace App\Modules\Meta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'meta';

    protected $fillable = [
        'key',
        'value',
        'name',
        'workspace_id',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'is_active'
    ];

    protected $casts = [
        'id' => 'integer',
        'workspace_id' => 'integer',
    ];

    public function workspace()
    {
        return $this->belongsTo(\App\Modules\Workspace\Workspace::class);
    }
}
