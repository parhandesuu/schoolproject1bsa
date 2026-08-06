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
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <style>
        [x-cloak] { display: none !important; }
        html, body { overflow-x: hidden; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden" style="font-family:'Inter',sans-serif;">

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
                <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3 min-w-0 pr-2">
                    @php 
                        $logo1 = \App\Models\Setting::get('school_logo'); 
                        $logo2 = \App\Models\Setting::get('school_logo_2'); 
                    @endphp
                    
                    <div class="flex items-center space-x-1.5 sm:space-x-2 shrink-0">
                        @if($logo1)
                            <img src="{{ asset('storage/'.$logo1) }}" alt="Logo 1" class="h-7 sm:h-8 md:h-9 w-auto">
                        @else
                            <div class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center font-bold text-white text-xs md:text-sm">S1</div>
                        @endif

                        @if($logo2)
                            <img src="{{ asset('storage/'.$logo2) }}" alt="Logo 2" class="h-7 sm:h-8 md:h-9 w-auto">
                        @endif
                    </div>

                    <div class="leading-tight pt-1 min-w-0">
                        <div class="font-bold text-blue-800 text-xs sm:text-sm leading-snug truncate sm:whitespace-normal">{{ \App\Models\Setting::get('school_short_name', 'SMPN 1') }}</div>
                        <div class="hidden sm:block text-[11px] text-gray-500 leading-none">{{ \App\Models\Setting::get('school_motto', 'Berakhlakul Karimah, Sukses Berprestasi, dan Andal') }}</div>
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

    <main class="min-h-screen {{ request()->routeIs('home') ? '' : 'pt-28 md:pt-32' }}">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 border-t border-gray-800/60">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-14 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 xl:gap-12">
                {{-- Kolom 1: Profil Sekolah & Sosmed --}}
                <div class="lg:col-span-4">
                    <div class="flex items-center space-x-3 mb-4">
                        @php 
                            $footerLogo1 = \App\Models\Setting::get('school_logo'); 
                            $footerLogo2 = \App\Models\Setting::get('school_logo_2'); 
                        @endphp
                        @if($footerLogo1)
                            <img src="{{ asset('storage/'.$footerLogo1) }}" alt="Logo Footer 1" class="h-10 md:h-11 w-auto object-contain">
                        @else
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-white text-base">S1</div>
                        @endif

                        @if($footerLogo2)
                            <img src="{{ asset('storage/'.$footerLogo2) }}" alt="Logo Footer 2" class="h-10 md:h-11 w-auto object-contain">
                        @endif

                        <div>
                            <span class="font-bold text-white text-base block leading-snug">{{ \App\Models\Setting::get('school_name', 'SMP Negeri 1 Buay Sandang Aji') }}</span>
                            <span class="text-xs text-blue-400/90 font-medium block">{{ \App\Models\Setting::get('school_motto', 'Berakhlakul Karimah, Sukses Berprestasi, dan Andal') }}</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 max-w-sm">{{ \App\Models\Setting::get('school_description', 'Website resmi sekolah sebagai media informasi dan komunikasi.') }}</p>
                    <div class="flex items-center space-x-2.5">
                        @foreach(\App\Models\SocialMedia::active()->get() as $soc)
                        <a href="{{ $soc->url }}" target="_blank" class="w-9 h-9 bg-gray-800/90 hover:bg-blue-600 border border-gray-700/60 hover:border-blue-500 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-200 text-sm hover:-translate-y-0.5 shadow-sm">
                            <i class="{{ $soc->icon }}"></i>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kolom 2: Navigasi --}}
                <div class="lg:col-span-2">
                    <h4 class="font-semibold text-white mb-5 text-xs uppercase tracking-widest flex items-center gap-2">
                        <span>Navigasi</span>
                        <span class="w-5 h-0.5 bg-blue-500/80 rounded-full inline-block"></span>
                    </h4>
                    <ul class="space-y-2.5">
                        @foreach([['Beranda','home'],['Profil Sekolah','profile.index'],['Visi & Misi','profile.vision-mission'],['Guru & Staff','teachers.index'],['Berita','posts.index'],['Agenda','agendas.index'],['Kontak','contact.index']] as [$label,$route])
                        <li><a href="{{ route($route) }}" class="text-gray-400 hover:text-blue-400 hover:translate-x-1 inline-block text-sm transition-all duration-200">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Kolom 3: Informasi --}}
                <div class="lg:col-span-2">
                    <h4 class="font-semibold text-white mb-5 text-xs uppercase tracking-widest flex items-center gap-2">
                        <span>Informasi</span>
                        <span class="w-5 h-0.5 bg-blue-500/80 rounded-full inline-block"></span>
                    </h4>
                    <ul class="space-y-2.5">
                        @foreach([['Prestasi','achievements.index'],['Ekstrakurikuler','extracurriculars.index'],['Fasilitas','facilities.index'],['Galeri Foto','gallery.photos'],['Galeri Video','gallery.videos'],['Dokumen','documents.index'],['Layanan','services.index']] as [$label,$route])
                        <li><a href="{{ route($route) }}" class="text-gray-400 hover:text-blue-400 hover:translate-x-1 inline-block text-sm transition-all duration-200">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Kolom 4: Kontak --}}
                <div class="lg:col-span-4">
                    <h4 class="font-semibold text-white mb-5 text-xs uppercase tracking-widest flex items-center gap-2">
                        <span>Kontak</span>
                        <span class="w-5 h-0.5 bg-blue-500/80 rounded-full inline-block"></span>
                    </h4>
                    <ul class="space-y-3.5">
                        <li class="flex items-start gap-3 text-sm text-gray-400">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 text-blue-400 mt-0.5">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </div>
                            <span class="leading-relaxed">{{ \App\Models\Setting::get('contact_address','-') }}</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-400">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 text-blue-400">
                                <i class="fas fa-phone text-xs"></i>
                            </div>
                            <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="hover:text-blue-400 transition-colors">{{ \App\Models\Setting::get('contact_phone','-') }}</a>
                        </li>
                        @if(\App\Models\Setting::get('contact_whatsapp'))
                        <li class="flex items-center gap-3 text-sm text-gray-400">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 text-emerald-400">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </div>
                            <a href="https://wa.me/{{ \App\Models\Setting::get('contact_whatsapp') }}" target="_blank" class="hover:text-emerald-400 transition-colors">WhatsApp</a>
                        </li>
                        @endif
                        <li class="flex items-center gap-3 text-sm text-gray-400">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shrink-0 text-blue-400">
                                <i class="fas fa-envelope text-xs"></i>
                            </div>
                            <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="hover:text-blue-400 transition-colors break-all">{{ \App\Models\Setting::get('contact_email','-') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800/80 py-5">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl flex flex-col sm:flex-row items-center justify-between gap-2.5 text-xs text-gray-500 text-center sm:text-left">
                <p>&copy; {{ date('Y') }} <span class="text-gray-400 font-medium">{{ \App\Models\Setting::get('school_name','UPT SMP Negeri 1 Buay Sandang Aji') }}</span>. All rights reserved.</p>
                <p class="text-gray-500">Website Resmi Sekolah</p>
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 900,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
