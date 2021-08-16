<?php

namespace App\Services;

use App\Models\ShipPosition;
use Illuminate\Support\Facades\Cache;
use App\Interfaces\VesselTrackingInterface;
use Illuminate\Database\Eloquent\Collection;

class VesselTrackingService implements VesselTrackingInterface
{

    public function __construct(ShipPosition $shipPosition)
    {
        $this->shipPosition = $shipPosition;
    }

    public function getShipPositions($data) : Collection
    {
        $shipPositions=$this->shipPosition->filtered()->get();

        $expire=60 *60 * 24 * 7;
        
        $shipPositions= Cache::remember('shipPositions', $expire, function() {
            return $this->shipPosition->filtered()->get();
        });
        
        return $shipPositions;
    }

   

}
