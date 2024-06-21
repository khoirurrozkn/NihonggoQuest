<?php

namespace App\Services\User;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

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

        if ($findUser) {
            return [
                "code" => Response::HTTP_CONFLICT,
                "description" => "Email has been exists"
            ];
        }

        return $this->mainRepository->create([
            'user_id' => Uuid::uuid7()->toString(),
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
