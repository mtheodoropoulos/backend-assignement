<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\VesselTrackSearchRequest;
use App\Repositories\PublicApi\VesselTrackRepository;
use Exception;

class VesselTrackController
{

    public function __construct(private readonly VesselTrackRepository $vesselTrackRepository) {}

    public function __invoke(VesselTrackSearchRequest $request): array|string
    {
        $searchParameters = $request->validated();

        try {
            return $this->vesselTrackRepository->filterBy($searchParameters)->get()->toArray();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

}
