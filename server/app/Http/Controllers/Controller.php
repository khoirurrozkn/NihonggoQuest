<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
                'description' => $description
            ]
        ], $code);
    }
}
