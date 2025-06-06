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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('user_hash_token')->unique();
            $table->timestamps();
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->text('identifier')->unique();
            $table->string('name')->unique();
            $table->text("code");
            $table->timestamp("refreshed_at")->nullable();
            $table->timestamps();
        });

        Schema::create('track_player_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_id');
            $table->unsignedBigInteger('player_id');
            $table->integer('time_ms');
            $table->timestamps();

            $table->unique(['track_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('tracks');
        Schema::dropIfExists('track_player_records');
    }
};
