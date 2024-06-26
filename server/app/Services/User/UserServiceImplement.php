<?php

namespace App\Services\User;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class UserServiceImplement extends ServiceApi implements UserService
{
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function register($email, $username, $password){
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

    public function findById($id){
        $findUser = $this->mainRepository->findById($id);

        if( !$findUser ){
            return [
                "code" => Response::HTTP_NOT_FOUND,
                "description" => "User not found"
            ];
        }

        return $findUser;
    }

    public function updateEmail($id, $oldEmail, $newEmail){
        if( $oldEmail === $newEmail ) return true;

        $updatedEmail = $this->mainRepository->updateEmail($id, $newEmail);

        if( !$updatedEmail ){
            return [
                "code" => Response::HTTP_BAD_REQUEST,
                "description" => "Failed update email"
            ];
        }

        return true;
    }

    public function updateUsername($id, $oldUsername, $newUsername){
        if( $oldUsername === $newUsername ) return true;

        $updatedUsername = $this->mainRepository->updateUsername($id, $newUsername);

        if( !$updatedUsername ){
            return [
                "code" => Response::HTTP_BAD_REQUEST,
                "description" => "Failed update username"
            ];
        }

        return true;
    }

    public function updatePassword($id, $passwordFromToken, $oldPassword, $newPassword){
        if( !Hash::check($oldPassword, $passwordFromToken) ){
            return [
                "code" => Response::HTTP_BAD_REQUEST,
                "description" => "Old password don't match"
            ];
        }

        if( $oldPassword === $newPassword ) return true;

        $updatedPassword = $this->mainRepository->updatePassword($id, Hash::make($newPassword));

        if( !$updatedPassword ){
            return [
                "code" => Response::HTTP_BAD_REQUEST,
                "description" => "Failed update password"
            ];
        }

        return true;
    }

}
