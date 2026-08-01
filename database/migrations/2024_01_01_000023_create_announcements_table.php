<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('file')->nullable();
            $table->enum('type', ['info', 'warning', 'success', 'danger'])->default('info');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();

            $table->index(['is_active', 'is_pinned']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
