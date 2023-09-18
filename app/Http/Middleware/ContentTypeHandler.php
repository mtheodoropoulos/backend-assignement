<?php

namespace App\Http\Middleware;

use App\Services\ContentTypeHandlerService;
use Closure;
use Illuminate\Http\Request;

class ContentTypeHandler
{

    public function __construct(protected ContentTypeHandlerService $contentTypeHandlerService){}

    public function handle(Request $request, Closure $next)
    {
        return $this->contentTypeHandlerService->handle(
            $request->header('Content-Type'),
            json_decode($next($request)->getContent(), true)
        );
    }
}
