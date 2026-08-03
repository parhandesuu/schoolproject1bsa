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
<body class="bg-gray-100 antialiased" style="font-family:'Inter',sans-serif;" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform transition-transform duration-300 ease-in-out flex flex-col"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" @click.outside="if(window.innerWidth < 1024) sidebarOpen = false">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
            <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white text-sm flex-shrink-0">S1</div>
            <div class="overflow-hidden">
                <div class="font-bold text-white text-sm truncate">{{ \App\Models\Setting::get('school_short_name','SMAN 1') }}</div>
                <div class="text-xs text-gray-500">Admin Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt icon"></i><span>Dashboard</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelola Home</p>
            <a href="{{ route('admin.hero-sliders.index') }}" class="sidebar-link {{ request()->routeIs('admin.hero-sliders.*') ? 'active' : '' }}">
                <i class="fas fa-images icon"></i><span>Hero Slider</span>
            </a>
            <a href="{{ route('admin.logos.index') }}" class="sidebar-link {{ request()->routeIs('admin.logos.*') ? 'active' : '' }}">
                <i class="fas fa-medal icon"></i><span>Logo</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Profil Sekolah</p>
            <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt icon"></i><span>Halaman Statis</span>
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="fas fa-users icon"></i><span>Guru & Staff</span>
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="sidebar-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                <i class="fas fa-building icon"></i><span>Fasilitas</span>
            </a>
            <a href="{{ route('admin.achievements.index') }}" class="sidebar-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                <i class="fas fa-trophy icon"></i><span>Prestasi</span>
            </a>
            <a href="{{ route('admin.extracurriculars.index') }}" class="sidebar-link {{ request()->routeIs('admin.extracurriculars.*') ? 'active' : '' }}">
                <i class="fas fa-running icon"></i><span>Ekstrakurikuler</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Konten</p>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags icon"></i><span>Kategori</span>
            </a>
            <a href="{{ route('admin.posts.index') }}" class="sidebar-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper icon"></i><span>Berita</span>
            </a>
            <a href="{{ route('admin.comments.index') }}" class="sidebar-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <i class="fas fa-comments icon"></i><span>Komentar
                    @php $pendingComments = \App\Models\Comment::where('status','pending')->count(); @endphp
                    @if($pendingComments > 0)<span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingComments }}</span>@endif
                </span>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="sidebar-link {{ request()->routeIs('admin.agendas.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt icon"></i><span>Agenda</span>
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn icon"></i><span>Pengumuman</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Media</p>
            <a href="{{ route('admin.photo-albums.index') }}" class="sidebar-link {{ request()->routeIs('admin.photo-albums.*') ? 'active' : '' }}">
                <i class="fas fa-camera icon"></i><span>Galeri Foto</span>
            </a>
            <a href="{{ route('admin.video-galleries.index') }}" class="sidebar-link {{ request()->routeIs('admin.video-galleries.*') ? 'active' : '' }}">
                <i class="fas fa-video icon"></i><span>Galeri Video</span>
            </a>
            <a href="{{ route('admin.documents.index') }}" class="sidebar-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                <i class="fas fa-file-download icon"></i><span>Dokumen</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Layanan & Lainnya</p>
            <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell icon"></i><span>Layanan</span>
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="fas fa-envelope icon"></i><span>Pesan Masuk
                    @php $unreadContacts = \App\Models\Contact::where('status','unread')->count(); @endphp
                    @if($unreadContacts > 0)<span class="ml-auto bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadContacts }}</span>@endif
                </span>
            </a>
            <a href="{{ route('admin.statistics.index') }}" class="sidebar-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar icon"></i><span>Statistik</span>
            </a>
            <a href="{{ route('admin.social-media.index') }}" class="sidebar-link {{ request()->routeIs('admin.social-media.*') ? 'active' : '' }}">
                <i class="fas fa-share-alt icon"></i><span>Social Media</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengaturan</p>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog icon"></i><span>Pengaturan</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog icon"></i><span>Pengguna</span>
            </a>
        </nav>

        {{-- Footer --}}
        <div class="px-3 py-4 border-t border-gray-800">
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link text-xs">
                <i class="fas fa-external-link-alt icon"></i><span>Lihat Website</span>
            </a>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen && window.innerWidth < 1024" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition></div>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out" :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-0': !sidebarOpen }">

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

                <div class="flex items-center gap-3" x-data="{ open: false }">
                    {{-- Notif --}}
                    @if(isset($unreadContacts) && $unreadContacts > 0 || \App\Models\Contact::where('status','unread')->count() > 0)
                    <a href="{{ route('admin.contacts.index') }}" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </a>
                    @endif

                    {{-- User Dropdown --}}
                    <div class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center font-semibold text-blue-700 text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <div class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-400">{{ ucfirst(auth()->user()->role) }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 hidden sm:block"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-circle w-4 text-gray-400"></i>Profil Saya
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog w-4 text-gray-400"></i>Pengaturan
                            </a>
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
