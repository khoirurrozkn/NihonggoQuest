<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\PhotoProfileRequest;
use App\Http\Resources\PhotoProfileResource;
use App\Models\PhotoProfile;
use Symfony\Component\HttpFoundation\Response;

class PhotoProfileController extends Controller
{
    public function create(PhotoProfileRequest $photoProfileRequest){
        $request = $photoProfileRequest->validated();

        $createdPhotoProfile = PhotoProfile::create([
            'photo_url' => $request['photo_url']
        ]);

        return Dto::success(
            Response::HTTP_CREATED, 
            "Success create photo profile", 
            new PhotoProfileResource($createdPhotoProfile)
        );
    }

    public function findAll(){
        return Dto::success(
            Response::HTTP_OK, 
            "Success find all photo profiles", 
            PhotoProfileResource::collection(PhotoProfile::all())
        );
    }

    public function updatePhotoUrlById(PhotoProfileRequest $photoProfileRequest, PhotoProfile $photoProfile){
        $request = $photoProfileRequest->validated();

        $photoProfile->update([
            'photo_url' => $request['photo_url']
        ]);

        return Dto::success(
            Response::HTTP_OK, 
            "Success update photo profile", 
            new PhotoProfileResource($photoProfile)
        );
    }
}
