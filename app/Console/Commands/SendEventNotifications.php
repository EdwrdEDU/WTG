<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendEventNotifications extends Command
{
    protected $signature = 'notifications:send-event-reminders';
    protected $description = 'Send pending event notifications to users';

    public function handle(NotificationService $notificationService)
    {
        $this->info('Sending pending event notifications...');
        
        $count = $notificationService->sendPendingNotifications();
        
        $this->info("Sent {$count} notifications");
        
        return 0;
    }
}
