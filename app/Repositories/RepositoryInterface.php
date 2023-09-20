<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function get();

    public function paginate();

    public function filterBy(array $filters);
}
