@extends('layouts.app')
@section('title', 'Sambutan Kepala Sekolah')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Sambutan Kepala Sekolah</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / <a href="{{ route('profile.index') }}" class="hover:text-white">Profil</a> / Sambutan</nav>
    </div>
</div>
<div class="container mx-auto px-4 max-w-7xl py-16">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <aside class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-24">
                <div class="bg-blue-700 px-5 py-4"><h3 class="font-bold text-white text-sm">Menu Profil</h3></div>
                <nav class="divide-y divide-gray-50">
                    @foreach([['Profil Sekolah','profile.index'],['Sejarah','profile.history'],['Visi & Misi','profile.vision-mission'],['Sambutan Kepsek','profile.principal'],['Struktur Organisasi','profile.organization']] as [$label,$route])
                    <a href="{{ route($route) }}" class="flex items-center justify-between px-5 py-3 text-sm {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        {{ $label }} <i class="fas fa-chevron-right text-xs opacity-40"></i>
                    </a>
                    @endforeach
                </nav>
            </div>
        </aside>
        <main class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <div class="flex flex-col md:flex-row gap-8 mb-8">
                    @if($principal)
                    <div class="flex-shrink-0 text-center">
                        @if($principal->photo)
                        <img src="{{ asset('storage/'.$principal->photo) }}" alt="{{ $principal->name }}"
                             class="w-44 h-52 object-cover rounded-2xl shadow-md mx-auto mb-3">
                        @else
                        <div class="w-44 h-52 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-tie text-blue-400 text-5xl"></i>
                        </div>
                        @endif
                        <div class="font-bold text-gray-900">{{ $principal->name }}</div>
                        <div class="text-sm text-blue-600">{{ $principal->position }}</div>
                        @if($principal->nip)<div class="text-xs text-gray-400 mt-1">NIP: {{ $principal->nip }}</div>@endif
                    </div>
                    @endif
                    <div class="flex-1">
                        @if($page)
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $page->title }}</h2>
                        <div class="prose-school">{!! $page->content !!}</div>
                        @else
                        <p class="text-gray-500">Konten sambutan belum tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
