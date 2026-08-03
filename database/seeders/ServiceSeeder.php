<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate / delete existing dummy services
        DB::table('services')->truncate();

        $services = [
            [
                'title' => 'LAYANAN PELAKSANAAN KEGIATAN PEMBELAJARAN',
                'description' => 'Standar pelayanan kegiatan pembelajaran tatap muka dan dalam jaringan (daring) bagi murid UPT SMP Negeri 1 Buay Sandang Aji.',
                'icon' => 'fas fa-chalkboard-teacher',
                'order' => 1,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Layanan:</h4>
        <ul class="list-disc pl-5 space-y-1 text-gray-700">
            <li>Terdaftar sebagai murid UPT SMP Negeri 1 Buay Sandang Aji</li>
        </ul>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <div class="space-y-3">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h5 class="font-semibold text-blue-800 mb-1">Pembelajaran Tatap Muka:</h5>
                <ol class="list-decimal pl-5 space-y-1 text-gray-700">
                    <li>Murid hadir di sekolah 15 menit sebelum pembelajaran dimulai</li>
                    <li>Murid dan Guru membaca do’a sebelum memulai kegiatan pembelajaran</li>
                    <li>Murid dan Guru melaksanakan pembelajaran sesuai jadwal pelajaran di kelas masing-masing</li>
                    <li>Murid dan Guru membaca doa sebelum mengakhiri pembelajaran</li>
                </ol>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h5 class="font-semibold text-blue-800 mb-1">Pembelajaran Dalam Jaringan (Daring):</h5>
                <ol class="list-decimal pl-5 space-y-1 text-gray-700">
                    <li>Murid dan Guru bergabung dalam kelas virtual Google Classroom</li>
                    <li>Murid mengisi presensi kehadiran dalam kelas Google Classroom / WhatsApp</li>
                    <li>Guru memberikan materi dan Lembar Tugas Murid dalam Pembelajaran asinkron melalui Google Classroom / WhatsApp</li>
                    <li>Guru memberikan materi dan Lembar Tugas Murid dalam Pembelajaran sinkron melalui Zoom Meeting</li>
                    <li>Murid mengumpulkan tugas sesuai dengan jadwal yang ditentukan</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <ul class="text-xs text-gray-700 space-y-1 list-disc pl-4">
                <li><strong>Tatap Muka:</strong> 6 hari setiap minggu (mulai 07.30 WIB)</li>
                <li><strong>PJJ:</strong> 6 hari setiap minggu</li>
            </ul>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Layanan Pembelajaran</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'LAYANAN PELAKSANAAN KEGIATAN PENILAIAN PEMBELAJARAN',
                'description' => 'Standar penilaian hasil pembelajaran (PTS, PAS, PAT, dan Ujian Sekolah).',
                'icon' => 'fas fa-file-signature',
                'order' => 2,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ul class="list-disc pl-5 space-y-1 text-gray-700">
            <li>Terdaftar sebagai murid UPT SMP Negeri 1 Buay Sandang Aji</li>
        </ul>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Penyiapan Perlengkapan Administrasi Penilaian.</li>
            <li>Penyiapan Sarana Prasarana Pendukung Penilaian.</li>
            <li>Pelaksanaan Penilaian.</li>
            <li>Pengolahan hasil/nilai.</li>
            <li>Penyampaian laporan Capaian Kompetensi Pembelajaran Murid.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <ul class="text-xs text-gray-700 space-y-1 list-disc pl-4">
                <li><strong>PTS:</strong> 6 hari</li>
                <li><strong>PAS:</strong> 6 hari</li>
                <li><strong>PAT:</strong> 6 hari</li>
                <li><strong>Ujian Sekolah:</strong> 6 hari ujian tulis & 6 hari ujian praktek</li>
            </ul>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Layanan Penilaian Pembelajaran</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN SISTEM PENERIMAAN MURID BARU (SPMB)',
                'description' => 'Layanan pendaftaran dan seleksi calon peserta didik baru secara online maupun langsung.',
                'icon' => 'fas fa-user-plus',
                'order' => 3,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700">
            <li>Kartu Keluarga (KK)</li>
            <li>Akta Kelahiran</li>
            <li>Surat Keterangan Kurang Mampu / KIP / PIP (jika ada)</li>
        </ol>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Menyampaikan Persyaratan langsung ke Panitia SPMB.</li>
            <li>Mendaftar secara online pada laman web SPMB.</li>
            <li>Jika lolos, maka harus melakukan daftar ulang dengan membawa dokumen yang disyaratkan.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">1 Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Layanan SPMB</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'LAYANAN MASA PENGENALAN LINGKUNGAN SEKOLAH (MPLS)',
                'description' => 'Layanan kegiatan adaptasi dan pengenalan program, sarana, tata tertib, serta lingkungan sekolah.',
                'icon' => 'fas fa-school',
                'order' => 4,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ul class="list-disc pl-5 space-y-1 text-gray-700">
            <li>Ditetapkan sebagai Murid UPT SMP Negeri 1 Buay Sandang Aji</li>
        </ul>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Mengikuti apel pembukaan MPLS.</li>
            <li>Setiap hari mengisi daftar hadir.</li>
            <li>Setiap hari mengikuti materi dan kegiatan serta mengerjakan tugas.</li>
            <li>Mengikuti apel penutupan MPLS.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">6 Hari</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Layanan MPLS</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN EKSTRAKURIKULER',
                'description' => 'Layanan pendaftaran, penjadwalan, dan pembinaan kegiatan minat dan bakat murid.',
                'icon' => 'fas fa-running',
                'order' => 5,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700">
            <li>Murid mendaftar pada salah satu jenis ekstrakurikuler</li>
            <li>Jadwal kegiatan ekstrakurikuler</li>
            <li>Daftar pembina dan pelatih ekstrakurikuler</li>
            <li>Daftar hadir Murid, pembina dan pelatih ekstrakurikuler</li>
            <li>Jurnal pelaksanaan ekstrakurikuler</li>
            <li>Penyusunan materi kegiatan ekstrakurikuler</li>
        </ol>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Koordinasi persiapan kegiatan ekstrakurikuler bersama pembina dan pelatih.</li>
            <li>Persiapan administrasi kegiatan ekstrakurikuler.</li>
            <li>Pelaksanaan kegiatan ekstrakurikuler.</li>
            <li>Melakukan evaluasi pelaksanaan kegiatan ekstrakurikuler.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">1 Tahun Ajaran</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Layanan Kegiatan Ekstrakurikuler</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'LAYANAN BIMBINGAN KONSELING',
                'description' => 'Layanan konseling individual bagi murid serta ruang konsultasi pendampingan bagi orang tua.',
                'icon' => 'fas fa-hands-helping',
                'order' => 6,
                'is_active' => true,
                'content' => '
<div class="space-y-5">
    <div class="bg-gray-50 p-4 md:p-5 rounded-2xl border border-gray-200">
        <h4 class="font-bold text-blue-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-user-graduate text-blue-700"></i> A. LAYANAN KONSELING INDIVIDU</h4>
        <p class="text-xs text-gray-500 mb-3"><strong>Persyaratan:</strong> Tidak ada persyaratan khusus (-)</p>
        <h5 class="font-semibold text-gray-800 text-sm mb-1.5">Sistem, Mekanisme dan Prosedur:</h5>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700 text-sm">
            <li>Murid datang ke ruang konseling setelah mendapat ijin dari guru pengajar.</li>
            <li>Konselor menyambut Murid dan mengarahkan Murid untuk duduk di ruang konseling.</li>
            <li>Konselor melaksanakan layanan konseling individu bersama Murid.</li>
            <li>Konselor mengakhiri layanan konseling serta membuat kesepakatan pertemuan berikutnya.</li>
            <li>Konselor memberikan Murid surat ijin masuk kelas.</li>
            <li>Murid kembali ke kelas untuk mengikuti pembelajaran.</li>
        </ol>
        <div class="mt-3 flex flex-wrap gap-4 text-xs">
            <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-lg"><strong>Waktu:</strong> &le; 40 menit / pertemuan</span>
            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-lg"><strong>Biaya:</strong> Gratis</span>
            <span class="bg-purple-100 text-purple-800 px-2.5 py-1 rounded-lg"><strong>Produk:</strong> Layanan konseling permasalahan Murid</span>
        </div>
    </div>

    <div class="bg-gray-50 p-4 md:p-5 rounded-2xl border border-gray-200">
        <h4 class="font-bold text-blue-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-user-friends text-blue-700"></i> B. LAYANAN KONSULTASI BAGI ORANG TUA</h4>
        <p class="text-xs text-gray-500 mb-3"><strong>Persyaratan:</strong> Tidak ada persyaratan khusus (-)</p>
        <h5 class="font-semibold text-gray-800 text-sm mb-1.5">Sistem, Mekanisme dan Prosedur:</h5>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700 text-sm">
            <li>Guru mengirimkan undangan kepada orang tua / orang tua datang atas inisiatif sendiri.</li>
            <li>Orang tua hadir di ruang guru.</li>
            <li>Guru meminta orang tua untuk mengisi buku tamu.</li>
            <li>Jika orang tua hadir atas inisiatif sendiri maka Guru menanyakan keperluan orang tua ingin berkonsultasi dengan siapa (Guru pengajar / wali kelas / Kepala Sekolah / Konselor / Tenaga Kependidikan).</li>
            <li>Guru melayani orang tua dengan layanan konsultasi.</li>
            <li>Jika memerlukan tindak lanjut, maka Guru membuat kesepakatan dengan orang tua untuk pertemuan berikutnya.</li>
            <li>Orang tua pulang.</li>
        </ol>
        <div class="mt-3 flex flex-wrap gap-4 text-xs">
            <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-lg"><strong>Waktu:</strong> &le; 60 menit / pertemuan</span>
            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-lg"><strong>Biaya:</strong> Gratis</span>
            <span class="bg-purple-100 text-purple-800 px-2.5 py-1 rounded-lg"><strong>Produk:</strong> Layanan konsultasi orang tua dengan guru/wali kelas</span>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN LEGALISIR IJAZAH',
                'description' => 'Layanan legalisasi dan pengesahan fotokopi ijazah resmi oleh pihak sekolah.',
                'icon' => 'fas fa-stamp',
                'order' => 7,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700">
            <li>Asli Ijazah</li>
            <li>Fotokopi Ijazah</li>
        </ol>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Pemohon mengenakan baju rapih berkerah dan bersepatu.</li>
            <li>Pemohon menyampaikan berkas pada petugas administrasi/guru.</li>
            <li>Petugas meneliti kesesuaian berkas.</li>
            <li>Jika sudah sesuai, Petugas membubuhkan stempel legalisir pada berkas fotokopi.</li>
            <li>Petugas menyerahkan berkas legalisir pada Kepala Sekolah untuk ditandatangani.</li>
            <li>Petugas membubuhkan stempel sekolah di atas tanda tangan Kepala Sekolah.</li>
            <li>Petugas menyerahkan berkas yang telah dilegalisir kepada pemohon.</li>
            <li>Pemohon mengisi buku bukti pengambilan hasil legalisir.</li>
            <li>Pemohon pulang.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">1 (satu) Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Legalisir Ijazah</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN PENGURUSAN SURAT KETERANGAN PRESTASI',
                'description' => 'Layanan penerbitan surat keterangan prestasi murid berdasarkan piagam atau bukti kejuaraan resmi.',
                'icon' => 'fas fa-award',
                'order' => 8,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ul class="list-disc pl-5 space-y-1 text-gray-700">
            <li>Asli Piagam Prestasi</li>
        </ul>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Pemohon mengenakan baju rapih berkrah dan bersepatu.</li>
            <li>Pemohon mengisi form data diri sebagai sumber data pada surat keterangan.</li>
            <li>Pemohon menyerahkan piagam prestasi asli.</li>
            <li>Petugas meneliti berkas piagam asli.</li>
            <li>Petugas membuatkan surat keterangan prestasi serta mencetaknya.</li>
            <li>Petugas menyerahkan surat keterangan prestasi pada Kepala Sekolah untuk ditandatangani Kepala Sekolah.</li>
            <li>Petugas membubuhkan stempel sekolah di atas tanda tangan Kepala Sekolah.</li>
            <li>Petugas menyerahkan berkas/surat keterangan prestasi pada pemohon.</li>
            <li>Pemohon pulang.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">1 (satu) Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Surat Keterangan Prestasi Murid</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN PENGURUSAN SURAT KETERANGAN MURID',
                'description' => 'Layanan penerbitan surat keterangan resmi siswa aktif di UPT SMP Negeri 1 Buay Sandang Aji.',
                'icon' => 'fas fa-file-alt',
                'order' => 9,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ul class="list-disc pl-5 space-y-1 text-gray-700">
            <li>Tidak ada persyaratan khusus (-)</li>
        </ul>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Pemohon mengenakan baju rapih berkerah dan bersepatu.</li>
            <li>Pemohon mengisi form data diri sebagai sumber data pada surat keterangan.</li>
            <li>Petugas membuatkan surat keterangan serta mencetaknya.</li>
            <li>Petugas menyerahkan berkas pada Kepala Sekolah untuk ditandatangani Kepala Sekolah.</li>
            <li>Petugas membubuhkan stempel sekolah di atas tanda tangan Kepala Sekolah.</li>
            <li>Petugas menyerahkan berkas/surat keterangan pada pemohon.</li>
            <li>Pemohon pulang.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">1 (satu) Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Surat Keterangan</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN SURAT KETERANGAN PENGGANTI IJAZAH HILANG',
                'description' => 'Layanan penerbitan surat keterangan pengganti ijazah yang hilang dan proses pengesahan hingga Dinas Pendidikan.',
                'icon' => 'fas fa-id-card-alt',
                'order' => 10,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700">
            <li>Fotokopi Ijazah</li>
            <li>Asli Surat Keterangan Tanda Lapor Kehilangan dari Kepolisian</li>
            <li>Fotokopi Keterangan Tanda Lapor Kehilangan dari Kepolisian</li>
            <li>Surat pernyataan tanggungjawab mutlak yang sudah ditandatangani di atas materai oleh pemohon</li>
            <li>Pas foto 3x4 (1 lembar)</li>
            <li>Materai (1 lembar)</li>
        </ol>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Pemohon mengenakan baju rapih berkerah dan bersepatu.</li>
            <li>Pemohon menyerahkan berkas persyaratan pada petugas Tata Usaha bidang kemuridan.</li>
            <li>Petugas membuatkan surat keterangan pengganti ijazah kemudian mencetaknya rangkap 2.</li>
            <li>Petugas menyerahkan berkas pada Kepala Sekolah untuk ditandatangani Kepala Sekolah di atas materai.</li>
            <li>Petugas membubuhkan stempel sekolah di atas tanda tangan Kepala Sekolah.</li>
            <li>Petugas menyerahkan dua lembar berkas/surat keterangan pada pemohon dan mengarahkan pemohon untuk meminta tanda tangan Kepala Dinas Pendidikan.</li>
            <li>Pemohon datang ke Dinas Pendidikan untuk meminta tanda tangan Kepala Dinas Pendidikan pada surat keterangan pengganti ijazah.</li>
            <li>Setelah surat keterangan pengganti ijazah ditandatangani Kepala Dinas Pendidikan, pemohon datang ke sekolah menemui petugas Tata Usaha bidang kemuridan untuk menyerahkan satu lembar surat keterangan pengganti ijazah sebagai arsip sekolah. Satu lembar lainnya diserahkan untuk pemohon.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">2 (dua) Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Surat Keterangan Pengganti Ijazah Hilang</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN PENGURUSAN SURAT KETERANGAN KESALAHAN PENULISAN IJAZAH',
                'description' => 'Layanan perbaikan data dan penerbitan surat keterangan resmi kesalahan penulisan dalam ijazah.',
                'icon' => 'fas fa-spell-check',
                'order' => 11,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ol class="list-decimal pl-5 space-y-1 text-gray-700">
            <li>Asli dan Fotokopi Ijazah</li>
            <li>Asli dan Fotokopi Akta Kelahiran</li>
            <li>Materai (1 lembar)</li>
        </ol>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>Pemohon mengenakan baju rapih berkerah dan bersepatu.</li>
            <li>Pemohon menyerahkan berkas persyaratan pada petugas.</li>
            <li>Petugas membuatkan surat keterangan yang menyatakan pembetulan data pada kesalahan penulisan dalam ijazah.</li>
            <li>Petugas kemudian mencetak surat keterangan tersebut rangkap 2.</li>
            <li>Petugas menyerahkan berkas pada Kepala Sekolah untuk ditandatangani Kepala Sekolah di atas materai.</li>
            <li>Petugas membubuhkan stempel sekolah di atas tanda tangan Kepala Sekolah.</li>
            <li>Petugas menyerahkan dua lembar berkas/surat keterangan pada pemohon dan mengarahkan pemohon untuk meminta tanda tangan Kepala Dinas Pendidikan.</li>
            <li>Pemohon datang ke Dinas Pendidikan untuk meminta tanda tangan Kepala Dinas Pendidikan pada surat keterangan.</li>
            <li>Setelah surat keterangan ditandatangani Kepala Dinas Pendidikan, pemohon datang ke sekolah menemui petugas Tata Usaha bidang kemuridan untuk menyerahkan satu lembar surat keterangan sebagai arsip sekolah. Satu lembar lainnya diserahkan untuk pemohon.</li>
        </ol>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">2 (dua) Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Surat Keterangan Kesalahan Penulisan Ijazah</p>
        </div>
    </div>
</div>',
            ],
            [
                'title' => 'PELAYANAN PENGURUSAN SURAT KETERANGAN DAN REKOMENDASI MUTASI MURID',
                'description' => 'Layanan pengurusan administrasi perpindahan / mutasi murid (Mutasi Keluar & Mutasi Masuk).',
                'icon' => 'fas fa-exchange-alt',
                'order' => 12,
                'is_active' => true,
                'content' => '
<div class="space-y-4">
    <div>
        <h4 class="font-bold text-gray-900 mb-1 text-base flex items-center gap-2"><i class="fas fa-clipboard-check text-blue-600"></i> Persyaratan Pelayanan:</h4>
        <ol class="list-decimal pl-5 space-y-1.5 text-gray-700">
            <li>
                <strong>Fotokopi Rapot meliputi:</strong>
                <ul class="list-disc pl-5 mt-1 space-y-0.5 text-gray-600">
                    <li>Identitas Murid</li>
                    <li>Nilai kelas terakhir</li>
                    <li>Riwayat pindah (halaman belakang raport yang ditandatangani oleh Kepala Sekolah)</li>
                </ul>
            </li>
            <li>Fotokopi Surat Keterangan pindah dari sekolah asal</li>
            <li>Fotokopi Surat keterangan diterima di sekolah yang dituju</li>
            <li>Dokumen asli yang difotokopi</li>
        </ol>
    </div>

    <div>
        <h4 class="font-bold text-gray-900 mb-2 text-base flex items-center gap-2"><i class="fas fa-tasks text-blue-600"></i> Sistem, Mekanisme, dan Prosedur:</h4>
        <div class="space-y-3">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h5 class="font-semibold text-blue-800 mb-1.5">A. MUTASI KELUAR:</h5>
                <ol class="list-decimal pl-5 space-y-1 text-gray-700 text-sm">
                    <li>Pemohon datang ke ruang Tata Usaha.</li>
                    <li>Pemohon menyerahkan berkas persyaratan kepada petugas Tata Usaha.</li>
                    <li>Petugas memverifikasi berkas-berkas.</li>
                    <li>Petugas membuatkan surat mutasi pindah sekolah rangkap dua.</li>
                    <li>Petugas menyerahkan surat mutasi pindah sekolah pada Kepala Sekolah untuk ditandatangani.</li>
                    <li>Petugas menyerahkan surat mutasi pindah sekolah yang sudah ditandatangani Kepala Sekolah kepada pemohon.</li>
                    <li>Pemohon datang ke Dinas Pendidikan untuk meminta tanda tangan Kepala Dinas Pendidikan pada surat mutasi pindah.</li>
                    <li>Pemohon datang ke ruang Tata Usaha menemui petugas untuk menyerahkan satu lembar surat mutasi yang sudah ditandatangani Kepala Dinas Pendidikan sebagai arsip sekolah.</li>
                    <li>Pemohon pulang membawa satu lembar surat mutasi pindah sekolah yang telah ditandatangani Kepala Sekolah dan Kepala Dinas Pendidikan.</li>
                </ol>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h5 class="font-semibold text-blue-800 mb-1.5">B. MUTASI MASUK:</h5>
                <ol class="list-decimal pl-5 space-y-1 text-gray-700 text-sm">
                    <li>Pemohon datang ke ruang Tata Usaha.</li>
                    <li>Pemohon menyerahkan berkas persyaratan kepada petugas Tata Usaha.</li>
                    <li>Petugas memverifikasi berkas-berkas.</li>
                    <li>Petugas menyerahkan berkas kepada Kepala Sekolah dan operator sekolah untuk memastikan ketersediaan daya tampung bagi Murid.</li>
                    <li>Jika tersedia daya tampung bagi Murid mutasi, maka petugas membuatkan surat keterangan bersedia menerima Murid pindah ke sekolah ini.</li>
                    <li>Pemohon pulang untuk mengurus mutasi Murid dari sekolah asal.</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
        <div class="bg-blue-50/70 p-3 rounded-xl border border-blue-100">
            <span class="text-xs font-semibold text-blue-800 uppercase block mb-1">Jangka Waktu Pelayanan</span>
            <p class="text-sm font-semibold text-gray-800">2 (dua) Hari Kerja</p>
        </div>
        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
            <span class="text-xs font-semibold text-emerald-800 uppercase block mb-1">Biaya / Tarif</span>
            <p class="text-base font-bold text-emerald-600">Gratis (Rp 0)</p>
        </div>
        <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100">
            <span class="text-xs font-semibold text-indigo-800 uppercase block mb-1">Produk Pelayanan</span>
            <p class="text-sm font-medium text-gray-800">Surat Keterangan / Surat Rekomendasi Mutasi</p>
        </div>
    </div>
</div>',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
