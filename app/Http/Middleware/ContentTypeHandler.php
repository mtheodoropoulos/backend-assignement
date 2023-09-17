<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SimpleXMLElement;

class ContentTypeHandler
{
    public function handle(Request $request, Closure $next)
    {
        $acceptHeader = $request->header('Content-Type');

        $response = $next($request);

        if (str_contains($acceptHeader, 'application/json') ||
            str_contains($acceptHeader, 'application/vnd.api+json') ||
            str_contains($acceptHeader, 'application/ld+json') ||
            str_contains($acceptHeader, 'application/hal+json'))
        {
            return $response->getContent();
        }
        elseif (str_contains($acceptHeader, 'application/xml'))
        {
            return $this->arrayToXml(json_decode($response->getContent(),true));
        }
        elseif (str_contains($acceptHeader, 'text/csv'))
        {
            return  $this->arrayTocsv(json_decode($response->getContent(),true));
        }

        return response()->json(['error' => 'Unsupported content type'], 400);

        // Continue processing the request
        return $response;
    }

    private function arrayTocsv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'r+');
        //fputcsv($f, $item, $delimiter, $enclosure, $escape_char); // add headers from DB
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }


    private function arrayToXml($array, $rootElement = null, $xml = null)
    {
        // If there is no Root Element then insert root
        if ($xml === null) {
            $xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<tracks/>');
        }

        // Visit all key value pair
        foreach ($array as $k => $v) {

            $key = $k;
            if(is_numeric($k)){
                $key = "track";
            }

            // If there is nested array then
            if (is_array($v)) {
                // Call function for nested array
                $this->arrayToXml($v, $k, $xml->addChild($key));
            }
            else {
                // Simply add child element.
                $xml->addChild($key, $v);
            }
        }

        return $xml->asXML();
    }

    // Add any additional helper methods here
}
