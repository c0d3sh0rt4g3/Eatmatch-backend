<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    // List all restaurants with their reviews
    public function index()
    {
        $restaurants = Restaurant::with('reviews')->get();
        return response()->json($restaurants, 200);
    }

    // Show a single restaurant by its manual id
    public function show($id)
    {
        $restaurant = Restaurant::with('reviews')->find($id);
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Restaurant not found'
                ]
            ], 404);
        }
        return response()->json($restaurant, 200);
    }

    // Create a new restaurant (restaurant id must be provided manually)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer|unique:restaurants,id',
            'name' => 'required|string'
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
        // Initialize average rating at 0 when the restaurant is created.
        $data['average_rating'] = 0;
        $restaurant = Restaurant::create($data);
        return response()->json($restaurant, 201);
    }

    // Update an existing restaurant (only its name can be updated)
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Restaurant not found'
                ]
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string'
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

        $restaurant->update($validator->validated());
        return response()->json($restaurant, 200);
    }

    // Delete a restaurant
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Restaurant not found'
                ]
            ], 404);
        }
        $restaurant->delete();
        return response()->json(null, 204);
    }

    // Optional: Update average rating using the associated reviews.
    // This endpoint could be called after adding or updating a review.
    public function updateAverageRating($id)
    {
        $restaurant = Restaurant::with('reviews')->find($id);
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 404,
                    'message' => 'Restaurant not found'
                ]
            ], 404);
        }
        $average = $restaurant->reviews->avg('rating');
        $restaurant->average_rating = $average ?: 0;
        $restaurant->save();
        return response()->json($restaurant, 200);
    }
}
