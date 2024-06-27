<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Resources\AdminResource;
use App\Services\Admin\AdminServiceImplement;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminServiceImplement $adminService)
    {
        $this->adminService = $adminService;
    }

    public function register(AdminRegisterRequest $adminRegisterRequest){
        $request = $adminRegisterRequest->validated();

        $response = $this->adminService->register(
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
            "Success create admin", 
            new AdminResource($response)
        );
    }

    public function login(AdminLoginRequest $adminLoginRequest){
        $request = $adminLoginRequest->validated();

        $response = $this->adminService->login(
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
            "Success login admin", 
            new AdminResource($response)
        );
    }

    public function findAll(){
        $response = $this->adminService->findAll();

        if( isset($response['code']) ){
            return $this->responseError(
                $response['code'], 
                $response['description']
            );
        }

        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success find all admin",
            AdminResource::collection($response)
        );
    }

    public function deleteById($id){
        $response = $this->adminService->deleteById($id);

        if( isset($response['code']) ){
            return $this->responseError(
                $response['code'], 
                $response['description']
            );
        }

        return $this->responseDataSuccess(
            Response::HTTP_OK, 
            "Success delete admin",
            null
        );
    }
}
