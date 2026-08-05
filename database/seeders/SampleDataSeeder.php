<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistic;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\SocialMedia;
use App\Models\HeroSlider;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedStatistics();
        $this->seedSocialMedia();
        $this->seedHeroSliders();
        $this->seedCategories();
        $this->seedPosts();
        $this->seedAgendas();
        $this->seedAnnouncements();
        $this->seedTeachers();
        $this->seedFacilities();
        $this->seedAchievements();
        $this->seedExtracurriculars();
        $this->seedServices();
    }

    private function seedStatistics(): void
    {
        $stats = [
            ['label' => 'Jumlah Peserta Didik', 'value' => '367', 'icon' => 'fas fa-user-graduate', 'color' => '#1e40af', 'order' => 1],
            ['label' => 'Tenaga Pendidik (Guru)', 'value' => '28', 'icon' => 'fas fa-chalkboard-teacher', 'color' => '#0ea5e9', 'order' => 2],
            ['label' => 'Tenaga Kependidikan', 'value' => '10', 'icon' => 'fas fa-users-cog', 'color' => '#6366f1', 'order' => 3],
            ['label' => 'Rombongan Belajar', 'value' => '13', 'icon' => 'fas fa-school', 'color' => '#10b981', 'order' => 4],
            ['label' => 'Ekstrakurikuler', 'value' => '9', 'icon' => 'fas fa-futbol', 'color' => '#f59e0b', 'order' => 5],
            ['label' => 'Akreditasi Sekolah', 'value' => 'B', 'icon' => 'fas fa-award', 'color' => '#ec4899', 'order' => 6],
        ];
        foreach ($stats as $s) {
            Statistic::updateOrCreate(['label' => $s['label']], $s + ['is_active' => true]);
        }
    }

    private function seedSocialMedia(): void
    {
        $socials = [
            ['name' => 'Facebook', 'url' => 'https://facebook.com/upt.smpn1buaysandangaji', 'icon' => 'fab fa-facebook-f', 'color' => '#1877F2', 'order' => 1],
            ['name' => 'Instagram', 'url' => 'https://instagram.com/smpn1buaysandangaji', 'icon' => 'fab fa-instagram', 'color' => '#E4405F', 'order' => 2],
            ['name' => 'YouTube', 'url' => 'https://youtube.com/@smpn1buaysandangaji', 'icon' => 'fab fa-youtube', 'color' => '#FF0000', 'order' => 3],
            ['name' => 'WhatsApp', 'url' => 'https://wa.me/6282178901234', 'icon' => 'fab fa-whatsapp', 'color' => '#25D366', 'order' => 4],
        ];
        foreach ($socials as $s) {
            SocialMedia::updateOrCreate(['name' => $s['name']], $s + ['is_active' => true]);
        }
    }

    private function seedHeroSliders(): void
    {
        $sliders = [
            [
                'title' => 'Selamat Datang di UPT SMP Negeri 1 Buay Sandang Aji',
                'subtitle' => 'Mewujudkan Generasi yang Berakhlakul Karimah, Sukses, Berprestasi, dan Andal (B-S-B-A)',
                'image' => 'hero-sliders/hero1.jpg',
                'button_text' => 'Profil Sekolah',
                'button_url' => '/profil',
                'button_text_2' => 'Kontak Kami',
                'button_url_2' => '/kontak',
                'order' => 1
            ],
            [
                'title' => 'Pendidikan Karakter & Prestasi Berkelanjutan',
                'subtitle' => 'Didukung oleh 42 tenaga pendidik profesional dan fasilitas pembelajaran yang representatif',
                'image' => 'hero-sliders/hero2.jpg',
                'button_text' => 'Visi & Misi',
                'button_url' => '/visi-misi',
                'button_text_2' => 'Guru & Staff',
                'button_url_2' => '/guru-staff',
                'order' => 2
            ],
            [
                'title' => 'Standar Pelayanan Publik Terpadu & Akuntabel',
                'subtitle' => 'Pelayanan administrasi, legalisir, surat pindah, dan bimbingan konseling bebas biaya (GRATIS)',
                'image' => 'hero-sliders/hero3.jpg',
                'button_text' => 'Standar Layanan',
                'button_url' => '/layanan',
                'button_text_2' => 'Fasilitas Sekolah',
                'button_url_2' => '/fasilitas',
                'order' => 3
            ],
        ];
        foreach ($sliders as $s) {
            HeroSlider::updateOrCreate(['order' => $s['order']], $s + ['is_active' => true]);
        }
    }

    private function seedCategories(): void
    {
        $cats = [
            ['name' => 'Berita Sekolah', 'slug' => 'berita-sekolah', 'color' => '#1e40af'],
            ['name' => 'Kegiatan Siswa', 'slug' => 'kegiatan-siswa', 'color' => '#0ea5e9'],
            ['name' => 'Akademik & Kurikulum', 'slug' => 'akademik-kurikulum', 'color' => '#10b981'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'color' => '#f59e0b'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'color' => '#ef4444'],
            ['name' => 'Keagamaan & Karakter', 'slug' => 'keagamaan-karakter', 'color' => '#8b5cf6'],
        ];
        foreach ($cats as $c) {
            Category::updateOrCreate(['slug' => $c['slug']], $c + ['is_active' => true]);
        }
    }

    private function seedPosts(): void
    {
        $admin = User::first();
        $catBerita = Category::where('slug', 'berita-sekolah')->first() ?? Category::first();
        $catKegiatan = Category::where('slug', 'kegiatan-siswa')->first() ?? Category::first();
        $catKarakter = Category::where('slug', 'keagamaan-karakter')->first() ?? Category::first();
        $catPrestasi = Category::where('slug', 'prestasi')->first() ?? Category::first();

        $posts = [
            [
                'title' => 'Pembiasaan Sholat Dhuha dan Infak Jumat Membentuk Karakter Berakhlakul Karimah di UPT SMPN 1 Buay Sandang Aji',
                'excerpt' => 'Sebagai wujud pilar pertama visi B-S-B-A, seluruh murid dan dewan guru rutin melaksanakan sholat dhuha berjamaah dan infak setiap hari Jumat.',
                'content' => '<p>UPT SMP Negeri 1 Buay Sandang Aji secara konsisten menanamkan nilai-nilai religius kepada seluruh peserta didik melalui program pembiasaan ibadah bersama. Setiap pagi sebelum memulai aktivitas KBM, siswa diajak melaksanakan sholat dhuha berjamaah serta tadarus Al-Qur\'an Juz \'Amma di musholla sekolah.</p><p>Kepala UPT SMP Negeri 1 Buay Sandang Aji, Ibu <strong>Rosidah, S.Pd</strong>, menyampaikan bahwa pembiasaan ini adalah pondasi utama pembentukan akhlak mulia dan kepribadian yang luhur bagi generasi muda.</p>',
                'category_id' => $catKarakter->id,
                'is_featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(2)
            ],
            [
                'title' => 'Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK) di Laboratorium Komputer Berjalan Tertib dan Lancar',
                'excerpt' => 'Sebanyak 13 rombel dan peserta asesmen mengikuti ANBK dengan sarana laboratorium komputer terpadu UPT SMPN 1 Buay Sandang Aji.',
                'content' => '<p>Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK) di UPT SMP Negeri 1 Buay Sandang Aji sukses digelar. Didukung oleh tim teknisi IT dan laboratorium komputer yang memadai, seluruh peserta didik dapat menyelesaikan instrumen asesmen literasi dan numerasi tanpa kendala teknis.</p><p>Proktor dan teknisi memastikan koneksi jaringan internet serta kestabilan server bekerja maksimal selama seluruh sesi berlangsung.</p>',
                'category_id' => $catBerita->id,
                'is_featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'Semarak Latihan Gabungan dan Pelantikan Anggota Pramuka Penggalang Gugus Depan',
                'excerpt' => 'Kegiatan ekstrakurikuler kepramukaan yang dibina oleh Bapak Indra Waryanda, S.Pd sukses melatih kedisiplinan dan keterampilan survival murid.',
                'content' => '<p>Pramuka Penggalang UPT SMP Negeri 1 Buay Sandang Aji menyelenggarakan kegiatan latihan gabungan dan penjelajahan alam di sekitar lingkungan Desa Gunung Terang. Kegiatan ini bertujuan melatih kemandirian, kekompakan regu, keterampilan tali-temali, semaphore, dan sandi morse.</p>',
                'category_id' => $catKegiatan->id,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(10)
            ],
            [
                'title' => 'Prestasi Membanggakan Kontingen Bola Voli dan Futsal Pelajar Tingkat Kecamatan',
                'excerpt' => 'Tim olahraga UPT SMP Negeri 1 Buay Sandang Aji berhasil mempersembahkan piala kejuaraan dalam ajang pekan olahraga pelajar.',
                'content' => '<p>Kerja keras dan latihan rutin di bawah bimbingan guru olahraga Bapak Muhammad Erwin, S.Pd dan Bapak Deki Iswanto, S.Pd membuahkan hasil manis. Tim voli putra dan putri sukses merebut juara pada turnamen antar pelajar se-Kecamatan Buay Sandang Aji.</p>',
                'category_id' => $catPrestasi->id,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(18)
            ],
            [
                'title' => 'Gelar Karya Projek Penguatan Profil Pelajar Pancasila (P5) Berbasis Kearifan Lokal',
                'excerpt' => 'Murid menampilkan aneka kerajinan tangan, pentas seni tari daerah OKU Selatan, dan produk olahan makanan tradisional.',
                'content' => '<p>Implementasi Kurikulum Merdeka di UPT SMP Negeri 1 Buay Sandang Aji diwarnai dengan kemeriahan Gelar Karya P5. Koordinator projek mengajak seluruh murid kelas VII, VIII, dan IX mendalami nilai gotong royong, kreativitas, dan pelestarian budaya lokal Sumatera Selatan.</p>',
                'category_id' => $catKegiatan->id,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(25)
            ],
        ];

        foreach ($posts as $p) {
            Post::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($p['title'])],
                array_merge($p, [
                    'user_id' => $admin ? $admin->id : 1,
                    'thumbnail' => null,
                    'slug' => \Illuminate\Support\Str::slug($p['title'])
                ])
            );
        }
    }

    private function seedAgendas(): void
    {
        $agendas = [
            [
                'title' => 'Pelaksanaan Asesmen Sumatif Akhir Semester (SAS)',
                'description' => 'Evaluasi hasil pembelajaran semester ganjil untuk seluruh kelas VII, VIII, dan IX UPT SMPN 1 Buay Sandang Aji.',
                'location' => 'Ruang Kelas 1 - 13',
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(14),
                'color' => '#ef4444'
            ],
            [
                'title' => 'Perkemahan Jumat-Sabtu (Perjusami) Pramuka Penggalang',
                'description' => 'Kegiatan pelantikan kenaikan tingkat ramu ke rakit bagi anggota pramuka penggalang.',
                'location' => 'Bumi Perkemahan Lapangan Sekolah',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(22),
                'color' => '#10b981'
            ],
            [
                'title' => 'Rapat Pleno Pembagian Laporan Hasil Belajar (Rapor)',
                'description' => 'Rapat dewan guru dan koordinasi bersama Komite Sekolah serta Wali Murid.',
                'location' => 'Ruang Guru & Aula Pertemuan',
                'start_date' => now()->addDays(25),
                'end_date' => null,
                'color' => '#1e40af'
            ],
            [
                'title' => 'Kajian Rutin & Pembagian Infak Keagamaan Jumat Berkah',
                'description' => 'Kajian pembinaan rohani Islam dan penyaluran infak bagi siswa yatim/piatu dan dhuafa.',
                'location' => 'Musholla Sekolah',
                'start_date' => now()->addDays(3),
                'end_date' => null,
                'color' => '#8b5cf6'
            ],
        ];
        foreach ($agendas as $a) {
            Agenda::updateOrCreate(['title' => $a['title']], $a + ['is_active' => true]);
        }
    }

    private function seedAnnouncements(): void
    {
        $announcements = [
            [
                'title' => 'Standar Pelayanan Publik UPT SMP Negeri 1 Buay Sandang Aji Resmi Diterapkan',
                'content' => '<p>Diumumkan kepada seluruh warga sekolah, orang tua murid, alumni, dan masyarakat luas bahwa seluruh layanan administrasi (surat pindah, legalisir ijazah, surat keterangan, izin penelitian) dilaksanakan <strong>GRATIS tanpa dipungut biaya apapun (Bebas Pungli)</strong> sesuai Standar Pelayanan Publik resmi.</p>',
                'type' => 'info',
                'is_active' => true,
                'is_pinned' => true,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(60)
            ],
            [
                'title' => 'Jadwal Pelaksanaan Penilaian Akhir Semester (PAS) Tahun Ajaran 2024/2025',
                'content' => '<p>Dihimbau kepada seluruh siswa-siswi kelas VII, VIII, dan IX untuk mempersiapkan diri dan menjaga kesehatan menjelang pelaksanaan Penilaian Akhir Semester.</p>',
                'type' => 'warning',
                'is_active' => true,
                'is_pinned' => false,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(20)
            ],
            [
                'title' => 'Pemberitahuan Pembiasaan Membawa Perlengkapan Sholat dan Al-Qur\'an / Juz \'Amma',
                'content' => '<p>Guna menunjang kelancaran program sholat dhuha dan tadarus pagi bersama, setiap murid diwajibkan membawa mukena (siswi) dan sarung/peci (siswa) serta mushaf Al-Qur\'an / Juz \'Amma.</p>',
                'type' => 'success',
                'is_active' => true,
                'is_pinned' => false,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(30)
            ],
        ];
        foreach ($announcements as $a) {
            Announcement::updateOrCreate(['title' => $a['title']], $a);
        }
    }

    private function seedTeachers(): void
    {
        Teacher::truncate();

        // 28 Pendidik (Guru)
        $teachers = [
            ['name' => 'MAMAH TARMAH, S.Pd.I', 'nip' => '197505132006042012', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PAI', 'education' => 'Pembina Tingkat 1 / IV.b', 'type' => 'teacher', 'order' => 1],
            ['name' => 'MUZAIYANA, S.Ag', 'nip' => '197001052007012055', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PAI', 'education' => 'Penata Tingkat I / III.d', 'type' => 'teacher', 'order' => 2],
            ['name' => 'RENI APRIYANTI, S.Pd', 'nip' => '199604102020122010', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PKn', 'education' => 'Penata Muda / III.a', 'type' => 'teacher', 'order' => 3],
            ['name' => 'LISNAYANTI, S.Pd', 'nip' => '198405102024212026', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PKn', 'education' => 'Ahli Pertama / IX', 'type' => 'teacher', 'order' => 4],
            ['name' => 'BERTI MAIYA SARI, S.Pd', 'nip' => '197905202008012026', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Indonesia', 'education' => 'Penata Tingkat 1 / III.d', 'type' => 'teacher', 'order' => 5],
            ['name' => 'NENNY TRIANA, S.Pd', 'nip' => '198106062010012007', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Indonesia', 'education' => 'Penata / III.c', 'type' => 'teacher', 'order' => 6],
            ['name' => 'AYU SURYANI, S.Pd', 'nip' => '199304302023212019', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Indonesia', 'education' => 'Ahli Pertama / IX', 'type' => 'teacher', 'order' => 7],
            ['name' => 'DAMRAN HADINATA, S.Pd', 'nip' => '197710192007011015', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Inggris', 'education' => 'Penata Tingkat 1 / III.d', 'type' => 'teacher', 'order' => 8],
            ['name' => 'APRIYANTI MUSTIKA RINI, S.Pd', 'nip' => '198204242009042002', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Inggris', 'education' => 'Penata Tingkat 1 / III.d', 'type' => 'teacher', 'order' => 9],
            ['name' => 'MUHAMMAD ERWIN, S.Pd', 'nip' => '198602082011011010', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Inggris', 'education' => 'Penata / III.c', 'type' => 'teacher', 'order' => 10],
            ['name' => 'FARA MUSTIKAWATI, S.Pd', 'nip' => '197210012006042013', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Matematika', 'education' => 'Pembina Tingkat 1 / IV.b', 'type' => 'teacher', 'order' => 11],
            ['name' => 'YUNIARTIKA, S.Pd', 'nip' => '198306042006042015', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Matematika', 'education' => 'Pembina Tingkat 1 / IV.b', 'type' => 'teacher', 'order' => 12],
            ['name' => 'ARJUNA, S.Pd', 'nip' => '198607282011012007', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Matematika', 'education' => 'Penata Tingkat 1 / III.d', 'type' => 'teacher', 'order' => 13],
            ['name' => 'SUCI ZANORA, S.Pd', 'nip' => '198901292024212020', 'position' => 'Guru Mata Pelajaran', 'subject' => 'TIK', 'education' => 'Ahli Pertama / IX', 'type' => 'teacher', 'order' => 14],
            ['name' => 'EMILIA RUSDA, S.Pd', 'nip' => '197405192005012005', 'position' => 'Guru Mata Pelajaran', 'subject' => 'IPA', 'education' => 'Pembina Tingkat 1 / IV.b', 'type' => 'teacher', 'order' => 15],
            ['name' => 'FIYA LARASATI, S.Pd', 'nip' => '198902252011012006', 'position' => 'Guru Mata Pelajaran', 'subject' => 'IPA', 'education' => 'Penata / III.c', 'type' => 'teacher', 'order' => 16],
            ['name' => 'LENI MARYAMA FITRY', 'nip' => '199303192025212114', 'position' => 'Guru Mata Pelajaran', 'subject' => 'IPA', 'education' => '-', 'type' => 'teacher', 'order' => 17],
            ['name' => 'ERLY KARTIKA WARDANI, S.Pd', 'nip' => '198207042006042012', 'position' => 'Guru Mata Pelajaran', 'subject' => 'IPS', 'education' => 'Pembina Tingkat 1 / IV.b', 'type' => 'teacher', 'order' => 18],
            ['name' => 'FITRIANTI ISNAINI, S.Pd', 'nip' => '198207192010012001', 'position' => 'Guru Mata Pelajaran', 'subject' => 'IPS', 'education' => 'Penata Muda Tk. 1 / III.b', 'type' => 'teacher', 'order' => 19],
            ['name' => 'ARYA ADI SANTIKA, S.Pd', 'nip' => '198902132023211008', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PJOK', 'education' => 'Ahli Pertama / IX', 'type' => 'teacher', 'order' => 20],
            ['name' => 'INDRA WARYANDA, S.Pd', 'nip' => '199103092023211004', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PJOK, TIK', 'education' => 'Ahli Pertama / IX', 'type' => 'teacher', 'order' => 21],
            ['name' => 'DIANA FITRY, S.Pd', 'nip' => '198804102025212138', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Bahasa Indonesia, TIK', 'education' => '-', 'type' => 'teacher', 'order' => 22],
            ['name' => 'EPA SILPIANA, S.Pd', 'nip' => '198406022025212074', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Seni Budaya', 'education' => '-', 'type' => 'teacher', 'order' => 23],
            ['name' => 'MULYADI, S.Psi', 'nip' => '197201252025211033', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Seni Budaya, BK', 'education' => '-', 'type' => 'teacher', 'order' => 24],
            ['name' => 'ARIFATI MUNFARIDA, S.Pd', 'nip' => '199803142025212064', 'position' => 'Guru Mata Pelajaran', 'subject' => 'IPS, Seni Budaya', 'education' => '-', 'type' => 'teacher', 'order' => 25],
            ['name' => 'SUSI BAYANSARI, S.Pd', 'nip' => '199702212025212077', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Seni Budaya, TIK', 'education' => '-', 'type' => 'teacher', 'order' => 26],
            ['name' => 'ROMAULI ISMAYANTI P, S.Pd', 'nip' => '198105092009042001', 'position' => 'Guru Bimbingan Konseling (BK)', 'subject' => 'BK', 'education' => 'Penata / III.c', 'type' => 'teacher', 'order' => 27],
            ['name' => 'FERIYANTI, S.Sos', 'nip' => '198102262009042001', 'position' => 'Guru Bimbingan Konseling (BK)', 'subject' => 'BK', 'education' => 'Penata Muda Tk. 1 / III.b', 'type' => 'teacher', 'order' => 28],
        ];

        foreach ($teachers as $t) {
            Teacher::create($t + ['is_active' => true, 'photo' => null, 'bio' => null]);
        }

        // 10 Tenaga Kependidikan (8 Staff TU + 2 Satpam)
        $staff = [
            ['name' => 'Irsan Ahmad Rani, SH', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => 'S1 Ilmu Hukum', 'type' => 'staff', 'order' => 29],
            ['name' => 'Kasianto', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 30],
            ['name' => 'Hermaliana', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 31],
            ['name' => 'Sitti Zahara', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 32],
            ['name' => 'Komariah', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 33],
            ['name' => 'Evi Emilia', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 34],
            ['name' => 'Bambang Irawan, SE', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => 'S1 Ekonomi', 'type' => 'staff', 'order' => 35],
            ['name' => 'Ria Pustika, S.Kom', 'nip' => null, 'position' => 'Staff Tata Usaha', 'subject' => null, 'education' => 'S1 Sistem Informasi', 'type' => 'staff', 'order' => 36],
            ['name' => 'Suherman', 'nip' => null, 'position' => 'Penjaga Sekolah / Satpam', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 37],
            ['name' => 'Sawak', 'nip' => null, 'position' => 'Penjaga Sekolah / Satpam', 'subject' => null, 'education' => null, 'type' => 'staff', 'order' => 38],
        ];

        foreach ($staff as $s) {
            Teacher::create($s + ['is_active' => true, 'photo' => null, 'bio' => null]);
        }
    }

    private function seedFacilities(): void
    {
        $facilities = [
            ['name' => 'Ruang Kepala Sekolah', 'description' => 'Ruang kerja representatif Kepala Sekolah dilengkapi ruang tamu, area koordinasi, dan sarana multimedia.', 'icon' => 'fas fa-user-tie', 'order' => 1],
            ['name' => 'Ruang Tata Usaha (TU)', 'description' => 'Pusat pelayanan administrasi kepegawaian, kesiswaan, surat-menyurat, kearsipan, dan registrasi Dapodik.', 'icon' => 'fas fa-briefcase', 'order' => 2],
            ['name' => 'Ruang Guru', 'description' => 'Ruang kerja bersama pendidik dengan meja kerja terpadu, area diskusi kurikulum, dan fasilitas KBM.', 'icon' => 'fas fa-chalkboard-teacher', 'order' => 3],
            ['name' => 'Ruang Kelas (13 Rombel)', 'description' => '13 ruang kelas representatif, bersih, dan nyaman yang dilengkapi papan tulis, ventilasi sehat, dan meja-kursi standar.', 'icon' => 'fas fa-door-open', 'order' => 4],
            ['name' => 'Laboratorium IPA', 'description' => 'Laboratorium terpadu untuk praktikum Biologi, Fisika, dan Kimia sederhana dengan perlengkapan mikroskop dan alat peraga.', 'icon' => 'fas fa-flask', 'order' => 5],
            ['name' => 'Laboratorium Komputer & TIK', 'description' => 'Fasilitas perangkat komputer PC dan jaringan internet fiber optik untuk pelaksanaan ANBK dan literasi digital murid.', 'icon' => 'fas fa-desktop', 'order' => 6],
            ['name' => 'Laboratorium Bahasa', 'description' => 'Fasilitas multimedia pembelajaran Bahasa Indonesia dan Bahasa Inggris untuk mengasah kecakapan listening dan speaking.', 'icon' => 'fas fa-headphones', 'order' => 7],
            ['name' => 'Ruang Bimbingan Konseling (BK)', 'description' => 'Ruang konseling privat dan pendampingan psikologis murid, konsultasi orang tua, serta pengembangan bakat minat.', 'icon' => 'fas fa-comments', 'order' => 8],
            ['name' => 'Ruang UKS (Unit Kesehatan Sekolah)', 'description' => 'Fasilitas pertolongan pertama pada kecelakaan (P3K), ranjang istirahat pasien, dan pemeriksaan kesehatan berkala.', 'icon' => 'fas fa-heartbeat', 'order' => 9],
            ['name' => 'Perpustakaan Sekolah', 'description' => 'Pusat literasi dengan ribuan koleksi buku teks pelajaran, buku fiksi/non-fiksi, ensiklopedia, dan ruang baca nyaman.', 'icon' => 'fas fa-book-reader', 'order' => 10],
            ['name' => 'Musholla Sekolah', 'description' => 'Sarana ibadah sholat dhuha & dzuhur berjamaah, kegiatan kajian Rohis, tadarus Al-Qur\'an, dan peringatan hari besar Islam.', 'icon' => 'fas fa-mosque', 'order' => 11],
            ['name' => 'Lapangan Olahraga Multifungsi', 'description' => 'Lapangan multifungsi untuk upacara bendera, senam kesegaran jasmani, pertandingan bola voli, futsal, dan basket.', 'icon' => 'fas fa-volleyball-ball', 'order' => 12],
            ['name' => 'Ruang OSIS', 'description' => 'Pusat kegiatan, diskusi kepemimpinan, dan perencanaan program kerja Pengurus Organisasi Siswa Intra Sekolah.', 'icon' => 'fas fa-users', 'order' => 13],
            ['name' => 'Ruang Sanggar Pramuka', 'description' => 'Pusat administrasi gugus depan kepanduan Pramuka dan tempat penyimpanan inventaris tenda serta perlengkapan perkemahan.', 'icon' => 'fas fa-campground', 'order' => 14],
            ['name' => 'Ruang Seni Budaya & Musik', 'description' => 'Ruang latihan seni tari tradisional daerah Ogan Komering Ulu Selatan, alat musik, paduan suara, dan kreasi panggung.', 'icon' => 'fas fa-music', 'order' => 15],
            ['name' => 'Kantin Sehat Sekolah', 'description' => 'Kantin penyedia aneka jajanan dan makanan bernutrisi, higienis, bersih, dan terjangkau bagi seluruh warga sekolah.', 'icon' => 'fas fa-utensils', 'order' => 16],
            ['name' => 'Koperasi Sekolah', 'description' => 'Menyediakan perlengkapan alat tulis sekolah, atribut seragam, buku tulis, dan kebutuhan belajar peserta didik.', 'icon' => 'fas fa-store', 'order' => 17],
            ['name' => 'Toilet & Sanitasi Terpisah', 'description' => 'Fasilitas sanitasi bersih dan terawat yang terpisah antara siswa putra, siswi putri, dan dewan guru dengan air bersih melimpah.', 'icon' => 'fas fa-restroom', 'order' => 18],
            ['name' => 'Taman & Area Hijau Sekolah', 'description' => 'Area penghijauan rindang dan taman asri yang menciptakan udara sejuk serta suasana belajar yang menyegarkan.', 'icon' => 'fas fa-tree', 'order' => 19],
            ['name' => 'Area Parkir Kendaraan', 'description' => 'Tempat parkir yang tertata rapi, tertib, dan aman bagi kendaraan dinas maupun pribadi pendidik, staf, dan tamu.', 'icon' => 'fas fa-parking', 'order' => 20],
        ];

        foreach ($facilities as $f) {
            Facility::updateOrCreate(
                ['name' => $f['name']],
                $f + ['is_active' => true, 'image' => null]
            );
        }
    }

    private function seedAchievements(): void
    {
        $achievements = [
            ['title' => 'Juara 1 Lomba Regu Prestasi Pramuka Penggalang (LT II)', 'description' => 'Regu Pramuka UPT SMPN 1 Buay Sandang Aji berhasil meraih predikat regu berprestasi tinggi tingkat Kwarran.', 'level' => 'Kecamatan', 'category' => 'Non-Akademik', 'year' => 2024, 'order' => 1],
            ['title' => 'Juara 1 Turnamen Bola Voli Pelajar Putra', 'description' => 'Meraih juara pertama dalam ajang kejuaraan bola voli antar sekolah menengah pertama.', 'level' => 'Kecamatan', 'category' => 'Olahraga', 'year' => 2024, 'order' => 2],
            ['title' => 'Juara 2 Lomba Seni Tari Tradisional Daerah (FLS2N)', 'description' => 'Menampilkan tari kreasi daerah Ogan Komering Ulu Selatan yang memukau dewan juri.', 'level' => 'Kabupaten', 'category' => 'Seni', 'year' => 2023, 'order' => 3],
            ['title' => 'Juara 1 Lomba MTQ dan Tahfidz Juz 30 Tingkat Pelajar', 'description' => 'Murid UPT SMPN 1 Buay Sandang Aji berhasil meraih predikat qari terbaik dalam peringatan Isra Mi\'raj.', 'level' => 'Kecamatan', 'category' => 'Keagamaan', 'year' => 2023, 'order' => 4],
            ['title' => 'Finalis Olimpiade Sains Nasional (OSN) Bidang IPA', 'description' => 'Mewakili sekolah dalam kompetisi sains bergengsi tingkat Kabupaten Ogan Komering Ulu Selatan.', 'level' => 'Kabupaten', 'category' => 'Akademik', 'year' => 2023, 'order' => 5],
            ['title' => 'Piagam Penghargaan Sekolah Bersih dan Asri Bebas Pungli', 'description' => 'Penghargaan atas komitmen sekolah dalam menciptakan lingkungan pendidikan yang aman, asri, dan transparan.', 'level' => 'Kabupaten', 'category' => 'Manajemen', 'year' => 2024, 'order' => 6],
        ];
        foreach ($achievements as $a) {
            Achievement::updateOrCreate(['title' => $a['title']], $a + ['is_active' => true, 'image' => null]);
        }
    }

    private function seedExtracurriculars(): void
    {
        $extras = [
            [
                'name' => 'Pramuka (Gugus Depan Penggalang)',
                'description' => 'Wadah pembentukan karakter tangguh, kedisiplinan, kepemimpinan, kepanduan, dan kecintaan pada alam dan tanah air.',
                'schedule' => 'Jumat, 14:00 - 16:30 WIB',
                'teacher' => 'Indra Waryanda, S.Pd',
                'order' => 1
            ],
            [
                'name' => 'OSIS & Latihan Dasar Kepemimpinan (LDK)',
                'description' => 'Organisasi kesiswaan resmi sebagai motor penggerak kegiatan sekolah, ketertiban murid, dan pengembangan jiwa kepemimpinan.',
                'schedule' => 'Sabtu, 10:00 - 12:00 WIB',
                'teacher' => 'Arya Adi Santika, S.Pd',
                'order' => 2
            ],
            [
                'name' => 'Seni Tari Tradisional Daerah & Nusantara',
                'description' => 'Melestarikan seni tari daerah khas Ogan Komering Ulu Selatan serta tari kreasi nusantara untuk ajang FLS2N dan festival.',
                'schedule' => 'Rabu, 14:30 - 16:30 WIB',
                'teacher' => 'Mulyadi, S.Psi & Reni Apriyanti, S.Pd',
                'order' => 3
            ],
            [
                'name' => 'Rohis, Tahfidz & Keagamaan Islam',
                'description' => 'Pembinaan keagamaan Islam, sholat dhuha & dzuhur berjamaah, tartil Al-Qur\'an, hafalan Juz \'Amma, dan da\'wah muda.',
                'schedule' => 'Kamis & Jumat Pagi',
                'teacher' => 'Mamah Tarmah, S.Ag & Zuraidah, S.Pd.I',
                'order' => 4
            ],
            [
                'name' => 'Bola Voli & Futsal Pelajar',
                'description' => 'Pengembangan fisik, teknik olahraga beregu, daya tahan, dan pembinaan atlet berprestasi untuk turnamen antar sekolah.',
                'schedule' => 'Selasa & Kamis, 15:30 - 17:30 WIB',
                'teacher' => 'Muhammad Erwin, S.Pd & Deki Iswanto, S.Pd',
                'order' => 5
            ],
            [
                'name' => 'Palang Merah Remaja (PMR)',
                'description' => 'Pendidikan pertolongan pertama pada kecelakaan (P3K), kesiapsiagaan bencana, kepedulian sosial, dan perilaku hidup sehat.',
                'schedule' => 'Senin, 14:30 - 16:00 WIB',
                'teacher' => 'Emilia Rusda, S.Pd',
                'order' => 6
            ],
            [
                'name' => 'Klub Sains & Bimbingan OSN (IPA & Matematika)',
                'description' => 'Bimbingan intensif persiapan Olimpiade Sains Nasional (OSN/KSN) untuk mata pelajaran IPA Terpadu dan Matematika.',
                'schedule' => 'Rabu, 14:00 - 16:00 WIB',
                'teacher' => 'Neti Herawati, S.Pd & Dewi Angraini, S.Pd',
                'order' => 7
            ],
            [
                'name' => 'English Club & Literasi Sekolah',
                'description' => 'Pengasahan kemampuan percakapan bahasa Inggris (English conversation), storytelling, pidato, dan gerakan gemar membaca.',
                'schedule' => 'Kamis, 14:30 - 16:00 WIB',
                'teacher' => 'Yuniartika, S.Pd & Erly Kartika W, S.Pd',
                'order' => 8
            ],
            [
                'name' => 'Komputer & Literasi TIK',
                'description' => 'Pelatihan pengoperasian komputer, aplikasi perkantoran, desain grafis sederhana, dan etika pemanfaatan internet sehat.',
                'schedule' => 'Sabtu, 08:30 - 10:30 WIB',
                'teacher' => 'Seria Pustika, S.Kom',
                'order' => 9
            ],
        ];

        foreach ($extras as $e) {
            Extracurricular::updateOrCreate(
                ['name' => $e['name']],
                $e + ['is_active' => true, 'image' => null]
            );
        }
    }

    private function seedServices(): void
    {
        $this->call(ServiceSeeder::class);
    }
}

