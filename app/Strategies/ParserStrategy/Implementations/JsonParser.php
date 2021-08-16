<?php

namespace App\Strategies\ParserStrategy\Implementations;

use App\Interfaces\ParserInterface;


class JsonParser implements ParserInterface
{
    public function parse($data){
        
        return $data;
    }

}
