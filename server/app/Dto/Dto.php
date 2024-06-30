<?php

namespace App\Dto;
use Symfony\Component\HttpFoundation\Response;

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

    public static function successWithPagination($data, $description, $paginate){
        return response()->json([
            'status' => [
                'code' => Response::HTTP_OK,
                'description' => $description
            ],
            'data' => $data,
            'pagination' => [
                'total' => $paginate->total(),
                'per_page' => $paginate->perPage(),
                'current_page' => $paginate->currentPage(),
                'last_page' => $paginate->lastPage(),
            ]
        ], Response::HTTP_OK);
    }

    public static function error($code, $description){
        return response()->json([
            'status' => [
                'code' => $code,
                'description' => $description
            ]
        ], $code);
    }

    public static function errorWithMessage($code, $message, $errors){
        return response()->json([
            "status" => [
                "code" => $code,
                "description" => $message
            ],
            "errors" => $errors
        ], $code);
    }
}