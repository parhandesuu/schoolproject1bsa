<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order')->default(1);
            $table->string('code', 20)->nullable(); // e.g. U1, U2, etc.
            $table->string('title');
            $table->text('question');
            $table->string('icon', 100)->nullable()->default('fas fa-clipboard-check');
            $table->string('opt1_label')->default('Tidak Sesuai');
            $table->string('opt2_label')->default('Kurang Sesuai');
            $table->string('opt3_label')->default('Sesuai');
            $table->string('opt4_label')->default('Sangat Sesuai');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('order');
            $table->index('is_active');
        });

        // Seed 9 initial standard questions (Permenpan RB No. 14/2017)
        $now = now();
        $defaults = [
            [
                'order'      => 1,
                'code'       => 'U1',
                'title'      => 'Kesesuaian Persyaratan Pelayanan',
                'question'   => 'Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan yang ada di UPT SMP Negeri 1 Buay Sandang Aji dengan jenis pelayanannya (SPMB, MPLS, pengurusan administrasi sekolah, dan pelayanan lainnya)?',
                'icon'       => 'fas fa-clipboard-check',
                'opt1_label' => 'Tidak Sesuai',
                'opt2_label' => 'Kurang Sesuai',
                'opt3_label' => 'Sesuai',
                'opt4_label' => 'Sangat Sesuai',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 2,
                'code'       => 'U2',
                'title'      => 'Kemudahan Prosedur Pelayanan',
                'question'   => 'Seberapa puas Saudara dengan kemudahan prosedur pelayanan di UPT SMP Negeri 1 Buay Sandang Aji (Perizinan, Mutasi Murid, Pengurusan Ijazah, Pengaduan, dan pelayanan lainnya)?',
                'icon'       => 'fas fa-route',
                'opt1_label' => 'Tidak Puas',
                'opt2_label' => 'Kurang Puas',
                'opt3_label' => 'Puas',
                'opt4_label' => 'Sangat Puas',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 3,
                'code'       => 'U3',
                'title'      => 'Kecepatan Waktu Pelayanan',
                'question'   => 'Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?',
                'icon'       => 'fas fa-stopwatch',
                'opt1_label' => 'Tidak Cepat',
                'opt2_label' => 'Kurang Cepat',
                'opt3_label' => 'Cepat',
                'opt4_label' => 'Sangat Cepat',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 4,
                'code'       => 'U4',
                'title'      => 'Kewajaran Biaya / Tarif Pelayanan',
                'question'   => 'Bagaimana pendapat Saudara tentang kewajaran biaya atau tarif dalam pelayanan?',
                'icon'       => 'fas fa-hand-holding-usd',
                'opt1_label' => 'Sangat Mahal',
                'opt2_label' => 'Cukup Mahal',
                'opt3_label' => 'Murah',
                'opt4_label' => 'Gratis',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 5,
                'code'       => 'U5',
                'title'      => 'Kesesuaian Hasil Pelayanan',
                'question'   => 'Bagaimana pendapat Saudara tentang kesesuaian pelayanan antara standar pelayanan dengan hasil pelayanan yang diberikan?',
                'icon'       => 'fas fa-check-double',
                'opt1_label' => 'Tidak Sesuai',
                'opt2_label' => 'Kurang Sesuai',
                'opt3_label' => 'Sesuai',
                'opt4_label' => 'Sangat Sesuai',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 6,
                'code'       => 'U6',
                'title'      => 'Kompetensi Guru & Tenaga Kependidikan',
                'question'   => 'Bagaimana pendapat Saudara mengenai kompetensi atau kemampuan guru dan tenaga kependidikan dalam memberikan pelayanan di UPT SMP Negeri 1 Buay Sandang Aji?',
                'icon'       => 'fas fa-user-graduate',
                'opt1_label' => 'Tidak Kompeten',
                'opt2_label' => 'Kurang Kompeten',
                'opt3_label' => 'Kompeten',
                'opt4_label' => 'Sangat Kompeten',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 7,
                'code'       => 'U7',
                'title'      => 'Perilaku Pelaksana (Kesopanan & Keramahan)',
                'question'   => 'Bagaimana pendapat Saudara mengenai perilaku guru dan tenaga kependidikan dalam memberikan pelayanan (kesopanan dan keramahan)?',
                'icon'       => 'fas fa-heart',
                'opt1_label' => 'Tidak Sopan & Ramah',
                'opt2_label' => 'Kurang Sopan & Ramah',
                'opt3_label' => 'Sopan & Ramah',
                'opt4_label' => 'Sangat Sopan & Ramah',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 8,
                'code'       => 'U8',
                'title'      => 'Kualitas Sarana & Prasarana',
                'question'   => 'Bagaimana pendapat Saudara mengenai kualitas sarana dan prasarana di UPT SMP Negeri 1 Buay Sandang Aji?',
                'icon'       => 'fas fa-school',
                'opt1_label' => 'Buruk',
                'opt2_label' => 'Cukup',
                'opt3_label' => 'Baik',
                'opt4_label' => 'Sangat Baik',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'order'      => 9,
                'code'       => 'U9',
                'title'      => 'Penanganan Pengaduan',
                'question'   => 'Bagaimana pendapat Saudara mengenai penanganan pengaduan di UPT SMP Negeri 1 Buay Sandang Aji?',
                'icon'       => 'fas fa-comments',
                'opt1_label' => 'Tidak Ada',
                'opt2_label' => 'Ada tapi Tidak Berfungsi',
                'opt3_label' => 'Berfungsi tapi Belum Maksimal',
                'opt4_label' => 'Dikelola dengan Baik',
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('survey_questions')->insert($defaults);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
