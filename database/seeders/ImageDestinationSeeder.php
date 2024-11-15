<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImageDestination;

class ImageDestinationSeeder extends Seeder
{
    public function run(): void
    {
        $imageDestinations = [
            // Bali Beach Images
            [
                'destination_id' => 1,
                'path' => 'destinations/bali-beach-1.jpg'
            ],
            [
                'destination_id' => 1,
                'path' => 'destinations/bali-beach-2.jpg'
            ],
            [
                'destination_id' => 1,
                'path' => 'destinations/bali-beach-3.jpg'
            ],

            // Jakarta Old Town Images
            [
                'destination_id' => 2,
                'path' => 'destinations/jakarta-oldtown-1.jpg'
            ],
            [
                'destination_id' => 2,
                'path' => 'destinations/jakarta-oldtown-2.jpg'
            ],
            [
                'destination_id' => 2,
                'path' => 'destinations/jakarta-oldtown-3.jpg'
            ],

            // Mount Rinjani Images
            [
                'destination_id' => 3,
                'path' => 'destinations/rinjani-1.jpg'
            ],
            [
                'destination_id' => 3,
                'path' => 'destinations/rinjani-2.jpg'
            ],
            [
                'destination_id' => 3,
                'path' => 'destinations/rinjani-3.jpg'
            ],

            // Yogyakarta Palace Images
            [
                'destination_id' => 4,
                'path' => 'destinations/yogyakarta-palace-1.jpg'
            ],
            [
                'destination_id' => 4,
                'path' => 'destinations/yogyakarta-palace-2.jpg'
            ],
            [
                'destination_id' => 4,
                'path' => 'destinations/yogyakarta-palace-3.jpg'
            ],
        ];

        foreach ($imageDestinations as $image) {
            ImageDestination::create($image);
        }
    }
}
