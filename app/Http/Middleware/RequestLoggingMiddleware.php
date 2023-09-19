<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Log the incoming request
        Log::info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'parameters' => $request->all(),
            'user_ip' => $request->ip(),
            'timestamp' => Carbon::now(),
        ]);

        return $next($request);
    }
}
