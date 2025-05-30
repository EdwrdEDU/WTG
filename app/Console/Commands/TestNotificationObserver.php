<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SavedEvent;
use App\Models\Account;

class TestNotificationObserver extends Command
{
    protected $signature = 'test:notification-observer {account_id?}';
    protected $description = 'Test the SavedEvent observer by creating a test saved event';

    public function handle()
    {
        $accountId = $this->argument('account_id') ?? 1;
        
        $account = Account::find($accountId);
        if (!$account) {
            $this->error("Account with ID {$accountId} not found.");
            return 1;
        }
        
        $this->info("Testing notification observer for account: {$account->firstname} {$account->lastname}");
        
        // Create a test saved event
        $savedEvent = SavedEvent::create([
            'account_id' => $account->id,
            'title' => 'Test Event - ' . now()->format('Y-m-d H:i:s'),
            'description' => 'This is a test event to verify the notification observer is working.',
            'event_date' => now()->addDays(2),
            'venue_name' => 'Test Venue',
            'price_info' => '$10.00'
        ]);
        
        $this->info("Created test saved event with ID: {$savedEvent->id}");
        
        // Check if notifications were created
        $notifications = $account->notifications()->where('saved_event_id', $savedEvent->id)->get();
        
        $this->info("Notifications created: {$notifications->count()}");
        
        foreach ($notifications as $notification) {
            $this->line("- {$notification->type}: {$notification->title}");
        }
        
        // Test updating the event
        $this->info("\nTesting event update...");
        $savedEvent->update([
            'venue_name' => 'Updated Test Venue',
            'event_date' => now()->addDays(3)
        ]);
        
        // Check for update notifications
        $updateNotifications = $account->notifications()
                                     ->where('saved_event_id', $savedEvent->id)
                                     ->where('type', 'event_update')
                                     ->get();
        
        $this->info("Update notifications created: {$updateNotifications->count()}");
        
        foreach ($updateNotifications as $notification) {
            $this->line("- {$notification->title}: {$notification->message}");
        }
        
        // Clean up test data
        $this->info("\nCleaning up test data...");
        $account->notifications()->where('saved_event_id', $savedEvent->id)->delete();
        $savedEvent->delete();
        
        $this->info("Test completed successfully!");
        
        return 0;
    }
}