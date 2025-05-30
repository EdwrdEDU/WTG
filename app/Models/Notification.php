<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'saved_event_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'scheduled_for',
        'is_sent'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'scheduled_for' => 'datetime',
        'is_sent' => 'boolean'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function savedEvent()
    {
        return $this->belongsTo(SavedEvent::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopePending($query)
    {
        return $query->where('is_sent', false)
                    ->where(function($q) {
                        $q->whereNull('scheduled_for')
                          ->orWhere('scheduled_for', '<=', now());
                    });
    }

    public function getIsUnreadAttribute()
    {
        return is_null($this->read_at);
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}