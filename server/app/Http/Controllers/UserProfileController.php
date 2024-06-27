<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Services\UserProfile\UserProfileServiceImplement;

class UserProfileController extends Controller
{
    private $userProfile;

    public function __construct(UserProfileServiceImplement $userProfile)
    {
        $this->userProfile = $userProfile;
    }

    // public function updateEmail(UserProfileUpdateRequest $userProfileUpdateRequest){
    //     $request = $userProfileUpdateRequest->validated();

    //     $this->userProfile->update(
    //         auth()->user()->id,
    //         auth()->user()->email,
    //         $request['email']
    //     );
            
    //     auth()->user()->email = $request['email'];
    //     return Dto::success(
    //         Response::HTTP_OK, 
    //         "Success update email user",
    //         new UserResource(auth()->user())
    //     );
    // }
}
