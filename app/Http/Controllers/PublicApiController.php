<?php

namespace App\Http\Controllers;

use App\Services\ResponseBuilder\PublicApiResponse;

class PublicApiController extends Controller
{
    public PublicApiResponse $apiResponse;

    public function __construct()
    {
        $this->apiResponse = new PublicApiResponse;
    }

}
