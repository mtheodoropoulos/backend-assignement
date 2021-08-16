<?php

namespace App\Strategies\ParserStrategy;

use App\Interfaces\ParserInterface;


class ParserClient 
{
    private $parser;
 
    public function __construct()
    {
   
    }
 
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }
 
    public function response($data)
    {
        return $this->parser->parse($data);
    }

}
