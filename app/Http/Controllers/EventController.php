<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
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
            'tickets' => 'nullable|json',
        ]);

        Event::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }
}
