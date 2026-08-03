@extends('layouts.admin')
@section('page-title','Ekstrakurikuler')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Ekstrakurikuler</h2><a href="{{ route('admin.extracurriculars.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Gambar</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Pembina</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Jadwal</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($extracurriculars as $e)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5">@if($e->image)<img src="{{ asset('storage/'.$e->image) }}" class="w-14 h-10 rounded-lg object-cover">@else<div class="w-14 h-10 bg-green-50 rounded-lg flex items-center justify-center"><i class="fas fa-football-ball text-green-300"></i></div>@endif</td>
        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $e->name }}</td>
        <td class="px-5 py-3.5 text-gray-600">{{ $e->teacher ?: '—' }}</td>
        <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $e->schedule ?: '—' }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $e->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $e->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.extracurriculars.edit', $e) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.extracurriculars.destroy', $e) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada data</td></tr>@endforelse
</tbody></table>
@if($extracurriculars->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-white">
        {{ $extracurriculars->links() }}
    </div>
@endif
</div>
@endsection
