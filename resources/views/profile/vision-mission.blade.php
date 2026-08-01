@extends('layouts.app')
@section('title', 'Visi & Misi')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Visi & Misi</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / <a href="{{ route('profile.index') }}" class="hover:text-white">Profil</a> / Visi & Misi</nav>
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
        <main class="lg:col-span-3 space-y-6">
            @if($page)
            <div class="bg-blue-700 rounded-2xl p-8 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center"><i class="fas fa-eye"></i></div>
                    <h2 class="text-xl font-bold">VISI</h2>
                </div>
                <div class="prose prose-invert max-w-none">{!! $page->content !!}</div>
            </div>
            @else
            <div class="bg-blue-700 rounded-2xl p-8 text-white text-center">
                <i class="fas fa-eye text-5xl mb-4 block opacity-50"></i>
                <p>Konten Visi & Misi belum tersedia.</p>
            </div>
            @endif
        </main>
    </div>
</div>
@endsection
