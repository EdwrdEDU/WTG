<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <-- use this instead
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}



