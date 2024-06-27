<?php

namespace App\Repositories\UserProfile;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\UserProfile;

class UserProfileRepositoryImplement extends Eloquent implements UserProfileRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(UserProfile $model)
    {
        $this->model = $model;
    }

    public function create($userProfile){
        return $this->model->create($userProfile);
    }

    public function findById($id){
        return $this->model->find($id);
    }

    public function update($id, $userProfile){
        return ( $this->findById($id) )->update($userProfile);
    }
}
