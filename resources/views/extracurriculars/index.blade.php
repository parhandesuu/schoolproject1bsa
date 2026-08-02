@extends('layouts.app')
@section('title', 'Ekstrakurikuler')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Ekstrakurikuler</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Ekstrakurikuler</h1>
    </div>
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
