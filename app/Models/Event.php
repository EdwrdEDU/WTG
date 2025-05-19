<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'title',
        'organizer',
        'description',
        'category_id',
        'event_type',
        'image',
        'start_date',
        'start_time',
        'venue_name',
        'address',
        'tickets',
    ];

    protected $casts = [
        'tickets' => 'array',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

