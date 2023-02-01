<?php

namespace App\Modules\JobDetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobDetail extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;
}
