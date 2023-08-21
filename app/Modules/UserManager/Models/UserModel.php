<?php

namespace App\Modules\UserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $guarded = ['id'];
}
