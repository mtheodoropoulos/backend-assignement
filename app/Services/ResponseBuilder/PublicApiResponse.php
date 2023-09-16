<?php

namespace App\Services\ResponseBuilder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PublicApiResponse
{

    public function success(string $message, $data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->apiResponse($message, $data, $statusCode);
    }

    public function error(string $message, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->apiResponse($message, null, $statusCode, false);
    }

    public function apiResponse(string $message, $data, int $statusCode, bool $success = true): JsonResponse
    {
        if (!$message) {
            return response()->json(['message' => 'Message is missing', 'error' => true, 'code' => Response::HTTP_INTERNAL_SERVER_ERROR],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success) {
            return response()->json(['message' => $message, 'error' => false, 'code' => $statusCode, 'data' => $data],
                $statusCode);
        }

        return response()->json(['message' => $message, 'error' => true, 'code' => $statusCode],
            $statusCode);
    }
}
