@extends('layouts.admin')
@section('page-title','Halaman Statis')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Halaman Statis</h2>
        <p class="text-xs text-gray-500 mt-0.5">Kelola halaman profil, visi misi, sejarah, dan struktur organisasi</p>
    </div>
    @can('halaman.create')
    <a href="{{ route('admin.pages.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Halaman</a>
    @endcan
</div>

<div class="admin-card p-0 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50/50">
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Judul</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Slug</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status Publikasi</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status Aktif</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($pages as $page)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5">
                    <div class="font-medium text-gray-900">{{ $page->title }}</div>
                    @if($page->status === 'rejected' && $page->rejection_note)
                        <div class="text-[11px] text-red-600 mt-0.5"><i class="fas fa-info-circle mr-1"></i>Revisi: {{ $page->rejection_note }}</div>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-gray-500 font-mono text-xs">{{ $page->slug }}</td>
                <td class="px-5 py-3.5 text-center">
                    @if($page->status === 'published')
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Published</span>
                    @elseif($page->status === 'pending_review')
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Menunggu Review</span>
                    @elseif($page->status === 'rejected')
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Ditolak</span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Draft</span>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $page->is_active ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $page->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        @can('halaman.update')
                        <a href="{{ route('admin.pages.edit', $page) }}" class="icon-btn-blue" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        @can('halaman.delete')
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Hapus halaman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="icon-btn-red" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada halaman statis</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($pages->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-white">
            {{ $pages->links() }}
        </div>
    @endif
</div>
@endsection
