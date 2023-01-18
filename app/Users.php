<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'userID';

    protected $fillable = [
        'userName', 'password', 'role', 'fullname', 'email', 'phone', 'active', 'description'

    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


}
