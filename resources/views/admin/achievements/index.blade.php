@extends('layouts.admin')
@section('page-title','Prestasi')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Prestasi</h2><a href="{{ route('admin.achievements.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Prestasi</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tingkat</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tahun</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($achievements as $a)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5"><div class="flex items-center gap-3">@if($a->image)<img src="{{ asset('storage/'.$a->image) }}" class="w-12 h-10 rounded-lg object-cover">@else<div class="w-12 h-10 bg-amber-50 rounded-lg flex items-center justify-center"><i class="fas fa-trophy text-amber-400"></i></div>@endif<div class="font-medium text-gray-900">{{ Str::limit($a->title, 35) }}<div class="text-xs text-gray-400">{{ $a->category }}</div></div></div></td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700">{{ $a->level }}</span></td>
        <td class="px-5 py-3.5 text-center text-gray-600">{{ $a->year }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $a->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $a->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2"><a href="{{ route('admin.achievements.edit', $a) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a><form action="{{ route('admin.achievements.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form></div></td>
    </tr>
    @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada prestasi</td></tr>@endforelse
</tbody></table>
@if($achievements->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $achievements->links() }}</div>@endif
</div>
@endsection
