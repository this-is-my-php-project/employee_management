<?php

namespace App\Modules\Storage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Storage extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
}
