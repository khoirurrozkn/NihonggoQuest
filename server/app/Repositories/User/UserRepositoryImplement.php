<?php

namespace App\Repositories\User;

use App\Models\User;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create($user){
        return $this->model->create($user);
    }

    public function findByUsernameOrEmail($usernameOrEmail, $username = null, $email = null){
        return $this->model->where("username", $username ?? $usernameOrEmail)
                            ->orWhere("email", $email ?? $usernameOrEmail)
                            ->first();
    }

    public function findById($id) {
        return $this->model->find($id)->first();
    }

    public function updateEmail($id, $email){
        return ( $this->findById($id) )->update([
            "email" => $email
        ]);
    }

    public function updateUsername($id, $username){
        return ( $this->findById($id) )->update([
            "username" => $username
        ]);
    }

    public function updatePassword($id, $password){
        return ( $this->findById($id) )->update([
            "password" => $password
        ]);
    }

    public function deleteById($id){
        return ( $this->findById($id) )->delete();
    }

    public function loginUpdateLastAcessByInstance($userModel, $date){
        return $userModel->update([
            'last_access' => $date
        ]);
    }
}
