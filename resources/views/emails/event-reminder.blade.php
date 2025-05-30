<!DOCTYPE html>
<html>
<head>
    <title>{{ $notification->title }} - WTG?</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background-color: #f9f9f9; }
        .header { background-color: #f05537; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: white; margin: 20px; border-radius: 8px; }
        .event-details { background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .button { display: inline-block; padding: 12px 24px; background-color: #f05537; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 {{ $notification->title }}</h1>
            <p>Event Reminder from WTG?</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->firstname }}!</h2>
            
            <p>{{ $notification->message }}</p>
            
            @if($event)
            <div class="event-details">
                <h3>{{ $event->title }}</h3>
                
                @if($event->event_date)
                <p><strong>📅 Date & Time:</strong> {{ $event->formatted_date }}</p>
                @endif
                
                @if($event->venue_name)
                <p><strong>📍 Venue:</strong> {{ $event->venue_name }}</p>
                @endif
                
                @if($event->venue_address)
                <p><strong>📍 Address:</strong> {{ $event->venue_address }}</p>
                @endif
                
                @if($event->price_info)
                <p><strong>💰 Price:</strong> {{ $event->price_info }}</p>
                @endif
            </div>
            
            @if($event->display_url)
            <div class="text-center">
                <a href="{{ $event->display_url }}" class="button">View Event Details</a>
            </div>
            @endif
            @endif
            
            <hr style="margin: 20px 0;">
            
            <p><small>This reminder was sent because you saved this event on WTG?. You can manage your notification preferences in your account settings.</small></p>
        </div>
        
        <div class="footer">
            <p>
                <a href="{{ route('notifications.settings') }}">Notification Preferences</a> | 
                <a href="{{ route('saved-events') }}">My Saved Events</a> | 
                <a href="{{ route('homepage') }}">WTG? Homepage</a>
            </p>
            <p>&copy; {{ date('Y') }} WTG? - Where To Go?</p>
        </div>
    </div>
</body>
</html>