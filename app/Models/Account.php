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
        'password',
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

    /**
     * Get all saved events for this account
     */
    public function savedEvents()
    {
        return $this->hasMany(SavedEvent::class);
    }

    /**
     * Check if user has saved a specific local event
     */
    public function hasSavedEvent($eventId)
    {
        return $this->savedEvents()->where('event_id', $eventId)->exists();
    }

    /**
     * Check if user has saved a specific external event
     */
    public function hasSavedExternalEvent($externalEventId, $source = 'ticketmaster')
    {
        return $this->savedEvents()
            ->where('external_event_id', $externalEventId)
            ->where('external_source', $source)
            ->exists();
    }

    /**
     * Save a local event
     */
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

    /**
     * Save an external event (from API)
     */
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

    /**
     * Unsave an event
     */
    public function unsaveEvent($eventId)
    {
        return $this->savedEvents()->where('event_id', $eventId)->delete();
    }

    /**
     * Unsave an external event
     */
    public function unsaveExternalEvent($externalEventId, $source = 'ticketmaster')
    {
        return $this->savedEvents()
            ->where('external_event_id', $externalEventId)
            ->where('external_source', $source)
            ->delete();
    }
}