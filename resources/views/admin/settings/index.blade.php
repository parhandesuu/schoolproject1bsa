@extends('layouts.admin')
@section('page-title','Pengaturan Situs')
@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Pengaturan Situs</h2>
    <p class="text-sm text-gray-500 mt-0.5">Kelola informasi dan konfigurasi website sekolah</p>
</div>

<div x-data="{ tab: 'general' }">
    {{-- Tabs --}}
    <div class="flex gap-2 mb-6 border-b border-gray-200">
        @foreach([['general','fas fa-cog','Umum'],['contact','fas fa-map-marker-alt','Kontak'],['seo','fas fa-search','SEO'],['social','fas fa-share-alt','Social Media']] as [$t,$icon,$label])
        <button @click="tab='{{ $t }}'"
                :class="tab==='{{ $t }}' ? 'border-b-2 border-blue-700 text-blue-700' : 'text-gray-500 hover:text-gray-700'"
                class="flex items-center gap-2 px-4 py-3 text-sm font-medium transition-colors -mb-px">
            <i class="{{ $icon }}"></i>{{ $label }}
        </button>
        @endforeach
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- General --}}
        <div x-show="tab==='general'" class="admin-card space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach([['school_name','Nama Sekolah','text'],['school_short_name','Nama Singkat','text'],['school_npsn','NPSN','text'],['school_accreditation','Akreditasi','text'],['school_year_established','Tahun Berdiri','number'],['school_motto','Motto Sekolah','text']] as [$key,$label,$type])
                <div>
                    <label class="form-label">{{ $label }}</label>
                    <input type="{{ $type }}" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="input-field">
                </div>
                @endforeach
            </div>
            <div>
                <label class="form-label">Deskripsi Sekolah</label>
                <textarea name="school_description" rows="4" class="input-field">{{ old('school_description', $settings['school_description'] ?? '') }}</textarea>
            </div>
        </div>

        {{-- Contact --}}
        <div x-show="tab==='contact'" class="admin-card space-y-5">
            <div>
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="contact_address" rows="3" class="input-field">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach([['contact_phone','Telepon','tel'],['contact_email','Email','email'],['contact_whatsapp','WhatsApp (tanpa +)','text'],['contact_maps_embed','Google Maps Embed URL','url']] as [$key,$label,$type])
                <div>
                    <label class="form-label">{{ $label }}</label>
                    <input type="{{ $type }}" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="input-field">
                </div>
                @endforeach
            </div>
            <div>
                <label class="form-label">Google Maps Embed Code (iframe src)</label>
                <textarea name="contact_maps_embed" rows="2" class="input-field font-mono text-xs">{{ old('contact_maps_embed', $settings['contact_maps_embed'] ?? '') }}</textarea>
            </div>
        </div>

        {{-- SEO --}}
        <div x-show="tab==='seo'" class="admin-card space-y-5">
            @foreach([['meta_title','Meta Title Utama'],['meta_description','Meta Description Utama'],['meta_keywords','Meta Keywords']] as [$key,$label])
            <div>
                <label class="form-label">{{ $label }}</label>
                <{{ $key === 'meta_description' || $key === 'meta_keywords' ? 'textarea rows="3"' : 'input type="text"' }} name="{{ $key }}" class="input-field">{{ old($key, $settings[$key] ?? '') }}</{{ $key === 'meta_description' || $key === 'meta_keywords' ? 'textarea' : 'input' }}>
            </div>
            @endforeach
        </div>

        {{-- Social --}}
        <div x-show="tab==='social'" class="admin-card space-y-5">
            <p class="text-sm text-gray-500">Kelola akun social media di menu <a href="{{ route('admin.social-media.index') }}" class="text-blue-600 hover:underline">Media Sosial</a>.</p>
        </div>

        <div class="mt-5">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection
