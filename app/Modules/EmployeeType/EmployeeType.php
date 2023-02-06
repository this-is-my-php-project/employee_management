<?php

namespace App\Modules\EmployeeType;

use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'employee_types';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'is_global',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_global' => 'boolean',
    ];

    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(
            Workspace::class,
            'workspace_employee_type',
        );
    }
}
