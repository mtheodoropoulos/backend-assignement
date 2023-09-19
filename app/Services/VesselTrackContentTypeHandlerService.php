<?php

namespace App\Services;

use App\Factories\ContentTypeConverterFactory;
use Illuminate\Http\Response;

class VesselTrackContentTypeHandlerService
{
    public function __construct(readonly ContentTypeConverterFactory $handlerFactory) {}

    public function handle($header, $request)
    {
        $handler = $this->handlerFactory->createHandler($header);

        return (new Response($handler->handle($request)))
            ->header('Content-Type', $header);
    }
}
