<?php

namespace App\Http\Controllers;

use App\Models\SavedEvent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display saved events
     */
    public function index()
    {
        $savedEvents = Auth::user()->savedEvents()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('saved-events.index', compact('savedEvents'));
    }

    /**
     * Save a local event
     */
    public function saveLocalEvent(Request $request, Event $event)
    {
        try {
            $user = Auth::user();
            
            // Check if already saved
            if ($user->hasSavedEvent($event->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event already saved!'
                ]);
            }

            $user->saveEvent($event->id);

            return response()->json([
                'success' => true,
                'message' => 'Event saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save event. Please try again.'
            ], 500);
        }
    }

    /**
     * Save an external event (from Ticketmaster API)
     */
    public function saveExternalEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'required|string',
            'event_name' => 'required|string',
            'event_url' => 'nullable|url',
            'event_image' => 'nullable|url',
            'event_date' => 'nullable|string',
            'venue_name' => 'nullable|string',
            'venue_address' => 'nullable|string',
            'price_info' => 'nullable|string'
        ]);

        try {
            $user = Auth::user();
            
            // Check if already saved
            if ($user->hasSavedExternalEvent($request->event_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event already saved!'
                ]);
            }

            // Create the event data structure
            $eventData = [
                'id' => $request->event_id,
                'name' => $request->event_name,
                'url' => $request->event_url,
                'images' => $request->event_image ? [['url' => $request->event_image]] : [],
                'dates' => $request->event_date ? ['start' => ['dateTime' => $request->event_date]] : [],
                '_embedded' => [
                    'venues' => [[
                        'name' => $request->venue_name ?? 'Venue TBA',
                        'address' => ['line1' => $request->venue_address]
                    ]]
                ]
            ];

            if ($request->price_info) {
                $eventData['priceRanges'] = [['min' => $request->price_info, 'max' => $request->price_info, 'currency' => '']];
            }

            $user->saveExternalEvent($eventData);

            return response()->json([
                'success' => true,
                'message' => 'Event saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save event. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove a saved event
     */
    public function destroy(SavedEvent $savedEvent)
    {
        try {
            // Make sure user owns this saved event
            if ($savedEvent->account_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            $savedEvent->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event removed from saved list!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove event. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove a local event from saved list
     */
    public function unsaveLocalEvent(Event $event)
    {
        try {
            $user = Auth::user();
            $removed = $user->unsaveEvent($event->id);

            if ($removed) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event removed from saved list!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Event was not in your saved list.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove event. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove an external event from saved list
     */
    public function unsaveExternalEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'required|string'
        ]);

        try {
            $user = Auth::user();
            $removed = $user->unsaveExternalEvent($request->event_id);

            if ($removed) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event removed from saved list!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Event was not in your saved list.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove event. Please try again.'
            ], 500);
        }
    }

    /**
     * Check if an event is saved
     */
    public function checkSaved(Request $request)
    {
        $request->validate([
            'event_id' => 'required|string',
            'type' => 'required|in:local,external'
        ]);

        $user = Auth::user();
        
        if ($request->type === 'local') {
            $isSaved = $user->hasSavedEvent($request->event_id);
        } else {
            $isSaved = $user->hasSavedExternalEvent($request->event_id);
        }

        return response()->json([
            'saved' => $isSaved
        ]);
    }
}