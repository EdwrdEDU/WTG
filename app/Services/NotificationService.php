<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\SavedEvent;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function createEventReminder(SavedEvent $savedEvent, string $type = 'event_reminder')
    {
        if (!$savedEvent->event_date) {
            return null;
        }

        // Check if user wants this type of notification
        if (!$savedEvent->account->wantsNotification($type)) {
            return null;
        }

        $eventDate = Carbon::parse($savedEvent->event_date);
        $now = now();

        // Don't create notifications for past events
        if ($eventDate->isPast()) {
            return null;
        }

        $scheduledFor = null;
        $title = '';
        $message = '';

        switch ($type) {
            case 'event_tomorrow':
                // Schedule notification 1 day before at 9 AM
                $scheduledFor = $eventDate->copy()->subDay()->setTime(9, 0);
                $title = "Event Tomorrow!";
                $message = "Don't forget! '{$savedEvent->title}' is happening tomorrow at " . 
                          $eventDate->format('g:i A');
                break;

            case 'event_today':
                // Schedule notification on event day at 8 AM
                $scheduledFor = $eventDate->copy()->startOfDay()->setTime(8, 0);
                $title = "Event Today!";
                $message = "'{$savedEvent->title}' is happening today at " . 
                          $eventDate->format('g:i A') . ". Don't miss it!";
                break;

            case 'event_in_week':
                // Schedule notification 1 week before at 10 AM
                $scheduledFor = $eventDate->copy()->subWeek()->setTime(10, 0);
                $title = "Event Next Week";
                $message = "'{$savedEvent->title}' is coming up next week on " . 
                          $eventDate->format('l, M j \a\t g:i A');
                break;

            case 'event_reminder':
            default:
                // Schedule notification exactly 2 hours before event
                $scheduledFor = $eventDate->copy()->subHours(2);
                $title = "Event Starting Soon!";
                $message = "'{$savedEvent->title}' starts in 2 hours at " . 
                          $eventDate->format('g:i A');
                break;
        }

        // CRITICAL FIX: Only create notification if it's time to send it
        if ($scheduledFor && $scheduledFor->isFuture()) {
            
            // KEY FIX: Don't create the notification record yet, just log it
            Log::info('Notification scheduled for future', [
                'event_title' => $savedEvent->title,
                'event_date' => $eventDate->toDateTimeString(),
                'notification_type' => $type,
                'scheduled_for' => $scheduledFor->toDateTimeString(),
                'time_until_notification' => $scheduledFor->diffForHumans(now()),
                'account_id' => $savedEvent->account_id
            ]);

            // Don't create notification record until it's time to send
            return null;
        }

        // Only create notification if it should be sent NOW
        if ($scheduledFor && $scheduledFor->isPast()) {
            return Notification::create([
                'account_id' => $savedEvent->account_id,
                'saved_event_id' => $savedEvent->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'scheduled_for' => $scheduledFor,
                'is_sent' => false, // Will be marked true when actually sent
                'data' => [
                    'event_title' => $savedEvent->title,
                    'event_date' => $savedEvent->event_date,
                    'venue_name' => $savedEvent->venue_name,
                    'event_url' => $savedEvent->display_url ?? null
                ]
            ]);
        }

        return null;
    }

    public function createEventUpdateNotification(SavedEvent $savedEvent, string $updateType, array $changes = [])
    {
        // Check if user wants update notifications
        if (!$savedEvent->account->wantsNotification('event_update')) {
            return null;
        }

        $title = "Event Updated";
        $message = "'{$savedEvent->title}' has been updated.";

        switch ($updateType) {
            case 'cancelled':
                $title = "Event Cancelled";
                $message = "Unfortunately, '{$savedEvent->title}' has been cancelled.";
                break;
                
            case 'rescheduled':
                $title = "Event Rescheduled";
                if (isset($changes['new_date'])) {
                    $message = "'{$savedEvent->title}' has been rescheduled to {$changes['new_date']}.";
                } else {
                    $message = "'{$savedEvent->title}' has been rescheduled. Please check the event details for the new date.";
                }
                break;
                
            case 'venue_changed':
                $title = "Venue Changed";
                if (isset($changes['new_venue'])) {
                    $message = "'{$savedEvent->title}' venue has been changed to {$changes['new_venue']}.";
                } else {
                    $message = "The venue for '{$savedEvent->title}' has been updated.";
                }
                break;
                
            case 'title_changed':
                $title = "Event Renamed";
                if (isset($changes['new_title'])) {
                    $message = "Your saved event has been renamed to '{$changes['new_title']}'.";
                } else {
                    $message = "One of your saved events has been renamed.";
                }
                break;
        }

        // Update notifications are sent immediately
        return Notification::create([
            'account_id' => $savedEvent->account_id,
            'saved_event_id' => $savedEvent->id,
            'type' => 'event_update',
            'title' => $title,
            'message' => $message,
            'is_sent' => false,
            'data' => array_merge([
                'event_title' => $savedEvent->title,
                'update_type' => $updateType,
                'event_url' => $savedEvent->display_url ?? null
            ], $changes)
        ]);
    }

    public function scheduleNotificationsForSavedEvent(SavedEvent $savedEvent)
    {
        // This method now just logs what WOULD be scheduled
        Log::info('Scheduling notifications for saved event', [
            'event_title' => $savedEvent->title,
            'event_date' => $savedEvent->event_date,
            'account_id' => $savedEvent->account_id
        ]);

        // Don't create notifications yet, they'll be created when it's time to send them
        $this->createEventReminder($savedEvent, 'event_in_week');
        $this->createEventReminder($savedEvent, 'event_tomorrow');
        $this->createEventReminder($savedEvent, 'event_today');
        $this->createEventReminder($savedEvent, 'event_reminder');
    }

    /**
     * NEW METHOD: Check for events that need notifications sent NOW
     */
    public function createDueNotifications()
    {
        $now = now();
        $eventsNeedingNotifications = SavedEvent::whereNotNull('event_date')
            ->where('event_date', '>', $now) // Only future events
            ->with('account')
            ->get();

        $notificationsCreated = 0;

        foreach ($eventsNeedingNotifications as $savedEvent) {
            $eventDate = Carbon::parse($savedEvent->event_date);

            // Check each notification type and create if it's time
            $notificationTypes = [
                'event_in_week' => $eventDate->copy()->subWeek()->setTime(10, 0),
                'event_tomorrow' => $eventDate->copy()->subDay()->setTime(9, 0),
                'event_today' => $eventDate->copy()->startOfDay()->setTime(8, 0),
                'event_reminder' => $eventDate->copy()->subHours(2)
            ];

            foreach ($notificationTypes as $type => $scheduledTime) {
                // Check if it's time to send this notification
                if ($scheduledTime->isPast() && $scheduledTime->diffInMinutes($now) <= 60) {
                    // Check if we already created this notification
                    $exists = Notification::where('account_id', $savedEvent->account_id)
                        ->where('saved_event_id', $savedEvent->id)
                        ->where('type', $type)
                        ->exists();

                    if (!$exists && $savedEvent->account->wantsNotification($type)) {
                        $this->createEventReminderNow($savedEvent, $type, $scheduledTime);
                        $notificationsCreated++;
                    }
                }
            }
        }

        Log::info('Created due notifications', [
            'count' => $notificationsCreated,
            'checked_at' => $now->toDateTimeString()
        ]);

        return $notificationsCreated;
    }

    /**
     * Create notification immediately (when it's due)
     */
    private function createEventReminderNow(SavedEvent $savedEvent, string $type, Carbon $scheduledTime)
    {
        $eventDate = Carbon::parse($savedEvent->event_date);
        $title = '';
        $message = '';

        switch ($type) {
            case 'event_tomorrow':
                $title = "Event Tomorrow!";
                $message = "Don't forget! '{$savedEvent->title}' is happening tomorrow at " . 
                          $eventDate->format('g:i A');
                break;

            case 'event_today':
                $title = "Event Today!";
                $message = "'{$savedEvent->title}' is happening today at " . 
                          $eventDate->format('g:i A') . ". Don't miss it!";
                break;

            case 'event_in_week':
                $title = "Event Next Week";
                $message = "'{$savedEvent->title}' is coming up next week on " . 
                          $eventDate->format('l, M j \a\t g:i A');
                break;

            case 'event_reminder':
            default:
                $title = "Event Starting Soon!";
                $message = "'{$savedEvent->title}' starts in 2 hours at " . 
                          $eventDate->format('g:i A');
                break;
        }

        return Notification::create([
            'account_id' => $savedEvent->account_id,
            'saved_event_id' => $savedEvent->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'scheduled_for' => $scheduledTime,
            'is_sent' => false,
            'data' => [
                'event_title' => $savedEvent->title,
                'event_date' => $savedEvent->event_date,
                'venue_name' => $savedEvent->venue_name,
                'event_url' => $savedEvent->display_url ?? null
            ]
        ]);
    }

    public function getUnreadNotifications(Account $account, $limit = 10)
    {
        return $account->notifications()
                      ->unread()
                      ->latest()
                      ->limit($limit)
                      ->get();
    }

    public function markAllAsRead(Account $account)
    {
        return $account->notifications()
                      ->unread()
                      ->update(['read_at' => now()]);
    }

    public function sendPendingNotifications()
    {
        // First, create any notifications that are due
        $this->createDueNotifications();

        // Then send notifications that exist and are ready
        $notifications = Notification::where('is_sent', false)
                                   ->whereNotNull('scheduled_for')
                                   ->where('scheduled_for', '<=', now())
                                   ->with(['account', 'savedEvent'])
                                   ->get();

        $successCount = 0;

        foreach ($notifications as $notification) {
            try {
                // Mark as sent
                $notification->update(['is_sent' => true]);
                $successCount++;

                // Here you can add email/SMS sending logic
                Log::info('Notification sent', [
                    'notification_id' => $notification->id,
                    'account_id' => $notification->account_id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'scheduled_for' => $notification->scheduled_for?->toDateTimeString(),
                    'sent_at' => now()->toDateTimeString()
                ]);

            } catch (\Exception $e) {
                // Revert sent status if failed
                $notification->update(['is_sent' => false]);
                
                Log::error('Failed to send notification', [
                    'notification_id' => $notification->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return $successCount;
    }

    /**
     * Debug method to check what notifications would be scheduled
     */
    public function getScheduledNotifications(Account $account = null)
    {
        $query = Notification::where('is_sent', false)
                            ->whereNotNull('scheduled_for')
                            ->orderBy('scheduled_for');

        if ($account) {
            $query->where('account_id', $account->id);
        }

        return $query->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $notification->title,
                'scheduled_for' => $notification->scheduled_for?->toDateTimeString(),
                'time_until' => $notification->scheduled_for?->diffForHumans(now()),
                'event_title' => $notification->savedEvent?->title,
                'event_date' => $notification->savedEvent?->event_date
            ];
        });
    }
}