@extends('layouts.admin')
@section('page-title','Halaman Statis')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Halaman Statis</h2>
    <a href="{{ route('admin.pages.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Halaman</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-gray-100 bg-gray-50/50">
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Judul</th>
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Slug</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($pages as $page)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5 font-medium text-gray-900">{{ $page->title }}</td>
                <td class="px-5 py-3.5 text-gray-500 font-mono text-xs">{{ $page->slug }}</td>
                <td class="px-5 py-3.5 text-center"><span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $page->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $page->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Hapus halaman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-12 text-gray-400">Belum ada halaman statis</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
