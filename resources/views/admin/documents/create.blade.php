@extends('layouts.admin')
@section('page-title', isset($document) ? 'Edit Dokumen' : 'Tambah Dokumen')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.documents.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($document) ? 'Edit' : 'Tambah' }} Dokumen</h2></div>
    <form action="{{ isset($document) ? route('admin.documents.update', $document) : route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($document)) @method('PUT') @endif
        <div><label class="form-label">Judul <span class="text-red-500">*</span></label><input type="text" name="title" value="{{ old('title', $document->title ?? '') }}" class="input-field" required>@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Deskripsi</label><textarea name="description" rows="3" class="input-field">{{ old('description', $document->description ?? '') }}</textarea></div>
        <div><label class="form-label">Kategori</label><input type="text" name="category" value="{{ old('category', $document->category ?? '') }}" class="input-field" placeholder="Contoh: Akademik, Administrasi"></div>
        <div>
            <label class="form-label">File {{ isset($document) ? '(kosongkan jika tidak diubah)' : '' }} <span class="text-red-500">{{ isset($document) ? '' : '*' }}</span></label>
            @if(isset($document) && $document->file)<p class="text-xs text-gray-500 mb-2"><i class="fas fa-file mr-1"></i>{{ basename($document->file) }} ({{ strtoupper($document->file_type) }}, {{ number_format(($document->file_size ?? 0)/1024) }} KB)</p>@endif
            <input type="file" name="file" class="input-field" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip" {{ isset($document) ? '' : 'required' }}>
            @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP. Maks 10MB</p>
        </div>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.documents.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
