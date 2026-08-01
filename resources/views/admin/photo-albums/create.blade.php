@extends('layouts.admin')
@section('page-title', isset($album) ? 'Edit Album' : 'Tambah Album')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.photo-albums.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($album) ? 'Edit' : 'Tambah' }} Album Foto</h2></div>
    <form action="{{ isset($album) ? route('admin.photo-albums.update', $album) : route('admin.photo-albums.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($album)) @method('PUT') @endif
        <div><label class="form-label">Nama Album <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name', $album->name ?? '') }}" class="input-field" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Deskripsi</label><textarea name="description" rows="3" class="input-field">{{ old('description', $album->description ?? '') }}</textarea></div>
        <div x-data="{ preview: '' }">
            <label class="form-label">Cover Album</label>
            @if(isset($album) && $album->cover)<img src="{{ asset('storage/'.$album->cover) }}" class="h-28 rounded-xl object-cover mb-2">@endif
            <input type="file" name="cover" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])">
            <img x-show="preview" :src="preview" class="h-28 rounded-xl object-cover mt-2">
        </div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $album->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan Album</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.photo-albums.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
