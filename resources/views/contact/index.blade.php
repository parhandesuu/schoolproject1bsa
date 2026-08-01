@extends('layouts.app')
@section('title', 'Hubungi Kami')
@section('content')
<div class="bg-gradient-to-r from-blue-800 to-blue-900 py-16">
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-4xl font-bold text-white mb-2">Hubungi Kami</h1>
        <nav class="text-white/60 text-sm"><a href="{{ route('home') }}" class="hover:text-white">Beranda</a> / Kontak</nav>
    </div>
</div>

<div class="container mx-auto px-4 max-w-7xl py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Info --}}
        <aside class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-5">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 mb-0.5">Alamat</div>
                            <div class="text-sm text-gray-700">{{ $settings['contact_address'] ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 mb-0.5">Telepon</div>
                            <a href="tel:{{ $settings['contact_phone'] ?? '' }}" class="text-sm text-blue-600 hover:underline">{{ $settings['contact_phone'] ?? '-' }}</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 mb-0.5">Email</div>
                            <a href="mailto:{{ $settings['contact_email'] ?? '' }}" class="text-sm text-blue-600 hover:underline">{{ $settings['contact_email'] ?? '-' }}</a>
                        </div>
                    </div>
                    @if(isset($settings['contact_whatsapp']) && $settings['contact_whatsapp'])
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-500 mb-0.5">WhatsApp</div>
                            <a href="https://wa.me/{{ $settings['contact_whatsapp'] }}" target="_blank" class="text-sm text-green-600 hover:underline">{{ $settings['contact_whatsapp'] }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Social Media --}}
            @if($socialMedia->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Media Sosial</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($socialMedia as $sm)
                    <a href="{{ $sm->url }}" target="_blank"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all hover:shadow-md"
                       style="background-color:{{ $sm->color ?? '#3b82f6' }}15; color:{{ $sm->color ?? '#3b82f6' }}; border: 1px solid {{ $sm->color ?? '#3b82f6' }}25">
                        <i class="{{ $sm->icon }}"></i>
                        {{ $sm->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Maps --}}
            @if(isset($settings['contact_maps_embed']) && $settings['contact_maps_embed'])
            <div class="rounded-2xl overflow-hidden shadow-sm h-48">
                <iframe src="{{ $settings['contact_maps_embed'] }}" width="100%" height="100%"
                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            @endif
        </aside>

        {{-- Form --}}
        <main class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                <h3 class="font-bold text-gray-900 text-xl mb-6">Kirim Pesan</h3>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <div>
                        <div class="font-semibold text-green-800">Pesan Terkirim!</div>
                        <div class="text-sm text-green-600">{{ session('success') }}</div>
                    </div>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input-field" required placeholder="Masukkan nama Anda">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="input-field" required placeholder="email@contoh.com">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="input-field" placeholder="(opsional)">
                        </div>
                        <div>
                            <label class="form-label">Subjek *</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="input-field" required placeholder="Perihal pesan Anda">
                            @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Pesan *</label>
                        <textarea name="message" rows="6" class="input-field resize-none" required placeholder="Tulis pesan Anda...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
