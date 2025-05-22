<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InterestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userInterests = Auth::user()->interests->pluck('id')->toArray();
        $allInterests = Interest::all();
        
        return view('interests.index', compact('userInterests', 'allInterests'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'interests' => 'required|array',
            'interests.*' => 'exists:interests,id'
        ]);

        $user = Auth::user();
        $user->interests()->sync($request->interests);

        return response()->json([
            'success' => true,
            'message' => 'Interests saved successfully!',
            'count' => count($request->interests)
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'interest_id' => 'required|exists:interests,id'
        ]);

        $user = Auth::user();
        $interest = Interest::find($request->interest_id);
        
        if ($user->interests()->where('interest_id', $interest->id)->exists()) {
            // Remove interest
            $user->interests()->detach($interest->id);
            $attached = false;
        } else {
            // Add interest
            $user->interests()->attach($interest->id);
            $attached = true;
        }

        return response()->json([
            'success' => true,
            'attached' => $attached,
            'message' => $attached ? 'Interest added!' : 'Interest removed!'
        ]);
    }

    public function getRecommendedEvents()
    {
        $user = Auth::user();
        $userInterests = $user->interests;
        
        if ($userInterests->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Please select some interests first!',
                'events' => []
            ]);
        }

        $allEvents = collect();
        
        foreach ($userInterests as $interest) {
            if ($interest->ticketmaster_classification) {
                try {
                    $response = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', [
                        'apikey' => 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R',
                        'classificationName' => $interest->ticketmaster_classification,
                        'countryCode' => 'US',
                        'size' => 10,
                        'sort' => 'date,asc'
                    ]);

                    $data = $response->json();
                    if (isset($data['_embedded']['events'])) {
                        $events = collect($data['_embedded']['events'])->map(function ($event) use ($interest) {
                            $event['interest_category'] = $interest->name;
                            $event['interest_color'] = $interest->color;
                            return $event;
                        });
                        $allEvents = $allEvents->merge($events);
                    }
                } catch (\Exception $e) {
                    logger()->error('Ticketmaster API error for interest ' . $interest->name . ': ' . $e->getMessage());
                }
            }
        }

        // Remove duplicates and limit results
        $uniqueEvents = $allEvents->unique('id')->take(20);

        return response()->json([
            'success' => true,
            'events' => $uniqueEvents,
            'total' => $uniqueEvents->count()
        ]);
    }
}