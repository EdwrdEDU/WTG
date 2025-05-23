<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function show()
    {
        return view('contacts');
    }

    /**
     * Store the contact form submission
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'concern' => 'required|string|max:1000',
        ]);

        // Create the contact record
        Contact::create($validated);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}