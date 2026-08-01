@extends('layouts.app')
@section('title', 'Pengumuman')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Pengumuman</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Pengumuman</nav>
    </div>
</div>
<div class="container mx-auto px-4 max-w-7xl py-12">
    @if($announcements->count() > 0)
    <div class="space-y-4 mb-8">
        @foreach($announcements as $ann)
        @php
            $borderColor = match($ann->type) {
                'warning' => 'border-amber-400',
                'success' => 'border-green-500',
                'danger'  => 'border-red-500',
                default   => 'border-blue-500',
            };
            $iconColor = match($ann->type) {
                'warning' => 'text-amber-500',
                'success' => 'text-green-500',
                'danger'  => 'text-red-500',
                default   => 'text-blue-500',
            };
            $icon = match($ann->type) {
                'warning' => 'fas fa-exclamation-triangle',
                'success' => 'fas fa-check-circle',
                'danger'  => 'fas fa-times-circle',
                default   => 'fas fa-info-circle',
            };
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 border-l-4 {{ $borderColor }} shadow-sm p-5 md:p-6">
            <div class="flex items-start gap-4">
                <i class="{{ $icon }} {{ $iconColor }} text-xl flex-shrink-0 mt-0.5"></i>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                        @if($ann->is_pinned)
                        <span class="text-xs bg-amber-100 text-amber-700 font-semibold px-2 py-0.5 rounded-full"><i class="fas fa-thumbtack mr-1"></i>Penting</span>
                        @endif
                        <h3 class="font-bold text-gray-900 text-lg">{{ $ann->title }}</h3>
                    </div>
                    <div class="prose-school text-sm mb-3">{!! $ann->content !!}</div>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                        <span><i class="fas fa-calendar mr-1"></i>{{ $ann->start_date ? \Carbon\Carbon::parse($ann->start_date)->format('d M Y') : $ann->created_at->format('d M Y') }}</span>
                        @if($ann->end_date)
                        <span>&mdash; {{ \Carbon\Carbon::parse($ann->end_date)->format('d M Y') }}</span>
                        @endif
                        @if($ann->file)
                        <a href="{{ asset('storage/'.$ann->file) }}" target="_blank"
                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg transition-colors">
                            <i class="fas fa-file-download"></i> Unduh Lampiran
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $announcements->links() }}
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-bullhorn text-6xl mb-4 block"></i><p>Belum ada pengumuman.</p></div>
    @endif
</div>
@endsection
