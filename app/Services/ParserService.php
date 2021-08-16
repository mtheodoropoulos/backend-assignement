<?php

namespace App\Services;

use App\Models\ShipPosition;
use App\Interfaces\ParserServiceInterface;
use App\Interfaces\VesselTrackingInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Strategies\ParserStrategy\ParserClient;
use App\Strategies\ParserStrategy\Implementations\XmlParser;
use App\Strategies\ParserStrategy\Implementations\JsonParser;

class ParserService implements ParserServiceInterface
{

    public function __construct(ParserClient $parserClient,XmlParser $xmlParser,JsonParser $jsonParser)
    {
        $this->parserClient = $parserClient;
        $this->xmlParser = $xmlParser;
        $this->jsonParser = $jsonParser;
    }

    public function getParsingRequest(): array
    {
        
        if (request()->header('content-type')=="application/xml"){
            $this->parserClient->setParser( $this->xmlParser);
            $data=request()->getContent();
        }
        else {
            $this->parserClient->setParser( $this->jsonParser);
            $data=request()->all();
        }
        $parsingRequest= $this->parserClient->response($data);
        
        return $parsingRequest;
    }

   

}
