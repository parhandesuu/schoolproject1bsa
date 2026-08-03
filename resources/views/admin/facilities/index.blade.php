@extends('layouts.admin')
@section('page-title','Fasilitas')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Fasilitas</h2><a href="{{ route('admin.facilities.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Gambar</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Urutan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($facilities as $f)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5">@if($f->image)<img src="{{ asset('storage/'.$f->image) }}" class="w-16 h-12 rounded-lg object-cover">@else<div class="w-16 h-12 bg-gray-100 rounded-lg flex items-center justify-center"><i class="fas fa-building text-gray-300"></i></div>@endif</td>
        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $f->name }}<div class="text-xs text-gray-400 line-clamp-1">{{ $f->description }}</div></td>
        <td class="px-5 py-3.5 text-center text-gray-600">{{ $f->order }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $f->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $f->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.facilities.edit', $f) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.facilities.destroy', $f) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada fasilitas</td></tr>@endforelse
</tbody></table>
@if($facilities->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-white">
        {{ $facilities->links() }}
    </div>
@endif
</div>
@endsection
