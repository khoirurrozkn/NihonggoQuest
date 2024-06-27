<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function userProfiles(){
        return $this->hasMany(UserProfile::class, 'rank_id', 'id');
    }
}
