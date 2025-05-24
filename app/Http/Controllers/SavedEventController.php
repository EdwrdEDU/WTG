<?php

namespace App\Http\Controllers;

use App\Models\SavedEvent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            Log::error('Error saving local event: ' . $e->getMessage());
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
        try {
            // Add debug logging
            Log::info('saveExternalEvent called', ['request_data' => $request->all()]);
            
            $validated = $request->validate([
                'event_id' => 'required|string',
                'event_name' => 'required|string',
                'event_url' => 'nullable|string',
                'event_image' => 'nullable|string',
                'event_date' => 'nullable|string',
                'venue_name' => 'nullable|string',
                'venue_address' => 'nullable|string',
                'price_info' => 'nullable|string'
            ]);

            $user = Auth::user();
            
            // Check if already saved
            if ($user->hasSavedExternalEvent($validated['event_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event already saved!'
                ]);
            }

            // Create the event data structure
            $eventData = [
                'id' => $validated['event_id'],
                'name' => $validated['event_name'],
                'url' => $validated['event_url'] ?? null,
                'images' => $validated['event_image'] ? [['url' => $validated['event_image']]] : [],
                'dates' => $validated['event_date'] ? ['start' => ['dateTime' => $validated['event_date']]] : [],
                '_embedded' => [
                    'venues' => [[
                        'name' => $validated['venue_name'] ?? 'Venue TBA',
                        'address' => ['line1' => $validated['venue_address'] ?? null]
                    ]]
                ]
            ];

            if ($validated['price_info']) {
                $eventData['priceRanges'] = [['min' => $validated['price_info'], 'max' => $validated['price_info'], 'currency' => '']];
            }

            $user->saveExternalEvent($eventData);

            Log::info('External event saved successfully', ['event_id' => $validated['event_id']]);

            return response()->json([
                'success' => true,
                'message' => 'Event saved successfully!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error saving external event: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Invalid event data provided.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saving external event: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save event. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove a saved event
     */
    public function destroy(Request $request, $id)
    {
        try {
            $savedEvent = SavedEvent::where('id', $id)
                ->where('account_id', Auth::id())
                ->first();

            if (!$savedEvent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action or event not found.'
                ], 403);
            }

            $savedEvent->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event removed from saved list!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing saved event: ' . $e->getMessage());
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
            Log::error('Error unsaving local event: ' . $e->getMessage());
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
        try {
            $validated = $request->validate([
                'event_id' => 'required|string'
            ]);

            $user = Auth::user();
            $removed = $user->unsaveExternalEvent($validated['event_id']);

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
            Log::error('Error unsaving external event: ' . $e->getMessage());
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
        try {
            $validated = $request->validate([
                'event_id' => 'required|string',
                'type' => 'required|in:local,external'
            ]);

            $user = Auth::user();
            
            if ($validated['type'] === 'local') {
                $isSaved = $user->hasSavedEvent($validated['event_id']);
            } else {
                $isSaved = $user->hasSavedExternalEvent($validated['event_id']);
            }

            return response()->json([
                'saved' => $isSaved
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking saved status: ' . $e->getMessage());
            return response()->json([
                'saved' => false
            ], 500);
        }
    }
}