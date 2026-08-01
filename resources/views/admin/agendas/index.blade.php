@extends('layouts.admin')
@section('page-title','Agenda')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Agenda Sekolah</h2>
    <a href="{{ route('admin.agendas.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-gray-100 bg-gray-50/50">
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Judul</th>
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tanggal</th>
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Lokasi</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($agendas as $a)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5 font-medium text-gray-900 max-w-xs">{{ Str::limit($a->title, 40) }}</td>
                <td class="px-5 py-3.5 text-gray-600 text-xs">{{ $a->start_date->format('d M Y') }}@if($a->end_date) &ndash; {{ $a->end_date->format('d M Y') }}@endif</td>
                <td class="px-5 py-3.5 text-gray-500">{{ $a->location }}</td>
                <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $a->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $a->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2">
                    <a href="{{ route('admin.agendas.edit', $a) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
                    <form action="{{ route('admin.agendas.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
            @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada agenda</td></tr>@endforelse
        </tbody>
    </table>
    @if($agendas->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $agendas->links() }}</div>@endif
</div>
@endsection
