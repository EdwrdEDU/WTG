<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <-- use this instead
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}



