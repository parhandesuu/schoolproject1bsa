@extends('layouts.admin')

@section('title', 'Survei Kepuasan Masyarakat (SKM)')

@section('content')
<div x-data="{
    activeTab: 'table',
    selectedSurvey: null,
    showDetailModal: false,
    loadingDetail: false,

    viewDetail(id) {
        this.loadingDetail = true;
        this.showDetailModal = true;
        fetch('{{ url('admin/surveys') }}/' + id)
            .then(res => res.json())
            .then(data => {
                this.selectedSurvey = data;
                this.loadingDetail = false;
            })
            .catch(err => {
                alert('Gagal memuat detail survei');
                this.loadingDetail = false;
                this.showDetailModal = false;
            });
    }
}" class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold uppercase tracking-wider mb-1.5">
                <i class="fas fa-poll"></i> Evaluasi Kualitas Pelayanan
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Survei Kepuasan Masyarakat (SKM)</h1>
            <p class="text-sm text-gray-500 mt-0.5">Analisis hasil pengukuran indeks kepuasan pelayanan UPT SMP Negeri 1 Buay Sandang Aji.</p>
        </div>

        <div class="flex flex-wrap items-center justify-start sm:justify-end gap-2.5 shrink-0 self-start sm:self-auto sm:ml-auto">
            <a href="{{ route('admin.survey-questions.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-blue-200 bg-blue-50/70 hover:bg-blue-100 text-blue-800 text-xs sm:text-sm font-bold transition-colors flex items-center gap-2 shadow-xs whitespace-nowrap">
                <i class="fas fa-list-check"></i>
                <span>Kelola Pertanyaan</span>
            </a>
            <a href="{{ route('admin.surveys.export', request()->query()) }}" 
               class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold transition-colors flex items-center gap-2 shadow-xs whitespace-nowrap">
                <i class="fas fa-file-excel"></i>
                <span>Export Excel / CSV</span>
            </a>
            <a href="{{ route('admin.surveys.print', request()->query()) }}" target="_blank"
               class="px-4 py-2.5 rounded-xl bg-blue-800 hover:bg-blue-900 text-white text-xs sm:text-sm font-semibold transition-colors flex items-center gap-2 shadow-xs whitespace-nowrap">
                <i class="fas fa-print"></i>
                <span>Cetak Laporan Resmi</span>
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <i class="fas fa-check-circle text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Card 1: Total Responden --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Responden</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-base">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-extrabold text-gray-900">{{ number_format($totalRespondents) }}</div>
                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                    <span class="font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                        +{{ $todayCount }} Hari Ini
                    </span>
                    <span>• {{ $monthCount }} Bulan Ini</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Indeks IKM (Skala 25 - 100) --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai Konversi IKM</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-base">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-gray-900">{{ number_format($ikmScore, 2) }}</span>
                    <span class="text-xs text-gray-400 font-medium">/ 100</span>
                </div>
                <div class="mt-2 text-xs">
                    <span class="inline-flex items-center gap-1 font-bold px-2 py-0.5 rounded-md {{ $ikmGrade['bg_color'] }} {{ $ikmGrade['text_color'] }} border {{ $ikmGrade['border'] }}">
                        Mutu {{ $ikmGrade['grade'] }} ({{ $ikmGrade['performance'] }})
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 3: Rata-rata Skor (1 - 4) --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-rata Nilai Unsur</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-base">
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-gray-900">{{ number_format($avgOverall, 2) }}</span>
                    <span class="text-xs text-gray-400 font-medium">/ 4.00</span>
                </div>
                <div class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden flex-1">
                        <div class="bg-amber-500 h-full rounded-full" style="width: {{ $satisfactionPercentage }}%"></div>
                    </div>
                    <span class="font-bold text-gray-700">{{ $satisfactionPercentage }}%</span>
                </div>
            </div>
        </div>

        {{-- Card 4: Kinerja Pelayanan --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Predikat Kinerja</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-base">
                    <i class="fas fa-award"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold {{ $ikmGrade['text_color'] }}">
                    {{ $ikmGrade['performance'] }}
                </div>
                <p class="mt-2 text-[11px] text-gray-500 line-clamp-2">
                    {{ $ikmGrade['description'] }}
                </p>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart 1: Bar Chart Nilai per Unsur Pelayanan (U1 - U9) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-bold text-gray-900">Perbandingan Nilai 9 Unsur Pelayanan</h2>
                    <p class="text-xs text-gray-500">Skala rata-rata penilaian 1.00 (Rendah) s/d 4.00 (Tinggi)</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold">9 Unsur Layanan</span>
            </div>
            <div class="relative h-72">
                <canvas id="elementsChart"></canvas>
            </div>
        </div>

        {{-- Chart 2: Komposisi Responden per Peran --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs flex flex-col">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-bold text-gray-900">Komposisi Responden</h2>
                    <p class="text-xs text-gray-500">Berdasarkan peran / status hubungan</p>
                </div>
            </div>
            <div class="relative h-56 my-auto">
                <canvas id="rolesChart"></canvas>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 grid grid-cols-2 gap-2 text-xs">
                @foreach($roleDistribution as $roleName => $data)
                <div class="flex items-center justify-between p-1.5 rounded-lg bg-gray-50">
                    <span class="text-gray-600 truncate mr-1">{{ $roleName }}</span>
                    <span class="font-bold text-gray-900 shrink-0">{{ $data['count'] }} ({{ $data['percent'] }}%)</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Rekapitulasi Nilai 9 Unsur (Tabel Rinci) --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">Rekapitulasi 9 Unsur Standar Permenpan RB No. 14 Tahun 2017</h2>
                <p class="text-xs text-gray-500">Rincian nilai rata-rata, konversi IKM, dan mutu pelayanan per unsur kuesioner.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-gray-50/80 text-gray-600 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Unsur Pelayanan</th>
                        <th class="py-3.5 px-4 text-center">Rata-rata (1-4)</th>
                        <th class="py-3.5 px-4 text-center">Nilai IKM (25-100)</th>
                        <th class="py-3.5 px-4 text-center">Mutu</th>
                        <th class="py-3.5 px-4 text-center">Kinerja</th>
                        <th class="py-3.5 px-4 w-44">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($questionStats as $num => $stat)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="py-3.5 px-4 text-center font-bold text-gray-500">U{{ $num }}</td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-gray-900">{{ $stat['title'] }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $stat['question'] }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-center font-extrabold text-blue-800 text-base">
                            {{ number_format($stat['avg_score'], 2) }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold text-gray-900">
                            {{ number_format($stat['ikm'], 2) }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded text-xs font-bold {{ $stat['grade']['badge'] }}">
                                {{ $stat['grade']['grade'] }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-xs {{ $stat['grade']['text_color'] }}">
                            {{ $stat['grade']['performance'] }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-blue-600 h-full rounded-full" style="width: {{ $stat['percent'] }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-700 w-10 text-right">{{ $stat['percent'] }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Filter & Tab Management --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5 space-y-5">
        {{-- Filter Bar --}}
        <form action="{{ route('admin.surveys.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Filter Peran Responden</label>
                <select name="role" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-700 focus:ring-blue-200">
                    <option value="">Semua Peran Responden</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-700 focus:ring-blue-200">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-700 focus:ring-blue-200">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-blue-800 hover:bg-blue-900 text-white text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request()->hasAny(['role', 'date_from', 'date_to']))
                <a href="{{ route('admin.surveys.index') }}" class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition-colors" title="Reset Filter">
                    <i class="fas fa-undo"></i>
                </a>
                @endif
            </div>
        </form>

        {{-- Tabs --}}
        <div class="flex items-center gap-2 border-b border-gray-100 pt-2">
            <button type="button" @click="activeTab = 'table'" 
                    class="pb-3 px-4 text-xs sm:text-sm font-bold transition-all relative"
                    :class="activeTab === 'table' ? 'text-blue-800 border-b-2 border-blue-800' : 'text-gray-500 hover:text-gray-700'">
                <i class="fas fa-list-ul mr-1.5"></i> Seluruh Respon Masuk ({{ $responses->total() }})
            </button>
            <button type="button" @click="activeTab = 'suggestions'" 
                    class="pb-3 px-4 text-xs sm:text-sm font-bold transition-all relative"
                    :class="activeTab === 'suggestions' ? 'text-blue-800 border-b-2 border-blue-800' : 'text-gray-500 hover:text-gray-700'">
                <i class="fas fa-comments mr-1.5"></i> Kritik, Saran & Harapan ({{ $suggestions->total() }})
            </button>
        </div>

        {{-- TAB 1: DAFTAR RESPON MASUK --}}
        <div x-show="activeTab === 'table'" class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-gray-50/80 text-gray-600 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Peran Responden</th>
                        <th class="py-3 px-4 text-center">Rata-rata</th>
                        <th class="py-3 px-4 text-center">IKM</th>
                        <th class="py-3 px-4 text-center">Mutu</th>
                        <th class="py-3 px-4">Masukan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($responses as $resp)
                    @php
                        $rIkm = \App\Models\SurveyResponse::convertToIkm($resp->average_score);
                        $rGrade = \App\Models\SurveyResponse::getIkmGrade($rIkm);
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="py-3 px-4 text-gray-500 whitespace-nowrap">
                            <div class="font-medium text-gray-800">{{ $resp->created_at->format('d/m/Y') }}</div>
                            <div class="text-[11px] text-gray-400">{{ $resp->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="py-3 px-4 font-semibold text-gray-900 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-800 text-xs">
                                <i class="fas fa-user-circle text-gray-400"></i>
                                {{ $resp->respondent_role }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center font-bold text-blue-800">
                            {{ number_format($resp->average_score, 2) }}
                        </td>
                        <td class="py-3 px-4 text-center font-bold text-gray-800">
                            {{ number_format($rIkm, 2) }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-0.5 rounded text-xs font-bold {{ $rGrade['badge'] }}">
                                {{ $rGrade['grade'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 max-w-xs">
                            @if($resp->improvement_suggestion || $resp->future_expectation)
                                <span class="text-xs text-gray-600 line-clamp-1" title="{{ $resp->improvement_suggestion ?: $resp->future_expectation }}">
                                    {{ $resp->improvement_suggestion ?: $resp->future_expectation }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">Tidak ada catatan</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button" @click="viewDetail({{ $resp->id }})" 
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 flex items-center justify-center transition-colors"
                                        title="Lihat Detail Jawaban">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                <form action="{{ route('admin.surveys.destroy', $resp) }}" method="POST" onsubmit="return confirm('Hapus respon survei ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors" title="Hapus Data">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500 text-xs sm:text-sm">
                            <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-2 text-lg">
                                <i class="fas fa-inbox"></i>
                            </div>
                            Belum ada respon kuesioner yang sesuai dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $responses->links() }}
            </div>
        </div>

        {{-- TAB 2: SARAN, MASUKAN & HARAPAN (ESAI) --}}
        <div x-show="activeTab === 'suggestions'" class="space-y-4">
            @forelse($suggestions as $sug)
            <div class="p-4 sm:p-5 rounded-2xl bg-gray-50/70 border border-gray-200/70 space-y-3">
                <div class="flex items-center justify-between text-xs text-gray-500 pb-2 border-b border-gray-200">
                    <span class="font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="fas fa-user-circle text-blue-700"></i>
                        {{ $sug->respondent_role }}
                    </span>
                    <span>{{ $sug->created_at->translatedFormat('d F Y H:i') }} WIB</span>
                </div>

                @if($sug->improvement_suggestion)
                <div>
                    <div class="text-[11px] font-bold text-amber-800 uppercase tracking-wider mb-0.5">
                        <i class="fas fa-wrench mr-1"></i> Pelayanan yang perlu ditingkatkan:
                    </div>
                    <p class="text-xs sm:text-sm text-gray-800 bg-white p-3 rounded-xl border border-gray-100">
                        {{ $sug->improvement_suggestion }}
                    </p>
                </div>
                @endif

                @if($sug->future_expectation)
                <div>
                    <div class="text-[11px] font-bold text-blue-800 uppercase tracking-wider mb-0.5">
                        <i class="fas fa-lightbulb mr-1"></i> Harapan ke depan:
                    </div>
                    <p class="text-xs sm:text-sm text-gray-800 bg-white p-3 rounded-xl border border-gray-100">
                        {{ $sug->future_expectation }}
                    </p>
                </div>
                @endif
            </div>
            @empty
            <div class="py-8 text-center text-gray-500 text-xs sm:text-sm">
                <i class="fas fa-comment-slash text-2xl text-gray-300 mb-2 block"></i>
                Belum ada masukan esai yang tercatat.
            </div>
            @endforelse

            <div class="mt-4">
                {{ $suggestions->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL RESPONDEN --}}
    <div x-show="showDetailModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs">
        <div @click.outside="showDetailModal = false"
             class="bg-white rounded-3xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-100 space-y-5">
            
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Rincian Jawaban Responden</h3>
                    <p class="text-xs text-gray-500" x-text="'Peran: ' + (selectedSurvey?.respondent_role || '-')"></p>
                </div>
                <button type="button" @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <template x-if="loadingDetail">
                <div class="py-12 text-center text-gray-500">
                    <i class="fas fa-circle-notch fa-spin text-2xl text-blue-700"></i>
                    <p class="text-xs mt-2">Memuat rincian respon...</p>
                </div>
            </template>

            <template x-if="!loadingDetail && selectedSurvey">
                <div class="space-y-4">
                    {{-- Summary Badge --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-3.5 rounded-2xl bg-blue-50/70 border border-blue-100 text-xs">
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Rata-rata</span>
                            <span class="font-bold text-blue-900 text-sm" x-text="selectedSurvey.average_score + ' / 4.00'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Konversi IKM</span>
                            <span class="font-bold text-indigo-900 text-sm" x-text="selectedSurvey.ikm_score + ' / 100'"></span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Waktu Pengisian</span>
                            <span class="font-bold text-gray-800 text-xs" x-text="selectedSurvey.created_at"></span>
                        </div>
                    </div>

                    {{-- Question List --}}
                    <div class="space-y-2.5">
                        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Jawaban 9 Unsur:</h4>
                        <template x-for="item in selectedSurvey.answers" :key="item.num">
                            <div class="p-3 rounded-xl border border-gray-100 bg-gray-50/50 flex items-center justify-between gap-3 text-xs">
                                <div class="flex-1">
                                    <span class="font-bold text-blue-900" x-text="'U' + item.num + '. ' + item.title"></span>
                                    <p class="text-gray-500 text-[11px] line-clamp-1" x-text="item.question"></p>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg font-bold"
                                          :class="item.score >= 3 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
                                        <span x-text="item.score + ' - ' + item.label"></span>
                                    </span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Esai --}}
                    <div class="space-y-2 pt-2 border-t border-gray-100 text-xs">
                        <div>
                            <span class="font-bold text-gray-800 block">Saran Perbaikan:</span>
                            <p class="p-2.5 rounded-xl bg-gray-50 text-gray-700 mt-1 border border-gray-100" x-text="selectedSurvey.improvement_suggestion"></p>
                        </div>
                        <div>
                            <span class="font-bold text-gray-800 block">Harapan ke Depan:</span>
                            <p class="p-2.5 rounded-xl bg-gray-50 text-gray-700 mt-1 border border-gray-100" x-text="selectedSurvey.future_expectation"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>

{{-- Chart.js Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Elements Bar Chart
    const ctxElements = document.getElementById('elementsChart');
    if (ctxElements) {
        new Chart(ctxElements, {
            type: 'bar',
            data: {
                labels: {!! json_encode($radarLabels) !!},
                datasets: [{
                    label: 'Skor Rata-rata (1.00 - 4.00)',
                    data: {!! json_encode($radarData) !!},
                    backgroundColor: 'rgba(30, 64, 175, 0.85)',
                    hoverBackgroundColor: 'rgba(30, 64, 175, 1)',
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 4,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rata-rata: ' + context.parsed.y + ' / 4.00';
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Roles Doughnut Chart
    const ctxRoles = document.getElementById('rolesChart');
    if (ctxRoles) {
        new Chart(ctxRoles, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($roleChartLabels) !!},
                datasets: [{
                    data: {!! json_encode($roleChartData) !!},
                    backgroundColor: [
                        '#1e40af', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>
@endsection
