<?php

namespace App\Modules\Adjustment;

use App\Modules\AdjustmentType\AdjustmentType;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AdjustmentType::class);
    }
}