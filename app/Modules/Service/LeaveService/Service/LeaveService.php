<?php

namespace App\Modules\Service/LeaveService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service/LeaveService extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;
}
