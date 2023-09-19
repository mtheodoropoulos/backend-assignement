<?php

namespace App\Handlers\ContentType;

use App\Factories\ContentTypeConverterFactory;
use App\Models\VesselTrack;

class CsvHandler extends ContentTypeConverterFactory
{
    public function handle($content): bool|string
    {
        $delimiter = ',';
        $enclosure = '"';
        $escapeChar = "\\";

        $f = fopen('php://memory', 'r+');

        fputcsv($f, VesselTrack::$exportable, $delimiter, $enclosure, $escapeChar);

        foreach ($content as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escapeChar);
        }
        rewind($f);
        return stream_get_contents($f);
    }
}
