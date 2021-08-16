<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ParserInterface
{
    public function parse($data);

}
