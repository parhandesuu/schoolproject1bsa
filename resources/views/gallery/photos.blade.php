@extends('layouts.app')
@section('title', 'Galeri Foto')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Galeri Foto</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Galeri Foto</nav>
    </div>
</div>
<div class="container mx-auto px-4 max-w-7xl py-16">
    @if($albums->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($albums as $album)
        <a href="{{ route('gallery.album', $album) }}" class="card group block">
            <div class="aspect-video overflow-hidden bg-gray-100 relative">
                @if($album->cover)
                <img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                    <i class="fas fa-images text-blue-300 text-5xl"></i>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent flex items-end">
                    <div class="p-4 w-full">
                        <h3 class="font-bold text-white text-lg">{{ $album->name }}</h3>
                        <div class="text-white/70 text-sm"><i class="fas fa-images mr-1"></i>{{ $album->photos_count ?? 0 }} foto</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    {{ $albums->links() }}
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-camera text-6xl mb-4 block"></i><p>Belum ada album foto.</p></div>
    @endif
</div>
@endsection
