<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    public function run()
    {
        $interests = [
            [
                'name' => 'Music',
                'category' => 'Entertainment',
                'ticketmaster_classification' => 'Music',
                'icon' => 'bi-music-note-beamed',
                'color' => '#10b981'
            ],
            [
                'name' => 'Comedy',
                'category' => 'Entertainment',
                'ticketmaster_classification' => 'Comedy',
                'icon' => 'bi-emoji-laughing',
                'color' => '#f59e0b'
            ],
            [
                'name' => 'Sports',
                'category' => 'Sports',
                'ticketmaster_classification' => 'Sports',
                'icon' => 'bi-bicycle',
                'color' => '#ef4444'
            ],
            [
                'name' => 'Theatre',
                'category' => 'Arts',
                'ticketmaster_classification' => 'Theatre',
                'icon' => 'bi-mask',
                'color' => '#8b5cf6'
            ],
            [
                'name' => 'Arts & Culture',
                'category' => 'Arts',
                'ticketmaster_classification' => 'Arts & Theatre',
                'icon' => 'bi-palette',
                'color' => '#ec4899'
            ],
            [
                'name' => 'Family',
                'category' => 'Family',
                'ticketmaster_classification' => 'Family',
                'icon' => 'bi-house-heart',
                'color' => '#06b6d4'
            ],
            [
                'name' => 'Food & Drink',
                'category' => 'Lifestyle',
                'ticketmaster_classification' => 'Miscellaneous',
                'icon' => 'bi-cup-hot',
                'color' => '#84cc16'
            ],
            [
                'name' => 'Film',
                'category' => 'Entertainment',
                'ticketmaster_classification' => 'Film',
                'icon' => 'bi-film',
                'color' => '#6366f1'
            ],
            [
                'name' => 'Technology',
                'category' => 'Education',
                'ticketmaster_classification' => 'Miscellaneous',
                'icon' => 'bi-cpu',
                'color' => '#0ea5e9'
            ],
            [
                'name' => 'Health & Wellness',
                'category' => 'Lifestyle',
                'ticketmaster_classification' => 'Miscellaneous',
                'icon' => 'bi-heart-pulse',
                'color' => '#14b8a6'
            ],
            [
                'name' => 'Education',
                'category' => 'Education',
                'ticketmaster_classification' => 'Miscellaneous',
                'icon' => 'bi-book',
                'color' => '#f97316'
            ],
            [
                'name' => 'Travel',
                'category' => 'Lifestyle',
                'ticketmaster_classification' => 'Miscellaneous',
                'icon' => 'bi-airplane',
                'color' => '#64748b'
            ]
        ];

        foreach ($interests as $interest) {
            Interest::updateOrCreate(
                ['name' => $interest['name']],
                $interest
            );
        }
    }
}