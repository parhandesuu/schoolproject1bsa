<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Survei Kepuasan Masyarakat (SKM) - UPT SMP Negeri 1 Buay Sandang Aji</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { 
                background: white !important; 
                padding: 0 !important;
                color: black !important;
                font-size: 12pt;
            }
            .page-break { page-break-before: always; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #ddd !important; }
            @page {
                size: A4 portrait;
                margin: 1.5cm 1.5cm 1.5cm 1.5cm;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .sans-font {
            font-family: ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen py-6 px-4">

    {{-- Top Action Bar (Screen Only) --}}
    <div class="no-print max-w-4xl mx-auto mb-6 bg-white p-4 rounded-2xl shadow-md border border-gray-200 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.surveys.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold sans-font flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <span class="text-xs text-gray-500 sans-font">Pratinjau Dokumen Cetak / Simpan PDF</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold sans-font flex items-center gap-2 shadow-sm cursor-pointer">
                <i class="fas fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    {{-- Printable Paper Container --}}
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-xl print-shadow-none border border-gray-200">
        
        {{-- KOP SURAT RESMI --}}
        <div class="border-b-4 border-double border-gray-900 pb-4 mb-6 text-center relative">
            {{-- Logo --}}
            <div class="flex items-center justify-center gap-6">
                <div class="w-20 h-20 shrink-0 flex items-center justify-center">
                    @if(isset($settings['school_logo']) && $settings['school_logo'])
                        <img src="{{ asset('storage/' . $settings['school_logo']) }}" alt="Logo Sekolah" class="max-h-20 max-w-20 object-contain">
                    @else
                        <img src="{{ asset('images/logo.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=SMPN1+BSA&background=1e40af&color=fff'" alt="Logo" class="max-h-20 max-w-20 object-contain">
                    @endif
                </div>
                <div class="flex-1 text-center">
                    <h4 class="text-sm uppercase tracking-wider font-bold text-gray-800 leading-tight">
                        PEMERINTAH KABUPATEN OGAN KOMERING ULU SELATAN
                    </h4>
                    <h3 class="text-base uppercase tracking-wider font-bold text-gray-900 leading-tight">
                        DINAS PENDIDIKAN
                    </h3>
                    <h2 class="text-xl uppercase font-extrabold text-gray-900 tracking-wide leading-snug">
                        UPT SMP NEGERI 1 BUAY SANDANG AJI
                    </h2>
                    <p class="text-xs text-gray-600 mt-1 italic">
                        {{ $settings['school_address'] ?? 'Kecamatan Buay Sandang Aji, Kabupaten Ogan Komering Ulu Selatan, Sumatera Selatan' }}
                    </p>
                    <p class="text-xs text-gray-600">
                        NPSN: {{ $settings['school_npsn'] ?? '10604169' }} | Email: {{ $settings['school_email'] ?? 'smpn1bsa@gmail.com' }} | Website: {{ url('/') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- JUDUL LAPORAN --}}
        <div class="text-center mb-6">
            <h3 class="text-lg font-bold uppercase underline tracking-wide">
                LAPORAN HASIL PENGUKURAN SURVEI KEPUASAN MASYARAKAT (SKM)
            </h3>
            <p class="text-xs text-gray-700 mt-1 font-semibold">
                Periode Laporan: {{ $request->filled('date_from') ? \Carbon\Carbon::parse($request->date_from)->translatedFormat('d F Y') : 'Awal' }} s/d {{ $request->filled('date_to') ? \Carbon\Carbon::parse($request->date_to)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- RINGKASAN EKSEKUTIF / INDEKS IKM --}}
        <div class="mb-6 p-4 rounded-xl border border-gray-800 bg-gray-50/50 sans-font">
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 mb-3 border-b border-gray-300 pb-1">
                I. Ringkasan Eksekutif Indeks Kepuasan Masyarakat (IKM)
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div class="p-2 border-r border-gray-200">
                    <span class="text-[11px] text-gray-600 block">Total Responden</span>
                    <span class="text-xl font-bold text-gray-900">{{ number_format($totalRespondents) }} Orang</span>
                </div>
                <div class="p-2 border-r border-gray-200">
                    <span class="text-[11px] text-gray-600 block">Rata-rata Nilai Unsur</span>
                    <span class="text-xl font-bold text-blue-900">{{ number_format($avgOverall, 2) }} / 4.00</span>
                </div>
                <div class="p-2 border-r border-gray-200">
                    <span class="text-[11px] text-gray-600 block">Nilai Konversi IKM</span>
                    <span class="text-xl font-bold text-indigo-900">{{ number_format($ikmScore, 2) }}</span>
                </div>
                <div class="p-2">
                    <span class="text-[11px] text-gray-600 block">Mutu & Kinerja</span>
                    <span class="text-base font-bold text-emerald-800 block">Mutu {{ $ikmGrade['grade'] }} ({{ $ikmGrade['performance'] }})</span>
                </div>
            </div>
        </div>

        {{-- TABEL 9 UNSUR PERMENPAN RB --}}
        <div class="mb-6">
            <h4 class="text-sm font-bold uppercase text-gray-900 mb-2 sans-font">
                II. Nilai Rata-rata per Unsur Pelayanan (Standar Permenpan RB No. 14 Tahun 2017)
            </h4>
            <table class="w-full border-collapse border border-gray-800 text-xs sans-font">
                <thead class="bg-gray-100 text-gray-900 font-bold">
                    <tr>
                        <th class="border border-gray-800 p-2 text-center w-10">No</th>
                        <th class="border border-gray-800 p-2 text-left">Unsur Pelayanan</th>
                        <th class="border border-gray-800 p-2 text-center w-28">Nilai Rata-rata (1-4)</th>
                        <th class="border border-gray-800 p-2 text-center w-28">Nilai IKM (25-100)</th>
                        <th class="border border-gray-800 p-2 text-center w-20">Mutu</th>
                        <th class="border border-gray-800 p-2 text-center w-28">Kinerja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questionStats as $num => $stat)
                    <tr>
                        <td class="border border-gray-800 p-2 text-center font-bold">U{{ $num }}</td>
                        <td class="border border-gray-800 p-2">
                            <strong>{{ $stat['title'] }}</strong>
                        </td>
                        <td class="border border-gray-800 p-2 text-center font-bold">{{ number_format($stat['avg_score'], 2) }}</td>
                        <td class="border border-gray-800 p-2 text-center font-bold">{{ number_format($stat['ikm'], 2) }}</td>
                        <td class="border border-gray-800 p-2 text-center font-bold">{{ $stat['grade']['grade'] }}</td>
                        <td class="border border-gray-800 p-2 text-center">{{ $stat['grade']['performance'] }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg-gray-50 font-bold">
                        <td colspan="2" class="border border-gray-800 p-2 text-right uppercase">Rata-rata Keseluruhan / IKM Unit Pelayanan:</td>
                        <td class="border border-gray-800 p-2 text-center text-blue-900">{{ number_format($avgOverall, 2) }}</td>
                        <td class="border border-gray-800 p-2 text-center text-indigo-900">{{ number_format($ikmScore, 2) }}</td>
                        <td class="border border-gray-800 p-2 text-center">{{ $ikmGrade['grade'] }}</td>
                        <td class="border border-gray-800 p-2 text-center">{{ $ikmGrade['performance'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TABEL KOMPOSISI RESPONDEN --}}
        <div class="mb-8">
            <h4 class="text-sm font-bold uppercase text-gray-900 mb-2 sans-font">
                III. Komposisi Responden Berdasarkan Peran
            </h4>
            <table class="w-full border-collapse border border-gray-800 text-xs sans-font">
                <thead class="bg-gray-100 text-gray-900 font-bold">
                    <tr>
                        <th class="border border-gray-800 p-2 text-center w-10">No</th>
                        <th class="border border-gray-800 p-2 text-left">Peran / Kategori Responden</th>
                        <th class="border border-gray-800 p-2 text-center w-32">Jumlah Responden</th>
                        <th class="border border-gray-800 p-2 text-center w-32">Persentase (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($roleDistribution as $roleName => $data)
                    <tr>
                        <td class="border border-gray-800 p-2 text-center">{{ $i++ }}</td>
                        <td class="border border-gray-800 p-2">{{ $roleName }}</td>
                        <td class="border border-gray-800 p-2 text-center font-semibold">{{ $data['count'] }}</td>
                        <td class="border border-gray-800 p-2 text-center">{{ $data['percent'] }}%</td>
                    </tr>
                    @endforeach
                    <tr class="bg-gray-50 font-bold">
                        <td colspan="2" class="border border-gray-800 p-2 text-right uppercase">Total:</td>
                        <td class="border border-gray-800 p-2 text-center">{{ $totalRespondents }}</td>
                        <td class="border border-gray-800 p-2 text-center">100%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TANDA TANGAN PENGESAHAN --}}
        <div class="mt-12 grid grid-cols-2 gap-8 text-center text-xs sans-font">
            <div>
                <p>Mengetahui,</p>
                <p class="font-bold">Ketua Tim Penjamin Mutu Sekolah</p>
                <div class="h-20"></div>
                <p class="font-bold underline uppercase">( .................................................... )</p>
                <p class="text-gray-600">NIP. ....................................................</p>
            </div>
            <div>
                <p>Buay Sandang Aji, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Kepala UPT SMP Negeri 1 Buay Sandang Aji</p>
                <div class="h-20"></div>
                <p class="font-bold underline uppercase">{{ $settings['principal_name'] ?? '( .................................................... )' }}</p>
                <p class="text-gray-600">NIP. {{ $settings['principal_nip'] ?? '....................................................' }}</p>
            </div>
        </div>

    </div>

</body>
</html>
