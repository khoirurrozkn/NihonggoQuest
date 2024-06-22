<?php

namespace App\Services\User;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class UserServiceImplement extends ServiceApi implements UserService
{
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function register($email, $username, $password)
    {
        $findUser = $this->mainRepository->findByEmail($email);

        if( $findUser ){
            return [
                "code" => Response::HTTP_CONFLICT,
                "description" => "Email has been exists"
            ];
        }

        return $this->mainRepository->create([
            'id' => Uuid::uuid7()->toString(),
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    public function login($email, $password){
        $findUser = $this->mainRepository->findByEmail($email);

        if( !$findUser || !Hash::check($password, $findUser['password'])){
            return [
                "code" => Response::HTTP_BAD_REQUEST,
                "description" => "Email or Password is invalid"
            ];
        }

        $findUser['token'] = $findUser->createToken(
            'User Login', 
            ['*'], 
            Carbon::now()->addDay()
        )->plainTextToken;

        return $findUser;
    }
}
