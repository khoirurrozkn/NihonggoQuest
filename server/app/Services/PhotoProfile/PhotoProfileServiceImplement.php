<?php

namespace App\Services\PhotoProfile;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\PhotoProfile\PhotoProfileRepository;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoProfileServiceImplement extends ServiceApi implements PhotoProfileService{

    protected $mainRepository;

    public function __construct(PhotoProfileRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function create($photoUrl){
        if( $this->mainRepository->findByPhotoUrl($photoUrl) ){
            throw new ConflictHttpException("Photo has been exists");
        }

        return $this->mainRepository->create([
            'photo_url' => $photoUrl
        ]);
    }

    public function findAll(){
        return $this->mainRepository->findAll();
    }

    public function updatePhotoUrlById($id, $photoUrl){
        $findPhotoProfile = $this->mainRepository->findById($id);

        if( !$findPhotoProfile ) throw new NotFoundHttpException("Photo profile not found");

        if( $photoUrl !== $findPhotoProfile['photo_url'] ) {
            $this->mainRepository->updatePhotoUrlByInstance($findPhotoProfile, $photoUrl);
        }
        
        return $findPhotoProfile;
    }
}
