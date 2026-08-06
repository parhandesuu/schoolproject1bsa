@extends('layouts.app')
@section('title', 'Beranda')
@section('meta_description', \App\Models\Setting::get('meta_description', 'Website resmi sekolah'))

@section('content')

{{-- ===== HERO SECTION ===== --}}
@if($hero_sliders->count() > 0)
<section class="relative min-h-[700px] lg:min-h-screen overflow-hidden flex items-center"
    x-data="{
        current: 0,
        total: {{ $hero_sliders->count() }},
        autoplay: null,
        start() {
            this.autoplay = setInterval(() => { this.next(); }, 6000);
        },
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; }
    }" x-init="start()">

    {{-- Slides --}}
    @foreach($hero_sliders as $i => $slider)
    <div class="absolute inset-0 transition-opacity duration-1000"
         :class="{{ $i }} === current ? 'opacity-100 z-10' : 'opacity-0 z-0'">
        
        @if($slider->image)
        <img src="{{ asset('storage/'.$slider->image) }}" alt="{{ $slider->title }}"
             class="w-full h-full object-cover object-center">
        @else
        <div class="w-full h-full bg-gradient-to-br from-blue-900 to-blue-700"></div>
        @endif
        
        {{-- Overlay gradient for readability (Dark theme) --}}
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/60 to-transparent md:to-gray-900/10"></div>
        
        {{-- Content --}}
        <div class="absolute inset-0 flex items-center pt-24 pb-12">
            <div class="container mx-auto px-6 sm:px-10 lg:px-16 max-w-7xl">
                <div class="max-w-3xl" data-aos="fade-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        {!! nl2br(e($slider->title)) !!}
                    </h1>
                    
                    @if($slider->subtitle)
                    <p class="text-lg md:text-xl lg:text-2xl text-white/90 mb-10 leading-relaxed font-light max-w-2xl">{{ $slider->subtitle }}</p>
                    @endif

                    <div class="flex flex-wrap gap-4">
                        @if($slider->button_text)
                        <a href="{{ $slider->button_url ?? '#' }}" class="btn-primary">
                            {{ $slider->button_text }}
                        </a>
                        @endif
                        @if($slider->button_text_2)
                        <a href="{{ $slider->button_url_2 ?? '#' }}" class="btn-white">
                            {{ $slider->button_text_2 }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Controls --}}
    <button @click="prev()" class="absolute left-2 lg:left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/10 hover:bg-white/20 text-white shadow rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/20 backdrop-blur-md">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button @click="next()" class="absolute right-2 lg:right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/10 hover:bg-white/20 text-white shadow rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/20 backdrop-blur-md">
        <i class="fas fa-chevron-right"></i>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-10 left-6 lg:left-16 z-20 flex gap-3">
        @foreach($hero_sliders as $i => $s)
        <button @click="current = {{ $i }}" class="transition-all duration-300 rounded-full"
                :class="{{ $i }} === current ? 'w-10 h-2.5 bg-orange-500' : 'w-2.5 h-2.5 bg-white/50 hover:bg-white/80'"></button>
        @endforeach
    </div>
