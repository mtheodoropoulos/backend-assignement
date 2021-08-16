<?php

namespace App\Strategies\LogStrategy\Implementations;

use App\Interfaces\LoggerInterface;
use Illuminate\Support\Facades\Log;


class FileLogger implements LoggerInterface
{
    public function log($data): void
    {
        
        Log::Channel('requestlog')->info($data);
        
    }

}
