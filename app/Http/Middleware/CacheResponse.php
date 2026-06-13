<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class CacheResponse
{
    /**
     * Handle an incoming request.
     * Implementing Caching as an Aspect (AOP Concept)
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only cache GET requests
        if ($request->method() !== 'GET') {
            return $next($request);
        }

        // Generate a unique cache key based on the URL and query parameters
        $url = $request->url();
        $queryParams = $request->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $key = 'route_cache_' . md5("{$url}?{$queryString}");

        // If data is in cache, return it immediately without hitting the DB/Controller
        if (Cache::has($key)) {
            $cachedData = Cache::get($key);
            // Re-build a proper Laravel JsonResponse from cached array
            return response()->json($cachedData['data'], $cachedData['status'], $cachedData['headers']);
        }

        // If not in cache, let the controller handle it (business logic)
        $response = $next($request);

        // Cache the result for 60 seconds if it's a successful response
        if ($response->isSuccessful() && $response instanceof \Illuminate\Http\JsonResponse) {
            $dataToCache = [
                'data' => $response->getData(true),
                'status' => $response->getStatusCode(),
                'headers' => $response->headers->all(),
            ];
            Cache::put($key, $dataToCache, 60);
        }

        return $response;
    }
}
