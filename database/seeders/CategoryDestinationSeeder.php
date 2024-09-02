<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinationIds = Destination::pluck('id');
        $categoryIds = Category::pluck('id');

        foreach ($destinationIds as $destinationId) {
            $randomCategoryIds = $categoryIds->random(rand(1, $categoryIds->count()))->all();
            Destination::find($destinationId)->categories()->attach($randomCategoryIds);
        }
    }
}
