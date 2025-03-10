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
                'name'           => 'The Culinary Spot'
            ],
            [
                'id'             => 2,
                'name'           => 'Food Haven'
            ],
            [
                'id'             => 3,
                'name'           => 'Gourmet Delight'
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
