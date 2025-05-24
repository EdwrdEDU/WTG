<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function show()
    {
        return view('contacts.index');
    }

    /**
     * Store the contact form submission and send email
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
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'concern.required' => 'Please tell us how we can help you.',
        ]);

        try {
            // Save to database
            $contact = Contact::create($validated);
            Log::info('Contact form saved to database', ['contact_id' => $contact->id]);

            // Send email notification to your Gmail
            $contactEmail = env('CONTACT_EMAIL', 'your-default@gmail.com');
            Mail::to($contactEmail)->send(new ContactFormSubmitted($validated));
            Log::info('Contact form email sent', ['to' => $contactEmail]);

            // Redirect back with success message
            return redirect()->back()->with('success', 
                'Thank you for your message, ' . $validated['first_name'] . '! We\'ve received your inquiry and will get back to you soon. A notification has been sent to our team.'
            );
            
        } catch (\Exception $e) {
            // Log the detailed error
            Log::error('Contact form submission error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Try to save to database even if email fails
            try {
                Contact::create($validated);
                return redirect()->back()->with('success', 
                    'Your message has been saved! However, there was an issue sending the email notification. We\'ll still review your message soon.'
                );
            } catch (\Exception $dbError) {
                Log::error('Database save also failed: ' . $dbError->getMessage());
            }
            
            // Return with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, there was a problem submitting your message. Please try again or contact us directly at ' . env('CONTACT_EMAIL', 'contact@wtg.com'));
        }
    }
}