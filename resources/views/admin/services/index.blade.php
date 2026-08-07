@extends('layouts.admin')
@section('page-title','Layanan')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Layanan Sekolah</h2><a href="{{ route('admin.services.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
<div class="admin-card p-0 overflow-hidden"><table class="w-full text-sm"><thead><tr class="border-b border-gray-100 bg-gray-50/50">
    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Layanan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Media / Lampiran</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Urutan</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
</tr></thead><tbody class="divide-y divide-gray-50">
    @forelse($services as $s)
    <tr class="hover:bg-gray-50/50">
        <td class="px-5 py-3.5">
            <div class="flex items-center gap-3">
                @if($s->image)
                    <img src="{{ asset('storage/'.$s->image) }}" class="w-10 h-10 rounded-xl object-cover flex-shrink-0 border border-gray-100 shadow-sm">
                @else
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="{{ $s->icon ?? 'fas fa-concierge-bell' }} text-blue-600"></i>
                    </div>
                @endif
                <div>
                    <div class="font-semibold text-gray-900">{{ $s->title }}</div>
                    <div class="text-xs text-gray-400 line-clamp-1">{{ $s->description }}</div>
                </div>
            </div>
        </td>
        <td class="px-5 py-3.5 text-center">
            <div class="flex items-center justify-center gap-1.5 flex-wrap">
                @if($s->image)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700" title="Foto Utama">
                        <i class="fas fa-image"></i> Utama
                    </span>
                @endif
                @if(!empty($s->images) && is_array($s->images) && count($s->images) > 0)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-medium bg-purple-50 text-purple-700" title="Galeri Foto">
                        <i class="fas fa-images"></i> {{ count($s->images) }} Foto
                    </span>
                @endif
                @if($s->file)
                    <a href="{{ asset('storage/'.$s->file) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors" title="{{ $s->file_name ?? 'Download File' }}">
                        <i class="fas fa-file-download"></i> Dokumen
                    </a>
                @endif
                @if(!$s->image && empty($s->images) && !$s->file)
                    <span class="text-xs text-gray-400">-</span>
                @endif
            </div>
        </td>
        <td class="px-5 py-3.5 text-center text-gray-600 font-medium">{{ $s->order }}</td>
        <td class="px-5 py-3.5 text-center"><span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
        <td class="px-5 py-3.5 text-center">
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('admin.services.edit', $s) }}" class="icon-btn-blue" title="Edit Layanan"><i class="fas fa-pencil-alt"></i></a>
                <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="icon-btn-red" title="Hapus Layanan"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
    @empty<tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada layanan</td></tr>@endforelse
</tbody></table>
@if($services->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 bg-white">
        {{ $services->links() }}
    </div>
@endif
</div>
@endsection
