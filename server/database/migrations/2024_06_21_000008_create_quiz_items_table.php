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
        Schema::create('quiz_items', function (Blueprint $table) {
            $table->id("quiz_item_id");
            $table->string("question")->nullable(false);
            $table->string("answer")->nullable(false);
            $table->unsignedBigInteger("quiz_id")->nullable(false);

            $table->foreign('quiz_id')->references('quiz_id')->on('quizzes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_items');
    }
};
