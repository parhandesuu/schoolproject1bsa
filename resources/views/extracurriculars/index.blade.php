@extends('layouts.app')
@section('title', 'Ekstrakurikuler')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Ekstrakurikuler</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Ekstrakurikuler</nav>
    </div>
</div>
<div class="container mx-auto px-4 max-w-7xl py-16">
    @if($extracurriculars->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($extracurriculars as $ekskul)
        <div class="card group">
            @if($ekskul->image)
            <div class="aspect-video overflow-hidden">
                <img src="{{ asset('storage/'.$ekskul->image) }}" alt="{{ $ekskul->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @else
            <div class="aspect-video bg-gradient-to-br from-cyan-50 to-blue-100 flex items-center justify-center">
                <i class="fas fa-running text-cyan-400 text-5xl"></i>
            </div>
            @endif
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-2">{{ $ekskul->name }}</h3>
                <div class="flex flex-wrap gap-3 mb-3">
                    @if($ekskul->schedule)
                    <span class="text-xs text-gray-500"><i class="fas fa-clock text-blue-400 mr-1"></i>{{ $ekskul->schedule }}</span>
                    @endif
                    @if($ekskul->teacher)
                    <span class="text-xs text-gray-500"><i class="fas fa-user text-blue-400 mr-1"></i>{{ $ekskul->teacher }}</span>
                    @endif
                </div>
                @if($ekskul->description)
                <p class="text-gray-500 text-sm line-clamp-3">{{ $ekskul->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-running text-6xl mb-4 block"></i><p>Data ekstrakurikuler belum tersedia.</p></div>
    @endif
</div>
@endsection
