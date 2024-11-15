<?php

namespace Database\Seeders;

use App\Models\Destination;
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
                'description' => 'A stunning tropical paradise featuring white sand beaches, clear turquoise waters, and vibrant coral reefs. Known for its surfing spots, luxurious resorts, and lively beach clubs, Bali Beach offers unforgettable sunset views and a vibrant nightlife.',
                'province' => 'Bali',
                'city' => 'Denpasar',
                'budget' => 1000000,
                'facility' => 'Restaurants, Surfing Schools, Beach Clubs, Resorts',
            ],
            [
                'name' => 'Jakarta Old Town',
                'description' => 'A historical area in Jakarta filled with Dutch colonial buildings, museums, and art galleries. Known as "Kota Tua," this destination showcases the rich cultural heritage of Indonesia’s capital with landmarks like Fatahillah Square, the Jakarta History Museum, and traditional street vendors.',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'budget' => 500000,
                'facility' => 'Museums, Cafes, Art Galleries, Souvenir Shops',
            ],
            [
                'name' => 'Mount Rinjani',
                'description' => 'A majestic volcanic peak in Lombok, offering challenging trekking trails and breathtaking views from the summit. Known for its crater lake, Segara Anak, and natural hot springs, Mount Rinjani attracts adventurers and nature lovers from around the world.',
                'province' => 'West Nusa Tenggara',
                'city' => 'Lombok',
                'budget' => 750000,
                'facility' => 'Camping Grounds, Trekking Services, Guides',
            ],
            [
                'name' => 'Yogyakarta Palace',
                'description' => 'The royal palace complex, known as Kraton, which serves as a cultural hub and the residence of the Sultan. Visitors can experience Javanese traditions, admire intricate architecture, and explore exhibits showcasing traditional artifacts and the region’s rich history.',
                'province' => 'Yogyakarta',
                'city' => 'Yogyakarta',
                'budget' => 300000,
                'facility' => 'Guided Tours, Museums, Cultural Performances, Souvenir Shops',
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
