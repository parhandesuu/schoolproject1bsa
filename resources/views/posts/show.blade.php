@extends('layouts.app')
@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('og_image', $post->thumbnail ? asset('storage/'.$post->thumbnail) : '')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
<div class="container mx-auto px-4 max-w-7xl">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <main class="lg:col-span-2">
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Thumbnail --}}
                @if($post->thumbnail)
                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}"
                     class="w-full aspect-video object-cover">
                @endif

                <div class="p-6 md:p-8">
                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        @if($post->category)
                        <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
                           class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full hover:bg-blue-100">
                            {{ $post->category->name }}
                        </a>
                        @endif
                        @if($post->is_featured)
                        <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full"><i class="fas fa-thumbtack mr-1"></i>Disematkan</span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight mb-4">{{ $post->title }}</h1>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-6 pb-6 border-b border-gray-100">
                        @if($post->user)
                        <span class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-700">{{ strtoupper(substr($post->user->name,0,1)) }}</div>
                            {{ $post->user->name }}
                        </span>
                        @endif
                        <span><i class="fas fa-calendar mr-1"></i>{{ $post->published_at?->format('d F Y') }}</span>
                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->views) }} dilihat</span>
                    </div>

                    {{-- Content --}}
                    <div class="prose-school">
                        {!! $post->content !!}
                    </div>

                    {{-- Share --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-sm font-medium text-gray-500 mb-3">Bagikan artikel ini:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                               class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank"
                               class="flex items-center gap-2 px-4 py-2 bg-sky-400 text-white rounded-lg text-sm hover:bg-sky-500 transition-colors">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title.' - '.url()->current()) }}" target="_blank"
                               class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 transition-colors">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(()=>alert('Link disalin!'))"
                                    class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">
                                <i class="fas fa-link"></i> Salin Link
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Comments --}}
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Komentar <span class="text-blue-700">({{ $post->approvedComments->count() }})</span>
                </h3>

                {{-- Comment List --}}
                @forelse($post->approvedComments as $comment)
                <div class="flex gap-4 pb-4 mb-4 border-b border-gray-50 last:border-0 last:mb-0 last:pb-0">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-700 text-sm flex-shrink-0">
                        {{ strtoupper(substr($comment->name,0,1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-gray-800 text-sm">{{ $comment->name }}</span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $comment->content }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-comments text-3xl mb-2 block"></i>
                    <p class="text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                </div>
                @endforelse

                {{-- Comment Form --}}
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="font-bold text-gray-900 mb-4">Tinggalkan Komentar</h4>
                    @if(session('comment_success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('comment_success') }}
                    </div>
                    @endif
                    <form action="{{ route('posts.comment', $post) }}" method="POST" class="space-y-4">
                        @csrf
                        {{-- Honeypot --}}
                        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Nama *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="input-field" required>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Komentar *</label>
                            <textarea name="content" rows="4" class="input-field resize-none" required placeholder="Tulis komentar Anda...">{{ old('content') }}</textarea>
                            @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <p class="text-xs text-gray-400">* Komentar akan ditampilkan setelah dimoderasi oleh admin.</p>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>
        </main>

        {{-- Sidebar --}}
        <aside class="lg:col-span-1">
            {{-- Related Posts --}}
            @if($relatedPosts->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
                <h3 class="font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">Artikel Terkait</h3>
                <div class="space-y-4">
                    @foreach($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related) }}" class="flex gap-3 group">
                        <div class="w-20 h-16 flex-shrink-0 rounded-xl overflow-hidden bg-blue-50">
                            @if($related->thumbnail)
                            <img src="{{ asset('storage/'.$related->thumbnail) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                            <div class="w-full h-full flex items-center justify-center"><i class="fas fa-newspaper text-blue-300"></i></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-blue-700 transition-colors">{{ $related->title }}</h4>
                            <span class="text-xs text-gray-400 mt-1 block">{{ $related->published_at?->format('d M Y') }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Breadcrumb --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <nav class="text-sm text-gray-500 space-y-1">
                    <a href="{{ route('home') }}" class="block hover:text-blue-700"><i class="fas fa-home mr-2 text-xs"></i>Beranda</a>
                    <a href="{{ route('posts.index') }}" class="block hover:text-blue-700 pl-5"><i class="fas fa-chevron-right mr-2 text-xs text-gray-300"></i>Berita</a>
                    <span class="block pl-5 text-gray-400 text-xs line-clamp-2"><i class="fas fa-chevron-right mr-2 text-gray-200"></i>{{ $post->title }}</span>
                </nav>
            </div>
        </aside>
    </div>
</div>
</div>
@endsection
