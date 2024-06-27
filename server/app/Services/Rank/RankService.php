<?php

namespace App\Services\Rank;

use LaravelEasyRepository\BaseService;

interface RankService extends BaseService{

    public function create($name);
    public function findAll();
    public function findByIdWithTheirUsers($id);
}
