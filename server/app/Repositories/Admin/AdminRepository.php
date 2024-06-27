<?php

namespace App\Repositories\Admin;

use LaravelEasyRepository\Repository;

interface AdminRepository extends Repository{

    public function findAll();
    public function findById($id);
    public function findByUsername($username);
    public function deleteByInstance($adminModel);
}
