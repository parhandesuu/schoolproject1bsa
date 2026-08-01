{{-- Admin CRUD Index Generic Template --}}
@extends('layouts.admin')
@section('page-title', $pageTitle ?? 'Kelola Data')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">{{ $pageTitle ?? 'Data' }}</h2>
    <a href="{{ $createRoute }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    @foreach($columns as $col)
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase {{ $col['class'] ?? '' }}">{{ $col['label'] }}</th>
                    @endforeach
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50/50">
                    @foreach($columns as $col)
                    <td class="px-5 py-3.5 {{ $col['td_class'] ?? '' }}">{!! $col['value']($item) !!}</td>
                    @endforeach
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route($editRoute, $item) }}" class="icon-btn-blue"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route($deleteRoute, $item) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($columns)+1 }}" class="text-center py-12 text-gray-400">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($items) && method_exists($items,'hasPages') && $items->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $items->links() }}</div>
    @endif
</div>
@endsection
