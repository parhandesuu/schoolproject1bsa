@extends('layouts.admin')
@section('page-title','Dokumen')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Dokumen</h2><a href="{{ route('admin.documents.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Judul</th>
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Kategori</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tipe</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Unduhan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($documents as $d)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $d->title }}<div class="text-xs text-gray-400">{{ $d->description ? Str::limit($d->description, 40) : '' }}</div></td>
        <td class="px-5 py-3.5 text-gray-600 text-sm">{{ $d->category ?: '—' }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded text-xs font-mono uppercase bg-gray-100 text-gray-600">{{ $d->file_type }}</span></td>
        <td class="px-5 py-3.5 text-center text-gray-500">{{ $d->downloads }}</td>
        <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2">
            <a href="{{ asset('storage/'.$d->file) }}" target="_blank" class="icon-btn-gray"><i class="fas fa-download"></i></a>
            <a href="{{ route('admin.documents.edit', $d) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
            <form action="{{ route('admin.documents.destroy', $d) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form>
        </div></td>
    </tr>
    @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada dokumen</td></tr>@endforelse
</tbody></table>
@if($documents->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $documents->links() }}</div>@endif
</div>
@endsection
