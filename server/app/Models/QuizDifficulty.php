<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizDifficulty extends Model
{
    use HasFactory;

    protected $guarded = ['quiz_difficulty_id'];
}
