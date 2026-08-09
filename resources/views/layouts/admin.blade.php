<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('page-title', 'Dashboard') | {{ \App\Models\Setting::get('school_short_name', 'SMAN 1') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 antialiased" style="font-family:'Inter',sans-serif;" 
    x-data="{ 
        sidebarOpen: window.innerWidth >= 1024,
        isMobile: window.innerWidth < 1024,
        sidebarWidth: parseInt(localStorage.getItem('sidebarWidth')) || 256,
        isResizing: false,
        init() {
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 1024;
            });
        },
        startResize() {
            this.isResizing = true;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
        },
        doResize(e) {
            if (this.isResizing) {
                let newWidth = e.clientX;
                if (newWidth < 220) newWidth = 220; 
                if (newWidth > 450) newWidth = 450; 
                this.sidebarWidth = newWidth;
            }
        },
        stopResize() {
            if (this.isResizing) {
                this.isResizing = false;
                document.body.style.cursor = '';
                document.body.style.userSelect = '';
                localStorage.setItem('sidebarWidth', this.sidebarWidth);
            }
        }
    }"
    @mousemove.window="doResize"
    @mouseup.window="stopResize"
>

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="fixed inset-y-0 left-0 z-50 bg-gray-900 transform transition-transform duration-300 flex flex-col"
           :style="`width: ${sidebarWidth}px;`"
           :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', isResizing ? 'transition-none' : 'ease-in-out']" 
           @click.outside="if(isMobile) sidebarOpen = false">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
            @php $logo1 = \App\Models\Setting::get('school_logo'); @endphp
            @if($logo1)
                <img src="{{ Storage::url($logo1) }}" alt="Logo" class="w-10 h-10 object-contain flex-shrink-0">
            @else
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white text-sm flex-shrink-0">S1</div>
            @endif
            <div class="overflow-hidden">
                <div class="font-bold text-white text-sm truncate">{{ \App\Models\Setting::get('school_short_name','SMAN 1') }}</div>
                <div class="text-xs text-gray-500">Admin Panel ({{ ucfirst(auth()->user()->roles->first()->name ?? auth()->user()->role ?? 'Staff') }})</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt icon"></i><span>Dashboard</span>
            </a>

            {{-- Approval Menu (Editor & Admin) --}}
            @if(auth()->user()->can('berita.publish') || auth()->user()->can('halaman.publish'))
                @php
                    $pendingCount = \App\Models\Post::where('status', 'pending_review')->count() + \App\Models\Page::where('status', 'pending_review')->count();
                @endphp
                <a href="{{ route('admin.approvals.index') }}" class="sidebar-link {{ request()->routeIs('admin.approvals.*') ? 'active' : '' }}">
                    <i class="fas fa-check-double icon text-amber-400"></i>
                    <span class="flex-1 flex items-center justify-between">
                        <span>Persetujuan</span>
                        @if($pendingCount > 0)
                            <span class="bg-amber-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </span>
                </a>
            @endif

            {{-- Kelola Home --}}
            @canany(['hero-slider.read', 'slider.read'])
            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelola Home</p>
            @canany(['hero-slider.read', 'slider.read'])
            <a href="{{ route('admin.hero-sliders.index') }}" class="sidebar-link {{ request()->routeIs('admin.hero-sliders.*') ? 'active' : '' }}">
                <i class="fas fa-images icon"></i><span>Hero Slider</span>
            </a>
            @endcanany
            @endcanany

            {{-- Profil Sekolah --}}
            @canany(['halaman.read', 'halaman-statis.read', 'guru.read', 'staff-guru.read', 'fasilitas.read', 'prestasi.read', 'ekstrakurikuler.read', 'ekskul.read'])
            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Profil Sekolah</p>
            @canany(['halaman.read', 'halaman-statis.read'])
            <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt icon"></i><span>Halaman Statis</span>
            </a>
            @endcanany
            @canany(['guru.read', 'staff-guru.read'])
            <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="fas fa-users icon"></i><span>Guru & Staff</span>
            </a>
            @endcanany
            @can('fasilitas.read')
            <a href="{{ route('admin.facilities.index') }}" class="sidebar-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                <i class="fas fa-building icon"></i><span>Fasilitas</span>
            </a>
            @endcan
            @can('prestasi.read')
            <a href="{{ route('admin.achievements.index') }}" class="sidebar-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                <i class="fas fa-trophy icon"></i><span>Prestasi</span>
            </a>
            @endcan
            @canany(['ekstrakurikuler.read', 'ekskul.read'])
            <a href="{{ route('admin.extracurriculars.index') }}" class="sidebar-link {{ request()->routeIs('admin.extracurriculars.*') ? 'active' : '' }}">
                <i class="fas fa-running icon"></i><span>Ekstrakurikuler</span>
            </a>
            @endcanany
            @endcanany

            {{-- Konten --}}
            @canany(['kategori.read', 'kategori-berita.read', 'berita.read', 'komentar.read', 'agenda.read', 'pengumuman.read'])
            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Konten</p>
            @canany(['kategori.read', 'kategori-berita.read'])
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags icon"></i><span>Kategori</span>
            </a>
            @endcanany
            @can('berita.read')
            <a href="{{ route('admin.posts.index') }}" class="sidebar-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper icon"></i><span>Berita</span>
            </a>
            @endcan
            @can('komentar.read')
            <a href="{{ route('admin.comments.index') }}" class="sidebar-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <i class="fas fa-comments icon"></i>
                <span class="flex-1 flex items-center justify-between">
                    <span>Komentar</span>
                    @php $pendingComments = \App\Models\Comment::where('status','pending')->count(); @endphp
                    @if($pendingComments > 0)<span class="bg-yellow-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $pendingComments }}</span>@endif
                </span>
            </a>
            @endcan
            @can('agenda.read')
            <a href="{{ route('admin.agendas.index') }}" class="sidebar-link {{ request()->routeIs('admin.agendas.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt icon"></i><span>Agenda</span>
            </a>
            @endcan
            @can('pengumuman.read')
            <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn icon"></i><span>Pengumuman</span>
            </a>
            @endcan
            @endcanany

            {{-- Media --}}
            @canany(['galeri-foto.read', 'galeri_foto.read', 'galeri-video.read', 'galeri_video.read', 'dokumen.read'])
            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Media</p>
            @canany(['galeri-foto.read', 'galeri_foto.read'])
            <a href="{{ route('admin.photo-albums.index') }}" class="sidebar-link {{ request()->routeIs('admin.photo-albums.*') ? 'active' : '' }}">
                <i class="fas fa-camera icon"></i><span>Galeri Foto</span>
            </a>
            @endcanany
            @canany(['galeri-video.read', 'galeri_video.read'])
            <a href="{{ route('admin.video-galleries.index') }}" class="sidebar-link {{ request()->routeIs('admin.video-galleries.*') ? 'active' : '' }}">
                <i class="fas fa-video icon"></i><span>Galeri Video</span>
            </a>
            @endcanany
            @can('dokumen.read')
            <a href="{{ route('admin.documents.index') }}" class="sidebar-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                <i class="fas fa-file-download icon"></i><span>Dokumen</span>
            </a>
            @endcan
            @endcanany

            {{-- Layanan & Lainnya --}}
            @canany(['layanan.read', 'kontak.read', 'pesan.read', 'statistik.read', 'media-sosial.read', 'medsos.read', 'survei.read', 'skm.read'])
            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Layanan & Lainnya</p>
            @can('layanan.read')
            <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell icon"></i><span>Layanan</span>
            </a>
            @endcan
            @canany(['survei.read', 'skm.read', 'layanan.read'])
            <a href="{{ route('admin.surveys.index') }}" class="sidebar-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">
                <i class="fas fa-poll-h icon"></i><span>Survei SKM</span>
            </a>
            @endcanany
            @canany(['kontak.read', 'pesan.read'])

            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="fas fa-envelope icon"></i>
                <span class="flex-1 flex items-center justify-between">
                    <span>Pesan Masuk</span>
                    @php $unreadContacts = \App\Models\Contact::where('status','unread')->count(); @endphp
                    @if($unreadContacts > 0)<span class="bg-blue-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $unreadContacts }}</span>@endif
                </span>
            </a>
            @endcanany
            @can('statistik.read')
            <a href="{{ route('admin.statistics.index') }}" class="sidebar-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar icon"></i><span>Statistik</span>
            </a>
            @endcan
            @canany(['media-sosial.read', 'medsos.read'])
            <a href="{{ route('admin.social-media.index') }}" class="sidebar-link {{ request()->routeIs('admin.social-media.*') ? 'active' : '' }}">
                <i class="fas fa-share-alt icon"></i><span>Social Media</span>
            </a>
            @endcanany
            @endcanany

            {{-- Pengaturan --}}
            @canany(['pengaturan.read', 'settings.read', 'users.read', 'user.read', 'activity-log.read', 'log.read'])
            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengaturan</p>
            @canany(['pengaturan.read', 'settings.read'])
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog icon"></i><span>Pengaturan</span>
            </a>
            @endcanany
            @canany(['users.read', 'user.read'])
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog icon"></i><span>Pengguna</span>
            </a>
            @endcanany
            @canany(['activity-log.read', 'log.read'])
            <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <i class="fas fa-history icon"></i><span>Log Aktivitas</span>
            </a>
            @endcanany
            @endcanany
        </nav>

        {{-- Footer --}}
        <div class="px-3 py-4 border-t border-gray-800">
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link text-xs">
                <i class="fas fa-external-link-alt icon"></i><span>Lihat Website</span>
            </a>
        </div>
        {{-- Resizer Handle --}}
        <div class="absolute inset-y-0 right-0 w-1.5 cursor-col-resize hover:bg-blue-600/50 z-50 flex flex-col justify-center items-center group" 
             @mousedown.prevent="startResize"
             :class="{ 'bg-blue-600/50': isResizing }">
            <div class="h-10 w-0.5 bg-gray-500 rounded-full group-hover:bg-blue-400" :class="{ 'bg-blue-400': isResizing }"></div>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen && isMobile" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition></div>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0 transition-all duration-300" 
         :class="{ 'transition-none': isResizing, 'ease-in-out': !isResizing }"
         :style="!isMobile && sidebarOpen ? `margin-left: ${sidebarWidth}px;` : 'margin-left: 0px;'">

        {{-- TOP HEADER --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-4 sm:px-6 h-16">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-base font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        @hasSection('breadcrumb')
                        <nav class="text-xs text-gray-400">@yield('breadcrumb')</nav>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3" x-data="{ userMenuOpen: false }">
                    {{-- Notifications Bell --}}
                    @php
                        $unreadNotifCount = auth()->user()->unreadNotifications->count();
                    @endphp
                    <a href="{{ route('admin.notifications.index') }}" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-xl transition-colors" title="Pemberitahuan">
                        <i class="fas fa-bell text-base"></i>
                        @if($unreadNotifCount > 0)
                            <span class="absolute top-1.5 right-1.5 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-white text-[9px] font-bold items-center justify-center">
                                    {{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}
                                </span>
                            </span>
                        @endif
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center font-semibold text-blue-700 text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <div class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-400">{{ ucfirst(auth()->user()->roles->first()->name ?? auth()->user()->role ?? 'User') }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 hidden sm:block"></i>
                        </button>
                        <div x-show="userMenuOpen" @click.outside="userMenuOpen = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50" style="display: none;">
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-circle w-4 text-gray-400"></i>Profil Saya
                            </a>
                            @can('pengaturan.read')
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog w-4 text-gray-400"></i>Pengaturan
                            </a>
                            @endcan
                            <div class="border-t border-gray-100 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-4"></i>Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="text-sm text-green-700 flex-1">{{ session('success') }}</span>
                <button @click="show = false" class="text-green-400 hover:text-green-600"><i class="fas fa-times"></i></button>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3" x-data="{ show: true }" x-show="show">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span class="text-sm text-red-700 flex-1">{{ session('error') }}</span>
                <button @click="show = false" class="text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
            </div>
            @endif
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl" x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <span class="text-sm font-medium text-red-700">Terdapat kesalahan:</span>
                    <button @click="show = false" class="ml-auto text-red-400"><i class="fas fa-times"></i></button>
                </div>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
