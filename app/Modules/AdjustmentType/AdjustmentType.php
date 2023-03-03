<?php

namespace App\Modules\AdjustmentType;

use App\Modules\Adjustment\Adjustment;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjustmentType extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'adjustment_types';

    protected $fillable = [
        'clock_in',
        'clock_out',
        'date',
        'attendance_record_id',
        'workspace_id',
    ];

    public function adjustments()
    {
        return $this->hasMany(Adjustment::class);
    }

    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_adjustment_type');
    }
}
