<?php

namespace App\Repositories\Rank;

use LaravelEasyRepository\Repository;

interface RankRepository extends Repository{

    public function create($name);
    public function findAll();
    public function findByName($name);
    public function findByIdWithTheirUsers($id);
}
