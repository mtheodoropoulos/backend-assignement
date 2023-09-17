<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface
{
    protected Builder $query;

    public function get(): Collection
    {
        return $this->query->get();
    }

    public function paginate(): LengthAwarePaginator
    {
        return $this->query->paginate(10);
    }

    abstract public function filterBy(array $filters);

}
