<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\PhotoProfileRequest;
use App\Http\Resources\PhotoProfileResource;
use App\Services\PhotoProfile\PhotoProfileServiceImplement;
use Symfony\Component\HttpFoundation\Response;

class PhotoProfileController extends Controller
{
    private $photoProfileService;

    public function __construct(PhotoProfileServiceImplement $photoProfileService)
    {
        $this->photoProfileService = $photoProfileService;
    }

    public function create(PhotoProfileRequest $photoProfileRequest){
        $request = $photoProfileRequest->validated();

        $response = $this->photoProfileService->create(
            $request['photo_url']
        );

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success create photo profile", 
            new PhotoProfileResource($response)
        );
    }

    public function findAll(){
        $response = $this->photoProfileService->findAll();

        return Dto::success(
            Response::HTTP_OK, 
            "Success find all photo profiles", 
            PhotoProfileResource::collection($response)
        );
    }

    public function updatePhotoUrlById(PhotoProfileRequest $photoProfileRequest, $id){
        $request = $photoProfileRequest->validated();

        $response = $this->photoProfileService->updatePhotoUrlById(
            $id,
            $request['photo_url']
        );

        return Dto::success(
            Response::HTTP_OK, 
            "Success update photo profile", 
            new PhotoProfileResource($response)
        );
    }
}
