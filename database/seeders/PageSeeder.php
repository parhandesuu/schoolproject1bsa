<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'profil',
                'title' => 'Profil Sekolah',
                'excerpt' => 'SMA Negeri 1 Nusantara adalah sekolah unggulan berstatus negeri yang telah berdiri sejak tahun 1980.',
                'content' => '<h2>Tentang SMA Negeri 1 Nusantara</h2><p>SMA Negeri 1 Nusantara adalah sekolah menengah atas negeri yang berlokasi di Kabupaten Nusantara. Berdiri sejak tahun 1980, sekolah ini telah menghasilkan ribuan alumni yang tersebar di berbagai bidang.</p><p>Dengan akreditasi A dari Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M), SMA Negeri 1 Nusantara berkomitmen untuk terus meningkatkan kualitas pendidikan dan pelayanan kepada masyarakat.</p><h2>Identitas Sekolah</h2><ul><li><strong>Nama Sekolah:</strong> SMA Negeri 1 Nusantara</li><li><strong>NPSN:</strong> 20100001</li><li><strong>Akreditasi:</strong> A</li><li><strong>Status:</strong> Negeri</li><li><strong>Alamat:</strong> Jl. Pendidikan No. 1, Kecamatan Nusantara</li></ul>',
                'meta_title' => 'Profil Sekolah - SMA Negeri 1 Nusantara',
                'meta_description' => 'Profil lengkap SMA Negeri 1 Nusantara, sekolah unggulan berakreditasi A.',
                'is_active' => true,
            ],
            [
                'slug' => 'sejarah',
                'title' => 'Sejarah Sekolah',
                'excerpt' => 'Perjalanan panjang SMA Negeri 1 Nusantara dalam mencerdaskan generasi bangsa.',
                'content' => '<h2>Sejarah Berdirinya SMA Negeri 1 Nusantara</h2><p>SMA Negeri 1 Nusantara didirikan pada tahun 1980 atas prakarsa pemerintah daerah Kabupaten Nusantara dengan dukungan penuh dari masyarakat setempat. Pada awal pendiriannya, sekolah ini hanya memiliki 3 kelas dengan 120 siswa dan 15 tenaga pengajar.</p><p>Seiring berjalannya waktu, sekolah ini terus berkembang pesat. Pada tahun 1990, gedung sekolah diperluas dengan tambahan laboratorium IPA dan perpustakaan. Tahun 2000, sekolah ini mendapatkan akreditasi A pertama kalinya dari pemerintah.</p><p>Kini, SMA Negeri 1 Nusantara telah menjadi salah satu sekolah favorit di wilayah Kabupaten Nusantara dengan lebih dari 1.200 siswa aktif, 80 tenaga pengajar profesional, dan berbagai fasilitas modern.</p><h2>Tonggak Sejarah</h2><ul><li><strong>1980:</strong> Pendirian SMA Negeri 1 Nusantara</li><li><strong>1985:</strong> Pembangunan gedung permanen pertama</li><li><strong>1990:</strong> Penambahan laboratorium dan perpustakaan</li><li><strong>2000:</strong> Pertama kali mendapat akreditasi A</li><li><strong>2010:</strong> Pembangunan fasilitas modern (lab komputer, aula)</li><li><strong>2020:</strong> Transformasi digital pembelajaran</li></ul>',
                'meta_title' => 'Sejarah Sekolah - SMA Negeri 1 Nusantara',
                'meta_description' => 'Sejarah berdiri dan perkembangan SMA Negeri 1 Nusantara dari tahun 1980 hingga kini.',
                'is_active' => true,
            ],
            [
                'slug' => 'visi-misi',
                'title' => 'Visi & Misi',
                'excerpt' => 'Visi dan misi SMA Negeri 1 Nusantara sebagai landasan pengembangan sekolah.',
                'content' => '<h2>Visi</h2><blockquote><p><em>"Terwujudnya sekolah yang unggul dalam prestasi, berkarakter Pancasila, berwawasan lingkungan, dan berdaya saing global."</em></p></blockquote><h2>Misi</h2><ol><li>Menyelenggarakan pembelajaran yang inovatif, efektif, dan menyenangkan berbasis teknologi informasi.</li><li>Mengembangkan potensi peserta didik secara optimal melalui kegiatan akademik dan non-akademik.</li><li>Membangun karakter peserta didik yang beriman, bertakwa, berakhlak mulia, dan berwawasan kebangsaan.</li><li>Meningkatkan kompetensi pendidik dan tenaga kependidikan secara berkelanjutan.</li><li>Menciptakan lingkungan sekolah yang bersih, hijau, aman, dan kondusif untuk belajar.</li><li>Menjalin kemitraan yang harmonis dengan orang tua, masyarakat, dan pemangku kepentingan.</li></ol><h2>Tujuan Sekolah</h2><p>Berdasarkan visi dan misi tersebut, tujuan SMA Negeri 1 Nusantara adalah menghasilkan lulusan yang cerdas, berkarakter, mandiri, dan siap bersaing di era global.</p>',
                'meta_title' => 'Visi & Misi - SMA Negeri 1 Nusantara',
                'meta_description' => 'Visi dan misi SMA Negeri 1 Nusantara sebagai landasan pengembangan sekolah berkualitas.',
                'is_active' => true,
            ],
            [
                'slug' => 'sambutan-kepala-sekolah',
                'title' => 'Sambutan Kepala Sekolah',
                'excerpt' => 'Sambutan dari Kepala SMA Negeri 1 Nusantara.',
                'content' => '<p>Assalamu\'alaikum Warahmatullahi Wabarakatuh,</p><p>Puji syukur kehadirat Allah SWT atas segala rahmat dan karunia-Nya sehingga SMA Negeri 1 Nusantara dapat terus berkarya dan berprestasi dalam dunia pendidikan.</p><p>Selamat datang di website resmi SMA Negeri 1 Nusantara. Website ini hadir sebagai jembatan komunikasi antara sekolah dengan seluruh pemangku kepentingan—orang tua, siswa, alumni, dan masyarakat luas.</p><p>Kami berkomitmen untuk terus meningkatkan mutu pendidikan dan pelayanan. Dengan semangat gotong royong dan kerja keras seluruh warga sekolah, kami yakin SMA Negeri 1 Nusantara akan terus menjadi sekolah pilihan yang melahirkan generasi penerus bangsa yang cerdas, berkarakter, dan berprestasi.</p><p>Wassalamu\'alaikum Warahmatullahi Wabarakatuh.</p><p><strong>Drs. Bambang Wijaya, M.Pd.</strong><br>Kepala SMA Negeri 1 Nusantara</p>',
                'meta_title' => 'Sambutan Kepala Sekolah - SMA Negeri 1 Nusantara',
                'meta_description' => 'Sambutan Kepala SMA Negeri 1 Nusantara.',
                'is_active' => true,
            ],
            [
                'slug' => 'struktur-organisasi',
                'title' => 'Struktur Organisasi',
                'excerpt' => 'Struktur organisasi SMA Negeri 1 Nusantara.',
                'content' => '<h2>Struktur Organisasi</h2><p>SMA Negeri 1 Nusantara memiliki struktur organisasi yang terstruktur untuk mendukung pelaksanaan pendidikan yang efektif dan efisien.</p><h3>Kepala Sekolah</h3><p>Drs. Bambang Wijaya, M.Pd.</p><h3>Wakil Kepala Sekolah</h3><ul><li>Bidang Kurikulum: Ibu Siti Rahayu, S.Pd., M.Si.</li><li>Bidang Kesiswaan: Bapak Ahmad Fauzi, S.Pd.</li><li>Bidang Sarana Prasarana: Bapak Hendra Pratama, S.T.</li><li>Bidang Humas: Ibu Dewi Lestari, S.Pd.</li></ul><h3>Komite Sekolah</h3><p>Bapak H. Sudirman, S.E.</p>',
                'meta_title' => 'Struktur Organisasi - SMA Negeri 1 Nusantara',
                'meta_description' => 'Struktur organisasi SMA Negeri 1 Nusantara.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
