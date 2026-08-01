@extends('layouts.admin')
@section('page-title', isset($facility) ? 'Edit Fasilitas' : 'Tambah Fasilitas')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.facilities.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($facility) ? 'Edit' : 'Tambah' }} Fasilitas</h2></div>
    <form action="{{ isset($facility) ? route('admin.facilities.update', $facility) : route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($facility)) @method('PUT') @endif
        <div><label class="form-label">Nama Fasilitas <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name', $facility->name ?? '') }}" class="input-field" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Deskripsi</label><textarea name="description" rows="4" class="input-field">{{ old('description', $facility->description ?? '') }}</textarea></div>
        <div x-data="{ preview: '' }"><label class="form-label">Gambar</label>@if(isset($facility) && $facility->image)<img src="{{ asset('storage/'.$facility->image) }}" class="h-28 rounded-xl object-cover mb-2">@endif<input type="file" name="image" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])"><img x-show="preview" :src="preview" class="h-28 rounded-xl object-cover mt-2"></div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Icon (Font Awesome)</label><input type="text" name="icon" value="{{ old('icon', $facility->icon ?? '') }}" class="input-field" placeholder="fas fa-building"></div>
            <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $facility->order ?? 0) }}" class="input-field" min="0"></div>
        </div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $facility->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.facilities.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
