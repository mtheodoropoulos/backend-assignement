<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\VesselTrackingService;
use App\Interfaces\VesselTrackingInterface;
use App\Http\Requests\VesselPositionRequest;
use App\Http\Resources\ShipPositionResource;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Resources\ShipPositionCollection;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Api\BaseController as BaseController;

class VesselTrackingController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(VesselTrackingInterface $vesselTrackingService)
    {
        $this->vesselTrackingService = $vesselTrackingService;
    }

    public function vessel_positions(VesselPositionRequest $request) : JsonResponse
    {
        
        $shipPositions = $this->vesselTrackingService->getShipPositions($request->validated());
        
        $response =  new ShipPositionCollection($shipPositions);
        
        return $this->sendResponse($response, 'Ship Positions retrieved successfully.');
    }

   
}
