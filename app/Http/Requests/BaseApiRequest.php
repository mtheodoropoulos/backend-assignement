<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BaseApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'success' => false,
            'error'=>'Validation Error',
            'message' => $validator->messages()->first(),
        ];

        throw new HttpResponseException(
            response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
