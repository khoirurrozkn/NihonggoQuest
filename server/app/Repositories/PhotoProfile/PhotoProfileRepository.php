<?php

namespace App\Repositories\PhotoProfile;

use LaravelEasyRepository\Repository;

interface PhotoProfileRepository extends Repository{

    public function create($url);
    public function findAll();
    public function findById($id);
    public function findByPhotoUrl($photoUrl);

    public function updatePhotoUrlByInstance($photoProfileModel, $photo_url);
}
