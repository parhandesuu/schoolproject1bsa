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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('respondent_role'); // Orang Tua / Wali, Pendidik / Tenaga Kependidikan, Murid, Alumni, Lainnya
            $table->unsignedTinyInteger('q1_rating'); // 1-4
            $table->unsignedTinyInteger('q2_rating'); // 1-4
            $table->unsignedTinyInteger('q3_rating'); // 1-4
            $table->unsignedTinyInteger('q4_rating'); // 1-4
            $table->unsignedTinyInteger('q5_rating'); // 1-4
            $table->unsignedTinyInteger('q6_rating'); // 1-4
            $table->unsignedTinyInteger('q7_rating'); // 1-4
            $table->unsignedTinyInteger('q8_rating'); // 1-4
            $table->unsignedTinyInteger('q9_rating'); // 1-4
            $table->decimal('average_score', 4, 2)->default(0);
            $table->text('improvement_suggestion')->nullable();
            $table->text('future_expectation')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('respondent_role');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
