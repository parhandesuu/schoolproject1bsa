@extends('layouts.admin')
@section('page-title', isset($logo) ? 'Edit Logo' : 'Tambah Logo')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.logos.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($logo) ? 'Edit' : 'Tambah' }} Logo</h2></div>
    <form action="{{ isset($logo) ? route('admin.logos.update', $logo) : route('admin.logos.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf @if(isset($logo)) @method('PUT') @endif
        <div><label class="form-label">Nama <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name', $logo->name ?? '') }}" class="input-field" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Tipe</label><select name="type" class="input-field">@foreach(['school'=>'Sekolah','twh'=>'Tut Wuri Handayani','yayasan'=>'Yayasan','education'=>'Dinas Pendidikan'] as $k=>$v)<option value="{{ $k }}" {{ old('type', $logo->type ?? 'school') === $k ? 'selected' : '' }}>{{ $v }}</option>@endforeach</select></div>
        <div x-data="{ preview: '' }"><label class="form-label">Gambar Logo</label>@if(isset($logo) && $logo->image)<img src="{{ asset('storage/'.$logo->image) }}" class="h-16 object-contain mb-2">@endif<input type="file" name="image" accept="image/*" class="input-field" @change="preview=URL.createObjectURL($event.target.files[0])"><img x-show="preview" :src="preview" class="h-16 object-contain mt-2"></div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $logo->order ?? 0) }}" class="input-field" min="0"></div>
            <div class="flex items-end pb-2"><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $logo->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label></div>
        </div>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.logos.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
