<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the incoming request data using the Validator facade.
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string'
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

        // Retrieve the user by the provided email.
        $user = User::where('email', $data['email'])->first();

        // Check if user exists and if the password is correct.
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'error'  => [
                    'code'    => 401,
                    'message' => 'Incorrect username or password'
                ]
            ], 401);
        }

        // Create a token for the user (using Laravel Sanctum).
        $token = $user->createToken('apiToken')->plainTextToken;

        // Return the user and the token.
        return response()->json([
            'user'  => $user,
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        // Validate the incoming request data.
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password'
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

        // Create the new user with a hashed password.
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Optional: Issue an API token using Laravel Sanctum.
        $token = $user->createToken('apiToken')->plainTextToken;

        // Return the newly created user along with the token.
        return response()->json([
            'user'  => $user,
            'token' => $token
        ], 201);
    }
}
