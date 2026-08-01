<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable()->unique();
            $table->string('position'); // jabatan
            $table->string('subject')->nullable(); // mata pelajaran
            $table->string('education')->nullable(); // pendidikan terakhir
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->enum('type', ['teacher', 'staff'])->default('teacher');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
