@extends('layouts.app')
@section('title', 'Fasilitas Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Fasilitas</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Fasilitas Sekolah</h1>
    </div>
    @if($facilities->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($facilities as $facility)
        <div class="card group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
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
