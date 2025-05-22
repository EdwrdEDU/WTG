<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

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

        $validated['account_id'] = auth()->id();

        Event::create($validated);

        return redirect('/home')->with('success', 'Event created!');
    }
}


