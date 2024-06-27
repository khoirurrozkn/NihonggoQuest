<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory;

    use HasApiTokens, HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function getIncrementing(){
        return false;
    }

    public function getKeyType(){
        return "string";
    }
}
