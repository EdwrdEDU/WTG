<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
    'firstname',
    'lastname',
    'email',
    'phone',
    'date_of_birth',
    'notification_preferences',
    'notification_delivery',
    'notifications_enabled'
];

protected $casts = [
    'notification_preferences' => 'array',
    'notification_delivery' => 'array',
    'notifications_enabled' => 'boolean'
];

    protected $hidden = [
        'password',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'account_interests');
    }

    public function savedEvents()
    {
        return $this->hasMany(SavedEvent::class);
    }

    public function hasSavedEvent($eventId)
    {
        return $this->savedEvents()->where('event_id', $eventId)->exists();
    }

    public function hasSavedExternalEvent($externalEventId, $source = 'ticketmaster')
    {
        return $this->savedEvents()
            ->where('external_event_id', $externalEventId)
            ->where('external_source', $source)
            ->exists();
    }

    public function saveEvent($eventId)
    {
        $event = Event::find($eventId);
        if (!$event) return false;

        return $this->savedEvents()->firstOrCreate([
            'event_id' => $eventId
        ], [
            'title' => $event->title,
            'description' => $event->description,
            'image_url' => $event->image ? asset('storage/' . $event->image) : null,
            'event_date' => $event->start_date . ' ' . $event->start_time,
            'venue_name' => $event->venue_name,
            'venue_address' => $event->address,
            'price_info' => '₱' . number_format($event->ticket_price, 2)
        ]);
    }

    public function saveExternalEvent($eventData, $source = 'ticketmaster')
    {
        return $this->savedEvents()->firstOrCreate([
            'external_event_id' => $eventData['id'],
            'external_source' => $source
        ], [
            'title' => $eventData['name'],
            'description' => $eventData['info'] ?? '',
            'image_url' => $eventData['images'][0]['url'] ?? null,
            'event_url' => $eventData['url'] ?? null,
            'event_date' => isset($eventData['dates']['start']['dateTime']) 
                ? $eventData['dates']['start']['dateTime'] 
                : null,
            'venue_name' => $eventData['_embedded']['venues'][0]['name'] ?? 'Venue TBA',
            'venue_address' => $eventData['_embedded']['venues'][0]['address']['line1'] ?? null,
            'price_info' => isset($eventData['priceRanges']) 
                ? $eventData['priceRanges'][0]['min'] . '-' . $eventData['priceRanges'][0]['max'] . ' ' . $eventData['priceRanges'][0]['currency']
                : 'Price TBA'
        ]);
    }

    public function unsaveEvent($eventId)
    {
        return $this->savedEvents()->where('event_id', $eventId)->delete();
    }

    public function unsaveExternalEvent($externalEventId, $source = 'ticketmaster')
    {
        return $this->savedEvents()
            ->where('external_event_id', $externalEventId)
            ->where('external_source', $source)
            ->delete();
    }

public function notifications()
{
    return $this->hasMany(\App\Models\Notification::class);
}

public function unreadNotifications()
{
    return $this->notifications()->unread();
}

public function getUnreadNotificationsCountAttribute()
{
    return $this->unreadNotifications()->count();
}

// Helper method to check if user wants specific notification type
public function wantsNotification($type)
{
    // Default to true if notifications_enabled field doesn't exist yet
    if (!isset($this->attributes['notifications_enabled'])) {
        return true;
    }
    
    if (!$this->notifications_enabled) {
        return false;
    }
    
    $preferences = $this->notification_preferences ?? [];
    
    // Default preferences if none set
    if (empty($preferences)) {
        return true; // Enable all notifications by default
    }
    
    $typeMapping = [
        'event_in_week' => 'week_before',
        'event_tomorrow' => 'day_before',
        'event_today' => 'day_of',
        'event_reminder' => 'two_hours_before',
        'event_update' => 'event_changes',
        'event_cancellations' => 'event_cancellations'
    ];
    
    $preferenceKey = $typeMapping[$type] ?? $type;
    
    return in_array($preferenceKey, $preferences);
}
}