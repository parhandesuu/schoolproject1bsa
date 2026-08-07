@extends('layouts.admin')
@section('page-title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector: '#content', height: 350, plugins: 'anchor autolink link lists wordcount', toolbar: 'undo redo | bold italic | link | numlist bullist' });</script>
@endpush
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.services.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ isset($service) ? 'Edit' : 'Tambah' }} Layanan</h2>
            <p class="text-xs text-gray-500 mt-0.5">Kelola informasi layanan, foto maklumat/galeri, serta file lampiran formulir.</p>
        </div>
    </div>

    <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="admin-card space-y-6">
        @csrf @if(isset($service)) @method('PUT') @endif

        {{-- Judul Layanan --}}
        <div>
            <label class="form-label">Judul Layanan <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" class="input-field" placeholder="Contoh: Layanan Legalisir Ijazah & Raport" required>
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Deskripsi Singkat --}}
        <div>
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="description" rows="2" class="input-field" placeholder="Ringkasan singkat tentang layanan...">{{ old('description', $service->description ?? '') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Konten Detail --}}
        <div>
            <label class="form-label">Konten / Prosedur & Persyaratan Detail</label>
            <textarea name="content" id="content" class="input-field" rows="6">{{ old('content', $service->content ?? '') }}</textarea>
            @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Icon & Urutan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="form-label">Icon (Font Awesome)</label>
                <div class="relative">
                    <input type="text" name="icon" value="{{ old('icon', $service->icon ?? '') }}" class="input-field pl-10" placeholder="fas fa-concierge-bell">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="{{ old('icon', $service->icon ?? 'fas fa-concierge-bell') }}"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-1">Contoh: fas fa-file-signature, fas fa-graduation-cap, fas fa-id-card</p>
                @error('icon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="order" value="{{ old('order', $service->order ?? 0) }}" class="input-field" min="0">
                @error('order')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="border-t border-gray-100 pt-5 space-y-6">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-paperclip text-blue-600"></i> Media & Dokumen Lampiran
            </h3>

            {{-- 1. Foto / Banner Utama --}}
            <div x-data="{ preview: '' }" class="bg-gray-50/70 p-4 rounded-xl border border-gray-100 space-y-3">
                <label class="form-label font-semibold text-gray-800 flex items-center justify-between">
                    <span>Foto / Banner Utama (Maklumat / Alur Layanan)</span>
                    <span class="text-xs font-normal text-gray-400">Maks 5MB (JPG, PNG, WEBP)</span>
                </label>

                @if(isset($service) && $service->image)
                <div class="flex items-start gap-4 p-3 bg-white rounded-xl border border-gray-200 shadow-xs">
                    <img src="{{ asset('storage/'.$service->image) }}" class="h-20 w-28 rounded-lg object-contain bg-white border p-1">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-700 truncate">Foto Utama Saat Ini</p>
                        <a href="{{ asset('storage/'.$service->image) }}" target="_blank" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 mt-1">
                            <i class="fas fa-external-link-alt"></i> Lihat foto asli
                        </a>
                        <label class="flex items-center gap-1.5 mt-2 cursor-pointer text-xs text-red-600 hover:text-red-700">
                            <input type="checkbox" name="remove_image" value="1" class="rounded text-red-600 focus:ring-red-500">
                            <span>Hapus foto utama ini</span>
                        </label>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
                    <div>
                        <label class="text-[11px] font-semibold text-gray-700 block mb-1">
                            {{ isset($service) && $service->image ? 'Ganti File Foto Utama:' : 'Pilih File Foto Utama:' }}
                        </label>
                        <input type="file" name="image" accept="image/*" class="input-field text-xs bg-white py-1.5" @change="preview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : ''">
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-gray-700 block mb-1">Judul / Keterangan Foto Ini (Saat Dibuka Penuh):</label>
                        <input type="text" name="image_title" value="{{ old('image_title', $service->image_title ?? '') }}" 
                               class="input-field text-xs bg-white py-1.5" placeholder="Contoh: Maklumat Pelayanan UPT SMP Negeri 1 Buay Sandang Aji">
                        @error('image_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div x-show="preview" class="mt-2">
                    <p class="text-xs text-gray-500 mb-1">Pratinjau Foto Baru:</p>
                    <img :src="preview" class="h-28 rounded-xl object-contain border bg-white p-1">
                </div>
            </div>

            {{-- 2. Foto-Foto Tambahan / Galeri Layanan --}}
            <div x-data="{ 
                rows: [],
                addRow() {
                    this.rows.push({ id: Date.now() + Math.random(), preview: null });
                },
                removeRow(id) {
                    this.rows = this.rows.filter(r => r.id !== id);
                },
                handleRowFile(event, index) {
                    if (event.target.files.length) {
                        this.rows[index].preview = URL.createObjectURL(event.target.files[0]);
                    } else {
                        this.rows[index].preview = null;
                    }
                }
            }" class="bg-gray-50/70 p-4 rounded-xl border border-gray-100 space-y-4">
                <div>
                    <label class="form-label font-semibold text-gray-800 flex items-center justify-between mb-1">
                        <span>Foto Tambahan / Foto Kedua (Berdampingan)</span>
                        <span class="text-xs font-normal text-gray-400">Bisa upload foto disertai judul/keterangan tersendiri</span>
                    </label>
                    <p class="text-xs text-gray-500">Tambahkan foto tambahan jika ingin menampilkan foto di sebelah foto utama (misal: Maklumat Pelayanan, Alur Standar Pelayanan, dll).</p>
                </div>

                {{-- Foto Tersimpan Sebelumnya --}}
                @if(isset($service) && !empty($service->images) && is_array($service->images))
                <div class="space-y-3 bg-white p-3 rounded-xl border border-gray-200">
                    <p class="text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                        <i class="fas fa-images text-blue-500"></i>
                        Foto Tambahan Tersimpan ({{ count($service->images) }} Foto):
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($service->images as $idx => $imgItem)
                        @php
                            $imgPath = is_array($imgItem) ? ($imgItem['path'] ?? '') : $imgItem;
                            $imgTitle = is_array($imgItem) ? ($imgItem['title'] ?? '') : '';
                        @endphp
                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-2.5 flex gap-3 items-start shadow-xs">
                            <img src="{{ asset('storage/'.$imgPath) }}" class="h-20 w-24 rounded-lg object-contain bg-white border p-1 flex-shrink-0">
                            <div class="flex-1 min-w-0 space-y-1.5">
                                <input type="hidden" name="existing_image_paths[{{ $idx }}]" value="{{ $imgPath }}">
                                <div>
                                    <label class="text-[11px] font-semibold text-gray-600 block">Judul / Keterangan Foto Ini:</label>
                                    <input type="text" name="existing_image_titles[{{ $idx }}]" value="{{ old('existing_image_titles.'.$idx, $imgTitle) }}" 
                                           class="input-field text-xs py-1 px-2 bg-white border-gray-300 mt-0.5" placeholder="Contoh: Standar Operasional Prosedur">
                                </div>
                                <label class="inline-flex items-center gap-1.5 text-xs text-red-600 cursor-pointer hover:text-red-800">
                                    <input type="checkbox" name="remove_images[]" value="{{ $imgPath }}" class="rounded text-red-600 focus:ring-red-500">
                                    <span>Hapus foto ini</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Tambah Foto Baru Dinamis --}}
                <div class="space-y-3">
                    <template x-for="(row, index) in rows" :key="row.id">
                        <div class="p-3 bg-white rounded-xl border border-blue-100 shadow-xs flex flex-col md:flex-row gap-3 items-start md:items-center">
                            <div class="w-full md:w-5/12">
                                <label class="text-[11px] font-semibold text-gray-700 block mb-1">Pilih File Foto Baru:</label>
                                <input type="file" name="new_gallery_images[]" accept="image/*" class="input-field text-xs bg-gray-50 py-1.5" required @change="handleRowFile($event, index)">
                            </div>
                            <div class="w-full md:w-6/12">
                                <label class="text-[11px] font-semibold text-gray-700 block mb-1">Judul / Keterangan Foto Ini (Saat Dibuka Penuh):</label>
                                <input type="text" name="new_gallery_titles[]" class="input-field text-xs bg-gray-50 py-1.5" placeholder="Contoh: Alur Pelayanan / Formulir Pengajuan">
                            </div>
                            <div class="w-full md:w-1/12 flex md:justify-center">
                                <button type="button" @click="removeRow(row.id)" 
                                        class="mt-2 md:mt-5 p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg text-xs font-semibold flex items-center gap-1 cursor-pointer" title="Hapus Baris Ini">
                                    <i class="fas fa-trash-alt"></i> <span class="md:hidden">Hapus</span>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div class="flex items-center gap-2 pt-1">
                        <button type="button" @click="addRow()" 
                                class="btn-secondary text-xs py-2 px-3.5 flex items-center gap-1.5 cursor-pointer bg-white border border-blue-300 text-blue-700 hover:bg-blue-50 font-medium rounded-xl shadow-xs">
                            <i class="fas fa-plus"></i> + Tambah Foto Tambahan
                        </button>
                        <span class="text-xs text-gray-400">Klik tombol di atas untuk menambah baris foto beserta judul keterangannya</span>
                    </div>
                </div>
                @error('new_gallery_images.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- 3. File / Dokumen Lampiran --}}
            <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100">
                <label class="form-label font-semibold text-gray-800 flex items-center justify-between">
                    <span>File / Dokumen Lampiran (Formulir, SOP, Dokumen Persyaratan)</span>
                    <span class="text-xs font-normal text-gray-400">PDF, Word, Excel, ZIP (Maks 10MB)</span>
                </label>

                @if(isset($service) && $service->file)
                <div class="mb-3 flex items-center justify-between p-3 bg-white rounded-xl border border-gray-200">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-800 truncate">{{ $service->file_name ?? 'Dokumen Lampiran' }}</p>
                            <a href="{{ asset('storage/'.$service->file) }}" target="_blank" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1">
                                <i class="fas fa-file-download"></i> Unduh / Buka File
                            </a>
                        </div>
                    </div>
                    <label class="flex items-center gap-1.5 cursor-pointer text-xs text-red-600 hover:text-red-700 flex-shrink-0 ml-3">
                        <input type="checkbox" name="remove_file" value="1" class="rounded text-red-600 focus:ring-red-500">
                        <span>Hapus File</span>
                    </label>
                </div>
                @endif

                <input type="file" name="file" class="input-field bg-white" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt">
                @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Status Aktif --}}
        <div class="pt-2">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="rounded w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-gray-700">Aktifkan Layanan (Tampilkan di website publik)</span>
            </label>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-1"></i> Simpan Layanan
            </button>
            <a href="{{ route('admin.services.index') }}" class="btn-outline">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
