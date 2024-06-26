<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{

    public function create($user);
    public function findByUsernameOrEmail($usernameOrEmail, $username = null, $email = null);
    public function findById($id);
    public function updateEmail($id, $email);
    public function updateUsername($id, $username);
    public function updatePassword($id, $password);
    public function deleteById($id);
    public function loginUpdateLastAcess($user, $date);
}
