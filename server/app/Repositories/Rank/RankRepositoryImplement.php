<?php

namespace App\Repositories\Rank;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Rank;

class RankRepositoryImplement extends Eloquent implements RankRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Rank $model)
    {
        $this->model = $model;
    }

    public function create($name){
        return $this->model->create($name);
    }

    public function findAll(){
        return $this->model->orderBy('id', 'asc')->get();
    }    

    public function findByName($name) {
        return $this->model->where('name', $name)->first();
    }

    public function findByIdWithTheirUsers($id){
        return $this->model->with('userProfiles')->find($id);
    }

}
