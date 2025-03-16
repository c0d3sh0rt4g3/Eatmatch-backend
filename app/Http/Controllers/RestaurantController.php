<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Restaurant API",
 *     version="1.0.0",
 *     description="API for managing restaurant information and reviews"
 * )
 */
class RestaurantController extends Controller
{
    /**
     * List all restaurants with their reviews
     *
     * @OA\Get(
     *     path="/api/restaurants",
     *     summary="Get all restaurants with their reviews",
     *     tags={"Restaurants"},
     *     @OA\Response(
     *         response=200,
     *         description="List of restaurants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="resto-1"),
     *                 @OA\Property(property="name", type="string", example="Restaurant Name"),
     *                 @OA\Property(
     *                     property="reviews",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="rating", type="integer", example=5),
     *                         @OA\Property(property="comment", type="string", example="Great food!")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $restaurants = Restaurant::with('reviews')->get();
        return response()->json($restaurants, 200);
    }

    /**
     * Show a single restaurant by its manual id
     *
     * @OA\Get(
     *     path="/api/restaurants/{id}",
     *     summary="Get a specific restaurant with reviews",
     *     tags={"Restaurants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Restaurant ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string", example="resto-1"),
     *             @OA\Property(property="name", type="string", example="Restaurant Name"),
     *             @OA\Property(
     *                 property="reviews",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="rating", type="integer", example=5),
     *                     @OA\Property(property="comment", type="string", example="Great food!")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="message", type="string", example="Restaurant not found")
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * Create a new restaurant (restaurant id must be provided manually)
     *
     * @OA\Post(
     *     path="/api/restaurants",
     *     summary="Create a new restaurant",
     *     tags={"Restaurants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "name"},
     *             @OA\Property(property="id", type="string", example="resto-123"),
     *             @OA\Property(property="name", type="string", example="New Restaurant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurant created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string", example="resto-123"),
     *             @OA\Property(property="name", type="string", example="New Restaurant")
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
     *                 @OA\Property(
     *                     property="details",
     *                     type="object",
     *                     @OA\Property(property="id", type="array", @OA\Items(type="string", example="The id field is required.")),
     *                     @OA\Property(property="name", type="array", @OA\Items(type="string", example="The name field is required."))
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|string|unique:restaurants,id',
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
        $restaurant = Restaurant::create($data);
        return response()->json($restaurant, 201);
    }

    /**
     * Update an existing restaurant (only its name can be updated)
     *
     * @OA\Put(
     *     path="/api/restaurants/{id}",
     *     summary="Update a restaurant",
     *     tags={"Restaurants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Restaurant ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Restaurant Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string", example="resto-1"),
     *             @OA\Property(property="name", type="string", example="Updated Restaurant Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="message", type="string", example="Restaurant not found")
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
     *                 @OA\Property(
     *                     property="details",
     *                     type="object",
     *                     @OA\Property(property="name", type="array", @OA\Items(type="string", example="The name field is required."))
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * Delete a restaurant
     *
     * @OA\Delete(
     *     path="/api/restaurants/{id}",
     *     summary="Delete a restaurant",
     *     tags={"Restaurants"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Restaurant ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Restaurant deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=404),
     *                 @OA\Property(property="message", type="string", example="Restaurant not found")
     *             )
     *         )
     *     )
     * )
     */
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
}
