<?php

namespace App\Modules\Department;

use App\Modules\JobDetail\JobDetail;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'level',
        'is_active',
        'is_default',
        'workspace_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function jobDetails()
    {
        return $this->hasMany(JobDetail::class);
    }
}
