@extends('layouts.app')
@section('title', 'Galeri Foto')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Galeri Foto</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Galeri Foto</h1>
    </div>
    @if($albums->count() > 0)
    <div class="flex flex-wrap justify-center gap-6 mb-8">
        @foreach($albums as $album)
        <div class="w-full {{ $albums->count() == 1 ? 'max-w-md' : ($albums->count() == 2 ? 'sm:max-w-md md:w-[calc(50%-12px)]' : 'sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]') }}">
            <a href="{{ route('gallery.album', $album) }}" class="card group block overflow-hidden">
                <div class="aspect-video overflow-hidden bg-gray-100 relative">
                    @if($album->cover)
                    <img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                        <i class="fas fa-images text-blue-300 text-5xl"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/30 to-transparent flex items-end">
                        <div class="p-5 w-full">
                            <h3 class="font-bold text-white text-lg drop-shadow-sm group-hover:text-blue-200 transition-colors">{{ $album->name }}</h3>
                            <div class="text-white/80 text-sm mt-1 flex items-center gap-1.5"><i class="fas fa-images"></i><span>{{ $album->photos_count ?? 0 }} foto</span></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    {{ $albums->links() }}
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-camera text-6xl mb-4 block"></i><p>Belum ada album foto.</p></div>
    @endif
</div>
@endsection
