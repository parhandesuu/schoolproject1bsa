@extends('layouts.admin')

@section('title', 'Tambah Pertanyaan Survei SKM')

@section('page-title', 'Tambah Pertanyaan Kuesioner')

@section('content')
<div class="max-w-4xl space-y-6" x-data="{
    opt4: '{{ old('opt4_label', 'Sangat Sesuai') }}',
    opt3: '{{ old('opt3_label', 'Sesuai') }}',
    opt2: '{{ old('opt2_label', 'Kurang Sesuai') }}',
    opt1: '{{ old('opt1_label', 'Tidak Sesuai') }}',

    applyPreset(type) {
        if (type === 'sesuai') {
            this.opt4 = 'Sangat Sesuai';
            this.opt3 = 'Sesuai';
            this.opt2 = 'Kurang Sesuai';
            this.opt1 = 'Tidak Sesuai';
        } else if (type === 'puas') {
            this.opt4 = 'Sangat Puas';
            this.opt3 = 'Puas';
            this.opt2 = 'Kurang Puas';
            this.opt1 = 'Tidak Puas';
        } else if (type === 'cepat') {
            this.opt4 = 'Sangat Cepat';
            this.opt3 = 'Cepat';
            this.opt2 = 'Kurang Cepat';
            this.opt1 = 'Tidak Cepat';
        } else if (type === 'kompeten') {
            this.opt4 = 'Sangat Kompeten';
            this.opt3 = 'Kompeten';
            this.opt2 = 'Kurang Kompeten';
            this.opt1 = 'Tidak Kompeten';
        } else if (type === 'kualitas') {
            this.opt4 = 'Sangat Baik';
            this.opt3 = 'Baik';
            this.opt2 = 'Cukup';
            this.opt1 = 'Buruk';
        } else if (type === 'biaya') {
            this.opt4 = 'Gratis';
            this.opt3 = 'Murah';
            this.opt2 = 'Cukup Mahal';
            this.opt1 = 'Sangat Mahal';
        }
    }
}">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-700">Dashboard</a>
        <i class="fas fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('admin.surveys.index') }}" class="hover:text-blue-700">Survei SKM</a>
        <i class="fas fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('admin.survey-questions.index') }}" class="hover:text-blue-700">Kelola Pertanyaan</a>
        <i class="fas fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-gray-800 font-semibold">Tambah Pertanyaan</span>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Pertanyaan Kuesioner Baru</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Lengkapi formulir di bawah untuk menambahkan butir pertanyaan kuesioner ke dalam sistem SKM.</p>
        </div>
        <a href="{{ route('admin.survey-questions.index') }}" 
           class="px-4 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-semibold transition-all flex items-center gap-1.5 shadow-xs">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.survey-questions.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Row 1: Nomor Urut, Kode Unsur & Icon --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        No. Urut Tampil <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="order" value="{{ old('order', $nextOrder) }}" min="1" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all font-semibold">
                    @error('order')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Kode Unsur
                    </label>
                    <input type="text" name="code" value="{{ old('code', $suggestedCode) }}" placeholder="Contoh: U1, U2, ..."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    @error('code')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        Icon FontAwesome
                    </label>
                    <input type="text" name="icon" value="{{ old('icon', 'fas fa-clipboard-check') }}" placeholder="fas fa-clipboard-check"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    @error('icon')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Row 2: Judul Unsur --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Judul Unsur / Aspek Pelayanan <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required 
                       placeholder="Contoh: Kesesuaian Persyaratan Pelayanan"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all font-semibold">
                @error('title')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Row 3: Teks Pertanyaan Lengkap --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Teks Pertanyaan Kuesioner Lengkap <span class="text-rose-500">*</span>
                </label>
                <textarea name="question" rows="4" required
                          placeholder="Tuliskan butir pertanyaan yang jelas dan mudah dipahami oleh responden..."
                          class="w-full p-3.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">{{ old('question') }}</textarea>
                @error('question')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Section Opsi Jawaban (Skala 1-4) --}}
            <div class="pt-4 border-t border-gray-100 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Konfigurasi Label Opsi Jawaban (Skala 4 s/d 1)</h3>
                        <p class="text-xs text-gray-500">Tentukan teks label untuk masing-masing bobot nilai jawaban.</p>
                    </div>

                    {{-- Quick Presets --}}
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="text-[11px] font-semibold text-gray-400">Preset Cepat:</span>
                        <button type="button" @click="applyPreset('sesuai')" class="px-2 py-1 bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-700 rounded-lg text-[11px] font-medium transition-colors">Kesesuaian</button>
                        <button type="button" @click="applyPreset('puas')" class="px-2 py-1 bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-700 rounded-lg text-[11px] font-medium transition-colors">Kepuasan</button>
                        <button type="button" @click="applyPreset('cepat')" class="px-2 py-1 bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-700 rounded-lg text-[11px] font-medium transition-colors">Kecepatan</button>
                        <button type="button" @click="applyPreset('kompeten')" class="px-2 py-1 bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-700 rounded-lg text-[11px] font-medium transition-colors">Kompetensi</button>
                        <button type="button" @click="applyPreset('kualitas')" class="px-2 py-1 bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-700 rounded-lg text-[11px] font-medium transition-colors">Kualitas</button>
                        <button type="button" @click="applyPreset('biaya')" class="px-2 py-1 bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-700 rounded-lg text-[11px] font-medium transition-colors">Biaya</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Opsi 4 (Sangat Baik / Sangat Sesuai) --}}
                    <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-bold text-emerald-800">
                            <span><i class="fas fa-star text-emerald-600 mr-1"></i> Skala Nilai 4 (Tertinggi)</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-700 text-[10px]">Bobot 4</span>
                        </div>
                        <input type="text" name="opt4_label" x-model="opt4" required
                               placeholder="Contoh: Sangat Sesuai / Sangat Puas"
                               class="w-full px-3 py-2 rounded-lg border border-emerald-300 bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-200 transition-all font-semibold text-emerald-950">
                        @error('opt4_label')
                            <p class="text-rose-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Opsi 3 (Baik / Sesuai) --}}
                    <div class="p-3.5 rounded-xl border border-blue-200 bg-blue-50/40 space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-bold text-blue-800">
                            <span><i class="fas fa-check text-blue-600 mr-1"></i> Skala Nilai 3 (Baik)</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-[10px]">Bobot 3</span>
                        </div>
                        <input type="text" name="opt3_label" x-model="opt3" required
                               placeholder="Contoh: Sesuai / Puas"
                               class="w-full px-3 py-2 rounded-lg border border-blue-300 bg-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-200 transition-all font-semibold text-blue-950">
                        @error('opt3_label')
                            <p class="text-rose-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Opsi 2 (Kurang Baik / Kurang Sesuai) --}}
                    <div class="p-3.5 rounded-xl border border-amber-200 bg-amber-50/40 space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-bold text-amber-800">
                            <span><i class="fas fa-exclamation text-amber-600 mr-1"></i> Skala Nilai 2 (Kurang)</span>
                            <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-700 text-[10px]">Bobot 2</span>
                        </div>
                        <input type="text" name="opt2_label" x-model="opt2" required
                               placeholder="Contoh: Kurang Sesuai / Kurang Puas"
                               class="w-full px-3 py-2 rounded-lg border border-amber-300 bg-white text-xs sm:text-sm focus:ring-2 focus:ring-amber-200 transition-all font-semibold text-amber-950">
                        @error('opt2_label')
                            <p class="text-rose-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Opsi 1 (Tidak Baik / Tidak Sesuai) --}}
                    <div class="p-3.5 rounded-xl border border-rose-200 bg-rose-50/40 space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-bold text-rose-800">
                            <span><i class="fas fa-times text-rose-600 mr-1"></i> Skala Nilai 1 (Terendah)</span>
                            <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-700 text-[10px]">Bobot 1</span>
                        </div>
                        <input type="text" name="opt1_label" x-model="opt1" required
                               placeholder="Contoh: Tidak Sesuai / Tidak Puas"
                               class="w-full px-3 py-2 rounded-lg border border-rose-300 bg-white text-xs sm:text-sm focus:ring-2 focus:ring-rose-200 transition-all font-semibold text-rose-950">
                        @error('opt1_label')
                            <p class="text-rose-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Status Aktif Switch --}}
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <div>
                    <label for="is_active" class="text-xs sm:text-sm font-bold text-gray-900 cursor-pointer">Status Aktifkan Pertanyaan</label>
                    <p class="text-xs text-gray-500">Pertanyaan yang berstatus aktif akan langsung tampil pada formulir survei publik.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-hidden peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-700"></div>
                </label>
            </div>

            {{-- Submit Buttons --}}
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.survey-questions.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-semibold transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan Pertanyaan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
