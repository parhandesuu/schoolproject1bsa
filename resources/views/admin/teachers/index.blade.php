@extends('layouts.admin')
@section('page-title','Guru & Staff')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Guru & Staff</h2>
    <a href="{{ route('admin.teachers.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-gray-100 bg-gray-50/50">
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Foto</th>
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
            <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Jabatan</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tipe</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
            <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($teachers as $teacher)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5">
                    @if($teacher->photo)
                    <img src="{{ asset('storage/'.$teacher->photo) }}" class="w-10 h-10 rounded-full object-cover">
                    @else<div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700">{{ strtoupper(substr($teacher->name,0,1)) }}</div>@endif
                </td>
                <td class="px-5 py-3.5 font-medium text-gray-900">{{ $teacher->name }}<div class="text-xs text-gray-400">{{ $teacher->nip }}</div></td>
                <td class="px-5 py-3.5 text-gray-600">{{ $teacher->position }}<div class="text-xs text-gray-400">{{ $teacher->subject }}</div></td>
                <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $teacher->type === 'teacher' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">{{ $teacher->type === 'teacher' ? 'Guru' : 'Staff' }}</span></td>
                <td class="px-5 py-3.5 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $teacher->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $teacher->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-5 py-3.5 text-center"><div class="flex items-center justify-center gap-2">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
            @empty<tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada data guru & staff</td></tr>@endforelse
        </tbody>
    </table>
    @if($teachers->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $teachers->links() }}</div>@endif
</div>
@endsection
