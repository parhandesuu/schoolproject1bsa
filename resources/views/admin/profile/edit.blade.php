@extends('layouts.admin')
@section('page-title','Profil Saya')
@section('content')
<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Profil Saya</h2>

    {{-- Profile Info --}}
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="admin-card mb-6 space-y-5">
        @csrf @method('PUT')
        <h3 class="font-semibold text-gray-900 border-b border-gray-100 pb-3">Informasi Akun</h3>
        <div class="flex items-center gap-5 mb-4">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 text-2xl flex-shrink-0">
                @if(auth()->user()->avatar)
                <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-16 h-16 rounded-full object-cover">
                @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <label class="form-label">Foto Profil</label>
                <input type="file" name="avatar" accept="image/*" class="input-field">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="form-label">Nama Lengkap</label><input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input-field" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="input-field" required>@error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Profil</button>
    </form>

    {{-- Change Password --}}
    <form action="{{ route('admin.profile.password') }}" method="POST" class="admin-card space-y-5">
        @csrf @method('PUT')
        <h3 class="font-semibold text-gray-900 border-b border-gray-100 pb-3">Ubah Password</h3>
        <div><label class="form-label">Password Saat Ini</label><input type="password" name="current_password" class="input-field" required>@error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="form-label">Password Baru</label><input type="password" name="password" class="input-field" required>@error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="input-field" required></div>
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-lock"></i> Ubah Password</button>
    </form>
</div>
@endsection
