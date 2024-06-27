<?php

namespace App\Services\User;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use DateTime;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserServiceImplement extends ServiceApi implements UserService
{
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function register($email, $username, $password){
        if( $this->mainRepository->findByEmail($email) ){
            throw new ConflictHttpException('Email has been exists');
        }

        if( $this->mainRepository->findByUsername($username) ){
            throw new ConflictHttpException('Username has been exists');
        }

        return $this->mainRepository->create([
            'id' => Uuid::uuid7()->toString(),
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    public function login($usernameOrEmail, $password){
        $findUser = $this->mainRepository->findByUsernameOrEmail($usernameOrEmail);

        if( !$findUser || !Hash::check($password, $findUser['password'])){
            throw new BadRequestHttpException("Username - Email or Password is invalid");
        }

        $date = new DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $this->mainRepository->updateLastAcessByInstance($findUser, $formattedDate);

        $findUser['token'] = $findUser->createToken(
            'User Login', 
            ['user'], 
            Carbon::now()->addDay()
        )->plainTextToken;

        return $findUser;
    }

    public function findById($id){
        $findUser = $this->mainRepository->findById($id);

        if( !isset($findUser) ) throw new NotFoundHttpException("User not found");

        return $findUser;
    }

    public function updateEmail($id, $oldEmail, $newEmail){
        if( $oldEmail === $newEmail ) return true;

        return $this->mainRepository->updateEmail($id, $newEmail);
    }

    public function updateUsername($id, $oldUsername, $newUsername){
        if( $oldUsername === $newUsername ) return true;

        return $this->mainRepository->updateUsername($id, $newUsername);
    }

    public function updatePassword($id, $passwordFromToken, $oldPassword, $newPassword){
        if( !Hash::check($oldPassword, $passwordFromToken) ){
            throw new BadRequestHttpException("Old password don't match");
        }

        if( $oldPassword === $newPassword ) return true;

        return $this->mainRepository->updatePassword($id, Hash::make($newPassword));
    }

    public function deleteById($idFromToken, $idFromParam, $isAdmin){
        if( $isAdmin ) {
            $this->findById($idFromParam);
            return $this->mainRepository->deleteById($idFromParam);
        };

        return $this->mainRepository->deleteById($idFromToken);
    }
}
