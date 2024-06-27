<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\RankCreateRequest;
use App\Http\Resources\RankResource;
use App\Services\Rank\RankServiceImplement;
use Symfony\Component\HttpFoundation\Response;

class RankController extends Controller
{
    private $rankService;

    public function __construct(RankServiceImplement $rankService)
    {
        $this->rankService = $rankService;
    }

    public function create(RankCreateRequest $rankCreateRequest){
        $request = $rankCreateRequest->validated();

        $response = $this->rankService->create(
            $request['name']
        );

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success create rank", 
            new RankResource($response)
        );
    }

    public function findAll(){
        $getAllRank = $this->rankService->findAll();

        return Dto::success(
            Response::HTTP_OK, 
            "Success find all rank", 
            RankResource::collection($getAllRank)
        );
    }

    public function findByIdWithTheirUsers($id){
        $getRankWithUsers = $this->rankService->findByIdWithTheirUsers($id);

        return Dto::success(
            Response::HTTP_OK, 
            "Success find rank with their user", 
            new RankResource($getRankWithUsers)
        );
    }
}
