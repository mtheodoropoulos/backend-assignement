<?php

namespace App\Services;

use App\Models\ShipPosition;
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
        
        return $shipPositions;
    }

   

}
