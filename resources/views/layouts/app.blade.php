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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white text-gray-800 antialiased" style="font-family:'Inter',sans-serif;">

    @php $pinnedAnnouncement = \App\Models\Announcement::active()->where('is_pinned', true)->first(); @endphp
    @if($pinnedAnnouncement)
    <div class="bg-blue-700 text-white text-sm py-2 px-4 text-center" x-data="{ show: true }" x-show="show">
        <div class="container mx-auto flex items-center justify-between max-w-7xl">
            <span class="flex-1 text-center"><i class="fas fa-bullhorn mr-2"></i><strong>{{ $pinnedAnnouncement->title }}</strong></span>
            <button @click="show = false" class="ml-4 text-white/80 hover:text-white"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100" x-data="{ open: false }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    @php $logo = \App\Models\Setting::get('school_logo'); @endphp
                    @if($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="Logo" class="h-10 w-auto">
                    @else
                        <div class="w-10 h-10 bg-blue-700 rounded-xl flex items-center justify-center font-bold text-white text-sm">S1</div>
                    @endif
                    <div class="hidden sm:block leading-tight">
                        <div class="font-bold text-blue-700 text-sm">{{ \App\Models\Setting::get('school_short_name', 'SMPN 1') }}</div>
                        <div class="text-xs text-gray-500">{{ \App\Models\Setting::get('school_name', 'UPT SMP Negeri 1 Buay Sandang Aji') }}</div>
                    </div>
                </a>

                <div class="hidden lg:flex items-center space-x-1 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">Beranda</a>

                    <div class="relative group" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                        <button class="px-3 py-2 rounded-lg {{ request()->routeIs('profile.*') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-700 hover:bg-gray-50' }} transition-colors flex items-center gap-1">Profil <i class="fas fa-chevron-down text-xs opacity-60"></i></button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute top-full left-0 w-52 pt-1 z-50">
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm transition-colors">Profil Sekolah</a>
                                <a href="{{ route('profile.history') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm transition-colors">Sejarah</a>
                                <a href="{{ route('profile.vision-mission') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm transition-colors">Visi & Misi</a>
                                <a href="{{ route('profile.principal') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm transition-colors">Sambutan Kepsek</a>
                                <a href="{{ route('profile.organization') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm transition-colors">Struktur Organisasi</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                        <button class="px-3 py-2 rounded-lg text-gray-600 hover:text-blue-700 hover:bg-gray-50 transition-colors flex items-center gap-1">Akademik <i class="fas fa-chevron-down text-xs opacity-60"></i></button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute top-full left-0 w-48 pt-1 z-50">
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2">
                                <a href="{{ route('teachers.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Guru & Staff</a>
                                <a href="{{ route('facilities.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Fasilitas</a>
                                <a href="{{ route('achievements.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Prestasi</a>
                                <a href="{{ route('extracurriculars.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Ekstrakurikuler</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('posts.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('posts.*') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">Berita</a>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                        <button class="px-3 py-2 rounded-lg text-gray-600 hover:text-blue-700 hover:bg-gray-50 transition-colors flex items-center gap-1">Informasi <i class="fas fa-chevron-down text-xs opacity-60"></i></button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute top-full left-0 w-48 pt-1 z-50">
                            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2">
                                <a href="{{ route('agendas.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Agenda</a>
                                <a href="{{ route('announcements.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Pengumuman</a>
                                <a href="{{ route('gallery.photos') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Galeri Foto</a>
                                <a href="{{ route('gallery.videos') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Galeri Video</a>
                                <a href="{{ route('documents.index') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 text-sm">Download</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('services.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('services.*') ? 'text-blue-700 bg-blue-50' : 'text-gray-600 hover:text-blue-700 hover:bg-gray-50' }} transition-colors">Layanan</a>
                    <a href="{{ route('contact.index') }}" class="ml-2 bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">Kontak</a>
                </div>

                <button @click="open = !open" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    <i class="fas text-xl" :class="open ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition class="lg:hidden border-t border-gray-100 bg-white max-h-[80vh] overflow-y-auto">
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
                <a href="{{ route('documents.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Download</a>
                <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-lg text-gray-600 hover:bg-blue-50">Layanan</a>
                <a href="{{ route('contact.index') }}" class="block px-3 py-2.5 rounded-lg text-white bg-blue-700 font-medium text-center mt-2">Kontak</a>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer class="bg-gray-900 text-white mt-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-white text-sm">SMP</div>
                        <div>
                            <div class="font-bold text-white text-sm">{{ \App\Models\Setting::get('school_short_name', 'SMAN 1') }}</div>
                            <div class="text-xs text-gray-400">{{ \App\Models\Setting::get('school_name') }}</div>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-5">{{ \App\Models\Setting::get('school_motto', 'Cerdas, Berkarakter, dan Berprestasi') }}</p>
                    <div class="flex space-x-2">
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
                        @foreach([['Prestasi','achievements.index'],['Ekstrakurikuler','extracurriculars.index'],['Fasilitas','facilities.index'],['Galeri Foto','gallery.photos'],['Galeri Video','gallery.videos'],['Download','documents.index'],['Layanan','services.index']] as [$label,$route])
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

    <button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
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
