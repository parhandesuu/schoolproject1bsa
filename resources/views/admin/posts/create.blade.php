@extends('layouts.admin')
@section('page-title', isset($post) ? 'Edit Berita' : 'Tambah Berita')
@push('styles')
<style>
.ql-container { height: 350px; }
</style>
@endpush

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.posts.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
        <i class="fas fa-arrow-left text-gray-600"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-gray-900">{{ isset($post) ? 'Edit Berita' : 'Tambah Berita Baru' }}</h2>
        <p class="text-xs text-gray-500 mt-0.5">Lengkapi formulir di bawah ini untuk membuat atau memperbarui artikel berita.</p>
    </div>
</div>

@if(isset($post) && $post->status === 'rejected')
<div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
    <div class="flex items-start gap-3">
        <i class="fas fa-exclamation-triangle text-red-500 text-lg mt-0.5"></i>
        <div>
            <h4 class="text-sm font-bold text-red-800">Artikel Ini Ditolak / Memerlukan Revisi</h4>
            <p class="text-xs text-red-700 mt-1"><strong>Alasan / Catatan Editor:</strong> {{ $post->rejection_note ?? 'Silakan sesuaikan isi artikel sebelum mengajukan kembali.' }}</p>
            <p class="text-xs text-red-600 mt-1">Setelah diperbaiki, ubah status menjadi <strong>"Ajukan Review (Menunggu Persetujuan)"</strong> lalu simpan.</p>
        </div>
    </div>
</div>
@endif

<form action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf @if(isset($post)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="admin-card">
                <div>
                    <label class="form-label">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}"
                           class="input-field text-lg font-semibold" required placeholder="Judul artikel..."
                           oninput="generateSlug(this.value)">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mt-4">
                    <label class="form-label">Slug URL</label>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-400 flex-shrink-0">{{ url('/berita') }}/</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug ?? '') }}"
                               class="input-field flex-1" placeholder="slug-artikel">
                    </div>
                    @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="admin-card">
                <label class="form-label">Ringkasan (Excerpt)</label>
                <textarea name="excerpt" rows="3" class="input-field" placeholder="Ringkasan singkat artikel...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
            </div>

            <div class="admin-card">
                <label class="form-label">Konten Artikel <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" class="input-field" rows="10">{{ old('content', $post->content ?? '') }}</textarea>
                @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="admin-card">
                <label class="form-label">SEO</label>
                <div class="space-y-3">
                    <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}"
                           class="input-field" placeholder="Meta Title (opsional, default: judul berita)">
                    <textarea name="meta_description" rows="2" class="input-field" placeholder="Meta Description (opsional)">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-5">
            <div class="admin-card">
                <label class="form-label">Thumbnail @if(!isset($post))<span class="text-red-500">*</span>@endif</label>
                @if(isset($post) && $post->thumbnail)
                <img src="{{ asset('storage/'.$post->thumbnail) }}" class="w-full rounded-xl mb-3 object-cover h-36" id="thumb-preview">
                @else
                <img id="thumb-preview" class="w-full rounded-xl mb-3 object-cover h-36 hidden">
                @endif
                <input type="file" name="thumbnail" accept="image/*" class="input-field" {{ !isset($post) ? 'required' : '' }}
                       onchange="document.getElementById('thumb-preview').src=URL.createObjectURL(this.files[0]); document.getElementById('thumb-preview').classList.remove('hidden')">
                @error('thumbnail')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="admin-card space-y-4">
                <div>
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="input-field">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Status Publikasi</label>
                    <select name="status" class="input-field font-medium">
                        @can('berita.publish')
                            <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Published (Langsung Terbit)</option>
                            <option value="draft" {{ old('status', $post->status ?? '') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                            <option value="pending_review" {{ old('status', $post->status ?? '') === 'pending_review' ? 'selected' : '' }}>Menunggu Review (Pending)</option>
                        @else
                            <option value="draft" {{ old('status', $post->status ?? '') === 'draft' ? 'selected' : '' }}>Draft (Simpan Konsep)</option>
                            <option value="pending_review" {{ old('status', $post->status ?? 'pending_review') === 'pending_review' ? 'selected' : '' }}>Ajukan Review (Menunggu Persetujuan)</option>
                        @endcan
                    </select>
                    @cannot('berita.publish')
                        <p class="text-[11px] text-gray-500 mt-1">Pilih <em>Ajukan Review</em> agar artikel dapat ditinjau dan diterbitkan oleh Editor/Admin.</p>
                    @endcannot
                </div>
                <div>
                    <label class="form-label">Tanggal Publish</label>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                           class="input-field">
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-blue-600"
                           {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">Tandai sebagai Disematkan</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <i class="fas fa-save"></i> {{ isset($post) ? 'Simpan Perubahan' : 'Simpan Berita' }}
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn-outline px-4">Batal</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    height: 450,
    skin: 'oxide',
    content_css: 'default',
    images_upload_url: '{{ route("admin.posts.index") }}',
    automatic_uploads: false,
    file_picker_types: 'image',
});

function generateSlug(title) {
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
}
</script>
@endpush
@endsection
