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
                'excerpt' => 'UPT SMP Negeri 1 Buay Sandang Aji adalah satuan pendidikan formal jenjang SMP di Kabupaten Ogan Komering Ulu Selatan yang berlandaskan pada 4 pilar: Berakhlakul Karimah, Sukses, Berprestasi, dan Andal.',
                'content' => '<h2>Tentang UPT SMP Negeri 1 Buay Sandang Aji</h2><p>UPT SMP Negeri 1 Buay Sandang Aji merupakan satuan pendidikan formal jenjang Sekolah Menengah Pertama (SMP) berstatus Negeri yang berkedudukan di Desa Gunung Terang, Kecamatan Buay Sandang Aji, Kabupaten Ogan Komering Ulu Selatan, Provinsi Sumatera Selatan.</p><p>Sekolah ini berkomitmen mencetak generasi penerus bangsa yang unggul, berdaya saing, berakhlak mulia, dan tangguh dalam menghadapi perkembangan zaman melalui integrasi Kurikulum Merdeka dan pembiasaan karakter keagamaan.</p><h2>Identitas Satuan Pendidikan</h2><ul><li><strong>Nama Satuan Pendidikan:</strong> UPT SMP Negeri 1 Buay Sandang Aji</li><li><strong>NPSN:</strong> 10604104</li><li><strong>NSS:</strong> 201110800001</li><li><strong>Bentuk Pendidikan:</strong> Sekolah Menengah Pertama (SMP)</li><li><strong>Status Sekolah:</strong> Negeri</li><li><strong>Akreditasi:</strong> B</li><li><strong>Kepala Sekolah:</strong> Rosidah, S.Pd (NIP. 197005171997022002)</li><li><strong>Alamat:</strong> Jl. Raya Kenali RT 01 RW 01, Desa Gunung Terang, Kec. Buay Sandang Aji, Kab. Ogan Komering Ulu Selatan, Sumatera Selatan 32252</li></ul><h2>4 Pilar Keunggulan Sekolah (B-S-B-A)</h2><p>Penyelenggaraan pendidikan di UPT SMP Negeri 1 Buay Sandang Aji didorong oleh visi agung B-S-B-A:</p><ol><li><strong>Berakhlakul Karimah:</strong> Menanamkan nilai religius, pembiasaan sholat dhuha & dzuhur berjamaah, hafalan Juz \'Amma, dan budaya 5S.</li><li><strong>Sukses:</strong> Unggul dalam literasi, numerasi, Asesmen Nasional (ANBK), dan kelulusan menuju jenjang favorit.</li><li><strong>Berprestasi:</strong> Berprestasi dalam bidang akademik (Olimpiade Sains), olahraga (Voli, Futsal), seni budaya daerah, dan kepramukaan.</li><li><strong>Andal:</strong> Membentuk karakter mandiri, tangguh, berjiwa kepemimpinan, dan cakap teknologi sesuai Profil Pelajar Pancasila.</li></ol>',
                'meta_title' => 'Profil Sekolah - UPT SMP Negeri 1 Buay Sandang Aji',
                'meta_description' => 'Profil lengkap UPT SMP Negeri 1 Buay Sandang Aji, satuan pendidikan negeri di Kab. OKU Selatan.',
                'is_active' => true,
            ],
            [
                'slug' => 'sejarah',
                'title' => 'Sejarah Singkat Sekolah',
                'excerpt' => 'Perjalanan dedikasi UPT SMP Negeri 1 Buay Sandang Aji dalam mencerdaskan generasi bangsa di Kabupaten OKU Selatan.',
                'content' => '<h2>Sejarah Berdirinya UPT SMP Negeri 1 Buay Sandang Aji</h2><p>UPT SMP Negeri 1 Buay Sandang Aji didirikan sebagai respons atas kebutuhan masyarakat Kecamatan Buay Sandang Aji dan sekitarnya akan akses pendidikan menengah pertama yang bermutu dan mudah dijangkau.</p><p>Sejak awal berdirinya, sekolah ini terus mengalami transformasi yang signifikan, baik dari segi sarana prasarana fisik, kelengkapan laboratorium IPA dan TIK, hingga peningkatan kualifikasi akademik dan profesionalisme para tenaga pendidik.</p><p>Hingga kini, UPT SMP Negeri 1 Buay Sandang Aji telah mendidik ratusan generasi muda, mengukir berbagai prestasi kejuaraan di tingkat kabupaten maupun provinsi, dan terus menjadi institusi pendidikan yang dipercaya masyarakat dengan 13 rombongan belajar dan 49 tenaga pendidik serta kependidikan.</p>',
                'meta_title' => 'Sejarah Singkat - UPT SMP Negeri 1 Buay Sandang Aji',
                'meta_description' => 'Sejarah berdirinya UPT SMP Negeri 1 Buay Sandang Aji di Kabupaten Ogan Komering Ulu Selatan.',
                'is_active' => true,
            ],
            [
                'slug' => 'visi-misi',
                'title' => 'Visi & Misi Sekolah',
                'excerpt' => 'Visi B-S-B-A dan Misi UPT SMP Negeri 1 Buay Sandang Aji sebagai panduan mewujudkan mutu pendidikan unggul.',
                'content' => '<h2>Visi Sekolah</h2><blockquote><p><em>"Terwujudnya Peserta Didik yang Berakhlakul Karimah, Sukses, Berprestasi, dan Andal (B-S-B-A)"</em></p></blockquote><h2>Indikator Visi (4 Pilar)</h2><h3>1. Berakhlakul Karimah</h3><ul><li>Memiliki sikap beriman dan bertakwa kepada Tuhan Yang Maha Esa serta berbudi pekerti luhur.</li><li>Mampu membaca Al-Qur\'an dan menghafal ayat-ayat pendek (Juz \'Amma).</li><li>Melaksanakan ibadah rutin sholat dhuha dan sholat dzuhur berjamaah di sekolah.</li><li>Menjalankan budaya infak rutin setiap hari Jumat.</li><li>Menerapkan budaya 5S (Senyum, Salam, Sapa, Sopan, Santun) dalam pergaulan sehari-hari.</li></ul><h3>2. Sukses</h3><ul><li>Sukses dalam pelaksanaan proses pembelajaran intrakurikuler dan kokurikuler.</li><li>Sukses dalam pencapaian Asesmen Nasional Berbasis Komputer (ANBK) dan Ujian Sekolah.</li><li>Sukses mengantarkan lulusan melanjutkan ke jenjang SMA/SMK/MA favorit.</li><li>Sukses menguasai kecakapan literasi, numerasi, dan literasi digital dasar.</li></ul><h3>3. Berprestasi</h3><ul><li>Berprestasi dalam bidang akademik seperti Olimpiade Sains Nasional (OSN/KSN).</li><li>Berprestasi dalam bidang olahraga (Bola Voli, Futsal, Atletik).</li><li>Berprestasi dalam bidang seni budaya daerah dan kepramukaan (LT II, LT III, FLS2N).</li><li>Berprestasi dalam kompetisi keagamaan (MTQ, Dai Muda, Tahfidz Qur\'an).</li></ul><h3>4. Andal</h3><ul><li>Andal dalam kedisiplinan, tanggung jawab, dan kepemimpinan organisasi (OSIS, Pramuka, PMR).</li><li>Memiliki jiwa mandiri, tangguh, bernalar kritis, dan gotong royong sesuai Profil Pelajar Pancasila.</li><li>Siap menghadapi tantangan era globalisasi dengan pemanfaatan teknologi informasi secara bijak.</li></ul><h2>Misi Sekolah</h2><ol><li>Menanamkan nilai-nilai keimanan, ketakwaan, dan akhlak mulia melalui pembiasaan ibadah rutin dan keteladanan budi pekerti.</li><li>Menyelenggarakan proses pembelajaran yang aktif, inovatif, kreatif, efektif, menyenangkan, dan berpusat pada murid berbasis Kurikulum Merdeka.</li><li>Mengembangkan potensi, bakat, dan minat murid secara optimal melalui kegiatan ekstrakurikuler dan program pembinaan prestasi.</li><li>Mewujudkan lingkungan sekolah yang asri, bersih, aman, nyaman, dan kondusif untuk mendukung kegiatan belajar mengajar.</li><li>Meningkatkan kompetensi dan profesionalisme tenaga pendidik dan tenaga kependidikan secara berkelanjutan.</li><li>Menjalin kemitraan yang sinergis, transparan, dan harmonis bersama orang tua murid, komite sekolah, dan masyarakat luas.</li></ol>',
                'meta_title' => 'Visi & Misi - UPT SMP Negeri 1 Buay Sandang Aji',
                'meta_description' => 'Visi dan Misi B-S-B-A UPT SMP Negeri 1 Buay Sandang Aji Kab. OKU Selatan.',
                'is_active' => true,
            ],
            [
                'slug' => 'sambutan-kepala-sekolah',
                'title' => 'Sambutan Kepala Sekolah',
                'excerpt' => 'Sambutan resmi dari Kepala UPT SMP Negeri 1 Buay Sandang Aji, Ibu Rosidah, S.Pd.',
                'content' => '<p><strong>Assalamu\'alaikum Warahmatullahi Wabarakatuh,</strong></p><p>Puji dan syukur senantiasa kita panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, atas limpahan rahmat, hidayah, dan karunia-Nya, sehingga website resmi UPT SMP Negeri 1 Buay Sandang Aji dapat hadir sebagai media informasi, transparansi, dan komunikasi publik yang modern.</p><p>Di era transformasi digital saat ini, keberadaan website sekolah menjadi instrumen penting untuk mendekatkan seluruh warga sekolah, peserta didik, tenaga pendidik, orang tua/wali murid, alumni, dan masyarakat luas. Melalui platform ini, kami berupaya menyajikan informasi terkini mengenai profil sekolah, kegiatan pembelajaran, standar pelayanan publik, prestasi murid, program ekstrakurikuler, serta tata kelola sekolah secara akuntabel.</p><p>UPT SMP Negeri 1 Buay Sandang Aji terus berikhtiar dan berbenah guna mewujudkan visi utama sekolah, yaitu <strong>"Berakhlakul Karimah, Sukses, Berprestasi, dan Andal" (B-S-B-A)</strong>. Kami meyakini bahwa pendidikan sejati tidak hanya menitikberatkan pada capaian kecerdasan intelektual, namun juga pembentukan karakter akhlak mulia, penguatan spiritual, ketangguhan fisik, dan kepedulian sosial.</p><p>Kami menyampaikan apresiasi dan terima kasih yang setinggi-tingginya kepada seluruh dewan guru, tenaga kependidikan, komite sekolah, serta seluruh orang tua murid atas kerjasama, doa, dan dedikasi tanpa henti bagi kemajuan sekolah tercinta ini.</p><p>Semoga Allah SWT senantiasa meridhoi setiap langkah dan ikhtiar kita dalam mencerdaskan kehidupan bangsa.</p><p><strong>Wassalamu\'alaikum Warahmatullahi Wabarakatuh.</strong></p><p class="mt-4"><strong>ROSIDAH, S.Pd</strong><br><em>Kepala UPT SMP Negeri 1 Buay Sandang Aji</em><br>NIP. 197005171997022002</p>',
                'meta_title' => 'Sambutan Kepala Sekolah - UPT SMP Negeri 1 Buay Sandang Aji',
                'meta_description' => 'Sambutan Kepala UPT SMP Negeri 1 Buay Sandang Aji, Ibu Rosidah, S.Pd.',
                'is_active' => true,
            ],
            [
                'slug' => 'struktur-organisasi',
                'title' => 'Struktur Organisasi Sekolah',
                'excerpt' => 'Bagan susunan organisasi kepemimpinan, tata usaha, wakil kepala sekolah, dan staf pengajar UPT SMP Negeri 1 Buay Sandang Aji.',
                'content' => '<h2>Struktur Organisasi UPT SMP Negeri 1 Buay Sandang Aji</h2><p>Penyelenggaraan tata kelola di UPT SMP Negeri 1 Buay Sandang Aji dipimpin oleh Kepala Sekolah bersama jajaran pimpinan, komite, tata usaha, serta dewan pendidik yang berkomitmen tinggi terhadap mutu pendidikan.</p><h3>Pimpinan Sekolah & Unsur Penasihat</h3><ul><li><strong>Kepala Sekolah:</strong> Rosidah, S.Pd</li><li><strong>Komite Sekolah:</strong> Nazzarudin</li><li><strong>Pengawas Sekolah:</strong> Zahid, S.Pd</li></ul><h3>Tata Usaha & Administrasi</h3><ul><li><strong>Koordinator Tata Usaha:</strong> Irsan A Rani, SH</li><li><strong>Bendahara Sekolah:</strong> Muhammad Erwin, S.Pd</li><li><strong>Staf Kepegawaian & Kearsipan:</strong> Hermaliana</li><li><strong>Staf Administrasi Kemuridan:</strong> Sitti Zahara</li><li><strong>Staf Pengadministrasi Sarana:</strong> Bambang Irawan</li><li><strong>Operator Dapodik & IT:</strong> Seria Pustika, S.Kom</li><li><strong>Staf Administrasi Perpustakaan:</strong> Evi Emilia</li><li><strong>Penjaga & Keamanan:</strong> Suherman Sawak</li></ul><h3>Wakil Kepala Sekolah</h3><ul><li><strong>Wakil Kurikulum:</strong> Yuniartika, S.Pd</li><li><strong>Wakil Kesiswaan:</strong> Fara Mustikawati, S.Pd</li><li><strong>Wakil Sarana Prasarana:</strong> Muhammad Erwin, S.Pd</li><li><strong>Wakil Humas:</strong> Emilia Rusda, S.Pd</li></ul><h3>Kepala Unit & Koordinator</h3><ul><li><strong>Kepala Lab IPA:</strong> Emilia Rusda, S.Pd</li><li><strong>Kepala Lab Bahasa:</strong> Erly Kartika W, S.Pd</li><li><strong>Kepala Perpustakaan:</strong> Apriyanti Mustika R., S.Pd</li><li><strong>Pembina OSIS:</strong> Arya Adi Santika, S.Pd</li><li><strong>Pembina Pramuka:</strong> Indra Waryanda, S.Pd</li><li><strong>Pembina Seni:</strong> Mulyadi, S.Psi</li><li><strong>Koordinator Infak:</strong> Mamah Tarmah, S.Ag</li><li><strong>Koordinator Kekeluargaan:</strong> Arjuana, S.Pd</li><li><strong>Bimbingan Konseling (BK):</strong> Romauli, S.Pd & Feriyanti, S.Sos.i</li></ul>',
                'meta_title' => 'Struktur Organisasi - UPT SMP Negeri 1 Buay Sandang Aji',
                'meta_description' => 'Struktur organisasi dan tata kelola UPT SMP Negeri 1 Buay Sandang Aji Kab. OKU Selatan.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}

