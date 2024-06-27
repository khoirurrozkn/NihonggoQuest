<?php

namespace App\Repositories\Admin;

use LaravelEasyRepository\Repository;

interface AdminRepository extends Repository{

    public function findByUsername($username);
}
