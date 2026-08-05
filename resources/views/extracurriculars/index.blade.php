@extends('layouts.app')
@section('title', 'Ekstrakurikuler')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-10">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Ekstrakurikuler</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Ekstrakurikuler</h1>
        <p class="text-gray-500 text-sm md:text-base mt-1.5">Wadah pembinaan minat, bakat, kreativitas, dan kepemimpinan peserta didik UPT SMP Negeri 1 Buay Sandang Aji.</p>
    </div>

    @if($extracurriculars->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
        @foreach($extracurriculars as $ekskul)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
            <div>
                @if($ekskul->image)
                <div class="aspect-video overflow-hidden relative">
                    <img src="{{ asset('storage/'.$ekskul->image) }}" alt="{{ $ekskul->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white/95 backdrop-blur-sm text-gray-800 shadow-sm border border-gray-100">
                            {{ $ekskul->icon_theme['badge'] ?? 'Ekstrakurikuler' }}
                        </span>
                    </div>
                </div>
                @else
                <div class="h-44 bg-gradient-to-br {{ $ekskul->icon_theme['bg'] }} flex flex-col items-center justify-center relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-white/25 blur-xl pointer-events-none"></div>
                    <div class="absolute -left-8 -top-8 w-32 h-32 rounded-full bg-white/35 blur-xl pointer-events-none"></div>
                    
                    <div class="w-20 h-20 rounded-2xl bg-white shadow-md flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 {{ $ekskul->icon_theme['text'] }}">
                        <i class="{{ $ekskul->icon }} text-3xl"></i>
                    </div>
                    
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-white/95 backdrop-blur-sm {{ $ekskul->icon_theme['text'] }} shadow-sm border {{ $ekskul->icon_theme['border'] }}">
                            {{ $ekskul->icon_theme['badge'] ?? 'Ekstrakurikuler' }}
                        </span>
                    </div>
                </div>
                @endif

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors mb-3 leading-snug">
                        {{ $ekskul->name }}
                    </h3>

                    @if($ekskul->description)
                    <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $ekskul->description }}
                    </div>
                    @endif
                </div>
            </div>

            @if($ekskul->schedule || $ekskul->teacher)
            <div class="px-6 pb-6 pt-3 mt-auto">
                <div class="pt-4 border-t border-gray-100 space-y-2 text-xs text-gray-500">
                    @if($ekskul->schedule)
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-calendar-alt text-xs"></i>
                        </span>
                        <span class="font-medium text-gray-700">{{ $ekskul->schedule }}</span>
                    </div>
                    @endif
                    @if($ekskul->teacher)
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-user-tie text-xs"></i>
                        </span>
                        <span class="text-gray-600">Pembina: <strong class="text-gray-800 font-semibold">{{ $ekskul->teacher }}</strong></span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-shapes text-6xl mb-4 block text-gray-300"></i>
        <p class="text-lg font-medium text-gray-500">Data ekstrakurikuler belum tersedia.</p>
    </div>
    @endif
</div>
@endsection
