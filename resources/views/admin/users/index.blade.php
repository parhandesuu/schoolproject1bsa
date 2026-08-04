@extends('layouts.admin')
@section('page-title','Kelola Pengguna')
@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Kelola Pengguna & Hak Akses</h2>
        <p class="text-xs text-gray-500 mt-0.5">Manajemen akun pengguna dan penetapan peran (Admin, Editor, Staff)</p>
    </div>
    @can('users.create')
    <a href="{{ route('admin.users.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
    @endcan
</div>

<div class="admin-card p-0 overflow-hidden">
    {{-- Filter & Search --}}
    <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                       class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
            <select name="role" onchange="this.form.submit()" class="text-xs rounded-xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                <option value="">Semua Peran</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="editor" {{ request('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="text-xs text-red-600 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Email</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Role (Peran)</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Bergabung</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                @php
                    $roleName = $user->roles->first()?->name ?? $user->role;
                @endphp
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 flex items-center gap-2">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-bold border border-blue-200">Anda</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($roleName === 'admin')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Administrator</span>
                        @elseif($roleName === 'editor')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Editor</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Staff</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            @can('users.update')
                            <a href="{{ route('admin.users.edit', $user) }}" class="icon-btn-blue" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            @endcan
                            @can('users.delete')
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn-red" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada pengguna ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-white">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
