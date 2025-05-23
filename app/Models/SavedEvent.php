<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SavedEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'event_id',
        'external_event_id',
        'external_source',
        'title',
        'description',
        'image_url',
        'event_url',
        'event_date',
        'venue_name',
        'venue_address',
        'price_info'
    ];

    protected $casts = [
        'event_date' => 'datetime'
    ];

    /**
     * Get the account that saved this event
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the local event if this is a saved local event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Check if this is a local event
     */
    public function getIsLocalEventAttribute()
    {
        return !is_null($this->event_id);
    }

    /**
     * Check if this is an external event
     */
    public function getIsExternalEventAttribute()
    {
        return !is_null($this->external_event_id);
    }

    /**
     * Get formatted event date
     */
    public function getFormattedDateAttribute()
    {
        if ($this->event_date) {
            return Carbon::parse($this->event_date)->format('M d, Y \a\t g:i A');
        }
        return 'Date TBA';
    }

    /**
     * Get the display URL for the event
     */
    public function getDisplayUrlAttribute()
    {
        if ($this->is_local_event && $this->event) {
            return route('events.show', $this->event);
        }
        return $this->event_url;
    }

    /**
     * Get the display image for the event
     */
    public function getDisplayImageAttribute()
    {
        if ($this->is_local_event && $this->event && $this->event->image) {
            return asset('storage/' . $this->event->image);
        }
        return $this->image_url ?: asset('images/default-event.jpg');
    }

    /**
     * Scope to get only local events
     */
    public function scopeLocalEvents($query)
    {
        return $query->whereNotNull('event_id');
    }

    /**
     * Scope to get only external events
     */
    public function scopeExternalEvents($query)
    {
        return $query->whereNotNull('external_event_id');
    }

    /**
     * Scope to get upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }
}