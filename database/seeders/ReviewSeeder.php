<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');
        $destinationIds = Destination::pluck('id');

        $reviews = [
            [
                'user_id' => $userIds->random(),
                'destination_id' => $destinationIds->random(),
                'rating' => 5,
                'review' => 'Amazing place to visit!'
            ],
            [
                'user_id' => $userIds->random(),
                'destination_id' => $destinationIds->random(),
                'rating' => 4,
                'review' => 'Great experience, but could be better.'
            ],
            [
                'user_id' => $userIds->random(),
                'destination_id' => $destinationIds->random(),
                'rating' => 3,
                'review' => 'It was okay, nothing special.'
            ],
            [
                'user_id' => $userIds->random(),
                'destination_id' => $destinationIds->random(),
                'rating' => 2,
                'review' => 'Not worth the visit.'
            ],
            [
                'user_id' => $userIds->random(),
                'destination_id' => $destinationIds->random(),
                'rating' => 1,
                'review' => 'Terrible experience!'
            ]
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
