@extends('layouts.app')
@section('title', 'Berita & Artikel')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Berita & Artikel</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Berita & Artikel</h1>
    </div>
    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <form action="{{ route('posts.index') }}" method="GET" class="flex gap-2 flex-1">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..."
                   class="input-field flex-1">
            <button type="submit" class="btn-primary px-4"><i class="fas fa-search"></i></button>
        </form>
    </div>

    {{-- Category Tabs --}}
    @php $categories = \App\Models\Category::where('is_active',true)->withCount(['posts' => fn($q)=>$q->published()])->get(); @endphp
    @if($categories->count() > 0)
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('posts.index', request()->except('category')) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('category') ? 'bg-blue-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('posts.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === $cat->slug ? 'bg-blue-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            {{ $cat->name }} <span class="opacity-60">({{ $cat->posts_count }})</span>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Posts Grid --}}
    @if($posts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($posts as $post)
        <article class="card group {{ $post->is_featured ? 'ring-2 ring-blue-500 ring-offset-2' : '' }}">
            <a href="{{ route('posts.show', $post) }}" class="block">
                <div class="aspect-video overflow-hidden">
                    @if($post->thumbnail)
                    <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                        <i class="fas fa-newspaper text-blue-300 text-4xl"></i>
                    </div>
                    @endif
                </div>
            </a>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                    @if($post->category)
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">{{ $post->category->name }}</span>
                    @endif
                    @if($post->is_featured)
                    <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full"><i class="fas fa-star mr-1"></i>Featured</span>
                    @endif
                </div>
                <h2 class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-700 transition-colors">
                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                </h2>
                @if($post->excerpt)
                <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                @endif
                <div class="flex items-center justify-between text-xs text-gray-400 pt-3 border-t border-gray-50">
                    <span><i class="fas fa-calendar mr-1"></i>{{ $post->published_at?->format('d M Y') }}</span>
                    <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->views) }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    {{ $posts->withQueryString()->links() }}
    @else
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-newspaper text-6xl mb-4 block"></i>
        <h3 class="text-xl font-semibold mb-2">Belum Ada Berita</h3>
        <p class="text-sm">{{ request('q') ? 'Tidak ada hasil untuk pencarian "'.request('q').'"' : 'Belum ada berita yang dipublikasikan.' }}</p>
    </div>
    @endif
</div>
@endsection
