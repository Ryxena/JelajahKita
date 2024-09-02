<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Bali Beach',
                'description' => 'A beautiful beach in Bali.',
                'province' => 'Bali',
                'city' => 'Denpasar'
            ],
            [
                'name' => 'Jakarta Old Town',
                'description' => 'Historical area in Jakarta.',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta'
            ],
            [
                'name' => 'Mount Rinjani',
                'description' => 'A popular trekking destination in Lombok.',
                'province' => 'West Nusa Tenggara',
                'city' => 'Lombok'
            ],
            [
                'name' => 'Yogyakarta Palace',
                'description' => 'The royal palace in Yogyakarta.',
                'province' => 'Yogyakarta',
                'city' => 'Yogyakarta'
            ]
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
