@extends('layouts.admin')
@section('page-title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"><i class="fas fa-arrow-left text-gray-600"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h2>
    </div>
    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="admin-card space-y-5">
        @csrf @if(isset($user)) @method('PUT') @endif
        <div>
            <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="input-field" required>
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="input-field" required>
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Role</label>
            <select name="role" class="input-field">
                <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div>
            <label class="form-label">Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }} <span class="text-red-500">{{ isset($user) ? '' : '*' }}</span></label>
            <input type="password" name="password" class="input-field" {{ isset($user) ? '' : 'required' }} placeholder="{{ isset($user) ? 'Biarkan kosong...' : 'Password baru' }}">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        @if(!isset($user))
        <div>
            <label class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" class="input-field" required>
        </div>
        @endif
        <div class="flex gap-3 pt-2 border-t border-gray-100">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
