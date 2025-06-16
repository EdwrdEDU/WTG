<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class CheckNotifications extends Command
{
    protected $signature = 'notifications:check';
    protected $description = 'Check for due notifications and send them';

    public function handle(NotificationService $notificationService)
    {
        $this->info('Checking for due notifications...');
        
        $sent = $notificationService->sendPendingNotifications();
        
        $this->info("Sent {$sent} notifications");
    }
}