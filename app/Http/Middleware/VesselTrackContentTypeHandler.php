<?php

namespace App\Http\Middleware;

use App\Services\VesselTrackContentTypeHandlerService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VesselTrackContentTypeHandler
{

    public function __construct(protected VesselTrackContentTypeHandlerService $contentTypeHandlerService){}

    public function handle(Request $request, Closure $next)
    {
        $nextRequest = $next($request);

        $data = ($nextRequest->status() !== Response::HTTP_OK)
            ? ['errors' => ['message' => $nextRequest->statusText(), 'status' => $nextRequest->status()]]
            : json_decode($nextRequest->getContent(), true);

        return $this->contentTypeHandlerService->handle(
            $request->header('Content-Type'),
            $data,
            $nextRequest->status()
        );
    }
}
