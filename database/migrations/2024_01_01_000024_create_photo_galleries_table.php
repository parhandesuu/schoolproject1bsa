<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('photo_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_album_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('image');
            $table->text('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('photo_album_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_galleries');
        Schema::dropIfExists('photo_albums');
    }
};
