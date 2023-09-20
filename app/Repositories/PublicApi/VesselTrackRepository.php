<?php

namespace App\Repositories\PublicApi;

use App\Models\VesselTrack;
use App\Repositories\Repository;

class VesselTrackRepository extends Repository
{
    public function __construct()
    {
        $this->query = VesselTrack::query();
    }

    public function filterBy(array $filters)
    {

        if (isset($filters['mmsi'])) {
            $this->query->mmsi($filters['mmsi']);
        }

        if (isset($filters['coordinates'])) {
            $this->query->geolocation($filters['coordinates']);
        }

        if (isset($filters['interval'])) {
            $this->query->interval($filters['interval']);
        }

        return $this;
    }
}
