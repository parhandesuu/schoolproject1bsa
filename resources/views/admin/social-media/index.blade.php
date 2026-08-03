@extends('layouts.admin')
@section('page-title','Media Sosial')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Media Sosial</h2><a href="{{ route('admin.social-media.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Icon</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">URL</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Urutan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($socialMedia as $sm)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5"><div class="w-9 h-9 rounded-full flex items-center justify-center" style="background:{{ $sm->color ?? '#3b82f6' }}20"><i class="{{ $sm->icon }}" style="color:{{ $sm->color ?? '#3b82f6' }}"></i></div></td>
        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $sm->name }}</td>
        <td class="px-5 py-3.5 text-gray-500 text-xs truncate max-w-xs"><a href="{{ $sm->url }}" target="_blank" class="text-blue-600 hover:underline">{{ Str::limit($sm->url, 40) }}</a></td>
        <td class="px-5 py-3.5 text-center text-gray-600">{{ $sm->order }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $sm->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $sm->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.social-media.edit', $sm) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.social-media.destroy', $sm) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada social media</td></tr>@endforelse
</tbody></table>
@if($socialMedia->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-white">
        {{ $socialMedia->links() }}
    </div>
@endif
</div>
@endsection
