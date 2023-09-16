<?php

namespace App\Repositories;

interface VesselTrackRepositoryInterface
{
    public function get();

    public function paginate();

    public function filterBy(array $filters);
}
