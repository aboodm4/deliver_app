<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): Response
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return response()->noContent();
    // }
    public function store(LoginRequest $request): Response
    {
        // Authenticate the user by phone and password
        $user = User::where('phone', $request->phone)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate a token for the user using Sanctum
        $token = $user->createToken('deliver_app')->plainTextToken;

        // Regenerate the session to avoid session fixation attacks
        $request->session()->regenerate();

        $user->makeHidden(['created_at', 'email_verified_at', 'updated_at']);


        // Return the response with user data, message, and token
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        // // Check if the user is authenticated
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

            // Check if the user is authenticated using the 'sanctum' guard (for token-based authentication)
    if (!Auth::guard('sanctum')->check()) {
        return response()->json(['message' => 'Unauthenticated.'], 400);
    }

        // Invalidate the user's session for web guard
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent session fixation attacks
        $request->session()->regenerateToken();

        // Revoke the Sanctum token to log out the user from the API
        if ($request->user()) {
            // Delete all the user's API tokens
            $request->user()->tokens->each(function ($token) {
                $token->delete();  // Delete each token individually
            });
        }

        // Return a response indicating successful logout
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

}
