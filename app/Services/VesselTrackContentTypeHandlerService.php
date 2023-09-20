<?php

namespace App\Services;

use App\Factories\ContentTypeConverterFactory;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VesselTrackContentTypeHandlerService
{
    public function __construct(readonly ContentTypeConverterFactory $handlerFactory) {}

    public function handle($header, $request, $statusCode)
    {
        $handler = ($statusCode !== ResponseAlias::HTTP_OK)
            ? $request
            : $this->handlerFactory->createHandler($header)->handle($request);

        return (new Response($handler, $statusCode))
            ->header('Content-Type', $header);
    }
}
