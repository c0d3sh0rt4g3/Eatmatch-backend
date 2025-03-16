<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Restaurant",
 *     title="Restaurant",
 *     description="Restaurant model representing restaurant information",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="resto-123",
 *         description="Unique restaurant identifier (manually assigned)"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Delicious Bistro",
 *         description="Name of the restaurant"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-03-15T12:00:00Z",
 *         description="Timestamp when the restaurant was added to the system"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-03-16T08:30:00Z",
 *         description="Timestamp when the restaurant was last updated"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="RestaurantWithReviews",
 *     title="Restaurant with Reviews",
 *     description="Restaurant with its associated review collection",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Restaurant"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="reviews",
 *                 type="array",
 *                 description="Collection of reviews for this restaurant",
 *                 @OA\Items(ref="#/components/schemas/Review")
 *             )
 *         )
 *     }
 * )
 */
class Restaurant extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     * Set to false since restaurant IDs are manually assigned.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     * Set to string since restaurant IDs are string-based.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', // manual input for restaurant id
        'name',
    ];

    /**
     * Get the reviews associated with this restaurant.
     * Defines a one-to-many relationship where a restaurant can have multiple reviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
