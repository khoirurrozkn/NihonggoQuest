<?php

namespace App\Services\Admin;

use LaravelEasyRepository\BaseService;

interface AdminService extends BaseService{

    public function register($username, $password);
    public function login($username, $password);
}
