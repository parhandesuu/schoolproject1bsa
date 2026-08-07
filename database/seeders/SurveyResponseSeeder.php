<?php

namespace Database\Seeders;

use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SurveyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = SurveyResponse::questions();

        $sampleFeedbacks = [
            // 1. Orang Tua / Wali
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 3, 4],
                'suggestion' => 'Pelayanan informasi PPDB dan administrasi surat keterangan siswa sudah sangat cepat dan ramah.',
                'expectation' => 'Semoga ke depan sistem notifikasi kehadiran dan nilai siswa bisa diakses langsung via aplikasi atau pesan singkat.',
                'days_ago' => 28,
            ],
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [4, 3, 3, 4, 4, 4, 3, 3, 3],
                'suggestion' => 'Ruang tunggu pelayanan administrasi TU sudah nyaman, namun mohon ditambah kursi saat musim penerimaan murid baru.',
                'expectation' => 'Kualitas komunikasi antara pihak sekolah dan wali murid tetap dipertahankan dengan baik.',
                'days_ago' => 24,
            ],
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [4, 4, 3, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Transparansi biaya sangat baik, tidak ada pungutan liar sama sekali. Sangat membantu keluarga kami.',
                'expectation' => 'Fasilitas ekstrakurikuler seni dan olahraga murid dapat lebih diperbanyak.',
                'days_ago' => 19,
            ],
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [3, 4, 4, 4, 4, 4, 3, 3, 4],
                'suggestion' => 'Petugas tata usaha sangat santun dan sabar dalam menjelaskan alur pengurusan surat mutasi.',
                'expectation' => 'Semoga UPT SMPN 1 Buay Sandang Aji semakin berprestasi di tingkat kabupaten dan provinsi.',
                'days_ago' => 15,
            ],
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Semua layanan gratis, cepat, dan petugas sangat sigap membantu orang tua yang kurang paham berkas online.',
                'expectation' => 'Pertahankan keramahan dan integritas pelayanan yang sudah sangat baik ini.',
                'days_ago' => 11,
            ],
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [3, 3, 3, 4, 3, 3, 3, 2, 3],
                'suggestion' => 'Alur pendaftaran sudah jelas, hanya saja tempat parkir wali murid saat pengambilan rapor perlu ditata lebih rapi.',
                'expectation' => 'Penataan area parkir dan kanopi ruang tunggu depan gerbang sekolah agar tidak kepanasan.',
                'days_ago' => 6,
            ],
            [
                'role' => 'Orang Tua / Wali',
                'ratings' => [4, 4, 3, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Pelayanan guru dan staf sekolah sangat responsif jika ada pertanyaan terkait jadwal ujian anak.',
                'expectation' => 'Ditingkatkan lagi kegiatan parenting dan pertemuan berkala antara wali kelas dan wali murid.',
                'days_ago' => 2,
            ],

            // 2. Murid
            [
                'role' => 'Murid',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 3],
                'suggestion' => 'Bapak dan Ibu guru sangat baik dan sabar mengajar di kelas. Petugas perpustakaan juga ramah.',
                'expectation' => 'Semoga koleksi buku cerita dan ensiklopedia di perpustakaan ditambah lagi.',
                'days_ago' => 26,
            ],
            [
                'role' => 'Murid',
                'ratings' => [4, 3, 4, 4, 3, 4, 4, 3, 4],
                'suggestion' => 'Pelayanan bimbingan konseling (BK) sangat membantu saat kami membutuhkan konsultasi belajar.',
                'expectation' => 'Fasilitas WiFi sekolah untuk pembelajaran di lab komputer mohon dipercepat lagi.',
                'days_ago' => 21,
            ],
            [
                'role' => 'Murid',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 3, 4],
                'suggestion' => 'Pelayanan UKS dan fasilitas kebersihan kelas sudah sangat baik.',
                'expectation' => 'Kantin sekolah diperluas dan ditambah variasi menu makanan sehat.',
                'days_ago' => 17,
            ],
            [
                'role' => 'Murid',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Proses pengurusan surat izin dan kartu pelajar sangat cepat, langsung jadi.',
                'expectation' => 'Banyak lomba-lomba seru antarkelas seperti class meeting dan pentas seni.',
                'days_ago' => 12,
            ],
            [
                'role' => 'Murid',
                'ratings' => [3, 4, 3, 4, 4, 4, 3, 3, 3],
                'suggestion' => 'Kebersihan toilet siswa mohon ditingkatkan kembali dan air dipastikan selalu mengalir lancar.',
                'expectation' => 'Semoga ada tambahan pendingin ruangan atau kipas angin di beberapa ruang kelas.',
                'days_ago' => 5,
            ],
            [
                'role' => 'Murid',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Belajar di SMPN 1 Buay Sandang Aji sangat menyenangkan, guru-gurunya asik dan adil.',
                'expectation' => 'Kegiatan ekstrakurikuler pramuka dan futsal terus didukung penuh peralatannya.',
                'days_ago' => 1,
            ],

            // 3. Pendidik / Tenaga Kependidikan
            [
                'role' => 'Pendidik / Tenaga Kependidikan',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Tata kelola administrasi kepegawaian dan kearsipan di kantor TU sangat terstruktur dan rapi.',
                'expectation' => 'Penyediaan perangkat pembelajaran digital seperti proyektor interaktif di setiap ruang kelas.',
                'days_ago' => 25,
            ],
            [
                'role' => 'Pendidik / Tenaga Kependidikan',
                'ratings' => [4, 4, 3, 4, 4, 4, 4, 3, 4],
                'suggestion' => 'Koordinasi antarbidang berjalan harmonis. Penanganan pengaduan dari warga sekolah ditindaklanjuti cepat.',
                'expectation' => 'Peningkatan kapasitas pelatihan berkelanjutan (workshop Kurikulum Merdeka) untuk seluruh guru.',
                'days_ago' => 18,
            ],
            [
                'role' => 'Pendidik / Tenaga Kependidikan',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Transparansi anggaran operasional sekolah (BOS) sangat terjaga dan tepat sasaran.',
                'expectation' => 'Integrasi sistem administrasi guru dengan website sekolah agar lebih efisien dan ramah lingkungan (paperless).',
                'days_ago' => 10,
            ],
            [
                'role' => 'Pendidik / Tenaga Kependidikan',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 3, 4],
                'suggestion' => 'Suasana kerja sangat kondusif, sarana dan prasarana ruang guru sangat menunjang produktivitas.',
                'expectation' => 'Pengembangan laboratorium sains terpadu untuk praktikum siswa.',
                'days_ago' => 3,
            ],

            // 4. Alumni
            [
                'role' => 'Alumni',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Pengurusan legalisir ijazah dan surat keterangan pengganti ijazah sangat cepat, dilayani dengan ramah oleh staf TU.',
                'expectation' => 'Diadakan wadah reuni dan forum alumni untuk berbagi informasi beasiswa dan karir kepada adik-adik kelas.',
                'days_ago' => 27,
            ],
            [
                'role' => 'Alumni',
                'ratings' => [4, 4, 3, 4, 4, 4, 4, 4, 3],
                'suggestion' => 'Pelayanan legalisir via kontak sekolah direspon dengan cepat meskipun saya tinggal di luar kota.',
                'expectation' => 'Bisa disediakan fitur permohonan legalisir dan verifikasi dokumen secara online melalui website sekolah.',
                'days_ago' => 20,
            ],
            [
                'role' => 'Alumni',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Bangga melihat perkembangan sekolah saat ini yang semakin modern, bersih, dan berprestasi.',
                'expectation' => 'SMPN 1 Buay Sandang Aji terus menjadi sekolah rujukan terbaik di wilayah OKU Selatan.',
                'days_ago' => 9,
            ],
            [
                'role' => 'Alumni',
                'ratings' => [4, 3, 4, 4, 4, 4, 3, 3, 4],
                'suggestion' => 'Proses verifikasi data alumni cepat dan tidak berbelit-belit.',
                'expectation' => 'Koneksi ikatan alumni dibuatkan database resmi di website sekolah.',
                'days_ago' => 4,
            ],

            // 5. Lainnya (Masyarakat / Tamu / Komite Sekolah)
            [
                'role' => 'Lainnya',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Pelayanan informasi publik dan keterbukaan sekolah kepada masyarakat sekitar sangat patut diapresiasi.',
                'expectation' => 'Kerjasama antara pihak sekolah dengan lingkungan masyarakat dan tokoh pemuda setempat terus dipererat.',
                'days_ago' => 22,
            ],
            [
                'role' => 'Lainnya',
                'ratings' => [4, 4, 3, 4, 4, 4, 4, 3, 4],
                'suggestion' => 'Satpam dan petugas penerima tamu di gerbang utama sangat sopan, mengarahkan tamu dengan santun dan ramah.',
                'expectation' => 'Rambu petunjuk ruangan dan denah sekolah dipasang lebih jelas di area lobi.',
                'days_ago' => 14,
            ],
            [
                'role' => 'Lainnya',
                'ratings' => [4, 4, 4, 4, 4, 4, 4, 4, 4],
                'suggestion' => 'Pelayanan persuratan kedinasan dan koordinasi antarinstansi selalu cepat tanpa hambatan.',
                'expectation' => 'Pertahankan standar mutu pelayanan prima (pelayanan ramah anak dan berintegritas).',
                'days_ago' => 7,
            ],
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.6167.178 Mobile Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',
            'Mozilla/5.0 (Linux; Android 14; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.6261.90 Mobile Safari/537.36',
        ];

        foreach ($sampleFeedbacks as $idx => $sample) {
            $sum = 0;
            $answersDetail = [];
            $totalQ = count($questions);

            foreach ($questions as $num => $q) {
                $score = $sample['ratings'][$num - 1] ?? 4;
                $sum += $score;
                $optLabel = $q['options'][$score]['label'] ?? "Skala {$score}";

                $answersDetail[] = [
                    'number'         => $num,
                    'question_id'    => $q['id'] ?? null,
                    'code'           => $q['code'] ?? ('U' . $num),
                    'title'          => $q['title'],
                    'question'       => $q['question'],
                    'rating'         => $score,
                    'selected_label' => $optLabel,
                ];
            }

            $avgScore = $totalQ > 0 ? round($sum / $totalQ, 2) : 4.0;
            $createdAt = Carbon::now()->subDays($sample['days_ago'])->subHours(rand(1, 10))->subMinutes(rand(5, 55));
            $ip = '192.168.1.' . (10 + ($idx % 50));
            $ua = $userAgents[$idx % count($userAgents)];

            SurveyResponse::create([
                'respondent_role'        => $sample['role'],
                'q1_rating'              => (int) ($answersDetail[0]['rating'] ?? 4),
                'q2_rating'              => (int) ($answersDetail[1]['rating'] ?? 4),
                'q3_rating'              => (int) ($answersDetail[2]['rating'] ?? 4),
                'q4_rating'              => (int) ($answersDetail[3]['rating'] ?? 4),
                'q5_rating'              => (int) ($answersDetail[4]['rating'] ?? 4),
                'q6_rating'              => (int) ($answersDetail[5]['rating'] ?? 4),
                'q7_rating'              => (int) ($answersDetail[6]['rating'] ?? 4),
                'q8_rating'              => (int) ($answersDetail[7]['rating'] ?? 4),
                'q9_rating'              => (int) ($answersDetail[8]['rating'] ?? 4),
                'average_score'          => $avgScore,
                'answers'                => $answersDetail,
                'improvement_suggestion' => $sample['suggestion'],
                'future_expectation'     => $sample['expectation'],
                'ip_address'             => $ip,
                'user_agent'             => $ua,
                'created_at'             => $createdAt,
                'updated_at'             => $createdAt,
            ]);
        }
    }
}
