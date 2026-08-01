@extends('layouts.admin')
@section('page-title', isset($extracurricular) ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.extracurriculars.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($extracurricular) ? 'Edit' : 'Tambah' }} Ekstrakurikuler</h2></div>
    <form action="{{ isset($extracurricular) ? route('admin.extracurriculars.update', $extracurricular) : route('admin.extracurriculars.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($extracurricular)) @method('PUT') @endif
        <div><label class="form-label">Nama <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name', $extracurricular->name ?? '') }}" class="input-field" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Deskripsi</label><textarea name="description" rows="4" class="input-field">{{ old('description', $extracurricular->description ?? '') }}</textarea></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="form-label">Pembina</label><input type="text" name="teacher" value="{{ old('teacher', $extracurricular->teacher ?? '') }}" class="input-field"></div>
            <div><label class="form-label">Jadwal</label><input type="text" name="schedule" value="{{ old('schedule', $extracurricular->schedule ?? '') }}" class="input-field" placeholder="Senin, 15:00-17:00"></div>
        </div>
        <div x-data="{ preview: '' }"><label class="form-label">Gambar</label>@if(isset($extracurricular) && $extracurricular->image)<img src="{{ asset('storage/'.$extracurricular->image) }}" class="h-28 rounded-xl object-cover mb-2">@endif<input type="file" name="image" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])"><img x-show="preview" :src="preview" class="h-28 rounded-xl object-cover mt-2"></div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $extracurricular->order ?? 0) }}" class="input-field" min="0"></div>
            <div class="flex items-end pb-2"><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $extracurricular->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label></div>
        </div>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.extracurriculars.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
