@extends('layouts.admin')
@section('page-title', isset($page) ? 'Edit Halaman' : 'Tambah Halaman')
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector: '#content', height: 400, plugins: 'anchor autolink charmap codesample image link lists table wordcount', toolbar: 'undo redo | blocks | bold italic | link image | numlist bullist | removeformat' });</script>
@endpush
@section('content')
<div class="max-w-4xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pages.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ isset($page) ? 'Edit Halaman' : 'Tambah Halaman' }}</h2>
    </div>
    <form action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($page)) @method('PUT') @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" class="input-field" required oninput="this.form.slug.value=this.value.toLowerCase().replace(/[^\w ]/g,'').replace(/\s+/g,'-')">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Slug <span class="text-red-500">*</span></label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" class="input-field font-mono" required>
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="form-label">Ringkasan (Excerpt)</label>
            <textarea name="excerpt" rows="3" class="input-field">{{ old('excerpt', $page->excerpt ?? '') }}</textarea>
        </div>
        <div>
            <label class="form-label">Konten</label>
            <textarea name="content" id="content" class="input-field" rows="8">{{ old('content', $page->content ?? '') }}</textarea>
        </div>
        <div x-data="{ preview: '' }">
            <label class="form-label">Gambar Header</label>
            @if(isset($page) && $page->image)
            <img src="{{ asset('storage/'.$page->image) }}" class="h-28 rounded-xl mb-2 object-cover">
            @endif
            <input type="file" name="image" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])">
            <img x-show="preview" :src="preview" class="h-28 rounded-xl mt-2 object-cover">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}" class="input-field">
            </div>
            <div>
                <label class="form-label">Meta Description</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $page->meta_description ?? '') }}" class="input-field">
            </div>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-gray-700">Aktifkan Halaman</span>
        </label>
        <div class="flex gap-3 pt-2 border-t border-gray-100">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.pages.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
