@extends('layouts.admin')
@section('page-title', 'Foto Album: '.$album->name)
@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.photo-albums.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a>
        <div><h2 class="text-xl font-bold text-gray-900">{{ $album->name }}</h2><p class="text-sm text-gray-400">{{ $album->photos_count }} foto</p></div>
    </div>
</div>
{{-- Upload form --}}
<div class="admin-card mb-6">
    <h3 class="font-semibold text-gray-900 mb-4">Upload Foto</h3>
    <form action="{{ route('admin.photo-albums.photos.store', $album) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
        @csrf
        <div class="flex-1">
            <label class="form-label">Pilih Foto (bisa multiple)</label>
            <input type="file" name="images[]" accept="image/*" multiple class="input-field" required>
        </div>
        <button type="submit" class="btn-primary flex-shrink-0"><i class="fas fa-upload"></i> Upload</button>
    </form>
</div>
{{-- Photos grid --}}
<div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
    @forelse($album->photos as $photo)
    <div class="relative group aspect-square rounded-xl overflow-hidden bg-gray-100">
        <img src="{{ asset('storage/'.$photo->image) }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 flex items-end justify-end p-2 transition-all">
            <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" class="opacity-0 group-hover:opacity-100">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Hapus foto?')" class="w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center text-xs"><i class="fas fa-times"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-6 text-center py-12 text-gray-400"><i class="fas fa-camera text-4xl mb-3 block"></i>Belum ada foto</div>
    @endforelse
</div>
@endsection
