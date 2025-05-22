<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'ticketmaster_classification',
        'icon',
        'color'
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_interests');
    }
}