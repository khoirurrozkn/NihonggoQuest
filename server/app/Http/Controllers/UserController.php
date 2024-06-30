<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateEmailRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateUsernameRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use DateTime;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends Controller
{
    public function register(UserRegisterRequest $userRegisterRequest){
        $request = $userRegisterRequest->validated();

        DB::beginTransaction();

        try{

            $createdUser = User::create([
                'id' => Uuid::uuid7()->toString(),
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);

            UserProfile::create([
                'id' => Uuid::uuid7()->toString(),
                'user_id' => $createdUser['id'],
            ]);

            DB::commit();

            return Dto::success(
                Response::HTTP_CREATED, 
                "Success create user", 
                new UserResource($createdUser)
            );

        }catch(Exception $e){

            DB::rollBack();
            throw new Exception($e->getMessage());

        }
    }

    public function login(UserLoginRequest $userLoginRequest){
        $request = $userLoginRequest->validated();

        $findUser = User::with('userProfile.photoProfile', 'userProfile.rank')
            ->where("username", $request['username_or_email'])
            ->orWhere("email", $request['username_or_email'])
            ->first();
        
        if( !$findUser || !Hash::check($request['password'], $findUser['password'])){
            throw new BadRequestHttpException("Username - Email or Password is invalid");
        }

        $findUser->update([
            'last_access' => ( new DateTime() )->format('Y-m-d H:i:s')
        ]);

        $findUser['token'] = $findUser->createToken(
            'User Login', 
            ['user'], 
            Carbon::now()->addDay()
        )->plainTextToken;

        return Dto::success(
            Response::HTTP_OK, 
            "Success login user", 
            new UserResource($findUser)
        );
    }

    public function findById(User $user){
        $user->load(['userProfile.rank', 'userProfile.photoProfile']);

        return Dto::success(
            Response::HTTP_OK,
            "Success find by id user",
            new UserResource($user)
        );
    }

    public function updateEmail(UserUpdateEmailRequest $userUpdateEmailRequest){
        $request = $userUpdateEmailRequest->validated();

        $findUser = User::find(auth()->user()->id);
        $findUser->update([
            'email' => $request['email']
        ]);
            
        return Dto::success(
            Response::HTTP_OK, 
            "Success update email user",
            new UserResource($findUser)
        );
    }

    public function updateUsername(UserUpdateUsernameRequest $userUpdateUsernameRequest){
        $request = $userUpdateUsernameRequest->validated();

        $findUser = User::find(auth()->user()->id);
        $findUser->update([
            'username' => $request['username']
        ]);

        return Dto::success(
            Response::HTTP_OK,
            "Success update username user",
            new UserResource($findUser)
        );
    }

    public function updatePassword(UserUpdatePasswordRequest $userUpdatePasswordRequest){
        $request = $userUpdatePasswordRequest->validated();

        if( !Hash::check($request['old_password'], auth()->user()->password) ){
            throw new BadRequestHttpException("Old password don't match");
        }

        User::find(auth()->user()->id)
            ->update([
                'password' => Hash::make($request['new_password'])
            ]);

        return Dto::success(
            Response::HTTP_OK, 
            "Success update password user", 
            null
        );
    }

    public function deleteById(Request $request, User $user){
        
        if( $request->user()->currentAccessToken()->abilities[0] === 'admin' ){
            $user->tokens()->delete();
            $user->delete();
        }else{
            $findUser = User::find(auth()->user()->id);
            $findUser->tokens()->delete();
            $findUser->delete();
        }

        return Dto::success(
            Response::HTTP_OK, 
            "Success delete user",
            null
        );
    }
}
