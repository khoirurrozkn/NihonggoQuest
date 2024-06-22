<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    public function register($email, $username, $password);
    public function login($email, $password);
}
