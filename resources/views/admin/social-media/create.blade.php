@extends('layouts.admin')
@section('page-title', isset($socialMedia) ? 'Edit Social Media' : 'Tambah Social Media')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.social-media.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($socialMedia) ? 'Edit' : 'Tambah' }} Social Media</h2></div>
    <form action="{{ isset($socialMedia) ? route('admin.social-media.update', $socialMedia) : route('admin.social-media.store') }}" method="POST" class="admin-card space-y-5">
        @csrf @if(isset($socialMedia)) @method('PUT') @endif
        <div><label class="form-label">Nama Platform <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name', $socialMedia->name ?? '') }}" class="input-field" required placeholder="Facebook, Instagram...">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">URL <span class="text-red-500">*</span></label><input type="url" name="url" value="{{ old('url', $socialMedia->url ?? '') }}" class="input-field" required placeholder="https://...">@error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Icon (Font Awesome)</label><input type="text" name="icon" value="{{ old('icon', $socialMedia->icon ?? 'fab fa-facebook') }}" class="input-field" placeholder="fab fa-instagram"></div>
            <div><label class="form-label">Warna</label><input type="color" name="color" value="{{ old('color', $socialMedia->color ?? '#3b82f6') }}" class="h-10 w-20 rounded-lg border border-gray-300 p-1"></div>
        </div>
        <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $socialMedia->order ?? 0) }}" class="input-field" min="0"></div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $socialMedia->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.social-media.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
