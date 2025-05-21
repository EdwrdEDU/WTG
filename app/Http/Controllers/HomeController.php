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

        // List of cities with their latitudes and longitudes
        $cities = [
            'New York' => '40.7128,-74.0060',
            'Los Angeles' => '34.0522,-118.2437',
            'Chicago' => '41.8781,-87.6298',
            'San Francisco' => '37.7749,-122.4194',
        ];

        try {
            // Fetch featured events (same as before)
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

        // Loop through the cities to fetch events near each city
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

        return view('homepage', compact('interests', 'featuredEvents', 'eventsNearYou'));
    }

    public function landing()
    {
        return view('landing');
    }

    public function showInterests()
    {
        $interests = Interest::all();
        return view('interests.index', compact('interests'));
    }
    public function showInterest($id)
    {
        $interest = Interest::findOrFail($id);
        return view('interests.show', compact('interest'));
    }
}
