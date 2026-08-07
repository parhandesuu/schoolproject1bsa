@extends('layouts.app')
@section('title', 'Layanan Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16" x-data="{ 
    open: null,
    lightbox: false,
    currentSrc: '',
    currentAlt: '',
    init() {
        if (window.location.hash) {
            const target = document.querySelector(window.location.hash);
            if (target) {
                const idx = target.getAttribute('data-index');
                if (idx !== null) {
                    this.open = parseInt(idx);
                    setTimeout(() => {
                        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 200);
                }
            }
        }
    }
}">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Layanan Sekolah</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Layanan Sekolah</h1>
    </div>
    @if($services->count() > 0)
    <div class="space-y-4">
        @foreach($services as $i => $service)
        <div id="service-{{ $service->id }}" data-index="{{ $i }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:border-blue-200 transition-all" data-aos="fade-up" data-aos-delay="{{ ($i % 5) * 100 }}">
            <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                    class="w-full flex items-center gap-4 p-5 md:p-6 text-left cursor-pointer">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors"
                     :class="open === {{ $i }} ? 'bg-blue-800 text-white' : 'bg-blue-100 text-blue-600'">
                    <i class="{{ $service->icon ?? 'fas fa-concierge-bell' }} transition-colors"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-900 group-hover:text-blue-800 transition-colors">{{ $service->title }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-1 mt-0.5">{{ $service->description }}</p>
                </div>
                <i class="fas fa-chevron-down text-gray-400 flex-shrink-0 transition-transform duration-300"
                   :class="open === {{ $i }} ? 'rotate-180 text-blue-800' : ''"></i>
            </button>
            <div x-show="open === {{ $i }}" x-transition x-collapse class="px-5 md:px-6 pb-6 pt-0 border-t border-gray-50">
                <div class="pt-4 md:pl-16 space-y-6">
                    {{-- Photos Display (Side by side without titles) --}}
                    @php
                        $allImages = [];
                        if ($service->image) {
                            $allImages[] = [
                                'src'   => $service->image,
                                'title' => !empty($service->image_title) ? $service->image_title : $service->title,
                            ];
                        }
                        if (!empty($service->images) && is_array($service->images)) {
                            foreach ($service->images as $extraImg) {
                                if (is_array($extraImg) && !empty($extraImg['path'])) {
                                    $allImages[] = [
                                        'src'   => $extraImg['path'],
                                        'title' => !empty($extraImg['title']) ? $extraImg['title'] : ($service->image_title ?? $service->title),
                                    ];
                                } elseif (is_string($extraImg) && !empty($extraImg)) {
                                    $allImages[] = [
                                        'src'   => $extraImg,
                                        'title' => !empty($service->image_title) ? $service->image_title : $service->title,
                                    ];
                                }
                            }
                        }
                    @endphp

                    @if(count($allImages) > 0)
                    <div class="pt-1">
                        <div class="{{ count($allImages) === 1 ? 'max-w-2xl' : (count($allImages) === 2 ? 'grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6') }}">
                            @foreach($allImages as $imgItem)
                            @php
                                $imgSrc = $imgItem['src'];
                                $photoCaption = $imgItem['title'];
                            @endphp
                            <div class="relative group w-full rounded-2xl overflow-hidden border border-gray-200/80 shadow-sm bg-gray-50 flex items-center justify-center">
                                <img src="{{ asset('storage/'.$imgSrc) }}" 
                                     alt="{{ $photoCaption }}" 
                                     class="w-full max-h-[520px] object-contain rounded-2xl cursor-pointer transition-transform duration-300 group-hover:scale-[1.01]"
                                     @click="lightbox=true; currentSrc='{{ asset('storage/'.$imgSrc) }}'; currentAlt='{{ addslashes($photoCaption) }}'">
                                <button type="button" 
                                        @click="lightbox=true; currentSrc='{{ asset('storage/'.$imgSrc) }}'; currentAlt='{{ addslashes($photoCaption) }}'"
                                        class="absolute bottom-3 right-3 bg-black/60 hover:bg-black/80 text-white text-xs px-3 py-1.5 rounded-lg flex items-center gap-1.5 backdrop-blur-sm transition-all opacity-90 group-hover:opacity-100 cursor-pointer">
                                    <i class="fas fa-search-plus"></i> Perbesar Gambar
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Description / Content --}}
                    @if($service->content)
                    <div class="prose-school text-sm leading-relaxed">{!! $service->content !!}</div>
                    @elseif($service->description)
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $service->description }}</p>
                    @endif

                    {{-- File / Document Attachment --}}
                    @if($service->file)
                    <div class="pt-2 border-t border-gray-100">
                        <a href="{{ asset('storage/'.$service->file) }}" target="_blank" download="{{ $service->file_name ?? '' }}" 
                           class="inline-flex items-center gap-3 px-4 py-3 bg-blue-50/70 hover:bg-blue-100/70 border border-blue-200 text-blue-900 rounded-xl transition-all shadow-sm group">
                            <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class="fas fa-file-download"></i>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-semibold text-blue-900">{{ $service->file_name ?? 'Unduh Dokumen Lampiran' }}</div>
                                <div class="text-xs text-blue-600">Klik untuk mengunduh / membuka lampiran</div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Lightbox Modal --}}
    <div x-show="lightbox" x-transition x-cloak class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 p-4"
         @keydown.escape.window="lightbox=false" @click="lightbox=false">
        <div @click.stop class="relative max-w-5xl max-h-full">
            <img :src="currentSrc" :alt="currentAlt" class="max-w-full max-h-[85vh] rounded-xl object-contain shadow-2xl mx-auto">
            <div class="flex items-center justify-between mt-3 text-white text-sm px-2 gap-4">
                <p x-show="currentAlt" x-text="currentAlt" class="font-medium opacity-90 truncate"></p>
                <div class="flex items-center gap-2 flex-shrink-0" :class="!currentAlt ? 'w-full justify-end' : ''">
                    <a :href="currentSrc" target="_blank" class="text-xs bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
                        <i class="fas fa-external-link-alt"></i> Buka Gambar Asli
                    </a>
                </div>
            </div>
        </div>
        <button @click="lightbox=false" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/40 text-white rounded-full flex items-center justify-center transition-colors cursor-pointer">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-concierge-bell text-6xl mb-4 block"></i><p>Belum ada layanan tersedia.</p></div>
    @endif
</div>
@endsection
