@extends('layouts.admin')
@section('page-title','Kelola Berita')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Berita & Artikel</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kelola publikasi dan persetujuan berita sekolah</p>
    </div>
    @can('berita.create')
    <a href="{{ route('admin.posts.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Berita</a>
    @endcan
</div>

{{-- Filters --}}
<div class="admin-card mb-5 p-4">
    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." class="input-field w-48">
        <select name="status" class="input-field w-auto">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
            <option value="pending_review" {{ request('status') === 'pending_review' ? 'selected' : '' }}>Menunggu Review</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
        </select>
        <button type="submit" class="btn-primary px-4"><i class="fas fa-search"></i></button>
        @if(request()->hasAny(['q','status']))
        <a href="{{ route('admin.posts.index') }}" class="btn-outline px-4">Reset</a>
        @endif
    </form>
</div>

<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Berita</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Kategori</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Penulis</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Views</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tanggal</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            @if($post->thumbnail)
                            <img src="{{ asset('storage/'.$post->thumbnail) }}" class="w-14 h-10 rounded-lg object-cover flex-shrink-0">
                            @else
                            <div class="w-14 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-newspaper text-blue-300"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 line-clamp-1">{{ $post->title }}</div>
                                @if($post->is_featured)<span class="text-xs text-amber-600 font-medium"><i class="fas fa-star mr-1"></i>Featured</span>@endif
                                @if($post->status === 'rejected' && $post->rejection_note)
                                    <div class="text-[11px] text-red-600 mt-0.5 line-clamp-1"><i class="fas fa-info-circle mr-1"></i>Catatan: {{ $post->rejection_note }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($post->category)
                        <span class="text-xs bg-blue-50 text-blue-700 font-medium px-2 py-1 rounded-full">{{ $post->category->name }}</span>
                        @else<span class="text-gray-300 text-xs">—</span>@endif
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">
                        <div class="font-medium text-xs text-gray-800">{{ $post->user?->name ?? 'Unknown' }}</div>
                        <div class="text-[10px] text-gray-400">{{ ucfirst($post->user?->roles->first()?->name ?? $post->user?->role ?? 'User') }}</div>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        @if($post->status === 'published')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Published</span>
                        @elseif($post->status === 'pending_review')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Menunggu Review</span>
                        @elseif($post->status === 'rejected')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Ditolak</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Draft</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-center text-gray-500">{{ number_format($post->views) }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2" x-data="{ del: false }">
                            <a href="{{ route('posts.show', $post) }}" target="_blank" class="icon-btn-gray" title="Lihat Pratinjau"><i class="fas fa-eye"></i></a>
                            
                            @can('berita.update')
                            <a href="{{ route('admin.posts.edit', $post) }}" class="icon-btn-blue" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            @endcan

                            @can('berita.delete')
                            <button @click="del=true" class="icon-btn-red" title="Hapus"><i class="fas fa-trash"></i></button>
                            <div x-show="del" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="del=false">
                                <div @click.stop class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4 mx-auto"><i class="fas fa-trash text-red-500"></i></div>
                                    <h3 class="font-bold text-gray-900 text-center mb-2">Hapus Berita?</h3>
                                    <p class="text-gray-500 text-sm text-center mb-5">Artikel "{{ Str::limit($post->title,30) }}" akan dihapus secara permanen.</p>
                                    <div class="flex gap-3">
                                        <button @click="del=false" class="btn-outline w-full">Batal</button>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="w-full">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-newspaper text-4xl mb-3 block"></i>Belum ada berita</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $posts->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
