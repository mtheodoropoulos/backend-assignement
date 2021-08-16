<?php

namespace App\Services;

use App\Interfaces\LoggerServiceInterface;
use App\Strategies\LogStrategy\LoggerClient;
use App\Strategies\ParserStrategy\ParserClient;
use App\Strategies\LogStrategy\Implementations\FileLogger;

class LoggerService implements LoggerServiceInterface
{

    public function __construct(LoggerClient $loggerClient,FileLogger $fileLogger)
    {
        $this->loggerClient = $loggerClient;
        $this->fileLogger = $fileLogger;
    }

    public function logRequest(Array $parsingRequest): void
    {
        $this->loggerClient->setLogger($this->fileLogger);
        
        $response= $this->loggerClient->logData($parsingRequest);

    }

   

}
