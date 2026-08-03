@extends('layouts.admin')
@section('page-title','Statistik')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Statistik Beranda</h2><a href="{{ route('admin.statistics.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Icon</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Label</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nilai</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Urutan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($statistics as $s)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5"><div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:{{ $s->color ?? '#3b82f6' }}15"><i class="{{ $s->icon ?? 'fas fa-chart-bar' }}" style="color:{{ $s->color ?? '#3b82f6' }}"></i></div></td>
        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $s->label }}</td>
        <td class="px-5 py-3.5 text-center font-bold text-gray-900 text-lg">{{ $s->value }}</td>
        <td class="px-5 py-3.5 text-center text-gray-600">{{ $s->order }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $s->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.statistics.edit', $s) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.statistics.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada statistik</td></tr>@endforelse
</tbody></table>
@if($statistics->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-white">
        {{ $statistics->links() }}
    </div>
@endif
</div>
@endsection
