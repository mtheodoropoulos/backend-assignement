<?php

namespace App\Http\Middleware;

use App\Services\VesselTrackContentTypeHandlerService;
use Closure;
use Illuminate\Http\Request;

class VesselTrackContentTypeHandler
{

    public function __construct(protected VesselTrackContentTypeHandlerService $contentTypeHandlerService){}

    public function handle(Request $request, Closure $next)
    {
        return $this->contentTypeHandlerService->handle(
            $request->header('Content-Type'),
            json_decode($next($request)->getContent(), true)
        );
    }
}
