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
        if ($filters['mmsi']) {
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

/*

&interval[start_time]=2023-01-01
&interval[end_time]=2023-01-04
&coordinates[min_lat]=30&coordinates[max_lat]=42.05627&coordinates[min_lon]=16.19508&coordinates[max_lon]=20

 * */
