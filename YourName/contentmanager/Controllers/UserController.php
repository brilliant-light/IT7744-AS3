<?php namespace yourname\contentmanager\Controllers;

use RainLab\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Create new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_activated' => 1, // Activate the user by default
        ]);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user
        ], 201);
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
{
    // Validate login credentials
    $credentials = $request->only(['email', 'password']);

    try {
        // Attempt to generate a token for the user
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    } catch (JWTException $e) {
        return response()->json(['error' => 'Could not create token'], 500);
    }

    // Return the token in the response
    return response()->json([
        'message' => 'Login successful!',
        'token' => $token
    ], 200);
}

    /**
     * Fetch the authenticated user details
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'user' => $user
        ], 200);
    }
}