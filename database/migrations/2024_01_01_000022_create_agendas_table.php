<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('color')->default('#1e40af');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
