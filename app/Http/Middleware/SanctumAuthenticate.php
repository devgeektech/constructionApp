<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; 

class SanctumAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!auth()->guard('sanctum')->check()) {
            // Return error response if the user is not authenticated
            return response()->json(['error' => 'Unauthorized. Please provide a valid token.'], 401);
        }

        return $next($request);
    }
}
