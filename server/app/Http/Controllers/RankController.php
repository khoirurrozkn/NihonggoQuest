<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\RankCreateRequest;
use App\Http\Requests\RankUpdateNameRequest;
use App\Http\Resources\RankResource;
use App\Models\Rank;
use Symfony\Component\HttpFoundation\Response;

class RankController extends Controller
{
    public function create(RankCreateRequest $rankCreateRequest){
        $request = $rankCreateRequest->validated();

        $createdRank = Rank::create([
            'name' => $request['name']
        ]);

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success create rank", 
            new RankResource($createdRank)
        );
    }

    public function findAll(){
        return Dto::success(
            Response::HTTP_OK, 
            "Success find all rank", 
            RankResource::collection(Rank::orderBy('id')->get())
        );
    }

    public function findByIdWithTheirUsers(Rank $rank){
        $paginate = $rank->userProfiles()->paginate(10);
        $rank->user_profiles = $paginate->items();

        return Dto::successWithPagination(
            new RankResource($rank), 
            "Success get rank with their users", 
            $paginate
        );
    }

    public function updateNameById(RankUpdateNameRequest $rankUpdateNameRequest, Rank $rank){
        $request = $rankUpdateNameRequest->validated();

        $rank->update([
            'name' => $request['name']
        ]);

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success update name rank", 
            new RankResource($rank)
        );
    }
}
