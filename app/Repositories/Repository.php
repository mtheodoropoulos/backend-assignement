<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Repository implements VesselTrackRepositoryInterface
{

    public function __construct(protected Model $model) {}

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function paginate()
    {
        return $this->model->paginate(10);
    }

    abstract public function filterBy(array $filters);

}
