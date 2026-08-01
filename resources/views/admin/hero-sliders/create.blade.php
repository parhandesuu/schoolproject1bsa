@extends('layouts.admin')
@section('page-title', isset($slider) ? 'Edit Hero Slider' : 'Tambah Hero Slider')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.hero-sliders.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <h2 class="text-xl font-bold text-gray-900">{{ isset($slider) ? 'Edit Hero Slider' : 'Tambah Hero Slider' }}</h2>
    </div>

    <form action="{{ isset($slider) ? route('admin.hero-sliders.update', $slider) : route('admin.hero-sliders.store') }}"
          method="POST" enctype="multipart/form-data" class="admin-card space-y-5">
        @csrf
        @if(isset($slider)) @method('PUT') @endif

        <div>
            <label class="form-label">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $slider->title ?? '') }}" class="input-field" required placeholder="Judul hero slider">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Subtitle</label>
            <textarea name="subtitle" rows="3" class="input-field" placeholder="Deskripsi singkat...">{{ old('subtitle', $slider->subtitle ?? '') }}</textarea>
        </div>

        <div x-data="{ preview: '{{ isset($slider) && $slider->image ? asset('storage/'.$slider->image) : '' }}' }">
            <label class="form-label">Gambar <span class="text-red-500">{{ isset($slider) ? '' : '*' }}</span></label>
            @if(isset($slider) && $slider->image)
            <div class="mb-3">
                <img src="{{ asset('storage/'.$slider->image) }}" class="w-full h-40 object-cover rounded-xl" id="current-image">
                <p class="text-xs text-gray-400 mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
            </div>
            @endif
            <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-400 transition-colors">
                <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                       @change="preview = URL.createObjectURL($event.target.files[0])">
                <template x-if="preview">
                    <img :src="preview" class="w-full h-40 object-cover rounded-lg mb-3">
                </template>
                <template x-if="!preview">
                    <div><i class="fas fa-cloud-upload-alt text-blue-400 text-3xl mb-2"></i><p class="text-sm text-gray-500">Klik atau drag gambar di sini</p><p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP. Maks 2MB</p></div>
                </template>
            </div>
            @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Teks Tombol 1</label>
                <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text ?? '') }}" class="input-field" placeholder="Profil Sekolah">
            </div>
            <div>
                <label class="form-label">URL Tombol 1</label>
                <input type="text" name="button_url" value="{{ old('button_url', $slider->button_url ?? '') }}" class="input-field" placeholder="/profil">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Teks Tombol 2</label>
                <input type="text" name="button_text_2" value="{{ old('button_text_2', $slider->button_text_2 ?? '') }}" class="input-field" placeholder="Hubungi Kami">
            </div>
            <div>
                <label class="form-label">URL Tombol 2</label>
                <input type="text" name="button_url_2" value="{{ old('button_url_2', $slider->button_url_2 ?? '') }}" class="input-field" placeholder="/kontak">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Urutan</label>
                <input type="number" name="order" value="{{ old('order', $slider->order ?? 0) }}" class="input-field" min="0">
            </div>
            <div class="flex items-end pb-2">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Aktifkan Slider</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-gray-100">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.hero-sliders.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
