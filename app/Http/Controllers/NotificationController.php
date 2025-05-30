<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }

    /**
     * Display all notifications for the authenticated user
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
                             ->with('savedEvent')
                             ->latest()
                             ->paginate(20);

        $unreadCount = Auth::user()->unread_notifications_count;

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Get unread notifications for AJAX requests
     */
    public function getUnread()
    {
        try {
            $notifications = $this->notificationService->getUnreadNotifications(Auth::user(), 10);

            return response()->json([
                'success' => true,
                'notifications' => $notifications->map(function($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'created_at' => $notification->created_at->toISOString(),
                        'saved_event' => $notification->savedEvent ? [
                            'id' => $notification->savedEvent->id,
                            'title' => $notification->savedEvent->title,
                            'display_url' => $notification->savedEvent->display_url
                        ] : null
                    ];
                }),
                'count' => $notifications->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching unread notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load notifications'
            ], 500);
        }
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead(Notification $notification)
    {
        try {
            // Ensure user can only mark their own notifications as read
            if ($notification->account_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read for the authenticated user
     */
    public function markAllAsRead()
    {
        try {
            $count = $this->notificationService->markAllAsRead(Auth::user());

            return response()->json([
                'success' => true,
                'message' => "Marked {$count} notifications as read",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }

    /**
     * Delete a specific notification
     */
    public function destroy(Notification $notification)
    {
        try {
            // Ensure user can only delete their own notifications
            if ($notification->account_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification'
            ], 500);
        }
    }

    /**
     * Show notification settings page
     */
    public function settings()
    {
        $user = Auth::user();
        
        // Get user's notification preferences (with defaults)
        $preferences = $user->notification_preferences ?? ['day_before', 'day_of', 'two_hours_before', 'event_changes'];
        $delivery = $user->notification_delivery ?? ['in_app'];
        
        // Get notification statistics
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'this_week' => $user->notifications()->where('created_at', '>=', now()->startOfWeek())->count()
        ];
        
        return view('notifications.settings', compact('preferences', 'delivery', 'stats'));
    }

    /**
     * Update notification settings
     */
    public function updateSettings(Request $request)
    {
        try {
            $request->validate([
                'preferences' => 'array',
                'preferences.*' => 'string|in:week_before,day_before,day_of,two_hours_before,event_changes,event_cancellations',
                'delivery' => 'array',
                'delivery.*' => 'string|in:in_app,email',
                'notifications_enabled' => 'boolean'
            ]);
            
            $user = Auth::user();
            $user->update([
                'notification_preferences' => $request->preferences ?? [],
                'notification_delivery' => $request->delivery ?? ['in_app'],
                'notifications_enabled' => $request->has('notifications_enabled')
            ]);
            
            return redirect()->back()->with('success', 'Notification preferences updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating notification settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update notification preferences.');
        }
    }

    /**
     * Send a test notification
     */
    public function test()
    {
        try {
            $user = Auth::user();
            
            Notification::create([
                'account_id' => $user->id,
                'type' => 'test',
                'title' => 'Test Notification',
                'message' => 'This is a test notification to verify your notification system is working correctly. If you can see this, everything is set up properly!',
                'data' => [
                    'test' => true,
                    'timestamp' => now()->toISOString()
                ]
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Test notification created successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating test notification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create test notification'
            ], 500);
        }
    }

    /**
     * Clear all notifications for the authenticated user
     */
    public function clearAll()
    {
        try {
            $user = Auth::user();
            $count = $user->notifications()->count();
            $user->notifications()->delete();
            
            return redirect()->back()->with('success', "Cleared {$count} notifications successfully!");
        } catch (\Exception $e) {
            Log::error('Error clearing all notifications: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to clear notifications.');
        }
    }

    /**
     * Get notification statistics (for dashboard/API)
     */
    public function getStats()
    {
        try {
            $user = Auth::user();
            
            $stats = [
                'total' => $user->notifications()->count(),
                'unread' => $user->unreadNotifications()->count(),
                'read' => $user->notifications()->whereNotNull('read_at')->count(),
                'this_week' => $user->notifications()->where('created_at', '>=', now()->startOfWeek())->count(),
                'this_month' => $user->notifications()->where('created_at', '>=', now()->startOfMonth())->count(),
                'types' => $user->notifications()
                    ->selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type')
                    ->toArray()
            ];
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting notification stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load notification statistics'
            ], 500);
        }
    }
}