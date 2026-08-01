@extends('layouts.admin')
@section('page-title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
    </div>
    <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="admin-card space-y-5">
        @csrf @if(isset($category)) @method('PUT') @endif
        <div>
            <label class="form-label">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="input-field" required oninput="this.form.slug.value=this.value.toLowerCase().replace(/[^\w ]/g,'').replace(/\s+/g,'-')">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="input-field font-mono">
            @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Warna</label>
            <input type="color" name="color" value="{{ old('color', $category->color ?? '#3b82f6') }}" class="h-10 w-20 rounded-lg border border-gray-300 cursor-pointer p-1">
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-gray-700">Aktifkan Kategori</span>
        </label>
        <div class="flex gap-3 pt-2 border-t border-gray-100">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
