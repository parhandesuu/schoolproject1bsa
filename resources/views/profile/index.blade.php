@extends('layouts.app')
@section('title', $page->title ?? 'Profil Sekolah')
@section('meta_description', $page->meta_description ?? '')

@section('content')
{{-- Page Header --}}
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Profil Sekolah</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Profil</nav>
    </div>
</div>

<div class="container mx-auto px-4 max-w-7xl py-16">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sidebar --}}
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
        {{-- Content --}}
        <main class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                @if($page)
                    @if($page->image)
                    <img src="{{ asset('storage/'.$page->image) }}" alt="{{ $page->title }}" class="w-full rounded-xl mb-8 object-cover max-h-72">
                    @endif
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $page->title }}</h2>
                    <div class="prose-school">{!! $page->content !!}</div>
                @else
                    <div class="text-center text-gray-400 py-12">
                        <i class="fas fa-file-alt text-5xl mb-4 block"></i>
                        <p>Konten belum tersedia. Silakan tambahkan melalui panel admin.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
