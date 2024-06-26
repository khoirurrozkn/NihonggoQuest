<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateEmailRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateUsernameRequest;
use App\Http\Resources\UserResource;
use App\Services\User\UserServiceImplement;
use Illuminate\Http\Request;
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
    }

    public function login(LoginRequest $loginRequest){
        $request = $loginRequest->validated();

        $response = $this->userService->login(
            $request['username_or_email'],
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
            "Success login user", 
            new UserResource($response)
        );
    }

    public function findById($id){
        $response = $this->userService->findById($id);

        if( isset($response['code']) ){
            return $this->responseError(
                $response['code'], 
                $response['description']
            );
        }
        
        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success find by id user",
            new UserResource($response)
        );
    }

    public function updateEmail(UserUpdateEmailRequest $userUpdateEmailRequest){
        $request = $userUpdateEmailRequest->validated();

        $this->userService->updateEmail(
            auth()->user()->id,
            auth()->user()->email,
            $request['email']
        );
            
        auth()->user()->email = $request['email'];
        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success update email user",
            new UserResource(auth()->user())
        );
    }

    public function updateUsername(UserUpdateUsernameRequest $userUpdateUsernameRequest){
        $request = $userUpdateUsernameRequest->validated();

        $this->userService->updateUsername(
            auth()->user(),
            auth()->user()->username,
            $request['username'],
        );

        auth()->user()->username = $request['username'];
        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success update username user",
            new UserResource(auth()->user())
        );
    }

    public function updatePassword(UserUpdatePasswordRequest $userUpdatePasswordRequest){
        $request = $userUpdatePasswordRequest->validated();

        $response = $this->userService->updatePassword(
            auth()->user(),
            auth()->user()->password,
            $request['old_password'],
            $request['new_password']
        );

        if( isset($response['code']) ){
            return $this->responseError(
                $response['code'], 
                $response['description']
            );
        }

        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success update password", 
            new UserResource(auth()->user())
        );
    }

    public function deleteById(Request $request, $paramId){
        $isAdmin = $request->user()->currentAccessToken()->abilities[0] === 'admin';
        $response = $this->userService->deleteById(
            auth()->user()->id,
            $paramId,
            $isAdmin
        );

        if( isset($response['code']) ){
            return $this->responseError(
                $response['code'], 
                $response['description']
            );
        }

        $request->user()->currentAccessToken()->delete();
        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success delete user",
            null
        );
    }
}
