<?php

namespace App\Handlers\ContentType;

use App\Factories\ContentTypeConverterFactory;

class JsonHandler extends ContentTypeConverterFactory
{
    public function handle($content): bool|string
    {
        return json_encode($content, JSON_PRETTY_PRINT);
    }
}
