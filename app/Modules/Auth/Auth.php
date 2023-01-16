<?php

namespace App\Modules\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;

class Auth extends Model
{
    use HasFactory, HasApiTokens;
}
