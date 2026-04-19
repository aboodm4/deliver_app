<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DeliveryOrAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'delivery' or 'admin' role
        if (Auth::check() && Auth::user()->role === 'delivery'||Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If not an delivery or admin, redirect to the home page or any other page
        return response()->json([
            'message' => 'you not allowed',
        ],403);
    }
}
