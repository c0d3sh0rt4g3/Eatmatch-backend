<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // List all reviews
    public function index()
    {
        $reviews = Review::with('restaurant')->get();
        return response()->json($reviews, 200);
    }

    // Show a single review by id
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

    // Create a new review
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

    // Update an existing review
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

    // Delete a review
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
