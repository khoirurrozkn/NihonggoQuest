<?php

namespace App\Dto;

class Dto{

    public static function success($code, $description, $data){
        return response()->json([
            'status' => [
                'code' => $code,
                'description' => $description
            ],
            'data' => $data
        ], $code);
    }

    public static function error($code, $description){
        return response()->json([
            'status' => [
                'code' => $code,
                'description' => $description
            ]
        ], $code);
    }
}