<?php

namespace App\Services\Admin;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminServiceImplement extends ServiceApi implements AdminService{

    protected $mainRepository;

    public function __construct(AdminRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function register($username, $password){
        if( $this->mainRepository->findByUsername($username) ){
            throw new ConflictHttpException("Username has been exists");
        }

        return $this->mainRepository->create([
            'id' => Uuid::uuid7()->toString(),
            'username' => $username,
            'password' => Hash::make($password)
        ]);
    }

    public function login($username, $password){
        $findAdmin = $this->mainRepository->findByUsername($username);

        if( !$findAdmin || !Hash::check($password, $findAdmin['password'])){
            throw new BadRequestHttpException("Username or Password is invalid");
        }

        $findAdmin['token'] = $findAdmin->createToken(
            'Admin Login', 
            ['admin'], 
            Carbon::now()->addDay()
        )->plainTextToken;

        return $findAdmin;
    }

    public function findAll(){
        return $this->mainRepository->findAll();
    }

    public function findById($id){
        $findAdmin = $this->mainRepository->findById($id);

        if( !isset($findAdmin) ) throw new NotFoundHttpException("Admin not found");

        return $findAdmin;
    }

    public function deleteById($id){
        $findAdmin = $this->findById($id);

        return $this->mainRepository->deleteByInstance($findAdmin);
    }
}
