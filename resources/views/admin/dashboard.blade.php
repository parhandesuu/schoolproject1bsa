@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
@php $schoolName = \App\Models\Setting::get('school_name', 'SMP Negeri 1 Buay Sandang Aji'); @endphp

{{-- Welcome --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
    <p class="text-gray-500 text-sm mt-1">{{ $schoolName }} &mdash; Panel Admin</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('admin.posts.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                <i class="fas fa-newspaper text-blue-600 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['posts'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Total Berita</div>
        <div class="text-xs text-gray-400 mt-0.5">Artikel dipublikasikan</div>
    </a>

    <a href="{{ route('admin.comments.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-yellow-500 transition-colors">
                <i class="fas fa-comments text-yellow-600 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['pending_comments'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Komentar Pending</div>
        <div class="text-xs text-yellow-500 mt-0.5">Perlu moderasi</div>
    </a>

    <a href="{{ route('admin.contacts.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-600 transition-colors">
                <i class="fas fa-envelope text-green-600 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['unread_contacts'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Pesan Masuk</div>
        <div class="text-xs text-gray-400 mt-0.5">Belum dibaca</div>
    </a>

    <a href="{{ route('admin.teachers.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                <i class="fas fa-users text-purple-600 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['teachers'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Guru & Staff</div>
        <div class="text-xs text-gray-400 mt-0.5">Total tenaga pendidik</div>
    </a>

    <a href="{{ route('admin.achievements.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-500 transition-colors">
                <i class="fas fa-trophy text-orange-500 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['achievements'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Prestasi</div>
        <div class="text-xs text-gray-400 mt-0.5">Penghargaan tercatat</div>
    </a>

    <a href="{{ route('admin.announcements.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center group-hover:bg-red-600 transition-colors">
                <i class="fas fa-bullhorn text-red-500 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['announcements'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Pengumuman</div>
        <div class="text-xs text-gray-400 mt-0.5">Aktif ditampilkan</div>
    </a>

    <a href="{{ route('admin.extracurriculars.index') }}" class="admin-card hover:shadow-md transition-shadow group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center group-hover:bg-cyan-600 transition-colors">
                <i class="fas fa-running text-cyan-600 group-hover:text-white transition-colors"></i>
            </div>
            <span class="text-2xl font-bold text-gray-900">{{ $stats['extracurriculars'] }}</span>
        </div>
        <div class="text-sm font-medium text-gray-600">Ekstrakurikuler</div>
        <div class="text-xs text-gray-400 mt-0.5">Program aktif</div>
    </a>

    <div class="admin-card bg-gradient-to-br from-blue-700 to-blue-900 text-white">
        <div class="text-xs font-medium opacity-75 mb-1">Quick Actions</div>
        <div class="space-y-2 mt-2">
            <a href="{{ route('admin.posts.create') }}" class="block text-xs bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-plus mr-1"></i>Tambah Berita</a>
            <a href="{{ route('admin.announcements.create') }}" class="block text-xs bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-plus mr-1"></i>Pengumuman</a>
        </div>
    </div>
</div>

{{-- Tables Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Latest Posts --}}
    <div class="admin-card p-0 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Berita Terbaru</h3>
            <a href="{{ route('admin.posts.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($latestPosts as $post)
            <div class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50/50 transition-colors">
                @if($post->thumbnail)
                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                @else
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-newspaper text-blue-500 text-sm"></i>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm font-medium text-gray-800 hover:text-blue-700 truncate block">{{ $post->title }}</a>
                    <div class="text-xs text-gray-400">{{ $post->created_at->format('d M Y') }}</div>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0 {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $post->status === 'published' ? 'Publish' : 'Draft' }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada berita</div>
            @endforelse
        </div>
    </div>

    {{-- Latest Contacts --}}
    <div class="admin-card p-0 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Pesan Masuk Terbaru</h3>
            <a href="{{ route('admin.contacts.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($latestContacts as $contact)
            <a href="{{ route('admin.contacts.show', $contact) }}" class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50/50 transition-colors block">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-semibold text-gray-600 text-sm flex-shrink-0">
                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-800">{{ $contact->name }}</span>
                        @if(!$contact->is_read)<span class="w-2 h-2 bg-blue-500 rounded-full"></span>@endif
                    </div>
                    <div class="text-xs text-gray-400 truncate">{{ $contact->subject }}</div>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ $contact->created_at->diffForHumans() }}</span>
            </a>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada pesan masuk</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
