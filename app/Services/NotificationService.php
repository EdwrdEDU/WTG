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
                $scheduledFor = $eventDate->copy()->subDay()->setTime(9, 0);
                $title = "Event Tomorrow!";
                $message = "Don't forget! '{$savedEvent->title}' is happening tomorrow at " . 
                          $eventDate->format('g:i A');
                break;

            case 'event_today':
                $scheduledFor = $eventDate->copy()->setTime(8, 0);
                $title = "Event Today!";
                $message = "'{$savedEvent->title}' is happening today at " . 
                          $eventDate->format('g:i A') . ". Don't miss it!";
                break;

            case 'event_in_week':
                $scheduledFor = $eventDate->copy()->subWeek()->setTime(10, 0);
                $title = "Event Next Week";
                $message = "'{$savedEvent->title}' is coming up next week on " . 
                          $eventDate->format('l, M j \a\t g:i A');
                break;

            default:
                $scheduledFor = $eventDate->copy()->subHours(2);
                $title = "Event Starting Soon!";
                $message = "'{$savedEvent->title}' starts in 2 hours at " . 
                          $eventDate->format('g:i A');
        }

        // Only schedule if the notification time is in the future
        if ($scheduledFor && $scheduledFor->isFuture()) {
            return Notification::create([
                'account_id' => $savedEvent->account_id,
                'saved_event_id' => $savedEvent->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'scheduled_for' => $scheduledFor,
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

        return Notification::create([
            'account_id' => $savedEvent->account_id,
            'saved_event_id' => $savedEvent->id,
            'type' => 'event_update',
            'title' => $title,
            'message' => $message,
            'data' => array_merge([
                'event_title' => $savedEvent->title,
                'update_type' => $updateType,
                'event_url' => $savedEvent->display_url ?? null
            ], $changes)
        ]);
    }

    public function scheduleNotificationsForSavedEvent(SavedEvent $savedEvent)
    {
        // Create multiple reminder notifications
        $this->createEventReminder($savedEvent, 'event_in_week');
        $this->createEventReminder($savedEvent, 'event_tomorrow');
        $this->createEventReminder($savedEvent, 'event_today');
        $this->createEventReminder($savedEvent, 'event_reminder');
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
        $notifications = Notification::pending()
                                   ->with(['account', 'savedEvent'])
                                   ->get();

        foreach ($notifications as $notification) {
            try {
                // Mark as sent
                $notification->update(['is_sent' => true]);

                // Here you can add email/SMS sending logic
                Log::info('Notification sent', [
                    'notification_id' => $notification->id,
                    'account_id' => $notification->account_id,
                    'type' => $notification->type,
                    'title' => $notification->title
                ]);

            } catch (\Exception $e) {
                // Revert sent status if failed
                $notification->update(['is_sent' => false]);
                
                Log::error('Failed to send notification', [
                    'notification_id' => $notification->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $notifications->count();
    }
}