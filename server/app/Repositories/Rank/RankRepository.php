<?php

namespace App\Repositories\Rank;

use LaravelEasyRepository\Repository;

interface RankRepository extends Repository{

    public function findByName($name);
    public function create($name);
}
