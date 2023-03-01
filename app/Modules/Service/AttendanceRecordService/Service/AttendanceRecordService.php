<?php

namespace App\Modules\Service/AttendanceRecordService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service/AttendanceRecordService extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;
}
