<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\PublicApiController;
use App\Http\Requests\VesselTrackSearchRequest;
use App\Repositories\PublicApi\VesselTrackRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VesselTrackController extends PublicApiController
{

    public function __construct(private readonly VesselTrackRepository $vesselTrackRepository) {
        parent::__construct();
    }

    public function __invoke(VesselTrackSearchRequest $request): JsonResponse
    {
        $searchParameters = $request->validated();

        try {
            return $this->apiResponse->success(
                'Find vessel tracks',
                $this->vesselTrackRepository->filterBy($searchParameters)
            );
        } catch (ModelNotFoundException $exception) {
            return $this->apiResponse->error($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

}
