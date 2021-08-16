<?php

namespace App\Strategies\LogStrategy\Implementations;

use App\Interfaces\LoggerInterface;


class DatabaseLogger implements LoggerInterface
{
    public function log($data){
        
        return $data;
    }

}
