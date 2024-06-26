<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{

    public function create($user);
    public function findByEmail($email);
    public function findById($id);
    public function updateEmail($id, $email);
    public function updateUsername($id, $username);
    public function updatePassword($id, $password);
    public function deleteById($id);
}