</section>
@else
{{-- Fallback Hero --}}
<section class="relative min-h-[700px] lg:min-h-screen overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-700"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIiBmaWxsPSJyZ2JhKDMwLCA2NCwgMTc1LCAwLjA1KSIvPjwvc3ZnPg==')] opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/60 to-transparent"></div>

    <div class="container mx-auto px-6 lg:px-16 max-w-7xl relative z-10 pt-24 pb-12">
        <div class="max-w-3xl" data-aos="fade-up">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                {{ \App\Models\Setting::get('school_name', 'SMP Negeri 1 Buay Sandang Aji') }}
            </h1>
            
            <p class="text-lg md:text-xl lg:text-2xl text-white/90 mb-10 leading-relaxed font-light max-w-2xl">{{ \App\Models\Setting::get('school_motto', 'Cerdas, Berkarakter, dan Berprestasi') }}</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('profile.index') }}" class="btn-primary">
                    Profil Sekolah
                </a>
                <a href="{{ route('contact.index') }}" class="btn-white">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== ABOUT SCHOOL ===== --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {{-- Left: Profile Text --}}
            <div data-aos="fade-right">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-800 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                    <i class="fas fa-school"></i> Tentang Kami
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ \App\Models\Setting::get('school_name', 'SMP Negeri 1 Buay Sandang Aji') }}
                </h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    @if($profilePage && $profilePage->excerpt)
                        {{ $profilePage->excerpt }}
                    @else
                        {{ \App\Models\Setting::get('school_description', 'Sekolah unggulan yang berkomitmen menghasilkan lulusan berkualitas dengan karakter mulia dan prestasi membanggakan.') }}
                    @endif
                </p>
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-certificate text-blue-800"></i>
                        Akreditasi <strong class="text-blue-800 ml-1">{{ \App\Models\Setting::get('school_accreditation', 'A') }}</strong>
                    </div>
                    <div class="w-px h-5 bg-gray-200"></div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-id-badge text-blue-800"></i>
                        NPSN <strong class="text-gray-700 ml-1">{{ \App\Models\Setting::get('school_npsn', '-') }}</strong>
                    </div>
                </div>
                <a href="{{ route('profile.index') }}" class="btn-primary">Selengkapnya <i class="fas fa-arrow-right text-sm"></i></a>
            </div>

            {{-- Right: Statistics --}}
            <div class="grid grid-cols-2 gap-4">
                @forelse($statistics as $stat)
                <div class="bg-gradient-to-br from-white to-blue-50/50 border border-blue-100 rounded-2xl p-6 text-center hover:shadow-md transition-shadow group" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 4) * 150 }}">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-800 transition-colors">
                        <i class="{{ $stat->icon ?? 'fas fa-star' }} text-blue-800 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-blue-800 mb-1">{{ $stat->value }}</div>
                    <div class="text-sm text-gray-500 font-medium">{{ $stat->label }}</div>
                </div>
                @empty
                @foreach([['fas fa-users','1.200+','Siswa Aktif'],['fas fa-chalkboard-teacher','80+','Guru & Staff'],['fas fa-trophy','150+','Prestasi'],['fas fa-history','25+','Tahun Berdiri']] as [$icon,$val,$label])
                <div class="bg-gradient-to-br from-white to-blue-50/50 border border-blue-100 rounded-2xl p-6 text-center hover:shadow-md transition-shadow group" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 4) * 150 }}">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-800 transition-colors">
                        <i class="{{ $icon }} text-blue-800 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-blue-800 mb-1">{{ $val }}</div>
                    <div class="text-sm text-gray-500 font-medium">{{ $label }}</div>
                </div>
                @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ===== PRINCIPAL GREETING ===== --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {{-- Photo --}}
            <div class="order-2 lg:order-1 flex justify-center" data-aos="fade-right">
                <div class="relative">
                    @if($principal && $principal->photo)
                    <img src="{{ asset('storage/'.$principal->photo) }}" alt="{{ $principal->name }}"
                         class="w-72 h-80 object-cover rounded-2xl shadow-xl">
                    @elseif($sambutanPage && $sambutanPage->image)
                    <img src="{{ asset('storage/'.$sambutanPage->image) }}" alt="{{ $sambutanPage->title }}"
                         class="w-72 h-80 object-cover rounded-2xl shadow-xl">
                    @else
                    <div class="w-72 h-80 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl shadow-xl flex items-center justify-center">
                        <i class="fas fa-user-tie text-blue-400 text-6xl"></i>
                    </div>
                    @endif
                    <div class="absolute -bottom-4 -right-4 bg-blue-800 text-white px-4 py-2 rounded-xl shadow-lg">
                        <div class="text-xs">Kepala Sekolah</div>
                        <div class="font-bold text-sm">{{ $principal->name ?? ($sambutanPage->title ?? 'Kepala Sekolah') }}</div>
                    </div>
                </div>
            </div>
            {{-- Content --}}
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-800 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                    <i class="fas fa-quote-left"></i> Sambutan Kepala Sekolah
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Sambutan Kepala Sekolah</h2>
                <blockquote class="relative pl-6 border-l-4 border-blue-800 mb-6">
                    <p class="text-gray-600 leading-relaxed italic">
                        @if($sambutanPage && $sambutanPage->excerpt)
                            {{ $sambutanPage->excerpt }}
                        @else
                            Selamat datang di website resmi {{ \App\Models\Setting::get('school_name', 'SMP Negeri 1 Buay Sandang Aji') }}. Kami berkomitmen untuk memberikan pendidikan terbaik bagi seluruh siswa kami.
                        @endif
                    </p>
                </blockquote>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center overflow-hidden">
                        @if($principal && $principal->photo)
                        <img src="{{ asset('storage/'.$principal->photo) }}" alt="{{ $principal->name }}" class="w-full h-full object-cover">
                        @else
                        <i class="fas fa-user text-blue-800"></i>
                        @endif
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">{{ $principal->name ?? 'Kepala Sekolah' }}</div>
                        <div class="text-sm text-gray-500">{{ $principal->position ?? 'Kepala Sekolah' }}</div>
                    </div>
                </div>
                <a href="{{ route('profile.principal') }}" class="btn-outline">Baca Selengkapnya <i class="fas fa-arrow-right text-sm"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- ===== LATEST NEWS ===== --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-divider"></div>
            <h2 class="section-title">Berita Terbaru</h2>
            <p class="section-subtitle">Informasi dan kabar terkini dari lingkungan sekolah</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @forelse($posts as $post)
            <article class="card group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 150 }}">
                <a href="{{ route('posts.show', $post) }}" class="block">
                    <div class="aspect-video overflow-hidden">
                        @if($post->thumbnail)
                        <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <i class="fas fa-newspaper text-blue-300 text-4xl"></i>
                        </div>
                        @endif
                    </div>
                </a>
                <div class="p-5">
                    @if($post->category)
                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
                       class="inline-flex items-center text-xs font-semibold text-blue-800 bg-blue-50 px-2.5 py-1 rounded-full mb-3 hover:bg-blue-100">
                        {{ $post->category->name }}
                    </a>
                    @endif
                    <h3 class="font-bold text-gray-900 text-base mb-2 line-clamp-2 group-hover:text-blue-800 transition-colors">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </h3>
                    @if($post->excerpt)
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                    @endif
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span><i class="fas fa-calendar mr-1"></i>{{ $post->published_at?->format('d M Y') }}</span>
                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->views) }}</span>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-400">
                <i class="fas fa-newspaper text-4xl mb-3 block"></i>
                Belum ada berita tersedia
            </div>
            @endforelse
        </div>

        <div class="text-center" data-aos="fade-up">
            <a href="{{ route('posts.index') }}" class="btn-outline">Lihat Semua Berita <i class="fas fa-arrow-right text-sm"></i></a>
        </div>
    </div>
