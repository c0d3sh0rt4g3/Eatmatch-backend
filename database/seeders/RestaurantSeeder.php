<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        // Array of sample restaurants.
        $restaurants = [
            [
                'id'             => 1,
                'name'           => 'The Culinary Spot',
                'average_rating' => 0, // Initial value; can be updated based on reviews
            ],
            [
                'id'             => 2,
                'name'           => 'Food Haven',
                'average_rating' => 0,
            ],
            [
                'id'             => 3,
                'name'           => 'Gourmet Delight',
                'average_rating' => 0,
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
