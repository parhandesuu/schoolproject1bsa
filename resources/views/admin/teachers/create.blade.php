@extends('layouts.admin')
@section('page-title', isset($teacher) ? 'Edit Guru/Staff' : 'Tambah Guru/Staff')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.teachers.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a>
        <h2 class="text-xl font-bold text-gray-900">{{ isset($teacher) ? 'Edit' : 'Tambah' }} Guru / Staff</h2>
    </div>
    <form action="{{ isset($teacher) ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($teacher)) @method('PUT') @endif
        <div x-data="{ preview: '' }">
            <label class="form-label">Foto</label>
            @if(isset($teacher) && $teacher->photo)<img src="{{ asset('storage/'.$teacher->photo) }}" class="w-20 h-20 rounded-full object-cover mb-2">@endif
            <input type="file" name="photo" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])">
            <img x-show="preview" :src="preview" class="w-20 h-20 rounded-full object-cover mt-2">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="form-label">Nama <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name', $teacher->name ?? '') }}" class="input-field" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="form-label">NIP</label><input type="text" name="nip" value="{{ old('nip', $teacher->nip ?? '') }}" class="input-field"></div>
            <div><label class="form-label">Jabatan</label><input type="text" name="position" value="{{ old('position', $teacher->position ?? '') }}" class="input-field"></div>
            <div><label class="form-label">Mata Pelajaran</label><input type="text" name="subject" value="{{ old('subject', $teacher->subject ?? '') }}" class="input-field" placeholder="(untuk guru)"></div>
            <div><label class="form-label">Pendidikan Terakhir</label><input type="text" name="education" value="{{ old('education', $teacher->education ?? '') }}" class="input-field"></div>
            <div>
                <label class="form-label">Tipe</label>
                <select name="type" class="input-field">
                    <option value="teacher" {{ old('type', $teacher->type ?? '') === 'teacher' ? 'selected' : '' }}>Tenaga Pendidik (Guru)</option>
                    <option value="staff" {{ old('type', $teacher->type ?? '') === 'staff' ? 'selected' : '' }}>Tenaga Kependidikan (Staff)</option>
                </select>
            </div>
            <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $teacher->order ?? 0) }}" class="input-field" min="0"></div>
        </div>
        <div><label class="form-label">Bio</label><textarea name="bio" rows="4" class="input-field">{{ old('bio', $teacher->bio ?? '') }}</textarea></div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $teacher->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan Data</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.teachers.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
