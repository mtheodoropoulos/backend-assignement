<?php

namespace App\Handlers\ContentType;

use App\Factories\ContentTypeConverterFactory;
use SimpleXMLElement;

class XmlHandler extends ContentTypeConverterFactory
{
    public function handle($content): bool|string
    {
        return $this->toXml($content);
    }

    private function toXml($content, $rootElement = null, $xml = null)
    {
        // If there is no Root Element then insert root
        if ($xml === null) {
            $xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<tracks/>');
        }

        // Visit all key value pair
        foreach ($content as $k => $v) {
            $key = is_numeric($k) ? 'track' : $k;

            // If there is nested array then call func for nested or just add child element
            is_array($v)
                ? $this->toXml($v, $k, $xml->addChild($key))
                : $xml->addChild($key, $v);
        }

        return $xml->asXML();
    }

}
