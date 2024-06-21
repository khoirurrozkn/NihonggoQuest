<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_submissions', function (Blueprint $table) {
            $table->id("quiz_submission_id");
            $table->uuid("user_id")->nullable(false);
            $table->unsignedBigInteger("quiz_id")->nullable(false);
            $table->unsignedInteger("score")->nullable(false);

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete("cascade");
            $table->foreign('quiz_id')->references('quiz_id')->on('quizzes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_submissions');
    }
};
