<x-layout>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Notification Preferences</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('notifications.settings.update') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <h6>Event Reminders</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="week_before" name="preferences[]" value="week_before" 
                                           {{ in_array('week_before', $preferences ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="week_before">
                                        One week before event
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="day_before" name="preferences[]" value="day_before"
                                           {{ in_array('day_before', $preferences ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="day_before">
                                        One day before event
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="day_of" name="preferences[]" value="day_of"
                                           {{ in_array('day_of', $preferences ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="day_of">
                                        Day of event (morning reminder)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="two_hours_before" name="preferences[]" value="two_hours_before"
                                           {{ in_array('two_hours_before', $preferences ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="two_hours_before">
                                        Two hours before event
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h6>Event Updates</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="event_changes" name="preferences[]" value="event_changes"
                                           {{ in_array('event_changes', $preferences ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="event_changes">
                                        Notify me when saved events are updated
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="event_cancellations" name="preferences[]" value="event_cancellations"
                                           {{ in_array('event_cancellations', $preferences ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="event_cancellations">
                                        Notify me when saved events are cancelled
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h6>Delivery Method</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="in_app" name="delivery[]" value="in_app"
                                           {{ in_array('in_app', $delivery ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="in_app">
                                        In-app notifications
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email" name="delivery[]" value="email"
                                           {{ in_array('email', $delivery ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email">
                                        Email notifications
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm">
                                View All Notifications
                            </a>
                            <button class="btn btn-outline-secondary btn-sm" onclick="testNotification()">
                                Send Test Notification
                            </button>
                            <form action="{{ route('notifications.clear-all') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                        onclick="return confirm('Are you sure you want to clear all notifications?')">
                                    Clear All Notifications
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h6>Notification Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h4 mb-0 text-primary">{{ $stats['total'] ?? 0 }}</div>
                                <small class="text-muted">Total</small>
                            </div>
                            <div class="col-6">
                                <div class="h4 mb-0 text-warning">{{ $stats['unread'] ?? 0 }}</div>
                                <small class="text-muted">Unread</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function testNotification() {
        fetch('/notifications/test', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Test notification sent! Check your notifications.');
                updateNotificationBadge();
            }
        })
        .catch(error => console.error('Error sending test notification:', error));
    }
    </script>
</x-layout>