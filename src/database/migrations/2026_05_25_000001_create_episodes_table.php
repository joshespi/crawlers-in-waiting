<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('episode_number');
            $table->unsignedSmallInteger('season_number')->default(1);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('show_notes')->nullable();
            $table->string('audio_url');
            $table->string('youtube_url')->nullable();
            $table->unsignedInteger('duration_seconds');
            $table->string('cover_image_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('published_at');
            $table->index(['season_number', 'episode_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
