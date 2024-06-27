<?php

namespace App\Repositories\UserProfile;

use LaravelEasyRepository\Repository;

interface UserProfileRepository extends Repository{

    public function create($userProfile);
    public function findById($id);
    public function update($id, $userProfile);
}
