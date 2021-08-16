<?php

namespace App\Strategies\ParserStrategy\Implementations;

use App\Interfaces\ParserInterface;


class XmlParser implements ParserInterface
{
    public function parse($data){
        
        $xmlObject = simplexml_load_string($data);
        
        $json = json_encode($xmlObject);
        
        $phpDataArray = json_decode($json, true); 

        return $phpDataArray;
    }

}
