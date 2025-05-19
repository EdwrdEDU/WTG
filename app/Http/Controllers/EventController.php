<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
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

        $user = auth()->user();

        if (!$user || !$user->accounts) {
            return redirect()->back()->withErrors(['account' => 'Your account is not linked.']);
        }

        $data = $request->except(['account_id']);
        $data['account_id'] = $user->accounts->id;

        Event::create($data);

        return redirect()->route('books.index')->with('success', 'Event added successfully!');
    }
}


