<?php

namespace App\Services;

use Illuminate\Http\Response;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ContentTypeHandlerService
{
    public function handle($header, $request)
    {
        if (str_contains($header, 'application/json') || str_contains($header, 'application/hal+json')) {
            return $this->handleJson($request);
        }

        if (str_contains($header, 'application/xml') !== false) {
            return $this->handleXml($request);
        }

        if (str_contains($header, 'text/csv') !== false) {
            return $this->handleCsv($request);
        }

        return $this->handleUnsupported();
    }

    public function handleJson($content)
    {
        return $content;
    }

    private function handleCsv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'r+');
        //fputcsv($f, $item, $delimiter, $enclosure, $escape_char); // add headers from DB
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
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

    private function handleUnsupported(): Response
    {
        return new Response(['error' => 'Unsupported content type'], ResponseAlias::HTTP_BAD_REQUEST);
    }
}
