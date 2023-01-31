<?php

namespace App\Modules\Adjustment;

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
        'name',
        'status',
        'adjustment_type_id',
        'workspace_id',
        'is_global'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'boolean',
        'adjustment_type_id' => 'integer',
        'workspace_id' => 'integer',
        'is_global' => 'boolean',
    ];

    public function workspace()
    {
        return $this->belongsTo(\App\Modules\Workspace\Workspace::class);
    }

    public function type()
    {
        return $this->belongsTo(\App\Modules\AdjustmentType\AdjustmentType::class);
    }
}
