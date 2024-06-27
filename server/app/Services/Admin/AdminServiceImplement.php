<?php

namespace App\Services\Admin;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Admin\AdminRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class AdminServiceImplement extends ServiceApi implements AdminService{

    protected $mainRepository;

    public function __construct(AdminRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function register($username, $password){
        $findUser = $this->mainRepository->findByUsername($username);

        if( $findUser ){
            return [
                "code" => Response::HTTP_CONFLICT,
                "description" => "Username has been exists"
            ];
        }

        return $this->mainRepository->create([
            'id' => Uuid::uuid7()->toString(),
            'username' => $username,
            'password' => Hash::make($password)
        ]);
    }

    public function login($username, $password){
        $findUser = $this->mainRepository->findByUsername($username);

        if( !$findUser || !Hash::check($password, $findUser['password'])){
            return [
                "code" => Response::HTTP_BAD_REQUEST,
                "description" => "Username - Email or Password is invalid"
            ];
        }

        $findUser['token'] = $findUser->createToken(
            'Admin Login', 
            ['admin'], 
            Carbon::now()->addDay()
        )->plainTextToken;

        return $findUser;
    }

    public function findAll(){
        return $this->mainRepository->findAll();
    }

    public function findById($id){
        $findUser = $this->mainRepository->findById($id);

        if( !isset($findUser) ){
            return [
                "code" => Response::HTTP_NOT_FOUND,
                "description" => "Admin not found"
            ];
        }

        return $findUser;
    }

    public function deleteById($id){
        $findAdmin = $this->findById($id);

        if( isset($findAdmin['code']) ) return $findAdmin;

        return $this->mainRepository->deleteByInstance($findAdmin);
    }
}
