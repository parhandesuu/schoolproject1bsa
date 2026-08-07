<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'respondent_role',
        'q1_rating',
        'q2_rating',
        'q3_rating',
        'q4_rating',
        'q5_rating',
        'q6_rating',
        'q7_rating',
        'q8_rating',
        'q9_rating',
        'average_score',
        'answers',
        'improvement_suggestion',
        'future_expectation',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'q1_rating'     => 'integer',
        'q2_rating'     => 'integer',
        'q3_rating'     => 'integer',
        'q4_rating'     => 'integer',
        'q5_rating'     => 'integer',
        'q6_rating'     => 'integer',
        'q7_rating'     => 'integer',
        'q8_rating'     => 'integer',
        'q9_rating'     => 'integer',
        'average_score' => 'float',
        'answers'       => 'array',
    ];

    /**
     * Daftar pilihan peran responden.
     */
    public static function roles(): array
    {
        return [
            'Orang Tua / Wali',
            'Pendidik / Tenaga Kependidikan',
            'Murid',
            'Alumni',
            'Lainnya',
        ];
    }

    /**
     * Daftar lengkap pertanyaan unsur SKM beserta opsi skala 1-4 (Dinamis dari database).
     */
    public static function questions(): array
    {
        try {
            $dbQuestions = SurveyQuestion::active()->ordered()->get();
            if ($dbQuestions->isNotEmpty()) {
                $list = [];
                foreach ($dbQuestions as $index => $q) {
                    $num = $index + 1;
                    $list[$num] = [
                        'id'          => $q->id,
                        'order'       => $q->order,
                        'code'        => $q->code ?: ('U' . $num),
                        'title'       => $q->title,
                        'question'    => $q->question,
                        'icon'        => $q->icon ?: 'fas fa-clipboard-check',
                        'options'     => $q->formatted_options,
                    ];
                }
                return $list;
            }
        } catch (\Throwable $e) {
            // fallback if table does not exist or error
        }

        return self::defaultQuestions();
    }

    /**
     * Fallback 9 pertanyaan standar Permenpan RB No. 14/2017.
     */
    public static function defaultQuestions(): array
    {
        return [
            1 => [

                'title'       => 'Kesesuaian Persyaratan Pelayanan',
                'question'    => 'Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan yang ada di UPT SMP Negeri 1 Buay Sandang Aji dengan jenis pelayanannya (SPMB, MPLS, pengurusan administrasi sekolah, dan pelayanan lainnya)?',
                'icon'        => 'fas fa-clipboard-check',
                'options'     => [
                    4 => ['label' => 'Sangat Sesuai', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Sesuai', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Kurang Sesuai', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Sesuai', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            2 => [
                'title'       => 'Kemudahan Prosedur Pelayanan',
                'question'    => 'Seberapa puas Saudara dengan kemudahan prosedur pelayanan di UPT SMP Negeri 1 Buay Sandang Aji (Perizinan, Mutasi Murid, Pengurusan Ijazah, Pengaduan, dan pelayanan lainnya)?',
                'icon'        => 'fas fa-route',
                'options'     => [
                    4 => ['label' => 'Sangat Puas', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Puas', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Kurang Puas', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Puas', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            3 => [
                'title'       => 'Kecepatan Waktu Pelayanan',
                'question'    => 'Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?',
                'icon'        => 'fas fa-stopwatch',
                'options'     => [
                    4 => ['label' => 'Sangat Cepat', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Cepat', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Kurang Cepat', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Cepat', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            4 => [
                'title'       => 'Kewajaran Biaya / Tarif Pelayanan',
                'question'    => 'Bagaimana pendapat Saudara tentang kewajaran biaya atau tarif dalam pelayanan?',
                'icon'        => 'fas fa-hand-holding-usd',
                'options'     => [
                    4 => ['label' => 'Gratis', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Murah', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Cukup Mahal', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Sangat Mahal', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            5 => [
                'title'       => 'Kesesuaian Hasil Pelayanan',
                'question'    => 'Bagaimana pendapat Saudara tentang kesesuaian pelayanan antara standar pelayanan dengan hasil pelayanan yang diberikan?',
                'icon'        => 'fas fa-check-double',
                'options'     => [
                    4 => ['label' => 'Sangat Sesuai', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Sesuai', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Kurang Sesuai', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Sesuai', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            6 => [
                'title'       => 'Kompetensi Guru & Tenaga Kependidikan',
                'question'    => 'Bagaimana pendapat Saudara mengenai kompetensi atau kemampuan guru dan tenaga kependidikan dalam memberikan pelayanan di UPT SMP Negeri 1 Buay Sandang Aji?',
                'icon'        => 'fas fa-user-graduate',
                'options'     => [
                    4 => ['label' => 'Sangat Kompeten', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Kompeten', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Kurang Kompeten', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Kompeten', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            7 => [
                'title'       => 'Perilaku Pelaksana (Kesopanan & Keramahan)',
                'question'    => 'Bagaimana pendapat Saudara mengenai perilaku guru dan tenaga kependidikan dalam memberikan pelayanan (kesopanan dan keramahan)?',
                'icon'        => 'fas fa-heart',
                'options'     => [
                    4 => ['label' => 'Sangat Sopan & Ramah', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Sopan & Ramah', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Kurang Sopan & Ramah', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Sopan & Ramah', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            8 => [
                'title'       => 'Kualitas Sarana & Prasarana',
                'question'    => 'Bagaimana pendapat Saudara mengenai kualitas sarana dan prasarana di UPT SMP Negeri 1 Buay Sandang Aji?',
                'icon'        => 'fas fa-school',
                'options'     => [
                    4 => ['label' => 'Sangat Baik', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Baik', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Cukup', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Buruk', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
            9 => [
                'title'       => 'Penanganan Pengaduan',
                'question'    => 'Bagaimana pendapat Saudara mengenai penanganan pengaduan di UPT SMP Negeri 1 Buay Sandang Aji?',
                'icon'        => 'fas fa-comments',
                'options'     => [
                    4 => ['label' => 'Dikelola dengan Baik', 'color' => 'emerald', 'icon' => 'far fa-grin-stars'],
                    3 => ['label' => 'Berfungsi tapi Belum Maksimal', 'color' => 'blue', 'icon' => 'far fa-smile'],
                    2 => ['label' => 'Ada tapi Tidak Berfungsi', 'color' => 'amber', 'icon' => 'far fa-meh'],
                    1 => ['label' => 'Tidak Ada', 'color' => 'rose', 'icon' => 'far fa-frown'],
                ],
            ],
        ];
    }

    /**
     * Hitung rata-rata nilai dari baris instance saat ini.
     */
    public function calculateAverage(): float
    {
        $sum = $this->q1_rating + $this->q2_rating + $this->q3_rating +
               $this->q4_rating + $this->q5_rating + $this->q6_rating +
               $this->q7_rating + $this->q8_rating + $this->q9_rating;

        return round($sum / 9, 2);
    }

    /**
     * Konversi nilai rata-rata (1-4) ke Indeks Kepuasan Masyarakat (IKM) standar Permenpan RB (25 - 100).
     */
    public static function convertToIkm(float $averageScore): float
    {
        return round($averageScore * 25, 2);
    }

    /**
     * Predikat & Mutu Pelayanan berdasarkan Nilai IKM Konversi (25 - 100).
     */
    public static function getIkmGrade(float $ikmScore): array
    {
        if ($ikmScore >= 88.31) {
            return [
                'grade'       => 'A',
                'performance' => 'Sangat Baik',
                'text_color'  => 'text-emerald-700',
                'bg_color'    => 'bg-emerald-50',
                'border'      => 'border-emerald-200',
                'badge'       => 'bg-emerald-500 text-white',
                'description' => 'Tingkat kepuasan masyarakat sangat tinggi terhadap seluruh aspek pelayanan.',
            ];
        } elseif ($ikmScore >= 76.61) {
            return [
                'grade'       => 'B',
                'performance' => 'Baik',
                'text_color'  => 'text-blue-700',
                'bg_color'    => 'bg-blue-50',
                'border'      => 'border-blue-200',
                'badge'       => 'bg-blue-500 text-white',
                'description' => 'Pelayanan berjalan baik dan memenuhi standar yang diharapkan masyarakat.',
            ];
        } elseif ($ikmScore >= 65.00) {
            return [
                'grade'       => 'C',
                'performance' => 'Kurang Baik',
                'text_color'  => 'text-amber-700',
                'bg_color'    => 'bg-amber-50',
                'border'      => 'border-amber-200',
                'badge'       => 'bg-amber-500 text-white',
                'description' => 'Pelayanan masih memerlukan pembenahan pada beberapa unsur utama.',
            ];
        } else {
            return [
                'grade'       => 'D',
                'performance' => 'Tidak Baik',
                'text_color'  => 'text-rose-700',
                'bg_color'    => 'bg-rose-50',
                'border'      => 'border-rose-200',
                'badge'       => 'bg-rose-500 text-white',
                'description' => 'Perlu evaluasi menyeluruh terhadap sistem dan kualitas pelayanan.',
            ];
        }
    }
}
