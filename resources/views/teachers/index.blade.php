@extends('layouts.app')
@section('title', 'Guru & Staff')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16" x-data="{ tab: 'guru' }">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Guru & Staff</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Guru & Staff</h1>
    </div>
    {{-- Tabs --}}
    <div class="flex gap-2 mb-10">
        <button @click="tab='guru'" :class="tab==='guru' ? 'bg-blue-700 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'"
                class="px-6 py-2.5 rounded-xl font-medium text-sm transition-all">
            <i class="fas fa-chalkboard-teacher mr-2"></i>Tenaga Pendidik
            <span class="ml-2 text-xs bg-white/20 px-1.5 py-0.5 rounded-full">{{ $teachers->count() }}</span>
        </button>
        <button @click="tab='staff'" :class="tab==='staff' ? 'bg-blue-700 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'"
                class="px-6 py-2.5 rounded-xl font-medium text-sm transition-all">
            <i class="fas fa-user-cog mr-2"></i>Tenaga Kependidikan
            <span class="ml-2 text-xs bg-white/20 px-1.5 py-0.5 rounded-full">{{ $staff->count() }}</span>
        </button>
    </div>

    {{-- Teachers --}}
    <div x-show="tab==='guru'" x-transition>
        @if($teachers->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-5">
            @foreach($teachers as $teacher)
            <div class="card p-5 text-center group hover:border-blue-300 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-20 h-20 mx-auto mb-3 rounded-full overflow-hidden ring-2 ring-gray-100 group-hover:ring-blue-400 group-hover:scale-105 transition-all shadow-sm">
                        @if($teacher->photo)
                        <img src="{{ asset('storage/'.$teacher->photo) }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-2xl shadow-inner">
                            {{ strtoupper(substr($teacher->name,0,1)) }}
                        </div>
                        @endif
                    </div>
                    <div class="font-bold text-gray-900 text-sm mb-1 leading-snug">{{ $teacher->name }}</div>
                    <div class="text-xs text-blue-600 font-medium mb-1.5">{{ $teacher->position }}</div>
                    @if($teacher->subject)
                    <div class="inline-flex items-center gap-1 text-xs font-semibold text-blue-800 bg-blue-50 px-2.5 py-0.5 rounded-full mb-1.5">
                        <i class="fas fa-book-open text-[10px]"></i>
                        <span>{{ $teacher->subject }}</span>
                    </div>
                    @endif
                    @if($teacher->education && $teacher->education !== '-')
                    <div class="text-[11px] text-slate-600 bg-slate-100 rounded-md px-2 py-0.5 mt-1 inline-block font-medium">
                        {{ $teacher->education }}
                    </div>
                    @endif
                </div>
                @if($teacher->nip)
                <div class="text-[11px] text-gray-400 mt-3 pt-2 border-t border-gray-100 font-mono">
                    NIP. {{ $teacher->nip }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 text-gray-400"><i class="fas fa-users text-5xl mb-4 block"></i><p>Data guru belum tersedia.</p></div>
        @endif
    </div>

    {{-- Staff --}}
    <div x-show="tab==='staff'" x-transition>
        @if($staff->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-5">
            @foreach($staff as $s)
            <div class="card p-5 text-center group hover:border-purple-300 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-20 h-20 mx-auto mb-3 rounded-full overflow-hidden ring-2 ring-gray-100 group-hover:ring-purple-400 group-hover:scale-105 transition-all shadow-sm">
                        @if($s->photo)
                        <img src="{{ asset('storage/'.$s->photo) }}" alt="{{ $s->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-500 to-indigo-700 flex items-center justify-center text-white font-bold text-2xl shadow-inner">
                            {{ strtoupper(substr($s->name,0,1)) }}
                        </div>
                        @endif
                    </div>
                    <div class="font-bold text-gray-900 text-sm mb-1 leading-snug">{{ $s->name }}</div>
                    <div class="text-xs text-purple-600 font-medium mb-1.5">{{ $s->position }}</div>
                    @if($s->education)
                    <div class="text-[11px] text-purple-700 bg-purple-50 rounded-md px-2 py-0.5 mt-1 inline-block font-medium">
                        {{ $s->education }}
                    </div>
                    @endif
                </div>
                @if($s->nip)
                <div class="text-[11px] text-gray-400 mt-3 pt-2 border-t border-gray-100 font-mono">
                    NIP. {{ $s->nip }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 text-gray-400"><i class="fas fa-user-cog text-5xl mb-4 block"></i><p>Data staff belum tersedia.</p></div>
        @endif
    </div>
</div>
@endsection
