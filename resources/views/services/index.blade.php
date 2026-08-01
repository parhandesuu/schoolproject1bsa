@extends('layouts.app')
@section('title', 'Layanan Sekolah')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Layanan Sekolah</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Layanan</nav>
    </div>
</div>
<div class="container mx-auto px-4 max-w-7xl py-16">
    @if($services->count() > 0)
    <div class="space-y-4" x-data="{ open: null }">
        @foreach($services as $i => $service)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:border-blue-200 transition-colors">
            <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                    class="w-full flex items-center gap-4 p-5 md:p-6 text-left">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors"
                     :class="open === {{ $i }} ? 'bg-blue-700' : 'bg-blue-100'">
                    <i class="{{ $service->icon ?? 'fas fa-concierge-bell' }} transition-colors"
                       :class="open === {{ $i }} ? 'text-white' : 'text-blue-600'"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-900">{{ $service->title }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-1 mt-0.5">{{ $service->description }}</p>
                </div>
                <i class="fas fa-chevron-down text-gray-400 flex-shrink-0 transition-transform duration-300"
                   :class="open === {{ $i }} ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open === {{ $i }}" x-transition x-collapse class="px-5 md:px-6 pb-5 md:pb-6 pt-0">
                <div class="pl-16">
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
