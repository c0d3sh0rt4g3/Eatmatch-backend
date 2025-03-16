<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Restaurant Review API",
 *     version="1.0.0",
 *     description="API for managing restaurant reviews"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 */
class ReviewController extends Controller
{
    /**
     * List all reviews with their restaurant data
     *
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Get all reviews",
     *     tags={"Reviews"},
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="restaurant_id", type="string", example="resto-1"),
     *                 @OA\Property(property="reviewer_id", type="integer", example=5),
     *                 @OA\Property(property="rating", type="integer", example=4),
     *                 @OA\Property(property="title", type="string", example="Great place"),
     *                 @OA\Property(property="body", type="string", example="The food was excellent"),
     *                 @OA\Property(
     *                     property="restaurant",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="resto-1"),
     *                     @OA\Property(property="name", type="string", example="Restaurant Name")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $reviews = Review::with('restaurant')->get();
        return response()->json($reviews, 200);
    }

    /**
     * Show a single review by id with restaurant data
     *
     * @OA\Get(
     *     path="/api/reviews/{id}",
     *     summary="Get a specific review",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="restaurant_id", type="string", example="resto-1"),
     *             @OA\Property(property="reviewer_id", type="integer", example=5),
     *             @OA\Property(property="rating", type="integer", example=4),
     *             @OA\Property(property="title", type="string", example="Great place"),
     *             @OA\Property(property="body", type="string", example="The food was excellent"),
     *             @OA\Property(
     *                 property="restaurant",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="resto-1"),
     *                 @OA\Property(property="name", type="string", example="Restaurant Name")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="message", type="string", example="Review not found")
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $review = Review::with('restaurant')->find($id);
        if (!$review) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Review not found'
                ]
            ], 404);
        }
        return response()->json($review, 200);
    }

    /**
     * Get reviews by reviewer ID
     *
     * @OA\Get(
     *     path="/api/reviews/reviewer/{reviewerId}",
     *     summary="Get reviews by a specific reviewer",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="reviewerId",
     *         in="path",
     *         required=true,
     *         description="Reviewer User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews by the reviewer",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="restaurant_id", type="string", example="resto-1"),
     *                 @OA\Property(property="reviewer_id", type="integer", example=5),
     *                 @OA\Property(property="rating", type="integer", example=4),
     *                 @OA\Property(property="title", type="string", example="Great place"),
     *                 @OA\Property(property="body", type="string", example="The food was excellent"),
     *                 @OA\Property(
     *                     property="restaurant",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="resto-1"),
     *                     @OA\Property(property="name", type="string", example="Restaurant Name")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid reviewer ID",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=422),
     *                 @OA\Property(property="message", type="string", example="Invalid reviewer ID"),
     *                 @OA\Property(property="details", type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function getReviewsByReviewer($reviewerId)
    {
        // Validate that the reviewer exists
        $validator = Validator::make(['reviewer_id' => $reviewerId], [
            'reviewer_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 422,
                    'message' => 'Invalid reviewer ID',
                    'details' => $validator->errors()
                ]
            ], 422);
        }

        // Get all reviews by the reviewer with related restaurant data
        $reviews = Review::with('restaurant')
            ->where('reviewer_id', $reviewerId)
            ->get();

        return response()->json($reviews, 200);
    }

    /**
     * Create a new review
     *
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Create a new review",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"restaurant_id", "reviewer_id", "rating", "title", "body"},
     *             @OA\Property(property="restaurant_id", type="string", example="resto-1"),
     *             @OA\Property(property="reviewer_id", type="integer", example=5),
     *             @OA\Property(property="rating", type="integer", example=4, description="Rating between 1-5"),
     *             @OA\Property(property="title", type="string", example="Great place"),
     *             @OA\Property(property="body", type="string", example="The food was excellent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="restaurant_id", type="string", example="resto-1"),
     *             @OA\Property(property="reviewer_id", type="integer", example=5),
     *             @OA\Property(property="rating", type="integer", example=4),
     *             @OA\Property(property="title", type="string", example="Great place"),
     *             @OA\Property(property="body", type="string", example="The food was excellent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=422),
     *                 @OA\Property(property="message", type="string", example="Validation failed"),
     *                 @OA\Property(property="details", type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'reviewer_id'   => 'required|exists:users,id',
            'rating'        => 'required|integer|min:1|max:5',
            'title'         => 'required|string|max:255',
            'body'          => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 422,
                    'message' => 'Validation failed',
                    'details' => $validator->errors()
                ]
            ], 422);
        }

        $data = $validator->validated();
        $review = Review::create($data);

        return response()->json($review, 201);
    }

    /**
     * Update an existing review
     *
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Update a review",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", example=5, description="Rating between 1-5"),
     *             @OA\Property(property="title", type="string", example="Updated title"),
     *             @OA\Property(property="body", type="string", example="Updated review content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="restaurant_id", type="string", example="resto-1"),
     *             @OA\Property(property="reviewer_id", type="integer", example=5),
     *             @OA\Property(property="rating", type="integer", example=5),
     *             @OA\Property(property="title", type="string", example="Updated title"),
     *             @OA\Property(property="body", type="string", example="Updated review content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="message", type="string", example="Review not found")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=422),
     *                 @OA\Property(property="message", type="string", example="Validation failed"),
     *                 @OA\Property(property="details", type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Review not found'
                ]
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'title'  => 'sometimes|required|string|max:255',
            'body'   => 'sometimes|required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 422,
                    'message' => 'Validation failed',
                    'details' => $validator->errors()
                ]
            ], 422);
        }

        $review->update($validator->validated());

        return response()->json($review, 200);
    }

    /**
     * Delete a review
     *
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Delete a review",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Review deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="message", type="string", example="Review not found")
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Review not found'
                ]
            ], 404);
        }

        $review->delete();

        return response()->json(null, 204);
    }
}
