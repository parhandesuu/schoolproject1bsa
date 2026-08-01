@extends('layouts.admin')
@section('page-title','Pengumuman')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Pengumuman</h2><a href="{{ route('admin.announcements.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Judul</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tipe</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Pinned</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($announcements as $a)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5 font-medium text-gray-900 max-w-xs">{{ Str::limit($a->title, 45) }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ ucfirst($a->type) }}</span></td>
        <td class="px-5 py-3.5 text-center">@if($a->is_pinned)<i class="fas fa-thumbtack text-amber-500"></i>@else<span class="text-gray-300">—</span>@endif</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $a->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $a->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2">
            <a href="{{ route('admin.announcements.edit', $a) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
            <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form>
        </div></td>
    </tr>
    @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada pengumuman</td></tr>@endforelse
</tbody></table>
@if($announcements->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $announcements->links() }}</div>@endif
</div>
@endsection
