@extends('layouts.admin')

@section('title', 'Kelola Pertanyaan Survei SKM')

@section('page-title', 'Pertanyaan Survei Kepuasan Masyarakat')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb & Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-700">Dashboard</a>
                <i class="fas fa-chevron-right text-[9px] text-gray-400"></i>
                <a href="{{ route('admin.surveys.index') }}" class="hover:text-blue-700">Hasil Survei SKM</a>
                <i class="fas fa-chevron-right text-[9px] text-gray-400"></i>
                <span class="text-gray-800 font-semibold">Kelola Pertanyaan</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Kelola Unsur & Pertanyaan Kuesioner</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Atur pertanyaan kuesioner, teks indikator, bobot urutan, dan opsi jawaban skala 1-4.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.surveys.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-semibold transition-all flex items-center gap-2 shadow-xs">
                <i class="fas fa-chart-pie text-blue-700"></i>
                <span>Hasil & Laporan SKM</span>
            </a>
            <a href="{{ route('admin.survey-questions.create') }}" 
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Pertanyaan</span>
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2.5">
            <i class="fas fa-check-circle text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 text-sm">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- Stats Mini Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-lg">
                <i class="fas fa-list-ol"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Pertanyaan</p>
                <h3 class="text-xl font-extrabold text-gray-900">{{ $totalCount }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-lg">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Pertanyaan Aktif</p>
                <h3 class="text-xl font-extrabold text-emerald-700">{{ $activeCount }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-lg">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Dinonaktifkan</p>
                <h3 class="text-xl font-extrabold text-gray-700">{{ $inactiveCount }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Search Card --}}
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-xs">
        <form method="GET" action="{{ route('admin.survey-questions.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan judul, kode, atau teks pertanyaan..."
                       class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select name="status" class="py-2 px-3 rounded-xl border border-gray-200 text-xs sm:text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif Saja</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif Saja</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-gray-800 transition-all">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.survey-questions.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs sm:text-sm transition-all" title="Reset filter">
                    <i class="fas fa-redo"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Questions Table Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        @if($questions->isEmpty())
        <div class="p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fas fa-clipboard-question"></i>
            </div>
            <h3 class="text-base font-bold text-gray-900">Belum Ada Pertanyaan Ditemukan</h3>
            <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Tidak ada data pertanyaan survei yang cocok dengan filter pencarian Anda.</p>
            <div class="mt-4">
                <a href="{{ route('admin.survey-questions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-700 text-white text-xs font-semibold hover:bg-blue-800">
                    <i class="fas fa-plus"></i> Tambah Pertanyaan Baru
                </a>
            </div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/75 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                        <th class="py-3 px-4 text-center w-16">No / Urut</th>
                        <th class="py-3 px-4 w-24">Kode</th>
                        <th class="py-3 px-4 min-w-[280px]">Judul Unsur & Pertanyaan</th>
                        <th class="py-3 px-4 min-w-[220px]">Opsi Jawaban (Skala 4-1)</th>
                        <th class="py-3 px-4 text-center w-28">Status</th>
                        <th class="py-3 px-4 text-right w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                    @foreach($questions as $q)
                    <tr class="hover:bg-blue-50/30 transition-colors {{ !$q->is_active ? 'opacity-60 bg-gray-50/40' : '' }}">
                        {{-- Urutan --}}
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-blue-50 text-blue-800 font-extrabold text-xs shadow-2xs">
                                {{ $q->order }}
                            </span>
                        </td>

                        {{-- Kode --}}
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-800 font-bold text-xs">
                                {{ $q->code ?: '-' }}
                            </span>
                        </td>

                        {{-- Judul & Pertanyaan --}}
                        <td class="py-3.5 px-4">
                            <div class="flex items-start gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                    <i class="{{ $q->icon ?: 'fas fa-clipboard-check' }}"></i>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="font-bold text-gray-900 text-xs sm:text-sm leading-snug">
                                        {{ $q->title }}
                                    </h4>
                                    <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                        {{ $q->question }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Opsi Jawaban --}}
                        <td class="py-3.5 px-4">
                            <div class="grid grid-cols-2 gap-1 text-[11px]">
                                <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-200 truncate" title="4: {{ $q->opt4_label }}">
                                    <strong>4:</strong> {{ $q->opt4_label }}
                                </span>
                                <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-800 border border-blue-200 truncate" title="3: {{ $q->opt3_label }}">
                                    <strong>3:</strong> {{ $q->opt3_label }}
                                </span>
                                <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200 truncate" title="2: {{ $q->opt2_label }}">
                                    <strong>2:</strong> {{ $q->opt2_label }}
                                </span>
                                <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-800 border border-rose-200 truncate" title="1: {{ $q->opt1_label }}">
                                    <strong>1:</strong> {{ $q->opt1_label }}
                                </span>
                            </div>
                        </td>

                        {{-- Status Toggle --}}
                        <td class="py-3.5 px-4 text-center">
                            <form action="{{ route('admin.survey-questions.toggle-status', $q) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold transition-all {{ $q->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                        title="Klik untuk mengubah status">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $q->is_active ? 'bg-emerald-600' : 'bg-gray-500' }}"></span>
                                    <span>{{ $q->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </form>
                        </td>

                        {{-- Aksi --}}
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.survey-questions.edit', $q) }}" 
                                   class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 flex items-center justify-center text-xs transition-colors" 
                                   title="Edit Pertanyaan">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.survey-questions.destroy', $q) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini? Data survei yang sudah tersimpan sebelumnya tidak akan terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center text-xs transition-colors" 
                                            title="Hapus Pertanyaan">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($questions->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $questions->links() }}
        </div>
        @endif
        @endif
    </div>

</div>
@endsection
