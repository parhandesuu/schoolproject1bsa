@extends('layouts.admin')
@section('page-title','Album Foto')
@section('content')
<div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-gray-900">Album Foto</h2><a href="{{ route('admin.photo-albums.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Album</a></div>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
    @forelse($albums as $album)
    <div class="card group">
        <div class="aspect-video overflow-hidden bg-gray-100">
            @if($album->cover)<img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else<div class="w-full h-full flex items-center justify-center"><i class="fas fa-images text-gray-300 text-3xl"></i></div>@endif
        </div>
        <div class="p-3">
            <div class="font-semibold text-gray-900 text-sm mb-1 truncate">{{ $album->name }}</div>
            <div class="text-xs text-gray-400 mb-3"><i class="fas fa-images mr-1"></i>{{ $album->photos_count ?? 0 }} foto</div>
            <div class="flex gap-2">
                <a href="{{ route('admin.photo-albums.show', $album) }}" class="flex-1 text-center text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1.5 rounded-lg transition-colors"><i class="fas fa-images mr-1"></i>Foto</a>
                <a href="{{ route('admin.photo-albums.edit', $album) }}" class="icon-btn-blue text-xs"><i class="fas fa-pencil-alt"></i></a>
                <form action="{{ route('admin.photo-albums.destroy', $album) }}" method="POST" onsubmit="return confirm('Hapus album ini?')">@csrf @method('DELETE')<button type="submit" class="icon-btn-red text-xs"><i class="fas fa-trash"></i></button></form>
            </div>
        </div>
    </div>
    @empty<div class="col-span-4 text-center py-12 text-gray-400"><i class="fas fa-camera text-4xl mb-3 block"></i>Belum ada album foto</div>@endforelse
</div>
@if($albums->hasPages())<div class="mt-5">{{ $albums->links() }}</div>@endif
@endsection
