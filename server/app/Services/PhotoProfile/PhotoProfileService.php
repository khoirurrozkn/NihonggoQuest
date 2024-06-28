<?php

namespace App\Services\PhotoProfile;

use LaravelEasyRepository\BaseService;

interface PhotoProfileService extends BaseService{

    public function create($url);
    public function findAll();
    public function updatePhotoUrlById($id, $photoUrl);
}
