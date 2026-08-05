@extends('layouts.app')
@section('title', 'Galeri Video')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16" x-data="{ modal: false, videoId: '' }">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Galeri Video</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Galeri Video</h1>
    </div>
    @if($videos->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($videos as $video)
        <div class="card group cursor-pointer" @click="modal=true; videoId='{{ $video->youtube_id }}'" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
            <div class="aspect-video overflow-hidden relative">
                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                     alt="{{ $video->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 transition-colors flex items-center justify-center">
                    <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-play text-white ml-1 text-lg"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-blue-700 transition-colors">{{ $video->title }}</h3>
                @if($video->description)
                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $video->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    {{ $videos->links() }}

    {{-- Video Modal --}}
    <div x-show="modal" x-transition class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 p-4"
         @keydown.escape.window="modal=false; videoId=''" @click="modal=false; videoId=''">
        <div @click.stop class="w-full max-w-4xl">
            <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-2xl">
                <iframe :src="'https://www.youtube.com/embed/'+videoId+'?autoplay=1'"
                        width="100%" height="100%" frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <button @click="modal=false; videoId=''" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fab fa-youtube text-6xl mb-4 block"></i><p>Belum ada video.</p></div>
    @endif
</div>
@endsection
