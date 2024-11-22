<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'employee_name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
         'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}