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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable(false);
            $table->timestamp("created_at")->nullable(false);
            $table->unsignedBigInteger("quiz_difficulty_id")->nullable(false);

            $table->foreign('quiz_difficulty_id')->references('id')->on('quiz_difficulties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
