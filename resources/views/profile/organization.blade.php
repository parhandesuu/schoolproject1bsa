@extends('layouts.app')
@section('title', 'Struktur Organisasi')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Struktur Organisasi</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / <a href="{{ route('profile.index') }}" class="hover:text-white">Profil</a> / Struktur Organisasi</nav>
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
                @if($page)
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $page->title }}</h2>
                    <div class="prose-school">{!! $page->content !!}</div>
                @else
                    <div class="text-center text-gray-400 py-12"><i class="fas fa-sitemap text-5xl mb-4 block"></i><p>Konten struktur organisasi belum tersedia.</p></div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
