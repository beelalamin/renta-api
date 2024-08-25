<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class AuthController extends Controller
{

    // Register User
    public function register(RegisterRequest $request)
    {
        // Validate
        $credentials = $request->validated();
        // Register
        $user = User::create($credentials);

        // Login
        if ($user) {
            Auth::login($user);

            $token = $user->createToken('authToken', ['*'], now()->addWeek())->plainTextToken;

            // Invoke for email verification, 
            event(new Registered($user));

            // Redirect
            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $token
            ], 201);

        } else {
            return response()->json([
                'message' => 'Failed to create User',
            ], 401);
        }
    }

    // Athenticate User
    public function login(LoginRequest $request)
    {
        // Validate the request data
        $credentials = $request->validated();

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {

            /** @var User $user **/
            $user = Auth::user();

            // Generate a token for the user 
            $token = $user->createToken('authToken', ['*'], now()->addWeek())->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        // Return an error response if login failed
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
    // Logout User
    public function logout(Request $request)
    {

        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout successful',
            ], 200);
        }

        return response()->json([
            'message' => 'No active session found',
        ], 400);
    }

}
