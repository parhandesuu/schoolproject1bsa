@extends('layouts.app')
@section('title', 'Layanan Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Layanan Sekolah</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Layanan Sekolah</h1>
    </div>
    @if($services->count() > 0)
    <div class="space-y-4" x-data="{ 
        open: null,
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
        @foreach($services as $i => $service)
        <div id="service-{{ $service->id }}" data-index="{{ $i }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:border-blue-200 transition-all">
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
            <div x-show="open === {{ $i }}" x-transition x-collapse class="px-5 md:px-6 pb-5 md:pb-6 pt-0 border-t border-gray-50">
                <div class="pt-4 md:pl-16">
                    @if($service->content)
                    <div class="prose-school text-sm">{!! $service->content !!}</div>
                    @else
                    <p class="text-gray-600 text-sm">{{ $service->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-concierge-bell text-6xl mb-4 block"></i><p>Belum ada layanan tersedia.</p></div>
    @endif
</div>
@endsection
