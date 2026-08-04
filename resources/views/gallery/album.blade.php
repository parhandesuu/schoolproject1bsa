@extends('layouts.app')
@section('title', $album->name)
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16" x-data="{ lightbox: false, currentSrc: '', currentAlt: '' }">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <a href="{{ route('gallery.photos') }}" class="hover:text-blue-700">Galeri Foto</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">{{ $album->name }}</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">{{ $album->name }}</h1>
    </div>

    @if($album->description)
    <p class="text-gray-600 mb-8 max-w-2xl">{{ $album->description }}</p>
    @endif

    @if($photos->count() > 0)
    <div class="flex flex-wrap justify-center gap-4">
        @foreach($photos as $photo)
        <button @click="lightbox=true; currentSrc='{{ asset('storage/'.$photo->image) }}'; currentAlt='{{ $photo->caption ?? $album->name }}'"
                class="aspect-square rounded-xl overflow-hidden group block w-full {{ $photos->count() == 1 ? 'max-w-md' : ($photos->count() == 2 ? 'max-w-xs sm:w-[calc(50%-12px)]' : ($photos->count() == 3 ? 'max-w-xs sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]' : 'w-full sm:w-[calc(50%-12px)] md:w-[calc(33.333%-16px)] lg:w-[calc(25%-12px)]')) }}">
            <img src="{{ asset('storage/'.$photo->image) }}" alt="{{ $photo->caption }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        </button>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div x-show="lightbox" x-transition class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 p-4"
         @keydown.escape.window="lightbox=false" @click="lightbox=false">
        <div @click.stop class="relative max-w-5xl max-h-full">
            <img :src="currentSrc" :alt="currentAlt" class="max-w-full max-h-[80vh] rounded-xl object-contain shadow-2xl">
            <p x-text="currentAlt" class="text-white text-center mt-3 text-sm opacity-75"></p>
        </div>
        <button @click="lightbox=false" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-images text-6xl mb-4 block"></i><p>Belum ada foto di album ini.</p></div>
    @endif

    <div class="mt-8">
        <a href="{{ route('gallery.photos') }}" class="btn-outline"><i class="fas fa-arrow-left mr-2"></i>Kembali ke Galeri</a>
    </div>
</div>
@endsection
