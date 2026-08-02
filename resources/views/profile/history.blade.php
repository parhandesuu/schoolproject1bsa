@extends('layouts.app')
@section('title', 'Sejarah Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <a href="{{ route('profile.index') }}" class="hover:text-blue-700">Profil</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Sejarah</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Sejarah Sekolah</h1>
    </div>

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
                    <div class="text-center text-gray-400 py-12"><i class="fas fa-history text-5xl mb-4 block"></i><p>Konten sejarah belum tersedia.</p></div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
