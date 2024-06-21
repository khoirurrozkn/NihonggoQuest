<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\User\UserServiceImplement;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceImplement $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $registerRequest){
        $request = $registerRequest->validated();

        try{

            $response = $this->userService->register(
                $request['email'],
                $request['username'],
                $request['password']
            );

            if( isset($response['code']) ){
                return $this->responseError(
                    $response['code'], 
                    $response['description']
                );
            }

            return $this->responseDataSuccess(
                Response::HTTP_CREATED, 
                "Success create user", 
                new UserResource($response)
            );

        }catch(Exception $e){

            return $this->responseServerError(
                Response::HTTP_INTERNAL_SERVER_ERROR, 
                $e->getMessage(), 
                __METHOD__
            );
            
        }
    }
}
