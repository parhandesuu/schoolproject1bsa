@extends('layouts.admin')
@section('page-title','Layanan')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Layanan Sekolah</h2><a href="{{ route('admin.services.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Layanan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Urutan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($services as $s)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5"><div class="flex items-center gap-3"><div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0"><i class="{{ $s->icon ?? 'fas fa-concierge-bell' }} text-blue-600"></i></div><div><div class="font-medium text-gray-900">{{ $s->title }}</div><div class="text-xs text-gray-400 line-clamp-1">{{ $s->description }}</div></div></div></td>
        <td class="px-5 py-3.5 text-center text-gray-600">{{ $s->order }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $s->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.services.edit', $s) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="4" class="text-center py-12 text-gray-400">Belum ada layanan</td></tr>@endforelse
</tbody></table>
@if($services->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-white">
        {{ $services->links() }}
    </div>
@endif
</div>
@endsection