</section>

{{-- ===== AGENDA ===== --}}
@if($agendas->count() > 0)
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10" data-aos="fade-up">
            <div>
                <div class="section-divider bg-white/50 mx-0 mb-3"></div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">Agenda Mendatang</h2>
                <p class="text-white/75">Kegiatan dan acara sekolah yang akan datang</p>
            </div>
            <a href="{{ route('agendas.index') }}" class="mt-4 md:mt-0 btn-white text-sm">
                Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($agendas as $agenda)
            <div class="bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-colors rounded-2xl p-5 flex gap-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 2) * 150 }}">
                <div class="flex-shrink-0 w-16 h-16 rounded-xl flex flex-col items-center justify-center text-white"
                     style="background-color:{{ $agenda->color ?? 'rgba(255,255,255,0.2)' }}">
                    <span class="text-2xl font-bold leading-none">{{ $agenda->start_date->format('d') }}</span>
                    <span class="text-xs uppercase">{{ $agenda->start_date->format('M') }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-white text-base mb-1 truncate">{{ $agenda->title }}</h3>
                    @if($agenda->location)
                    <div class="flex items-center gap-1.5 text-white/70 text-sm">
                        <i class="fas fa-map-marker-alt text-xs"></i>
                        <span class="truncate">{{ $agenda->location }}</span>
                    </div>
                    @endif
                    @if($agenda->description)
                    <p class="text-white/60 text-xs mt-1 line-clamp-2">{{ $agenda->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== ACHIEVEMENTS ===== --}}
@if($achievements->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-divider"></div>
            <h2 class="section-title">Prestasi Unggulan</h2>
            <p class="section-subtitle">Kebanggaan dan pencapaian siswa-siswi kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($achievements as $achievement)
            <div class="card p-6 group hover:border-blue-200" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 150 }}">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                        <i class="fas fa-trophy text-amber-500 group-hover:text-white transition-colors"></i>
                    </div>
                    <div>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $achievement->level === 'Nasional' ? 'bg-blue-100 text-blue-800' :
                               ($achievement->level === 'Internasional' ? 'bg-purple-100 text-purple-700' :
                               ($achievement->level === 'Provinsi' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ $achievement->level }}
                        </span>
                        <div class="text-xs text-gray-400 mt-1">{{ $achievement->year }}</div>
                    </div>
                </div>
                <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $achievement->title }}</h3>
                @if($achievement->description)
                <p class="text-gray-500 text-sm line-clamp-2">{{ $achievement->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
        <div class="text-center" data-aos="fade-up">
            <a href="{{ route('achievements.index') }}" class="btn-outline">Lihat Semua Prestasi</a>
        </div>
    </div>
</section>
@endif

{{-- ===== EXTRACURRICULARS ===== --}}
@if($extracurriculars->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-divider"></div>
            <h2 class="section-title">Ekstrakurikuler</h2>
            <p class="section-subtitle">Berbagai kegiatan pengembangan diri di luar jam pelajaran</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-10">
            @foreach($extracurriculars as $ekskul)
            <a href="{{ route('extracurriculars.index') }}" class="block p-4 rounded-2xl bg-gray-50/60 hover:bg-white border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300 text-center group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 100 }}">
                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl overflow-hidden bg-gradient-to-br {{ $ekskul->icon_theme['bg'] }} flex items-center justify-center shadow-sm group-hover:scale-110 group-hover:shadow transition-all duration-300">
                    @if($ekskul->image)
                    <img src="{{ asset('storage/'.$ekskul->image) }}" alt="{{ $ekskul->name }}" class="w-full h-full object-cover">
                    @else
                    <i class="{{ $ekskul->icon }} {{ $ekskul->icon_theme['text'] }} text-2xl"></i>
                    @endif
                </div>
                <div class="font-bold text-gray-800 group-hover:text-blue-700 text-sm transition-colors line-clamp-2">{{ $ekskul->name }}</div>
                @if($ekskul->schedule)
                <div class="text-xs text-gray-400 mt-1 flex items-center justify-center gap-1">
                    <i class="fas fa-clock text-[10px]"></i>
                    <span>{{ $ekskul->schedule }}</span>
                </div>
                @endif
            </a>
            @endforeach
        </div>
        <div class="text-center" data-aos="fade-up">
            <a href="{{ route('extracurriculars.index') }}" class="btn-outline">Lihat Semua</a>
        </div>
    </div>
</section>
@endif

{{-- ===== GALLERY PREVIEW ===== --}}
@if($photo_albums->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-divider"></div>
            <h2 class="section-title">Galeri Foto</h2>
            <p class="section-subtitle">Momen dan kenangan indah kegiatan sekolah</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6 mb-10">
            @foreach($photo_albums as $album)
            <div class="w-full {{ $photo_albums->count() == 1 ? 'max-w-md' : ($photo_albums->count() == 2 ? 'sm:max-w-md md:w-[calc(50%-12px)]' : 'sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]') }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 150 }}">
                <a href="{{ route('gallery.album', $album) }}" class="card group block overflow-hidden">
                    <div class="aspect-video overflow-hidden bg-gray-100 relative">
                        @if($album->cover)
                        <img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @elseif($album->photos && $album->photos->isNotEmpty())
                        <img src="{{ asset('storage/'.$album->photos->first()->image) }}" alt="{{ $album->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                            <i class="fas fa-images text-blue-300 text-5xl"></i>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/30 to-transparent flex items-end">
                            <div class="p-5 w-full">
                                <h3 class="font-bold text-white text-lg drop-shadow-sm group-hover:text-blue-200 transition-colors">{{ $album->name }}</h3>
                                <div class="text-white/80 text-sm mt-1 flex items-center gap-1.5">
                                    <i class="fas fa-images"></i>
                                    <span>{{ $album->photos_count ?? ($album->photos ? $album->photos->count() : 0) }} foto</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center" data-aos="fade-up">
            <a href="{{ route('gallery.photos') }}" class="btn-outline">Lihat Galeri Lengkap <i class="fas fa-arrow-right text-sm"></i></a>
        </div>
    </div>
</section>
@endif

{{-- ===== SERVICES ===== --}}
@if($services->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="section-header" data-aos="fade-up">
            <div class="section-divider"></div>
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Berbagai layanan yang tersedia untuk siswa, orang tua, dan masyarakat</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <a href="{{ route('services.index') }}#service-{{ $service->id }}" class="card p-6 group hover:border-blue-300 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between block bg-white rounded-2xl border border-gray-100" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 150 }}">
                <div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-800 transition-colors">
                        <i class="{{ $service->icon ?? 'fas fa-concierge-bell' }} text-blue-800 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 group-hover:text-blue-800 transition-colors">{{ $service->title }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">{{ $service->description }}</p>
                </div>
                <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-semibold text-blue-700 group-hover:text-blue-800">
                    <span>Lihat Rincian Layanan</span>
                    <i class="fas fa-arrow-right transform group-hover:translate-x-1.5 transition-transform duration-200"></i>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-10" data-aos="fade-up">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 font-semibold text-blue-800 hover:text-white bg-blue-50 hover:bg-blue-800 px-6 py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                <span>Lihat Semua Layanan ({{ \App\Models\Service::where('is_active', true)->count() }})</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ===== CONTACT CTA ===== --}}
<section class="py-20 bg-gradient-to-br from-blue-800 to-gray-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 left-10 w-80 h-80 border border-white rounded-full"></div>
        <div class="absolute bottom-10 right-10 w-60 h-60 border border-white rounded-full"></div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div data-aos="fade-right">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Hubungi Kami</h2>
                <p class="text-white/75 mb-8">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami.</p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-white/85">
                        <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-sm"></i>
                        </div>
                        <span class="text-sm leading-relaxed">{{ \App\Models\Setting::get('contact_address','-') }}</span>
                    </li>
                    <li class="flex items-center gap-3 text-white/85">
                        <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-sm"></i>
                        </div>
                        <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="text-sm hover:text-white">{{ \App\Models\Setting::get('contact_phone','-') }}</a>
                    </li>
                    <li class="flex items-center gap-3 text-white/85">
                        <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="text-sm hover:text-white">{{ \App\Models\Setting::get('contact_email','-') }}</a>
                    </li>
                </ul>
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="{{ route('contact.index') }}" class="btn-white">Kirim Pesan <i class="fas fa-paper-plane text-sm"></i></a>
                    @if(\App\Models\Setting::get('contact_whatsapp'))
                    <a href="https://wa.me/{{ \App\Models\Setting::get('contact_whatsapp') }}" target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2.5 rounded-lg transition-all inline-flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    @endif
                </div>
            </div>
            @if(\App\Models\Setting::get('contact_maps_embed'))
            <div class="rounded-2xl overflow-hidden shadow-2xl h-64 lg:h-80" data-aos="fade-left">
                <iframe src="{{ \App\Models\Setting::get('contact_maps_embed') }}"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="grayscale hover:grayscale-0 transition-all duration-500"></iframe>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection
