@extends('layouts.app')
@section('title', 'Fasilitas Sekolah')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Fasilitas Sekolah</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Fasilitas</nav>
    </div>
</div>
<div class="container mx-auto px-4 max-w-7xl py-16">
    @if($facilities->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($facilities as $facility)
        <div class="card group">
            @if($facility->image)
            <div class="aspect-video overflow-hidden">
                <img src="{{ asset('storage/'.$facility->image) }}" alt="{{ $facility->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @else
            <div class="aspect-video bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                <i class="{{ $facility->icon ?? 'fas fa-building' }} text-blue-400 text-5xl"></i>
            </div>
            @endif
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-2">{{ $facility->name }}</h3>
                @if($facility->description)
                <p class="text-gray-500 text-sm leading-relaxed">{{ $facility->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-building text-6xl mb-4 block"></i><p>Data fasilitas belum tersedia.</p></div>
    @endif
</div>
@endsection
