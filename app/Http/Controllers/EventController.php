<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // Your existing search method
        $query = $request->input('event');
        $location = $request->input('location');
        $searchResults = collect();
        
        try {
            $params = [
                'apikey' => 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R',
                'countryCode' => 'US',
                'size' => 20,
            ];
            
            if ($query) {
                $params['keyword'] = $query;
            }
            
            if ($location) {
                $params['city'] = $location;
            }
            
            $response = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', $params);
            
            $data = $response->json();
            if (isset($data['_embedded']['events'])) {
                $searchResults = collect($data['_embedded']['events']);
            }
        } catch (\Exception $e) {
            logger()->error('Ticketmaster API search error: ' . $e->getMessage());
        }
        
        return view('account-view.search-page', compact('searchResults', 'query', 'location'));
    }
}