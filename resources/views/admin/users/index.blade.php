@extends('layouts.admin')
@section('page-title','Pengguna')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Kelola Pengguna</h2>
    <a href="{{ route('admin.users.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 bg-gray-50/50">
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Nama</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Email</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Role</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Bergabung</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 text-sm">{{ strtoupper(substr($user->name,0,1)) }}</div>
                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                            @if($user->id === auth()->id())<span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full">Anda</span>@endif
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada pengguna</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $users->links() }}</div>@endif
</div>
@endsection
