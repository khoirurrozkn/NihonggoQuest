<?php

namespace App\Services\UserProfile;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\UserProfile\UserProfileRepository;

class UserProfileServiceImplement extends ServiceApi implements UserProfileService{

    protected $mainRepository;

    public function __construct(UserProfileRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    
}
