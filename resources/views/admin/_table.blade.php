{{-- Reusable Simple CRUD Index Template - used by multiple admin sections --}}
@extends('layouts.admin')
@section('page-title', $pageTitle)
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">{{ $pageTitle }}</h2>
    <a href="{{ $createUrl }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 bg-gray-50/50">
                @foreach($headers as $h)
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase {{ strpos($h,'Aksi')!==false || strpos($h,'Status')!==false || strpos($h,'No')!==false ? 'text-center' : '' }}">{{ $h }}</th>
                @endforeach
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @isset($pagination){{ $pagination }}@endisset
</div>
@endsection
