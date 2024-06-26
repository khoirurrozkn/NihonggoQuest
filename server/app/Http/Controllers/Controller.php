<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // DTO
    protected function responseDataSuccess($code, $description, $data){
        return response()->json([
            'status' => [
                'code' => $code,
                'description' => $description
            ],
            'data' => $data
        ], $code);
    }

    // DTO
    protected function responseError($code, $description){
        return response()->json([
            'status' => [
                'code' => $code,
                'description' => isset($classAndMethod) ? 'Server error, please try again later' : $description
            ]
        ], $code);
    }

    // DTO
    protected function responseServerError($errorMessage, $classAndMethod){
        $currentTime = (new DateTime())->format('Y-m-d H:i');
        Log::error("Location : {$classAndMethod}\nDescription : {$errorMessage}\nTime : {$currentTime}\n\n");

        return $this->responseError(
            Response::HTTP_INTERNAL_SERVER_ERROR, 
            'Server error, please try again later'
        );
    }
}
