<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
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

    public function register(UserRegisterRequest $userRegisterRequest){
        $request = $userRegisterRequest->validated();

        $createdUser = $this->userService->register(
            $request['email'],
            $request['username'],
            $request['password']
        );

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success create user", 
            new UserResource($createdUser)
        );
    }

    public function login(UserLoginRequest $userLoginRequest){
        $request = $userLoginRequest->validated();

        $response = $this->userService->login(
            $request['username_or_email'],
            $request['password']
        );

        return Dto::success(
            Response::HTTP_OK, 
            "Success login user", 
            new UserResource($response)
        );
    }

    public function findById($id){
        $response = $this->userService->findById($id);
        
        return Dto::success(
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
        return Dto::success(
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
        return Dto::success(
            Response::HTTP_OK, 
            "Success update username user",
            new UserResource(auth()->user())
        );
    }

    public function updatePassword(UserUpdatePasswordRequest $userUpdatePasswordRequest){
        $request = $userUpdatePasswordRequest->validated();

        $this->userService->updatePassword(
            auth()->user(),
            auth()->user()->password,
            $request['old_password'],
            $request['new_password']
        );

        return Dto::success(
            Response::HTTP_OK, 
            "Success update password", 
            new UserResource(auth()->user())
        );
    }

    public function deleteById(Request $request, $paramId){
        $isAdmin = $request->user()->currentAccessToken()->abilities[0] === 'admin';
        $this->userService->deleteById(
            auth()->user()->id,
            $paramId,
            $isAdmin
        );

        return Dto::success(
            Response::HTTP_OK, 
            "Success delete user",
            null
        );
    }
}
