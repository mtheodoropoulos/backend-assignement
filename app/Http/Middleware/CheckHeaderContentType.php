<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Interfaces\LoggerInterface;
use App\Interfaces\LoggerServiceInterface;
use App\Interfaces\ParserServiceInterface;

class CheckHeaderContentType
{
    public function __construct(ParserServiceInterface $parserService,LoggerServiceInterface $loggerService)
    {
        $this->parserService = $parserService;
        $this->loggerService = $loggerService;
    }


    public function handle(Request $request, Closure $next)
    {
        $parsingRequest=$this->parserService->getParsingRequest();
        
        $this->loggerService->logRequest($parsingRequest);
        
        $request->attributes->add(['requestArray' => $parsingRequest]);
        
        return $next($request);
    }
}
