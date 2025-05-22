<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Interest;

class HomeController extends Controller
{
    public function index()
    {
        $interests = Interest::all();
        $featuredEvents = collect();
        $eventsNearYou = collect();
        $personalizedEvents = collect();

        // Get user's personalized events if logged in
        if (auth()->check()) {
            $userInterests = auth()->user()->interests;
            
            if ($userInterests->isNotEmpty()) {
                foreach ($userInterests->take(3) as $interest) {
                    if ($interest->ticketmaster_classification) {
                        try {
                            $response = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', [
                                'apikey' => 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R',
                                'classificationName' => $interest->ticketmaster_classification,
                                'countryCode' => 'US',
                                'size' => 4,
                                'sort' => 'date,asc'
                            ]);

                            $data = $response->json();
                            if (isset($data['_embedded']['events'])) {
                                $events = collect($data['_embedded']['events'])->map(function ($event) use ($interest) {
                                    $event['interest_category'] = $interest->name;
                                    $event['interest_color'] = $interest->color;
                                    return $event;
                                });
                                $personalizedEvents = $personalizedEvents->merge($events);
                            }
                        } catch (\Exception $e) {
                            logger()->error('Ticketmaster API error for personalized events: ' . $e->getMessage());
                        }
                    }
                }
            }
        }

        // Original featured events logic
        $cities = [
            'New York' => '40.7128,-74.0060',
            'Los Angeles' => '34.0522,-118.2437',
            'Chicago' => '41.8781,-87.6298',
            'San Francisco' => '37.7749,-122.4194',
        ];

        try {
            $response = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', [
                'apikey' => 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R', 
                'countryCode' => 'US',
                'size' => 3,
                'sort' => 'date,asc',
            ]);

            $data = $response->json();
            if (isset($data['_embedded']['events'])) {
                $featuredEvents = collect($data['_embedded']['events']);
            }
        } catch (\Exception $e) {
            logger()->error('Ticketmaster API error: ' . $e->getMessage());
        }

        foreach ($cities as $city => $latlong) {
            try {
                $eventsResponse = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', [
                    'apikey' => 'x3Vf8JCIUljRsLH2iqN6P7GgBYpJGP8R',
                    'countryCode' => 'US',
                    'size' => 4, 
                    'latlong' => $latlong, 
                ]);

                $eventsData = $eventsResponse->json();
                if (isset($eventsData['_embedded']['events'])) {
                    $eventsNearYou = $eventsNearYou->merge($eventsData['_embedded']['events']);
                }
            } catch (\Exception $e) {
                logger()->error('Ticketmaster API error for ' . $city . ': ' . $e->getMessage());
            }
        }

        return view('homepage', compact('interests', 'featuredEvents', 'eventsNearYou', 'personalizedEvents'));
    }

    public function landing()
    {
        return view('landing');
    }
}