<?php

namespace App\Services;

use App\Models\VesselTrack;
use Illuminate\Http\Response;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VesselTrackContentTypeHandlerService
{
    public function handle($header, $request)
    {
        if (str_contains($header, 'application/json')) {
            return (new Response($this->handleJson($request)))
                ->header('Content-Type', 'application/json');
        }

        if (str_contains($header, 'application/hal+json')) {
            return (new Response($this->handleJsonHal($request)))
                ->header('Content-Type', 'application/hal+json');
        }

        if (str_contains($header, 'application/xml') !== false) {
            return (new Response($this->handleXml($request)))
                ->header('Content-Type', 'application/xml');
        }

        if (str_contains($header, 'text/csv') !== false) {
            return (new Response($this->handleCsv($request)))
                ->header('Content-Type', 'text/csv');
        }

        return $this->handleUnsupported();
    }

    private function handleJson($content)
    {
        return $content;
    }

    private function handleJsonHal($data)
    {
        $href = 'https://example.org/data/';
        $halData = [
            '_links' => [
                'self' => ['href' => $href],
            ],
            '_embedded' => [
                'resource' => [],
            ],
        ];

        if (is_array($data)) {
            foreach ($data as $item) {
                $halData['_embedded']['resource'][] = [
                    '_links' => [
                        'self' => ['href' => $href . $item['mmsi']], // Replace with your resource URL structure
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
        } else {
            // Single item
            $halData['_embedded']['resource'] = [
                [
                    '_links' => [
                        'self' => ['href' => $href . $data['mmsi']], // Replace with your resource URL structure
                    ],
                    'mmsi' => $data['mmsi'],
                    'status' => $data['status'],
                    'stationId' => $data['stationId'],
                    'speed' => $data['speed'],
                    'lon' => $data['lon'],
                    'lat' => $data['lat'],
                    'course' => $data['course'],
                    'heading' => $data['heading'],
                    'rot' => $data['rot'],
                    'timestamp' => $data['timestamp'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['updated_at'],
                    'deleted_at' => $data['deleted_at'],
                ],
            ];
        }

        return json_encode($halData, JSON_PRETTY_PRINT);
    }

    private function handleXml($data, $rootElement = null, $xml = null)
    {
        // If there is no Root Element then insert root
        if ($xml === null) {
            $xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<tracks/>');
        }

        // Visit all key value pair
        foreach ($data as $k => $v) {
            $key = is_numeric($k) ? 'track' : $k;

            // If there is nested array then call func for nested or just add child element
            is_array($v)
                ? $this->handleXml($v, $k, $xml->addChild($key))
                : $xml->addChild($key, $v);
        }

        return $xml->asXML();
    }

    private function handleCsv($data, $delimiter = ',', $enclosure = '"', $escapeChar = "\\")
    {
        $f = fopen('php://memory', 'r+');

        fputcsv($f, VesselTrack::$exportable, $delimiter, $enclosure, $escapeChar);

        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escapeChar);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    private function handleUnsupported(): Response
    {
        return new Response(['error' => 'Unsupported content type'], ResponseAlias::HTTP_BAD_REQUEST);
    }
}
