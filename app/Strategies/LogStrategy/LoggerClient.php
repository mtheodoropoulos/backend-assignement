<?php

namespace App\Strategies\LogStrategy;

use App\Interfaces\LoggerInterface;


class LoggerClient 
{
    private $logger;
 
    public function __construct()
    {
   
    }
 
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
 
    public function logData($parsingRequest): void
    {
        $this->logger->log($parsingRequest);
    }

}
