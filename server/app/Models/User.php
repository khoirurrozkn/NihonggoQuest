<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public $timestamps = false;

    public function getIncrementing(){
        return false;
    }

    public function getKeyType(){
        return "string";
    }

    public function userProfile(){
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }
}
