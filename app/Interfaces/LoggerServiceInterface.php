<?php

namespace App\Interfaces;


interface LoggerServiceInterface
{
    public function logRequest(Array $parsingRequest) : void;

}
