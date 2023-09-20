<?php

namespace App\Handlers\ContentType;

use App\Factories\ContentTypeConverterFactory;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class UnsupportedHandler extends ContentTypeConverterFactory
{
    public function handle($content)
    {
        return json_encode(['error' => 'Unsupported content type'], ResponseAlias::HTTP_BAD_REQUEST);
    }
}
