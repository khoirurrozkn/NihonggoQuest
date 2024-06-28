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
            $table->uuid("id")->primary()->unique()->nullable(false);
            $table->string("bio", 120)->default("Japan language is easy")->nullable();
            $table->uuid("user_id")->unique()->nullable(false);
            $table->unsignedBigInteger("photo_profile_id")->default(1);
            $table->unsignedBigInteger("rank_id")->default(1);

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
