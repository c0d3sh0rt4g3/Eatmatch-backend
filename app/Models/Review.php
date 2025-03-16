<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Review",
 *     title="Review",
 *     description="Review model representing user reviews for restaurants",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="Unique review identifier"
 *     ),
 *     @OA\Property(
 *         property="restaurant_id",
 *         type="string",
 *         example="resto-123",
 *         description="ID of the restaurant being reviewed"
 *     ),
 *     @OA\Property(
 *         property="reviewer_id",
 *         type="integer",
 *         example=5,
 *         description="ID of the user who wrote the review"
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="integer",
 *         example=4,
 *         description="Rating score between 1-5"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Great food and service",
 *         description="Title of the review"
 *     ),
 *     @OA\Property(
 *         property="body",
 *         type="string",
 *         example="We had an amazing experience at this restaurant...",
 *         description="Full text content of the review"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-03-15T12:00:00Z",
 *         description="Timestamp when the review was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-03-16T08:30:00Z",
 *         description="Timestamp when the review was last updated"
 *     )
 * )
 */
class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'restaurant_id',
        'reviewer_id',
        'rating',
        'title',
        'body',
    ];

    /**
     * Get the restaurant that this review belongs to.
     * Defines an inverse one-to-many relationship where a review belongs to a single restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
