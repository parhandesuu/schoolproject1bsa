@extends('layouts.admin')
@section('page-title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')
@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector: '#content', height: 350, plugins: 'anchor autolink link lists wordcount', toolbar: 'undo redo | bold italic | link | numlist bullist' });</script>
@endpush
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.announcements.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($announcement) ? 'Edit' : 'Tambah' }} Pengumuman</h2></div>
    <form action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($announcement)) @method('PUT') @endif
        <div><label class="form-label">Judul <span class="text-red-500">*</span></label><input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}" class="input-field" required>@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Konten</label><textarea name="content" id="content" class="input-field" rows="6">{{ old('content', $announcement->content ?? '') }}</textarea></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div><label class="form-label">Tipe</label><select name="type" class="input-field">@foreach(['info'=>'Info','warning'=>'Peringatan','success'=>'Sukses','danger'=>'Bahaya'] as $k=>$v)<option value="{{ $k }}" {{ old('type', $announcement->type ?? 'info') === $k ? 'selected' : '' }}>{{ $v }}</option>@endforeach</select></div>
            <div><label class="form-label">Tanggal Mulai</label><input type="date" name="start_date" value="{{ old('start_date', isset($announcement) && $announcement->start_date ? $announcement->start_date->format('Y-m-d') : '') }}" class="input-field"></div>
            <div><label class="form-label">Tanggal Selesai</label><input type="date" name="end_date" value="{{ old('end_date', isset($announcement) && $announcement->end_date ? $announcement->end_date->format('Y-m-d') : '') }}" class="input-field"></div>
        </div>
        <div x-data="{ preview: '' }"><label class="form-label">Lampiran (PDF/Gambar, maks 5MB)</label>@if(isset($announcement) && $announcement->file)<a href="{{ asset('storage/'.$announcement->file) }}" target="_blank" class="text-blue-600 text-xs block mb-2"><i class="fas fa-file-download mr-1"></i>File lampiran saat ini</a>@endif<input type="file" name="file" class="input-field" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"></div>
        <div class="flex gap-4">
            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $announcement->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label>
            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_pinned" value="1" class="rounded" {{ old('is_pinned', $announcement->is_pinned ?? false) ? 'checked' : '' }}><span class="text-sm text-gray-700">Tandai Penting (Pin)</span></label>
        </div>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.announcements.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
