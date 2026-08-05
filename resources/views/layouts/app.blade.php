<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - {{ \App\Models\Setting::get('school_name', config('app.name')) }}</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', ''))">
    <meta name="keywords" content="{{ \App\Models\Setting::get('meta_keywords', '') }}">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', ''))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white text-gray-800 antialiased" style="font-family:'Inter',sans-serif;">

    @php $pinnedAnnouncement = \App\Models\Announcement::active()->where('is_pinned', true)->first(); @endphp
    @if($pinnedAnnouncement)
    <div class="bg-blue-700 text-white text-sm py-2 px-4 text-center" x-data="{ show: true }" x-show="show" x-cloak>
        <div class="container mx-auto flex items-center justify-between max-w-7xl">
            <span class="flex-1 text-center"><i class="fas fa-bullhorn mr-2"></i><strong>{{ $pinnedAnnouncement->title }}</strong></span>
            <button @click="show = false" class="ml-4 text-white/80 hover:text-white"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    <nav class="fixed top-6 md:top-7 left-0 right-0 z-50 mx-4 md:mx-auto max-w-7xl transition-all duration-300" x-data="{ open: false }">
        <div class="bg-white/90 backdrop-blur-xl shadow-md shadow-blue-900/5 border border-white/60 rounded-full px-4 lg:px-6 py-0.5">
            <div class="flex items-center justify-between h-14 lg:h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    @php 
                        $logo1 = \App\Models\Setting::get('school_logo'); 
                        $logo2 = \App\Models\Setting::get('school_logo_2');
                    @endphp
                    
                    <div class="flex items-center space-x-2">
                        @if($logo1)
                            <img src="{{ asset('storage/'.$logo1) }}" alt="Logo 1" class="h-8 md:h-9 w-auto">
                        @else
                            <div class="w-8 h-8 md:w-9 md:h-9 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center font-bold text-white text-xs md:text-sm">S1</div>
                        @endif

                        @if($logo2)
                            <img src="{{ asset('storage/'.$logo2) }}" alt="Logo 2" class="h-8 md:h-9 w-auto">
                        @endif
                    </div>

                    <div class="hidden sm:block leading-tight pt-1">
                        <div class="font-bold text-blue-800 text-sm leading-snug">{{ \App\Models\Setting::get('school_short_name', 'SMPN 1') }}</div>
                        <div class="text-[11px] text-gray-500 leading-none">{{ \App\Models\Setting::get('school_motto', 'Berakhlakul Karimah, Sukses Berprestasi, dan Andal') }}</div>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-1 xl:gap-1.5 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-full inline-flex items-center justify-center transition-all duration-200 {{ request()->routeIs('home') ? 'text-blue-800 bg-blue-50 font-semibold' : 'text-gray-600 hover:text-blue-800 hover:bg-gray-50' }}">Beranda</a>

                    <div class="relative group" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false" @click.outside="open=false">
                        <button @click="open = !open" type="button" class="px-3 py-1.5 rounded-full inline-flex items-center justify-center gap-1.5 transition-all duration-200 {{ request()->routeIs('profile.*') ? 'text-blue-800 bg-blue-50 font-semibold' : 'text-gray-600 hover:text-blue-800 hover:bg-gray-50' }}">
                            <span>Profil</span>
                            <i class="fas fa-chevron-down text-[10px] opacity-60 transition-transform duration-200" :class="open ? 'rotate-180 opacity-100' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute top-full left-0 w-52 pt-1.5 z-50">
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 py-2">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Profil Sekolah</a>
                                <a href="{{ route('profile.history') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Sejarah</a>
                                <a href="{{ route('profile.vision-mission') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Visi & Misi</a>
                                <a href="{{ route('profile.principal') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Sambutan Kepsek</a>
                                <a href="{{ route('profile.organization') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Struktur Organisasi</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false" @click.outside="open=false">
                        <button @click="open = !open" type="button" class="px-3 py-1.5 rounded-full inline-flex items-center justify-center gap-1.5 transition-all duration-200 {{ request()->routeIs('teachers.*', 'facilities.*', 'achievements.*', 'extracurriculars.*') ? 'text-blue-800 bg-blue-50 font-semibold' : 'text-gray-600 hover:text-blue-800 hover:bg-gray-50' }}">
                            <span>Akademik</span>
                            <i class="fas fa-chevron-down text-[10px] opacity-60 transition-transform duration-200" :class="open ? 'rotate-180 opacity-100' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute top-full left-0 w-48 pt-1.5 z-50">
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 py-2">
                                <a href="{{ route('teachers.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Guru & Staff</a>
                                <a href="{{ route('facilities.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Fasilitas</a>
                                <a href="{{ route('achievements.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Prestasi</a>
                                <a href="{{ route('extracurriculars.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Ekstrakurikuler</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('posts.index') }}" class="px-3 py-1.5 rounded-full inline-flex items-center justify-center transition-all duration-200 {{ request()->routeIs('posts.*') ? 'text-blue-800 bg-blue-50 font-semibold' : 'text-gray-600 hover:text-blue-800 hover:bg-gray-50' }}">Berita</a>

                    <div class="relative group" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false" @click.outside="open=false">
                        <button @click="open = !open" type="button" class="px-3 py-1.5 rounded-full inline-flex items-center justify-center gap-1.5 transition-all duration-200 {{ request()->routeIs('agendas.*', 'announcements.*', 'gallery.*', 'documents.*') ? 'text-blue-800 bg-blue-50 font-semibold' : 'text-gray-600 hover:text-blue-800 hover:bg-gray-50' }}">
                            <span>Informasi</span>
                            <i class="fas fa-chevron-down text-[10px] opacity-60 transition-transform duration-200" :class="open ? 'rotate-180 opacity-100' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute top-full left-0 w-48 pt-1.5 z-50">
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 py-2">
                                <a href="{{ route('agendas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Agenda</a>
                                <a href="{{ route('announcements.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Pengumuman</a>
                                <a href="{{ route('gallery.photos') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Galeri Foto</a>
                                <a href="{{ route('gallery.videos') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Galeri Video</a>
                                <a href="{{ route('documents.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 text-sm transition-colors">Dokumen</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('services.index') }}" class="px-3 py-1.5 rounded-full inline-flex items-center justify-center transition-all duration-200 {{ request()->routeIs('services.*') ? 'text-blue-800 bg-blue-50 font-semibold' : 'text-gray-600 hover:text-blue-800 hover:bg-gray-50' }}">Layanan</a>
                    <a href="{{ route('contact.index') }}" class="ml-1 px-4 py-1.5 rounded-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium inline-flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md">Kontak</a>
                </div>

                <button @click="open = !open" class="lg:hidden p-2 rounded-full text-gray-600 hover:bg-gray-100">
                    <i class="fas text-xl" :class="open ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <div x-show="open" x-cloak x-transition class="lg:hidden mt-4 border border-gray-100 rounded-3xl bg-white/95 backdrop-blur-xl shadow-xl max-h-[80vh] overflow-y-auto">
            <div class="px-4 py-3 space-y-1 text-sm">
                <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 font-medium">Beranda</a>
                <p class="px-3 pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Profil</p>
                <a href="{{ route('profile.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Profil Sekolah</a>
                <a href="{{ route('profile.history') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Sejarah</a>
                <a href="{{ route('profile.vision-mission') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Visi & Misi</a>
                <a href="{{ route('profile.principal') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Sambutan Kepsek</a>
                <a href="{{ route('profile.organization') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Struktur Organisasi</a>
                <p class="px-3 pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akademik</p>
                <a href="{{ route('teachers.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Guru & Staff</a>
                <a href="{{ route('facilities.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Fasilitas</a>
                <a href="{{ route('achievements.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Prestasi</a>
                <a href="{{ route('extracurriculars.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Ekstrakurikuler</a>
                <p class="px-3 pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Informasi</p>
                <a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Berita</a>
                <a href="{{ route('agendas.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Agenda</a>
                <a href="{{ route('announcements.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Pengumuman</a>
                <a href="{{ route('gallery.photos') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Galeri Foto</a>
                <a href="{{ route('gallery.videos') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Galeri Video</a>
                <a href="{{ route('documents.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Dokumen</a>
                <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Layanan</a>
                <a href="{{ route('contact.index') }}" class="block px-3 py-2.5 rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-800 font-medium text-center mt-2">Kontak</a>
            </div>
        </div>
    </nav>

    <main class="{{ request()->routeIs('home') ? '' : 'pt-28 md:pt-32' }}">@yield('content')</main>

    <footer class="bg-gray-900 text-white mt-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <div class="flex flex-col space-y-4 mb-5">
                        @php 
                            $logo1 = \App\Models\Setting::get('school_logo'); 
                            $logo2 = \App\Models\Setting::get('school_logo_2');
                        @endphp
                        
                        <div class="flex items-center space-x-3">
                            @if($logo1)
                                <img src="{{ asset('storage/'.$logo1) }}" alt="Logo 1" class="h-12 w-auto">
                            @else
                                <div class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center font-bold text-white text-sm">S1</div>
                            @endif

                            @if($logo2)
                                <img src="{{ asset('storage/'.$logo2) }}" alt="Logo 2" class="h-12 w-auto">
                            @endif
                        </div>
                        <div>
                            <div class="font-bold text-white text-base mb-1 leading-tight">{{ \App\Models\Setting::get('school_name', 'UPT SMP Negeri 1 Buay Sandang Aji') }}</div>
                            <div class="text-sm text-gray-400">{{ \App\Models\Setting::get('school_short_name', 'SMPN 1 BSA') }}</div>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">{{ \App\Models\Setting::get('school_motto', 'Cerdas, Berkarakter, dan Berprestasi') }}</p>
                    <div class="flex space-x-3">
                        @foreach(\App\Models\SocialMedia::active()->get() as $social)
                        <a href="{{ $social->url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg flex items-center justify-center text-sm hover:scale-110 transition-transform" style="background-color:{{ $social->color ?? '#1e40af' }}">
                            <i class="{{ $social->icon }} text-white text-sm"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5 text-sm uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2.5">
                        @foreach([['Beranda','home'],['Profil Sekolah','profile.index'],['Visi & Misi','profile.vision-mission'],['Guru & Staff','teachers.index'],['Berita','posts.index'],['Agenda','agendas.index'],['Kontak','contact.index']] as [$label,$route])
                        <li><a href="{{ route($route) }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5 text-sm uppercase tracking-wider">Informasi</h4>
                    <ul class="space-y-2.5">
                        @foreach([['Prestasi','achievements.index'],['Ekstrakurikuler','extracurriculars.index'],['Fasilitas','facilities.index'],['Galeri Foto','gallery.photos'],['Galeri Video','gallery.videos'],['Dokumen','documents.index'],['Layanan','services.index']] as [$label,$route])
                        <li><a href="{{ route($route) }}" class="text-gray-400 hover:text-white text-sm transition-colors">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5 text-sm uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-sm text-gray-400"><i class="fas fa-map-marker-alt text-blue-400 mt-0.5 w-4 shrink-0"></i><span>{{ \App\Models\Setting::get('contact_address','-') }}</span></li>
                        <li class="flex items-center gap-3 text-sm text-gray-400"><i class="fas fa-phone text-blue-400 w-4 shrink-0"></i><a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="hover:text-white">{{ \App\Models\Setting::get('contact_phone','-') }}</a></li>
                        @if(\App\Models\Setting::get('contact_whatsapp'))
                        <li class="flex items-center gap-3 text-sm text-gray-400"><i class="fab fa-whatsapp text-green-400 w-4 shrink-0"></i><a href="https://wa.me/{{ \App\Models\Setting::get('contact_whatsapp') }}" target="_blank" class="hover:text-white">WhatsApp</a></li>
                        @endif
                        <li class="flex items-center gap-3 text-sm text-gray-400"><i class="fas fa-envelope text-blue-400 w-4 shrink-0"></i><a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="hover:text-white">{{ \App\Models\Setting::get('contact_email','-') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 py-5">
            <div class="container mx-auto px-4 max-w-7xl text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::get('school_name','UPT SMP Negeri 1 Buay Sandang Aji') }}. All rights reserved. | Website Resmi Sekolah
            </div>
        </div>
    </footer>

    <button id="backToTop" class="fixed bottom-6 right-6 z-50 opacity-0 pointer-events-none transition-opacity duration-300" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all hover:-translate-y-1">
            <i class="fas fa-arrow-up text-white text-lg"></i>
        </div>
    </button>
    <script>
        const btt = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            btt.style.opacity = window.scrollY > 300 ? '1' : '0';
            btt.style.pointerEvents = window.scrollY > 300 ? 'auto' : 'none';
        });
    </script>
    @stack('scripts')
</body>
</html>
