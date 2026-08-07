@extends('layouts.app')

@section('title', 'Survei Kepuasan Masyarakat (SKM) - UPT SMP Negeri 1 Buay Sandang Aji')
@section('meta_description', 'Survei Kepuasan Masyarakat (SKM) UPT SMP Negeri 1 Buay Sandang Aji untuk mengukur dan meningkatkan mutu kualitas pelayanan pendidikan secara berkelanjutan.')

@section('content')
<div x-data="{
    role: '{{ old('respondent_role', '') }}',
    ratings: {
        @foreach($questions as $num => $q)
            q{{ $num }}: '{{ old("q{$num}_rating", "") }}',
        @endforeach
    },
    sug: '{{ old('improvement_suggestion', '') }}',
    exp: '{{ old('future_expectation', '') }}',
    isSubmitting: false,
    showSuccessModal: {{ session('survey_submitted') ? 'true' : 'false' }},
    totalQuestions: {{ count($questions) }},

    get totalFilled() {
        let count = 0;
        if (this.role) count++;
        for (let k in this.ratings) {
            if (this.ratings[k]) count++;
        }
        return count;
    },
    get totalRequired() {
        return this.totalQuestions + 1;
    },
    get progressPercent() {
        if (this.totalRequired === 0) return 0;
        return Math.round((this.totalFilled / this.totalRequired) * 100);
    },
    resetForm() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh isian survei?')) {
            this.role = '';
            for (let k in this.ratings) {
                this.ratings[k] = '';
            }
            this.sug = '';
            this.exp = '';
            document.getElementById('skm-survey-form').reset();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}" class="relative bg-gradient-to-b from-blue-50/50 via-white to-gray-50/80 min-h-screen py-8 md:py-12">

    {{-- Background Decorative Glows --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-tr from-blue-400/10 via-indigo-400/10 to-orange-400/10 blur-3xl -z-10 pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-800 transition-colors flex items-center gap-1">
                <i class="fas fa-home"></i> Beranda
            </a>
            <i class="fas fa-chevron-right text-[10px] text-gray-400"></i>
            <span class="text-blue-800 font-semibold">Survei Kepuasan Masyarakat</span>
        </nav>

        {{-- Header Card --}}
        <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 rounded-3xl p-6 sm:p-8 md:p-10 text-white shadow-xl shadow-blue-900/15 relative overflow-hidden mb-8 border border-white/10">
            {{-- Decorative circles --}}
            <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-white/5 blur-xl pointer-events-none"></div>
            <div class="absolute right-10 bottom-0 w-32 h-32 rounded-full bg-orange-500/10 blur-lg pointer-events-none"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-orange-300 text-xs font-semibold uppercase tracking-wider mb-4">
                    <i class="fas fa-poll-h"></i>
                    <span>Pelayanan Publik & Evaluasi Mutu</span>
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Survei Kepuasan Masyarakat (SKM)
                </h1>
                <p class="text-blue-200 text-sm md:text-base font-medium mt-1">
                    UPT SMP Negeri 1 Buay Sandang Aji
                </p>

                <div class="mt-6 pt-6 border-t border-white/15 text-xs sm:text-sm text-blue-100/90 leading-relaxed space-y-3 font-normal">
                    <p>
                        Dalam rangka meningkatkan mutu pelayanan pendidikan di <strong>UPT SMP Negeri 1 Buay Sandang Aji</strong>, kami mengharapkan partisipasi Bapak/Ibu/Saudara untuk mengisi kuesioner ini dengan jujur dan objektif. Survei ini <strong>bersifat anonim</strong> sehingga identitas responden tidak akan ditampilkan.
                    </p>
                    <p>
                        Data yang diberikan akan digunakan sebagai bahan evaluasi dalam meningkatkan kualitas pelayanan sekolah secara berkelanjutan.
                    </p>
                    <p class="text-white font-medium">
                        Atas kesediaan dan partisipasi Anda dalam mengisi survei ini, kami mengucapkan terima kasih. Semoga masukan yang diberikan dapat menjadi bahan perbaikan demi kemajuan UPT SMP Negeri 1 Buay Sandang Aji.
                    </p>
                </div>

                {{-- Badges / Highlights --}}
                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs">
                    <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-xs border border-white/10">
                        <i class="fas fa-user-secret text-emerald-400"></i>
                        <span>100% Bersifat Anonim</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-xs border border-white/10">
                        <i class="fas fa-clock text-amber-300"></i>
                        <span>Estimasi Waktu: ± 2-3 Menit</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur-xs border border-white/10">
                        <i class="fas fa-check-circle text-orange-400"></i>
                        <span>{{ count($questions) }} Unsur Penilaian Pelayanan</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Progress Bar Indicator --}}
        <div class="sticky top-20 z-30 mb-8">
            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-3 transition-all duration-300">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md shrink-0">
                        <span x-text="progressPercent + '%'"></span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-800">Progres Pengisian Survei</h4>
                        <p class="text-[11px] text-gray-500">
                            <span class="font-bold text-blue-700" x-text="totalFilled"></span> dari <span x-text="totalRequired"></span> Pertanyaan Wajib Terisi
                        </p>
                    </div>
                </div>

                <div class="w-full sm:flex-1 max-w-md">
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden p-0.5 border border-gray-200">
                        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-orange-500 h-full rounded-full transition-all duration-500 ease-out"
                             :style="'width: ' + progressPercent + '%'"></div>
                    </div>
                </div>

                <div class="hidden sm:block shrink-0">
                    <span x-show="totalFilled >= totalRequired" x-cloak class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        <i class="fas fa-check-circle"></i> Siap Dikirim
                    </span>
                    <span x-show="totalFilled < totalRequired" class="inline-flex items-center gap-1 text-xs font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full border border-orange-200">
                        <i class="fas fa-pen-alt"></i> Belum Lengkap
                    </span>
                </div>
            </div>
        </div>

        {{-- Errors Alert if Any --}}
        @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-rose-500 text-lg mt-0.5 shrink-0"></i>
            <div>
                <p class="font-bold">Mohon lengkapi seluruh pertanyaan wajib berikut:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Survey Form --}}
        <form id="skm-survey-form" action="{{ route('survey.store') }}" method="POST" @submit="isSubmitting = true">
            @csrf

            {{-- SECTION 1: IDENTITAS RESPONDEN --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 mb-8 transition-all hover:shadow-md">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-base shrink-0">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Identitas Responden</h2>
                        <p class="text-xs text-gray-500">Pilih salah satu peran yang paling menggambarkan status Anda.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">
                        Peran Sebagai <span class="text-rose-500 font-bold">*</span>
                        <span class="text-xs font-normal text-gray-500 ml-1">(Wajib Dipilih)</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $roleIcons = [
                                'Orang Tua / Wali'                => 'fas fa-hands-holding-child',
                                'Pendidik / Tenaga Kependidikan' => 'fas fa-chalkboard-teacher',
                                'Murid'                          => 'fas fa-graduation-cap',
                                'Alumni'                         => 'fas fa-user-graduate',
                                'Lainnya'                        => 'fas fa-users',
                            ];
                        @endphp

                        @foreach($roles as $r)
                        <label class="relative flex items-center p-3.5 rounded-2xl border-2 cursor-pointer transition-all duration-200 select-none group"
                               :class="role === '{{ $r }}' ? 'border-blue-700 bg-blue-50/70 shadow-xs ring-2 ring-blue-600/10' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50/60'">
                            <input type="radio" name="respondent_role" value="{{ $r }}" x-model="role" class="sr-only" required>
                            
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 transition-colors mr-3"
                                 :class="role === '{{ $r }}' ? 'bg-blue-700 text-white' : 'bg-gray-100 text-gray-500 group-hover:text-blue-700'">
                                <i class="{{ $roleIcons[$r] ?? 'fas fa-user' }} text-sm"></i>
                            </div>

                            <span class="text-xs sm:text-sm font-semibold leading-snug"
                                  :class="role === '{{ $r }}' ? 'text-blue-900 font-bold' : 'text-gray-700'">
                                {{ $r }}
                            </span>

                            <div class="ml-auto pl-2">
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all"
                                     :class="role === '{{ $r }}' ? 'border-blue-700 bg-blue-700' : 'border-gray-300'">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="role === '{{ $r }}'"></div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('respondent_role')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- SECTION 2: 9 PERTANYAAN PENILAIAN UNSUR SKM --}}
            <div class="space-y-6 mb-8">
                <div class="flex items-center justify-between px-2">
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-gray-900">Pertanyaan Penilaian Layanan</h2>
                        <p class="text-xs sm:text-sm text-gray-500">Gunakan skala penilaian 1 (sangat rendah / tidak puas) sampai 4 (sangat tinggi / sangat puas).</p>
                    </div>
                </div>

                @foreach($questions as $num => $q)
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border transition-all duration-200 hover:shadow-md"
                     :class="ratings['q{{ $num }}'] ? 'border-blue-200/80 bg-white' : 'border-gray-200'">
                    
                    {{-- Question Header --}}
                    <div class="flex items-start gap-3 sm:gap-4 mb-4">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center font-extrabold text-xs sm:text-sm shrink-0 transition-colors shadow-xs"
                             :class="ratings['q{{ $num }}'] ? 'bg-gradient-to-br from-blue-700 to-indigo-700 text-white' : 'bg-gray-100 text-gray-600'">
                            {{ sprintf('%02d', $num) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">
                                    {{ $q['title'] }}
                                </span>
                                <span class="text-rose-500 font-bold text-xs">*</span>
                            </div>
                            <h3 class="text-sm sm:text-base font-semibold text-gray-900 leading-snug">
                                {{ $q['question'] }}
                            </h3>
                        </div>
                    </div>

                    {{-- 4 Radio Options --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 mt-4">
                        @foreach($q['options'] as $score => $opt)
                        <label class="relative flex items-center p-3 rounded-2xl border-2 cursor-pointer transition-all duration-200 select-none group"
                               :class="ratings['q{{ $num }}'] == '{{ $score }}' 
                                    ? '{{ $score == 4 ? 'border-emerald-600 bg-emerald-50/70 text-emerald-950 ring-2 ring-emerald-600/10' : ($score == 3 ? 'border-blue-600 bg-blue-50/70 text-blue-950 ring-2 ring-blue-600/10' : ($score == 2 ? 'border-amber-500 bg-amber-50/70 text-amber-950 ring-2 ring-amber-500/10' : 'border-rose-500 bg-rose-50/70 text-rose-950 ring-2 ring-rose-500/10')) }}' 
                                    : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50/70 text-gray-700'">
                            
                            <input type="radio" name="q{{ $num }}_rating" value="{{ $score }}" x-model="ratings['q{{ $num }}']" class="sr-only" required>

                            <div class="flex items-center gap-2.5 w-full">
                                {{-- Score Number Circle --}}
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition-colors shadow-2xs"
                                     :class="ratings['q{{ $num }}'] == '{{ $score }}'
                                        ? '{{ $score == 4 ? 'bg-emerald-600 text-white' : ($score == 3 ? 'bg-blue-600 text-white' : ($score == 2 ? 'bg-amber-500 text-white' : 'bg-rose-500 text-white')) }}'
                                        : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200'">
                                    {{ $score }}
                                </div>

                                {{-- Label Text --}}
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-semibold block truncate sm:whitespace-normal"
                                          :class="ratings['q{{ $num }}'] == '{{ $score }}' ? 'font-bold' : ''">
                                        {{ $opt['label'] }}
                                    </span>
                                </div>

                                {{-- Icon Smile --}}
                                <div class="text-sm opacity-70 shrink-0"
                                     :class="ratings['q{{ $num }}'] == '{{ $score }}' ? 'opacity-100' : ''">
                                    <i class="{{ $opt['icon'] }}"></i>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>


                    @error("q{$num}_rating")
                        <p class="text-rose-500 text-xs font-medium mt-2">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>

            {{-- SECTION 3: PERTANYAAN ESAI (KRITIK, SARAN & HARAPAN) --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 mb-8 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-base shrink-0">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Masukan & Harapan (Esai)</h2>
                        <p class="text-xs text-gray-500">Berikan saran konstruktif untuk peningkatan mutu pelayanan sekolah (Opsional namun sangat berharga).</p>
                    </div>
                </div>

                {{-- Esai 1: Pelayanan yang perlu ditingkatkan --}}
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5">
                        1. Menurut Saudara, pelayanan apa saja yang masih perlu ditingkatkan di UPT SMP Negeri 1 Buay Sandang Aji?
                    </label>
                    <textarea name="improvement_suggestion" x-model="sug" rows="3"
                              class="input-field w-full text-xs sm:text-sm p-3.5 rounded-2xl border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all placeholder:text-gray-400"
                              placeholder="Tuliskan saran perbaikan pelayanan di sini..."></textarea>
                    @error('improvement_suggestion')
                        <p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Esai 2: Harapan tahun ajaran berikutnya --}}
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5">
                        2. Apa harapan Saudara agar pelayanan di UPT SMP Negeri 1 Buay Sandang Aji menjadi lebih baik pada tahun ajaran berikutnya?
                    </label>
                    <textarea name="future_expectation" x-model="exp" rows="3"
                              class="input-field w-full text-xs sm:text-sm p-3.5 rounded-2xl border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all placeholder:text-gray-400"
                              placeholder="Tuliskan harapan Anda untuk kemajuan sekolah kami..."></textarea>
                    @error('future_expectation')
                        <p class="text-rose-500 text-xs font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="bg-white/80 backdrop-blur-md rounded-3xl p-5 shadow-lg border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="button" @click="resetForm()" 
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl text-xs sm:text-sm font-semibold text-gray-600 hover:text-rose-600 hover:bg-rose-50 border border-gray-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-undo-alt"></i>
                    <span>Reset Form</span>
                </button>

                <button type="submit" :disabled="isSubmitting"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-2xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-800 hover:from-blue-800 hover:to-indigo-900 shadow-md hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2.5 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer group">
                    <span x-show="!isSubmitting" class="flex items-center gap-2">
                        <i class="fas fa-paper-plane group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                        <span>Kirim Survei Sekarang</span>
                    </span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        <span>Mengirimkan Jawaban...</span>
                    </span>
                </button>
            </div>
        </form>

    </div>

    {{-- SUCCESS MODAL --}}
    <div x-show="showSuccessModal" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        
        <div @click.outside="showSuccessModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 text-center shadow-2xl border border-gray-100 relative overflow-hidden">
            
            {{-- Decorative accent --}}
            <div class="w-32 h-32 rounded-full bg-emerald-500/10 blur-2xl absolute -top-10 -right-10 pointer-events-none"></div>

            {{-- Success Animated Icon --}}
            <div class="w-20 h-20 rounded-3xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mx-auto mb-5 shadow-inner border border-emerald-200 animate-bounce">
                <i class="fas fa-check-circle"></i>
            </div>

            <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight leading-snug">
                Terima kasih atas partisipasi Anda.
            </h3>

            <p class="text-xs sm:text-sm text-gray-600 mt-3 leading-relaxed">
                Masukan yang telah diberikan akan menjadi bahan evaluasi bagi <strong>UPT SMP Negeri 1 Buay Sandang Aji</strong> untuk terus meningkatkan kualitas pelayanan kepada masyarakat.
            </p>

            <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button @click="showSuccessModal = false" type="button"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold transition-colors">
                    Tutup Notifikasi
                </button>
                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-blue-800 hover:bg-blue-900 text-white text-xs sm:text-sm font-semibold transition-colors shadow-xs">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
