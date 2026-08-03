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
use App\Models\Service;
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
            ['label' => 'Jumlah Siswa', 'value' => '1.245', 'icon' => 'fas fa-user-graduate', 'color' => '#1e40af', 'order' => 1],
            ['label' => 'Tenaga Pendidik', 'value' => '78', 'icon' => 'fas fa-chalkboard-teacher', 'color' => '#0ea5e9', 'order' => 2],
            ['label' => 'Prestasi', 'value' => '256', 'icon' => 'fas fa-trophy', 'color' => '#f59e0b', 'order' => 3],
            ['label' => 'Ekstrakurikuler', 'value' => '24', 'icon' => 'fas fa-futbol', 'color' => '#10b981', 'order' => 4],
        ];
        foreach ($stats as $s) { Statistic::updateOrCreate(['label' => $s['label']], $s + ['is_active' => true]); }
    }

    private function seedSocialMedia(): void
    {
        $socials = [
            ['name' => 'Facebook', 'url' => 'https://facebook.com/sman1nusantara', 'icon' => 'fab fa-facebook-f', 'color' => '#1877F2', 'order' => 1],
            ['name' => 'Instagram', 'url' => 'https://instagram.com/sman1nusantara', 'icon' => 'fab fa-instagram', 'color' => '#E4405F', 'order' => 2],
            ['name' => 'YouTube', 'url' => 'https://youtube.com/@sman1nusantara', 'icon' => 'fab fa-youtube', 'color' => '#FF0000', 'order' => 3],
            ['name' => 'Twitter/X', 'url' => 'https://twitter.com/sman1nusantara', 'icon' => 'fab fa-x-twitter', 'color' => '#000000', 'order' => 4],
        ];
        foreach ($socials as $s) { SocialMedia::updateOrCreate(['name' => $s['name']], $s + ['is_active' => true]); }
    }

    private function seedHeroSliders(): void
    {
        $sliders = [
            ['title' => 'Selamat Datang di SMA Negeri 1 Nusantara', 'subtitle' => 'Cerdas, Berkarakter, dan Berprestasi', 'image' => 'hero-sliders/hero1.jpg', 'button_text' => 'Profil Sekolah', 'button_url' => '/profil', 'button_text_2' => 'Kontak Kami', 'button_url_2' => '/kontak', 'order' => 1],
            ['title' => 'Unggul dalam Prestasi Akademik & Non-Akademik', 'subtitle' => 'Raih prestasi terbaik bersama guru-guru berpengalaman kami', 'image' => 'hero-sliders/hero2.jpg', 'button_text' => 'Lihat Prestasi', 'button_url' => '/prestasi', 'button_text_2' => 'Ekskul Kami', 'button_url_2' => '/ekstrakurikuler', 'order' => 2],
            ['title' => 'Fasilitas Modern untuk Pembelajaran Optimal', 'subtitle' => 'Laboratorium, perpustakaan digital, dan sarana olahraga lengkap', 'image' => 'hero-sliders/hero3.jpg', 'button_text' => 'Lihat Fasilitas', 'button_url' => '/fasilitas', 'button_text_2' => null, 'button_url_2' => null, 'order' => 3],
        ];
        foreach ($sliders as $s) { HeroSlider::updateOrCreate(['order' => $s['order']], $s + ['is_active' => true]); }
    }

    private function seedCategories(): void
    {
        $cats = [
            ['name' => 'Berita Sekolah', 'slug' => 'berita-sekolah', 'color' => '#1e40af'],
            ['name' => 'Kegiatan Siswa', 'slug' => 'kegiatan-siswa', 'color' => '#0ea5e9'],
            ['name' => 'Akademik', 'slug' => 'akademik', 'color' => '#10b981'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'color' => '#f59e0b'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'color' => '#ef4444'],
        ];
        foreach ($cats as $c) { Category::updateOrCreate(['slug' => $c['slug']], $c + ['is_active' => true]); }
    }

    private function seedPosts(): void
    {
        $admin = User::where('role', 'admin')->first();
        $category = Category::first();
        $posts = [
            ['title' => 'Siswa SMAN 1 Nusantara Raih Juara 1 Olimpiade Matematika Nasional', 'excerpt' => 'Kebanggaan bagi SMAN 1 Nusantara! Dua siswa kelas XII berhasil meraih juara pertama dalam Olimpiade Matematika tingkat nasional yang diselenggarakan di Jakarta.', 'content' => '<p>Sebuah prestasi membanggakan diraih oleh siswa SMA Negeri 1 Nusantara dalam Olimpiade Matematika Nasional 2024. Ahmad Rizki (XII IPA 1) dan Sari Dewi (XII IPA 2) berhasil meraih posisi juara pertama dalam kompetisi bergengsi ini.</p><p>Keberhasilan ini tidak lepas dari persiapan intensif selama beberapa bulan, bimbingan guru-guru berpengalaman, serta dukungan penuh dari orang tua dan sekolah.</p>', 'is_featured' => true, 'status' => 'published', 'published_at' => now()->subDays(3)],
            ['title' => 'Peresmian Laboratorium Komputer Baru SMAN 1 Nusantara', 'excerpt' => 'Sekolah meresmikan laboratorium komputer baru yang dilengkapi dengan 40 unit komputer terbaru dan koneksi internet berkecepatan tinggi.', 'content' => '<p>SMA Negeri 1 Nusantara kembali meningkatkan fasilitas pembelajaran dengan meresmikan laboratorium komputer baru pada Senin (15/1/2024). Laboratorium ini dilengkapi dengan 40 unit komputer spesifikasi tinggi dan koneksi internet fiber optik 1 Gbps.</p>', 'is_featured' => false, 'status' => 'published', 'published_at' => now()->subDays(7)],
            ['title' => 'Kegiatan MPLS Tahun Ajaran 2024/2025', 'excerpt' => 'Masa Pengenalan Lingkungan Sekolah (MPLS) untuk siswa baru tahun ajaran 2024/2025 resmi dibuka oleh Kepala Sekolah.', 'content' => '<p>Masa Pengenalan Lingkungan Sekolah (MPLS) untuk peserta didik baru tahun ajaran 2024/2025 secara resmi dibuka oleh Kepala Sekolah pada Senin, 15 Juli 2024. Kegiatan ini berlangsung selama tiga hari dan diikuti oleh 360 siswa baru.</p>', 'is_featured' => false, 'status' => 'published', 'published_at' => now()->subDays(14)],
            ['title' => 'Tim Basket SMAN 1 Nusantara Juara Provinsi 2024', 'excerpt' => 'Tim basket putra SMAN 1 Nusantara berhasil meraih juara pertama dalam turnamen basket tingkat provinsi.', 'content' => '<p>Prestasi gemilang kembali diraih oleh tim basket putra SMA Negeri 1 Nusantara. Pada turnamen basket antar SMA tingkat provinsi yang diselenggarakan di GOR Provinsi, tim kita berhasil memenangkan babak final dengan skor 72-65.</p>', 'is_featured' => true, 'status' => 'published', 'published_at' => now()->subDays(21)],
            ['title' => 'Kunjungan Studi ke Universitas Gadjah Mada', 'excerpt' => 'Siswa kelas XI mengikuti kunjungan studi ke Universitas Gadjah Mada Yogyakarta sebagai bagian dari program pengenalan perguruan tinggi.', 'content' => '<p>Sebanyak 200 siswa kelas XI SMA Negeri 1 Nusantara melakukan kunjungan studi ke Universitas Gadjah Mada (UGM) Yogyakarta. Kegiatan ini merupakan bagian dari program career and university exploration yang rutin dilaksanakan setiap tahun.</p>', 'is_featured' => false, 'status' => 'published', 'published_at' => now()->subDays(28)],
            ['title' => 'Peringatan Hari Guru Nasional 2024', 'excerpt' => 'Seluruh warga sekolah merayakan Hari Guru Nasional dengan penuh keharuan dan semangat.', 'content' => '<p>SMA Negeri 1 Nusantara merayakan Hari Guru Nasional yang jatuh pada 25 November dengan menggelar berbagai kegiatan penghargaan untuk para guru. Acara berlangsung meriah dengan penampilan seni dari para siswa.</p>', 'is_featured' => false, 'status' => 'published', 'published_at' => now()->subDays(35)],
        ];
        foreach ($posts as $i => $p) {
            Post::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($p['title'])],
                array_merge($p, ['user_id' => $admin->id, 'category_id' => $category->id, 'thumbnail' => null, 'slug' => \Illuminate\Support\Str::slug($p['title'])])
            );
        }
    }

    private function seedAgendas(): void
    {
        $agendas = [
            ['title' => 'Ujian Akhir Semester Ganjil', 'description' => 'Pelaksanaan Ujian Akhir Semester Ganjil Tahun Ajaran 2024/2025 untuk seluruh kelas.', 'location' => 'Ruang Kelas Masing-masing', 'start_date' => now()->addDays(10), 'end_date' => now()->addDays(17), 'color' => '#ef4444'],
            ['title' => 'Peringatan Hari Pahlawan', 'description' => 'Upacara bendera dalam rangka memperingati Hari Pahlawan Nasional.', 'location' => 'Lapangan Upacara', 'start_date' => now()->addDays(5), 'end_date' => null, 'color' => '#1e40af'],
            ['title' => 'Pameran Karya Siswa', 'description' => 'Pameran hasil karya seni dan teknologi siswa SMAN 1 Nusantara.', 'location' => 'Aula Sekolah', 'start_date' => now()->addDays(20), 'end_date' => now()->addDays(21), 'color' => '#10b981'],
            ['title' => 'Rapat Orang Tua/Wali Siswa', 'description' => 'Rapat koordinasi antara sekolah dengan orang tua/wali siswa kelas XII.', 'location' => 'Aula Sekolah', 'start_date' => now()->addDays(3), 'end_date' => null, 'color' => '#f59e0b'],
            ['title' => 'Lomba Kebersihan Kelas', 'description' => 'Penilaian kebersihan dan kerapian kelas dalam rangka memperingati Hari Lingkungan Hidup.', 'location' => 'Seluruh Ruang Kelas', 'start_date' => now()->subDays(5), 'end_date' => null, 'color' => '#0ea5e9'],
        ];
        foreach ($agendas as $a) { Agenda::create($a + ['is_active' => true]); }
    }

    private function seedAnnouncements(): void
    {
        $announcements = [
            ['title' => 'Pendaftaran PPDB Tahun Ajaran 2025/2026', 'content' => '<p>Penerimaan Peserta Didik Baru (PPDB) SMA Negeri 1 Nusantara Tahun Ajaran 2025/2026 akan dibuka mulai tanggal 1 Juni 2025.</p><p>Persyaratan:<br>1. Lulus SMP/MTs sederajat<br>2. Nilai rapor minimal rata-rata 80<br>3. Usia maksimal 21 tahun</p>', 'type' => 'info', 'is_active' => true, 'is_pinned' => true, 'start_date' => now()->subDays(1), 'end_date' => now()->addDays(30)],
            ['title' => 'Jadwal Ujian Semester Ganjil 2024/2025', 'content' => '<p>Ujian Akhir Semester (UAS) Ganjil Tahun Ajaran 2024/2025 akan dilaksanakan pada tanggal 9-16 Desember 2024. Harap mempersiapkan diri dengan belajar yang giat.</p>', 'type' => 'warning', 'is_active' => true, 'is_pinned' => false, 'start_date' => now()->subDays(3), 'end_date' => now()->addDays(14)],
            ['title' => 'Selamat kepada Tim Basket Putra Juara Provinsi!', 'content' => '<p>Sekolah mengucapkan selamat dan bangga kepada Tim Basket Putra yang telah meraih Juara 1 dalam turnamen basket tingkat provinsi. Prestasi kalian mengharumkan nama sekolah!</p>', 'type' => 'success', 'is_active' => true, 'is_pinned' => false, 'start_date' => now()->subDays(7), 'end_date' => null],
        ];
        foreach ($announcements as $a) { Announcement::create($a); }
    }

    private function seedTeachers(): void
    {
        $teachers = [
            ['name' => 'Drs. Bambang Wijaya, M.Pd.', 'nip' => '196501011990011001', 'position' => 'Kepala Sekolah', 'subject' => 'Matematika', 'education' => 'S2 Pendidikan Matematika', 'type' => 'teacher', 'order' => 1],
            ['name' => 'Siti Rahayu, S.Pd., M.Si.', 'nip' => '197005151995032001', 'position' => 'Wakasek Kurikulum', 'subject' => 'Kimia', 'education' => 'S2 Kimia', 'type' => 'teacher', 'order' => 2],
            ['name' => 'Ahmad Fauzi, S.Pd.', 'nip' => '198003202005011002', 'position' => 'Wakasek Kesiswaan', 'subject' => 'Pendidikan Jasmani', 'education' => 'S1 PJOK', 'type' => 'teacher', 'order' => 3],
            ['name' => 'Dewi Lestari, S.Pd.', 'nip' => '198510102010012003', 'position' => 'Guru Bahasa Indonesia', 'subject' => 'Bahasa Indonesia', 'education' => 'S1 Bahasa Indonesia', 'type' => 'teacher', 'order' => 4],
            ['name' => 'Budi Santoso, S.Pd., M.Kom.', 'nip' => '198701012012011001', 'position' => 'Guru TIK', 'subject' => 'Informatika', 'education' => 'S2 Ilmu Komputer', 'type' => 'teacher', 'order' => 5],
            ['name' => 'Rini Amalia, S.Pd.', 'nip' => '199001202015012002', 'position' => 'Guru Bahasa Inggris', 'subject' => 'Bahasa Inggris', 'education' => 'S1 Bahasa Inggris', 'type' => 'teacher', 'order' => 6],
            ['name' => 'Hendra Pratama, S.T.', 'nip' => '197805152003011003', 'position' => 'Kepala Tata Usaha', 'subject' => null, 'education' => 'S1 Teknik Sipil', 'type' => 'staff', 'order' => 7],
            ['name' => 'Sri Mulyani, A.Md.', 'nip' => '198505202008012001', 'position' => 'Bendahara', 'subject' => null, 'education' => 'D3 Akuntansi', 'type' => 'staff', 'order' => 8],
        ];
        foreach ($teachers as $t) { Teacher::updateOrCreate(['nip' => $t['nip']], $t + ['is_active' => true, 'photo' => null, 'bio' => null]); }
    }

    private function seedFacilities(): void
    {
        $facilities = [
            ['name' => 'Laboratorium IPA', 'description' => 'Laboratorium IPA modern dengan peralatan lengkap untuk praktikum Fisika, Kimia, dan Biologi.', 'icon' => 'fas fa-flask', 'order' => 1],
            ['name' => 'Laboratorium Komputer', 'description' => '40 unit komputer terbaru dengan koneksi internet fiber optik 1 Gbps untuk pembelajaran digital.', 'icon' => 'fas fa-desktop', 'order' => 2],
            ['name' => 'Perpustakaan Digital', 'description' => 'Perpustakaan dengan koleksi lebih dari 10.000 buku dan akses e-library 24 jam.', 'icon' => 'fas fa-book', 'order' => 3],
            ['name' => 'Aula Serbaguna', 'description' => 'Aula berkapasitas 500 orang dilengkapi sound system dan proyektor modern.', 'icon' => 'fas fa-theater-masks', 'order' => 4],
            ['name' => 'Lapangan Olahraga', 'description' => 'Lapangan basket, voli, futsal, dan lintasan lari 400 meter.', 'icon' => 'fas fa-running', 'order' => 5],
            ['name' => 'Kantin Sekolah', 'description' => 'Kantin bersih dengan menu sehat dan harga terjangkau untuk warga sekolah.', 'icon' => 'fas fa-utensils', 'order' => 6],
        ];
        foreach ($facilities as $f) { Facility::updateOrCreate(['name' => $f['name']], $f + ['is_active' => true, 'image' => null]); }
    }

    private function seedAchievements(): void
    {
        $achievements = [
            ['title' => 'Juara 1 Olimpiade Matematika Nasional', 'description' => 'Meraih juara pertama dalam Olimpiade Matematika tingkat nasional yang diikuti oleh lebih dari 500 sekolah.', 'level' => 'Nasional', 'category' => 'Akademik', 'year' => 2024, 'order' => 1],
            ['title' => 'Juara 1 Basket Putra Tingkat Provinsi', 'description' => 'Tim basket putra berhasil meraih juara pertama dalam kompetisi basket antar SMA tingkat provinsi.', 'level' => 'Provinsi', 'category' => 'Olahraga', 'year' => 2024, 'order' => 2],
            ['title' => 'Juara 2 Lomba Debat Bahasa Inggris Nasional', 'description' => 'Tim debat bahasa Inggris meraih posisi runner-up dalam lomba debat nasional.', 'level' => 'Nasional', 'category' => 'Akademik', 'year' => 2024, 'order' => 3],
            ['title' => 'Juara 1 Lomba Karya Ilmiah Remaja', 'description' => 'Meraih juara pertama dalam Lomba Karya Ilmiah Remaja tingkat kabupaten.', 'level' => 'Kabupaten', 'category' => 'Akademik', 'year' => 2023, 'order' => 4],
            ['title' => 'Juara 3 Festival Seni Pelajar Provinsi', 'description' => 'Tim seni tari meraih juara ketiga dalam festival seni pelajar tingkat provinsi.', 'level' => 'Provinsi', 'category' => 'Seni', 'year' => 2023, 'order' => 5],
            ['title' => 'Sekolah Adiwiyata Nasional', 'description' => 'Mendapat penghargaan Sekolah Adiwiyata Nasional atas komitmen terhadap lingkungan hidup.', 'level' => 'Nasional', 'category' => 'Lingkungan', 'year' => 2023, 'order' => 6],
        ];
        foreach ($achievements as $a) { Achievement::updateOrCreate(['title' => $a['title']], $a + ['is_active' => true, 'image' => null]); }
    }

    private function seedExtracurriculars(): void
    {
        $extras = [
            ['name' => 'Pramuka', 'description' => 'Organisasi kepanduan yang membentuk karakter, kemandirian, dan jiwa kepemimpinan siswa.', 'schedule' => 'Jumat, 14:00 - 16:00', 'teacher' => 'Ahmad Fauzi, S.Pd.', 'order' => 1],
            ['name' => 'Basket', 'description' => 'Kegiatan olahraga basket yang melatih kerja sama tim dan kebugaran fisik siswa.', 'schedule' => 'Selasa & Kamis, 15:30 - 17:30', 'teacher' => 'Hendra Pratama, S.T.', 'order' => 2],
            ['name' => 'Paduan Suara', 'description' => 'Kegiatan seni musik vokal yang mengembangkan bakat bernyanyi dan apresiasi seni.', 'schedule' => 'Rabu, 14:00 - 16:00', 'teacher' => 'Dewi Lestari, S.Pd.', 'order' => 3],
            ['name' => 'English Club', 'description' => 'Klub bahasa Inggris untuk meningkatkan kemampuan komunikasi dalam bahasa internasional.', 'schedule' => 'Senin, 14:00 - 16:00', 'teacher' => 'Rini Amalia, S.Pd.', 'order' => 4],
            ['name' => 'Karya Ilmiah Remaja (KIR)', 'description' => 'Mengembangkan minat dan kemampuan penelitian serta penulisan karya ilmiah siswa.', 'schedule' => 'Kamis, 14:00 - 16:00', 'teacher' => 'Siti Rahayu, S.Pd., M.Si.', 'order' => 5],
            ['name' => 'Robotik', 'description' => 'Klub teknologi yang mempelajari pemrograman robot dan pengembangan teknologi terkini.', 'schedule' => 'Sabtu, 08:00 - 12:00', 'teacher' => 'Budi Santoso, S.Pd., M.Kom.', 'order' => 6],
        ];
        foreach ($extras as $e) { Extracurricular::updateOrCreate(['name' => $e['name']], $e + ['is_active' => true, 'image' => null]); }
    }

    private function seedServices(): void
    {
        $this->call(ServiceSeeder::class);
    }
}
