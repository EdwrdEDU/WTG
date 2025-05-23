<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http; 
use Carbon\Carbon;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['search']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'event_type' => 'required|in:in-person,online,hybrid',
            'image' => 'required|image|max:2048',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'venue_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'ticket_name' => 'required|string|max:255',
            'ticket_quantity' => 'required|integer|min:0',
            'ticket_price' => 'required|numeric|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['account_id'] = auth()->id();

        Event::create($validated);

        return redirect('/my-events')->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        // Make sure user can only edit their own events
        if ($event->account_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Make sure user can only update their own events
        if ($event->account_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'event_type' => 'required|in:in-person,online,hybrid',
            'image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'venue_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'ticket_name' => 'required|string|max:255',
            'ticket_quantity' => 'required|integer|min:0',
            'ticket_price' => 'required|numeric|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        $event->update($validated);

        return redirect('/my-events')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        // Make sure user can only delete their own events
        if ($event->account_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated image
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect('/my-events')->with('success', 'Event deleted successfully!');
    }

   public function search(Request $request)
    {
        // Get search parameters
        $query = $request->input('event');
        $location = $request->input('location');
        $category = $request->input('category');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        
        // Initialize collections
        $externalEvents = collect();
        $localEvents = collect();
        
        // 1. Search external events from Ticketmaster API
        try {
            $params = [
                'apikey' => 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R',
                'countryCode' => 'US',
                'size' => 20,
            ];
            
            // Add search parameters if provided
            if ($query) {
                $params['keyword'] = $query;
            }
            
            if ($location) {
                $params['city'] = $location;
            }
            
            if ($category) {
                $params['classificationName'] = $category;
            }
            
            if ($startDate) {
                $params['startDateTime'] = Carbon::parse($startDate)->format('Y-m-d').'T00:00:00Z';
            }
            
            if ($endDate) {
                $params['endDateTime'] = Carbon::parse($endDate)->format('Y-m-d').'T23:59:59Z';
            }
            
            // Execute the API request
            $response = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', $params);
            
            // Check if we got successful results
            $data = $response->json();
            if (isset($data['_embedded']['events'])) {
                $externalEvents = collect($data['_embedded']['events'])->map(function($event) {
                    // Add a type field to distinguish between external and local events
                    $event['event_type'] = 'external';
                    return $event;
                });
            }
        } catch (\Exception $e) {
            logger()->error('Ticketmaster API search error: ' . $e->getMessage());
        }
        
        // 2. Search local events from database
        try {
            $eventsQuery = Event::query();
            
            // Apply search filters
            if ($query) {
                $eventsQuery->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('organizer', 'like', "%{$query}%");
                });
            }
            
            if ($location) {
                $eventsQuery->where(function($q) use ($location) {
                    $q->where('venue_name', 'like', "%{$location}%")
                      ->orWhere('address', 'like', "%{$location}%");
                });
            }
            
            if ($category) {
                $eventsQuery->where('category_id', $category);
            }
            
            if ($startDate) {
                $eventsQuery->where('start_date', '>=', $startDate);
            }
            
            if ($endDate) {
                $eventsQuery->where('start_date', '<=', $endDate);
            }
            
            if ($priceMin !== null) {
                $eventsQuery->where('ticket_price', '>=', $priceMin);
            }
            
            if ($priceMax !== null) {
                $eventsQuery->where('ticket_price', '<=', $priceMax);
            }
            
            // Get results and transform them to match the format
            $localEvents = $eventsQuery->with('account')->get()->map(function($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->title,
                    'description' => $event->description,
                    'url' => route('events.show', $event),
                    'images' => [
                        [
                            'url' => $event->image ? asset('storage/' . $event->image) : asset('images/default-image.jpg')
                        ]
                    ],
                    'dates' => [
                        'start' => [
                            'localDate' => $event->start_date,
                            'dateTime' => $event->start_date . ' ' . $event->start_time,
                        ]
                    ],
                    '_embedded' => [
                        'venues' => [
                            [
                                'name' => $event->venue_name ?? 'Venue TBA',
                                'address' => [
                                    'line1' => $event->address ?? ''
                                ]
                            ]
                        ]
                    ],
                    'priceRanges' => [
                        [
                            'min' => $event->ticket_price,
                            'max' => $event->ticket_price,
                            'currency' => 'USD'
                        ]
                    ],
                    'organizer' => $event->organizer,
                    'event_type' => 'local',
                    'local_event_id' => $event->id,
                    'creator' => $event->account ? $event->account->firstname . ' ' . $event->account->lastname : 'Unknown'
                ];
            });
        } catch (\Exception $e) {
            logger()->error('Local database search error: ' . $e->getMessage());
        }
        
        // 3. Merge results and sort by date
        $allEvents = $externalEvents->merge($localEvents);
        
        // Sort by date (most recent first)
        $sortedEvents = $allEvents->sortBy(function($event) {
            if (isset($event['dates']['start']['dateTime'])) {
                return Carbon::parse($event['dates']['start']['dateTime'])->timestamp * -1;
            }
            return 0;
        });
        
        // Prepare search info for the view
        $searchInfo = [
            'query' => $query,
            'location' => $location,
            'category' => $category,
            'totalResults' => $sortedEvents->count(),
            'externalResults' => $externalEvents->count(),
            'localResults' => $localEvents->count(),
        ];
        
        // Return the view with search results
        return view('account-view.search-page', [
            'searchResults' => $sortedEvents,
            'searchInfo' => $searchInfo,
            'query' => $query,
            'location' => $location
        ]);
    }
}
