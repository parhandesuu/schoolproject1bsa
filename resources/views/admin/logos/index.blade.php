@extends('layouts.admin')
@section('page-title','Logo')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Logo</h2><a href="{{ route('admin.logos.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Logo</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tipe</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($logos as $logo)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5">@if($logo->image)<img src="{{ asset('storage/'.$logo->image) }}" class="w-12 h-12 object-contain">@else<div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center"><i class="fas fa-image text-gray-300"></i></div>@endif</td>
        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $logo->name }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700">{{ $logo->type }}</span></td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $logo->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $logo->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.logos.edit', $logo) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.logos.destroy', $logo) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada logo</td></tr>@endforelse
</tbody></table></div>
@endsection
