@extends('layouts.admin')
@section('page-title', isset($video) ? 'Edit Video' : 'Tambah Video')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.video-galleries.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($video) ? 'Edit' : 'Tambah' }} Video</h2></div>
    <form action="{{ isset($video) ? route('admin.video-galleries.update', $video) : route('admin.video-galleries.store') }}" method="POST" class="admin-card space-y-5">
        @csrf @if(isset($video)) @method('PUT') @endif
        <div><label class="form-label">Judul <span class="text-red-500">*</span></label><input type="text" name="title" value="{{ old('title', $video->title ?? '') }}" class="input-field" required>@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">URL YouTube <span class="text-red-500">*</span></label><input type="url" name="youtube_url" value="{{ old('youtube_url', isset($video) ? 'https://www.youtube.com/watch?v='.$video->youtube_id : '') }}" class="input-field" required placeholder="https://www.youtube.com/watch?v=...">@error('youtube_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror<p class="text-xs text-gray-400 mt-1">Paste link YouTube lengkap</p></div>
        <div><label class="form-label">Deskripsi</label><textarea name="description" rows="3" class="input-field">{{ old('description', $video->description ?? '') }}</textarea></div>
        <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $video->order ?? 0) }}" class="input-field" min="0"></div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $video->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan Video</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.video-galleries.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
