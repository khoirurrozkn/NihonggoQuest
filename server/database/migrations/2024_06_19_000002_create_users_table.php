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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid("id")->primary()->unique()->nullable(false);
            $table->string("email", 255)->unique()->nullable(false);
            $table->string("username", 50)->unique()->nullable(false);
            $table->string("password", 255)->nullable(false);
            $table->timestamp("last_access")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
