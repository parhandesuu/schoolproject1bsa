@extends('layouts.admin')
@section('page-title','Hero Slider')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Hero Slider</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kelola slide gambar beranda</p>
    </div>
    <a href="{{ route('admin.hero-sliders.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Slider
    </a>
</div>

<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">No</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Gambar</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Judul</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Subtitle</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Urutan</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($sliders as $i => $slider)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5 text-gray-500">{{ $sliders->firstItem() + $i }}</td>
                    <td class="px-5 py-3.5">
                        @if($slider->image)
                        <img src="{{ asset('storage/'.$slider->image) }}" alt="{{ $slider->title }}" class="w-20 h-12 object-cover rounded-lg">
                        @else
                        <div class="w-20 h-12 bg-gray-100 rounded-lg flex items-center justify-center"><i class="fas fa-image text-gray-300 text-xl"></i></div>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 font-medium text-gray-900 max-w-xs">{{ Str::limit($slider->title, 40) }}</td>
                    <td class="px-5 py-3.5 text-gray-500 max-w-xs">{{ Str::limit($slider->subtitle, 40) }}</td>
                    <td class="px-5 py-3.5 text-center text-gray-600">{{ $slider->order }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $slider->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2" x-data="{ confirmDelete: false }">
                            <a href="{{ route('admin.hero-sliders.edit', $slider) }}" class="icon-btn-blue" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <button @click="confirmDelete=true" class="icon-btn-red" title="Hapus"><i class="fas fa-trash"></i></button>
                            {{-- Delete Modal --}}
                            <div x-show="confirmDelete" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="confirmDelete=false">
                                <div @click.stop class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                                        <i class="fas fa-trash text-red-500"></i>
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-center mb-2">Hapus Slider?</h3>
                                    <p class="text-gray-500 text-sm text-center mb-6">Tindakan ini tidak dapat dibatalkan.</p>
                                    <div class="flex gap-3">
                                        <button @click="confirmDelete=false" class="btn-outline w-full text-center">Batal</button>
                                        <form action="{{ route('admin.hero-sliders.destroy', $slider) }}" method="POST" class="w-full">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-images text-4xl mb-3 block"></i>Belum ada hero slider</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sliders->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $sliders->links() }}</div>
    @endif
</div>
@endsection
