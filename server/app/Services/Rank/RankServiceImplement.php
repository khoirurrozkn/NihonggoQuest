<?php

namespace App\Services\Rank;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Rank\RankRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RankServiceImplement extends ServiceApi implements RankService{

    protected $mainRepository;

    public function __construct(RankRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($name){
        if( $this->mainRepository->findByName($name) ){
            throw new ConflictHttpException("Name has been exists");
        }

        return $this->mainRepository->create([
            'name' => $name
        ]);
    }
}
