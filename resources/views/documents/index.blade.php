@extends('layouts.app')
@section('title', 'Dokumen Sekolah')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Dokumen</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Dokumen Sekolah</h1>
    </div>
    {{-- Search --}}
    <form method="GET" action="{{ route('documents.index') }}" class="flex gap-2 mb-8 max-w-md">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari dokumen..."
               class="input-field flex-1">
        <button type="submit" class="btn-primary px-4"><i class="fas fa-search"></i></button>
    </form>

    @if($groupedDocuments->count() > 0)
        @foreach($groupedDocuments as $category => $docs)
        <div class="mb-8">
            <h2 class="font-bold text-gray-900 text-xl mb-4 flex items-center gap-2">
                <i class="fas fa-folder-open text-amber-500"></i>
                {{ $category ?: 'Umum' }}
                <span class="text-sm font-normal text-gray-400">({{ $docs->count() }} file)</span>
            </h2>
            <div class="space-y-3">
                @foreach($docs as $doc)
                @php
                    $icon = match(strtolower($doc->file_type ?? '')) {
                        'pdf' => ['fas fa-file-pdf','text-red-500'],
                        'doc','docx' => ['fas fa-file-word','text-blue-600'],
                        'xls','xlsx' => ['fas fa-file-excel','text-green-600'],
                        'ppt','pptx' => ['fas fa-file-powerpoint','text-orange-500'],
                        'zip' => ['fas fa-file-archive','text-amber-500'],
                        default => ['fas fa-file','text-gray-400']
                    };
                @endphp
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-4 p-4">
                    <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center">
                        <i class="{{ $icon[0] }} {{ $icon[1] }} text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 text-sm">{{ $doc->title }}</div>
                        @if($doc->description)
                        <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $doc->description }}</div>
                        @endif
                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                            @if($doc->file_type)<span class="uppercase font-medium text-gray-500">{{ $doc->file_type }}</span>@endif
                            @if($doc->file_size)<span>{{ number_format($doc->file_size/1024, 0) }} KB</span>@endif
                            <span><i class="fas fa-download mr-1"></i>{{ $doc->downloads }} unduhan</span>
                        </div>
                    </div>
                    <a href="{{ route('documents.download', $doc) }}"
                       class="flex-shrink-0 flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-download"></i> Unduh
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @else
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-file-download text-6xl mb-4 block"></i>
        <p>{{ request('q') ? 'Tidak ada dokumen untuk pencarian "'.request('q').'"' : 'Belum ada dokumen tersedia.' }}</p>
    </div>
    @endif
</div>
@endsection
