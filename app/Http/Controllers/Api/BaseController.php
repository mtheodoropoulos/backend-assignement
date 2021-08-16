<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message,$code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if(!empty($result)){
            $response['reponse'] = $result;
        }

        return response()->json($response,$code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'error' => $error,
        ];

        if(!empty($errorMessages)){
            $response['message'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
