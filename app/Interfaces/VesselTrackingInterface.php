<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface VesselTrackingInterface
{
    public function getShipPositions($data): Collection ;

}
