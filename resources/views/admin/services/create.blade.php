@extends('layouts.admin')
@section('page-title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector: '#content', height: 350, plugins: 'anchor autolink link lists wordcount', toolbar: 'undo redo | bold italic | link | numlist bullist' });</script>
@endpush
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.services.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($service) ? 'Edit' : 'Tambah' }} Layanan</h2></div>
    <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($service)) @method('PUT') @endif
        <div><label class="form-label">Judul <span class="text-red-500">*</span></label><input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" class="input-field" required>@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Deskripsi Singkat</label><textarea name="description" rows="3" class="input-field">{{ old('description', $service->description ?? '') }}</textarea></div>
        <div><label class="form-label">Konten Detail</label><textarea name="content" id="content" class="input-field" rows="6">{{ old('content', $service->content ?? '') }}</textarea></div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Icon (Font Awesome)</label><input type="text" name="icon" value="{{ old('icon', $service->icon ?? '') }}" class="input-field" placeholder="fas fa-concierge-bell"></div>
            <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $service->order ?? 0) }}" class="input-field" min="0"></div>
        </div>
        <div x-data="{ preview: '' }"><label class="form-label">Gambar</label>@if(isset($service) && $service->image)<img src="{{ asset('storage/'.$service->image) }}" class="h-28 rounded-xl object-cover mb-2">@endif<input type="file" name="image" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])"><img x-show="preview" :src="preview" class="h-28 rounded-xl object-cover mt-2"></div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.services.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
