<?php

namespace App\Factories;

use App\Handlers\ContentType\JsonHalHandler;
use App\Handlers\ContentType\JsonHandler;
use App\Handlers\ContentType\UnsupportedHandler;
use App\Handlers\ContentType\XmlHandler;
use App\Handlers\ContentType\CsvHandler;

class ContentTypeConverterFactory
{
    public function createHandler($contentType = ''): JsonHalHandler|XmlHandler|JsonHandler|CsvHandler|UnsupportedHandler
    {
        return match ($contentType) {
            'application/json' => new JsonHandler(),
            'application/hal+json' => new JsonHalHandler(),
            'application/xml' => new XmlHandler(),
            'text/csv' => new CsvHandler(),
            default => new UnsupportedHandler()
        };
    }
}
