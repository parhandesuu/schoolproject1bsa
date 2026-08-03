@extends('layouts.admin')
@section('page-title','Kategori Berita')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Kategori Berita</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-gray-100 bg-gray-50/50">
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Slug</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Warna</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Berita</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5 font-medium text-gray-900">{{ $cat->name }}</td>
                <td class="px-5 py-3.5 text-gray-500 font-mono text-xs">{{ $cat->slug }}</td>
                <td class="px-5 py-3.5 text-center">
                    <span class="inline-block w-6 h-6 rounded-full border border-gray-200" style="background:{{ $cat->color ?? '#3b82f6' }}"></span>
                </td>
                <td class="px-5 py-3.5 text-center text-gray-600">{{ $cat->posts_count }}</td>
                <td class="px-5 py-3.5 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $cat->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada kategori</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-white">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
