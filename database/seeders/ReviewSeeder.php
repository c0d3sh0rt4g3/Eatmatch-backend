<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Create an array of sample reviews
        $reviews = [
            [
                'reviewer_id' => 1,
                'rating'      => 5,
                'title'       => 'Outstanding Experience',
                'body'        => 'The product exceeded my expectations!',
            ],
            [
                'reviewer_id' => 1,
                'rating'      => 4,
                'title'       => 'Very Good!',
                'body'        => 'I enjoyed using the product; only minor issues were present.',
            ],
            [
                'reviewer_id' => 1,
                'rating'      => 3,
                'title'       => 'It was okay',
                'body'        => 'The performance was average with a few bumps along the way.',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
