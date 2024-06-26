<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    public function register($email, $username, $password);
    public function login($usernameOrEmail, $password);
    public function findById($id);
    public function updateEmail($id, $oldEmail, $newEmail);
    public function updateUsername($id, $oldUsername, $newUsername);
    public function updatePassword($id, $passwordFromToken, $oldPassword, $newPassword);
    public function deleteById($idFromToken, $idFromParam, $isAdmin);
}
