<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AdminController extends Controller
{
    public function register(AdminRegisterRequest $adminRegisterRequest){
        $request = $adminRegisterRequest->validated();

        $createdAdmin = Admin::create([
            'id' => Uuid::uuid7()->toString(),
            'username' => $request['username'],
            'password' => Hash::make($request['password'])
        ]);

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success create admin", 
            new AdminResource($createdAdmin)
        );
    }

    public function login(AdminLoginRequest $adminLoginRequest){
        $request = $adminLoginRequest->validated();

        $findAdmin = Admin::where('username', $request['usernmae'])
            ->first();

        if( !$findAdmin || !Hash::check($request['password'], $findAdmin['password'])){
            throw new BadRequestHttpException("Username or Password is invalid");
        }

        $findAdmin['token'] = $findAdmin->createToken(
            'Admin Login', 
            ['admin'], 
            Carbon::now()->addDay()
        )->plainTextToken;

        return Dto::success(
            Response::HTTP_OK, 
            "Success login admin", 
            new AdminResource($findAdmin)
        );
    }

    public function findAll(){
        return Dto::success(
            Response::HTTP_OK, 
            "Success find all admin",
            AdminResource::collection(Admin::all())
        );
    }

    public function deleteById(Admin $admin){

        $admin->tokens()->delete();
        $admin->delete();

        return Dto::success(
            Response::HTTP_OK, 
            "Success delete admin",
            null
        );
    }
}
