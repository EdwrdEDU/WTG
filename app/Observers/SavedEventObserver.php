<?php

namespace App\Observers;

use App\Models\SavedEvent;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class SavedEventObserver
{
    /**
     * Handle the SavedEvent "created" event.
     */
    public function created(SavedEvent $savedEvent)
    {
        try {
            Log::info('SavedEvent created, scheduling notifications', [
                'saved_event_id' => $savedEvent->id,
                'account_id' => $savedEvent->account_id,
                'event_title' => $savedEvent->title
            ]);

            // Use app() helper to resolve the service
            $notificationService = app(NotificationService::class);
            $notificationService->scheduleNotificationsForSavedEvent($savedEvent);
            
        } catch (\Exception $e) {
            Log::error('Failed to schedule notifications for saved event', [
                'saved_event_id' => $savedEvent->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle the SavedEvent "updated" event.
     */
    public function updated(SavedEvent $savedEvent)
    {
        try {
            $notificationService = app(NotificationService::class);
            
            // Check if important fields changed
            $changes = $savedEvent->getChanges();
            $original = $savedEvent->getOriginal();
            
            Log::info('SavedEvent updated', [
                'saved_event_id' => $savedEvent->id,
                'changes' => array_keys($changes)
            ]);
            
            // Handle event date changes (rescheduling)
            if (isset($changes['event_date']) && $savedEvent->event_date) {
                $oldDate = $original['event_date'] ?? null;
                $newDate = $savedEvent->event_date;
                
                // Create rescheduled notification
                $notificationService->createEventUpdateNotification(
                    $savedEvent, 
                    'rescheduled', 
                    [
                        'old_date' => $oldDate ? \Carbon\Carbon::parse($oldDate)->format('M j, Y \a\t g:i A') : 'Unknown',
                        'new_date' => \Carbon\Carbon::parse($newDate)->format('M j, Y \a\t g:i A')
                    ]
                );
                
                // Remove old scheduled notifications and create new ones
                $savedEvent->account->notifications()
                          ->where('saved_event_id', $savedEvent->id)
                          ->where('is_sent', false)
                          ->where('type', '!=', 'event_update')
                          ->delete();
                          
                // Schedule new notifications with updated date
                $notificationService->scheduleNotificationsForSavedEvent($savedEvent);
            }
            
            // Handle venue changes
            if (isset($changes['venue_name'])) {
                $oldVenue = $original['venue_name'] ?? 'Unknown';
                $newVenue = $savedEvent->venue_name ?? 'TBA';
                
                $notificationService->createEventUpdateNotification(
                    $savedEvent, 
                    'venue_changed', 
                    [
                        'old_venue' => $oldVenue,
                        'new_venue' => $newVenue
                    ]
                );
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to handle saved event update', [
                'saved_event_id' => $savedEvent->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle the SavedEvent "deleting" event.
     */
    public function deleting(SavedEvent $savedEvent)
    {
        try {
            Log::info('SavedEvent being deleted, removing notifications', [
                'saved_event_id' => $savedEvent->id,
                'account_id' => $savedEvent->account_id
            ]);

            // Remove associated notifications when event is unsaved
            $deletedCount = $savedEvent->account->notifications()
                          ->where('saved_event_id', $savedEvent->id)
                          ->delete();
                          
            Log::info('Removed notifications for deleted saved event', [
                'saved_event_id' => $savedEvent->id,
                'notifications_deleted' => $deletedCount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to remove notifications for deleted saved event', [
                'saved_event_id' => $savedEvent->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}