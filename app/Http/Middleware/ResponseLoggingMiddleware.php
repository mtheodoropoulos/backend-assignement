<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ResponseLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Capture the response from the next middleware or controller
        $response = $next($request);

        // Log the response details
        Log::info('API Response', [
            'status_code' => $response->getStatusCode(),
            'headers' => $response->headers->all(),
            'timestamp' => now(),
        ]);

        return $response;
    }
}
