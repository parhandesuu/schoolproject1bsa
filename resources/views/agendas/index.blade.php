@extends('layouts.app')
@section('title', 'Agenda Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16 space-y-12">
    <div>
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Agenda</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Agenda Sekolah</h1>
    </div>

    {{-- Upcoming --}}
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-blue-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Agenda Mendatang</h2>
        </div>
        @if($upcomingAgendas->count() > 0)
        <div class="space-y-4">
            @foreach($upcomingAgendas as $agenda)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex gap-0 overflow-hidden group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                <div class="w-20 flex-shrink-0 bg-blue-700 flex flex-col items-center justify-center text-white py-4"
                     style="{{ $agenda->color ? 'background-color:'.$agenda->color : '' }}">
                    <span class="text-3xl font-extrabold leading-none">{{ $agenda->start_date->format('d') }}</span>
                    <span class="text-xs uppercase font-medium opacity-80">{{ $agenda->start_date->format('M Y') }}</span>
                </div>
                <div class="flex-1 px-6 py-4">
                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $agenda->title }}</h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        @if($agenda->location)
                        <span><i class="fas fa-map-marker-alt text-blue-400 mr-1"></i>{{ $agenda->location }}</span>
                        @endif
                        <span><i class="fas fa-clock text-blue-400 mr-1"></i>{{ $agenda->start_date->format('d M Y') }}
                            @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                &mdash; {{ $agenda->end_date->format('d M Y') }}
                            @endif
                        </span>
                    </div>
                    @if($agenda->description)
                    <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $agenda->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-gray-50 rounded-2xl text-gray-400"><i class="fas fa-calendar text-4xl mb-3 block"></i><p>Tidak ada agenda mendatang.</p></div>
        @endif
    </div>

    {{-- Past --}}
    @if($pastAgendas->count() > 0)
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-history text-gray-500"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-700">Agenda Lalu</h2>
        </div>
        <div class="space-y-3">
            @foreach($pastAgendas as $agenda)
            <div class="bg-white rounded-2xl border border-gray-100 flex gap-0 overflow-hidden opacity-70 hover:opacity-100 transition-opacity">
                <div class="w-16 flex-shrink-0 bg-gray-200 flex flex-col items-center justify-center text-gray-500 py-3">
                    <span class="text-xl font-bold leading-none">{{ $agenda->start_date->format('d') }}</span>
                    <span class="text-xs uppercase">{{ $agenda->start_date->format('M') }}</span>
                </div>
                <div class="flex-1 px-5 py-3">
                    <h3 class="font-semibold text-gray-700 mb-1">{{ $agenda->title }}</h3>
                    @if($agenda->location)
                    <span class="text-xs text-gray-400"><i class="fas fa-map-marker-alt mr-1"></i>{{ $agenda->location }}</span>
                    @endif
                </div>
                <div class="flex-shrink-0 flex items-center px-4">
                    <span class="text-xs bg-gray-100 text-gray-400 px-2 py-1 rounded-full">Selesai</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
