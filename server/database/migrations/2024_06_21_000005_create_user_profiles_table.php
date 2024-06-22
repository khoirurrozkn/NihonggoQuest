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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string("bio")->default("Japan language is easy")->nullable();
            $table->ulid("user_id")->unique()->nullable(false);
            $table->unsignedBigInteger("photo_profile_id")->nullable(false);
            $table->unsignedBigInteger("rank_id")->nullable(false);

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("photo_profile_id")->references("id")->on("photo_profiles");
            $table->foreign("rank_id")->references("id")->on("ranks");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
