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
    public function store(LoginRequest $request): Response
    {
        // Authenticate the user by phone and password
        $user = User::where('phone', $request->phone)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Generate a token for the user using Sanctum
        $token = $user->createToken("auth_token");

        // Return the response with user data, message, and token
        $user->makeHidden(['created_at', 'email_verified_at', 'updated_at']);

        return response()->json([
            "message" => "Login successful",
            "user" => $user,
            "token" => $token->plainTextToken
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        if (Auth::check()) {
            // Optionally, revoke only the current token if needed
            // $request->user()->currentAccessToken()->delete();

            // Revoke all tokens associated with the authenticated user
            $request->user()->tokens->each(function ($token) {
                $token->delete();
            });

            // Return a response indicating successful logout
            return response()->json([
                'message' => 'Logout successful',
            ], 200);
        } else {
            // If the user is not authenticated, return an appropriate response
            return response()->json([
                'message' => 'No user is logged in',
            ], 401);
        }
    }
}

