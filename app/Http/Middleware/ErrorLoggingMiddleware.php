<?php

namespace App\Http\Middleware;

use App\Exceptions\Handler;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ErrorLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        // Try executing the next middleware or controller
        try {
            return $next($request);
        } catch (Exception $exception) {
            // Log the exception details
            Log::error('Exception', [
                'message' => $exception->getMessage(),
                'timestamp' => now(),
            ]);
        }
    }
}
