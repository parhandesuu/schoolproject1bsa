@extends('layouts.app')
@section('title', 'Prestasi Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Prestasi</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Prestasi Sekolah</h1>
    </div>
    {{-- Filters --}}
    <form method="GET" action="{{ route('achievements.index') }}" class="flex flex-wrap items-center gap-3 mb-8">
        <select name="level" class="bg-white border border-gray-300 rounded-xl px-4 pr-9 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer" onchange="this.form.submit()">
            <option value="">Semua Tingkat</option>
            @foreach(['Sekolah','Kecamatan','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $level)
            <option value="{{ $level }}" {{ request('level') === $level ? 'selected' : '' }}>{{ $level }}</option>
            @endforeach
        </select>
        <select name="category" class="bg-white border border-gray-300 rounded-xl px-4 pr-9 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="year" class="bg-white border border-gray-300 rounded-xl px-4 pr-9 py-2.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer" onchange="this.form.submit()">
            <option value="">Semua Tahun</option>
            @foreach($years as $year)
            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary px-5 py-2.5 text-sm"><i class="fas fa-filter mr-2"></i>Filter</button>
        @if(request()->hasAny(['level','category','year']))
        <a href="{{ route('achievements.index') }}" class="btn-outline px-5 py-2.5 text-sm">Reset</a>
        @endif
    </form>

    @if($achievements->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($achievements as $achievement)
        <div class="card p-6 group hover:border-amber-200" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
            @if($achievement->image)
            <img src="{{ asset('storage/'.$achievement->image) }}" alt="{{ $achievement->title }}"
                 class="w-full h-32 object-cover rounded-xl mb-4">
            @endif
            <div class="flex items-start gap-3 mb-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                    <i class="fas fa-trophy text-amber-500 group-hover:text-white transition-colors"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ match($achievement->level) {
                            'Internasional' => 'bg-purple-100 text-purple-700',
                            'Nasional' => 'bg-blue-100 text-blue-700',
                            'Provinsi' => 'bg-emerald-100 text-emerald-700',
                            'Kabupaten/Kota', 'Kabupaten' => 'bg-amber-100 text-amber-700',
                            'Kecamatan' => 'bg-teal-100 text-teal-700',
                            'Sekolah' => 'bg-sky-100 text-sky-700',
                            default => 'bg-gray-100 text-gray-700'
                        } }}">Tingkat {{ $achievement->level }}</span>
                    <div class="text-xs text-gray-400 mt-1.5">{{ $achievement->year }} &bull; {{ $achievement->category }}</div>
                </div>
            </div>
            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $achievement->title }}</h3>
            @if($achievement->description)
            <p class="text-gray-500 text-sm line-clamp-3">{{ $achievement->description }}</p>
            @endif
        </div>
        @endforeach
    </div>
    {{ $achievements->withQueryString()->links() }}
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-trophy text-6xl mb-4 block"></i><p>Belum ada data prestasi.</p></div>
    @endif
</div>
@endsection
