<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Restaurant;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Array of sample reviews including the restaurant_id field.
        $reviews = [
            [
                'reviewer_id'   => 1,
                'restaurant_id' => 1, // Associates review with restaurant id 1
                'rating'        => 5,
                'title'         => 'Outstanding Experience',
                'body'          => 'The product exceeded my expectations!',
            ],
            [
                'reviewer_id'   => 1,
                'restaurant_id' => 1,
                'rating'        => 4,
                'title'         => 'Very Good!',
                'body'          => 'I enjoyed using the product; only minor issues were present.',
            ],
            [
                'reviewer_id'   => 1,
                'restaurant_id' => 1,
                'rating'        => 3,
                'title'         => 'It was okay',
                'body'          => 'The performance was average with a few bumps along the way.',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }

        // Optionally recalculate and update the restaurant's average rating after seeding reviews.
        $restaurant = Restaurant::find(1);
        if ($restaurant) {
            $restaurant->average_rating = (float) $restaurant->reviews()->avg('rating');
            $restaurant->save();
        }
    }
}
