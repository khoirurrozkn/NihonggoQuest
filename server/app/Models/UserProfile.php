<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function photoProfile(){
        return $this->belongsto(PhotoProfile::class, 'photo_profile_id', 'id');
    }

    public function rank(){
        return $this->belongsTo(Rank::class, 'rank_id', 'id');
    }
}
