<?php

namespace App\Repositories\PhotoProfile;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\PhotoProfile;

class PhotoProfileRepositoryImplement extends Eloquent implements PhotoProfileRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(PhotoProfile $model)
    {
        $this->model = $model;
    }

    public function create($url){
        return $this->model->create($url);
    }

    public function findById($id){
        return $this->model->find($id);
    }

    public function findAll(){
        return $this->model->orderBy('id', 'asc')->get();
    }    

    public function findByPhotoUrl($photoUrl){
        return $this->model->where('photo_url', $photoUrl)->first();
    }

    public function updatePhotoUrlByInstance($photoProfileModel, $photo_url){
        return $photoProfileModel->update([
            'photo_url' => $photo_url
        ]);
    }
}
