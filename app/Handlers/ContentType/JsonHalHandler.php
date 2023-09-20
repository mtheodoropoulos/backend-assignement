<?php

namespace App\Handlers\ContentType;

use App\Factories\ContentTypeConverterFactory;

class JsonHalHandler extends ContentTypeConverterFactory
{
    public function handle($content): bool|string
    {
        $href = config('app.url') . '/data/';

        $halData = [
            '_links' => [
                'self' => ['href' => $href],
            ],
            '_embedded' => [
                'resource' => [],
            ],
        ];

        if (is_array($content)) {
            foreach ($content as $item) {
                $halData['_embedded']['resource'][] = [
                    '_links' => [
                        'self' => ['href' => $href . $item['mmsi']],
                    ],
                    'mmsi' => $item['mmsi'],
                    'status' => $item['status'],
                    'stationId' => $item['stationId'],
                    'speed' => $item['speed'],
                    'lon' => $item['lon'],
                    'lat' => $item['lat'],
                    'course' => $item['course'],
                    'heading' => $item['heading'],
                    'rot' => $item['rot'],
                    'timestamp' => $item['timestamp'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                    'deleted_at' => $item['deleted_at'],
                ];
            }
        }

        return json_encode($halData, JSON_PRETTY_PRINT);
    }
}
