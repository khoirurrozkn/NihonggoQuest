<?php

namespace App\Http\Controllers;

use App\Dto\Dto;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\UserProfile;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController extends Controller
{
    public function update(UserProfileUpdateRequest $userProfileUpdateRequest){
        $request = $userProfileUpdateRequest->validated();

        $findUserProfile = UserProfile::find(auth()->user()->userProfile->id);
        $findUserProfile->update([
            'nickname' => $request['nickname'],
            'bio' => $request['bio'],
            'photo_profile_id' => $request['photo_profile_id']
        ]);
        
        return Dto::success(
            Response::HTTP_OK,
            "Success update user profile",
            new UserProfileResource($findUserProfile)
        );
    }
}
