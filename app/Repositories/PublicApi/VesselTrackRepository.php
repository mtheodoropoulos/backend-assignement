<?php

namespace App\Repositories\PublicApi;

use App\Models\VesselTrack;
use App\Repositories\Repository;

class VesselTrackRepository extends Repository
{
    public function __construct(VesselTrack $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function filterBy(array $filters): ?VesselTrack
    {
        return $this->model->filter($filters);
    }
}
