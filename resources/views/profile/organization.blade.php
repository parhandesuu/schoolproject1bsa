@extends('layouts.app')
@section('title', 'Struktur Organisasi')
@section('content')
<div class="container mx-auto px-4 max-w-7xl pt-8 pb-16">
    <div class="mb-8">
        <nav class="text-xs md:text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-blue-700">Beranda</a> <span class="mx-1 text-gray-400">/</span>
            <a href="{{ route('profile.index') }}" class="hover:text-blue-700">Profil</a> <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Struktur Organisasi</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800 tracking-tight">Struktur Organisasi</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <aside class="lg:col-span-1" data-aos="fade-right">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-24">
                <div class="bg-blue-700 px-5 py-4"><h3 class="font-bold text-white text-sm">Menu Profil</h3></div>
                <nav class="divide-y divide-gray-50">
                    @foreach([['Profil Sekolah','profile.index'],['Sejarah','profile.history'],['Visi & Misi','profile.vision-mission'],['Sambutan Kepsek','profile.principal'],['Struktur Organisasi','profile.organization']] as [$label,$route])
                    <a href="{{ route($route) }}" class="flex items-center justify-between px-5 py-3 text-sm {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        {{ $label }} <i class="fas fa-chevron-right text-xs opacity-40"></i>
                    </a>
                    @endforeach
                </nav>
            </div>
        </aside>
        <main class="lg:col-span-3" data-aos="fade-left">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Bagan Struktur Organisasi</h2>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">
                        UPT SMP Negeri 1 Buay Sandang Aji memiliki bagan struktur organisasi yang terintegrasi dan profesional untuk menjamin efektivitas tata kelola manajerial, mutu akademik, serta pelayanan pendidikan.
                    </p>
                </div>

                {{-- Organizational Tree Container --}}
                <div class="space-y-0 not-prose">
                    
                    {{-- ===== LEVEL 1: KEPALA SEKOLAH (PUNCAK HIERARKI) ===== --}}
                    <div class="relative z-10">
                        <div class="relative max-w-md mx-auto bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-950 text-white rounded-3xl p-6 md:p-7 shadow-xl border border-blue-500/30 text-center">
                            {{-- Top Role Badge --}}
                            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-white/10 backdrop-blur-md text-blue-200 text-xs font-semibold rounded-full border border-white/15 mb-3.5">
                                <i class="fas fa-crown text-amber-300 text-xs"></i> Pimpinan Satuan Pendidikan
                            </div>

                            {{-- Avatar / Foto --}}
                            <div class="relative w-24 h-24 md:w-28 md:h-28 mx-auto mb-3">
                                @if($principal && $principal->photo)
                                    <img src="{{ asset('storage/'.$principal->photo) }}" alt="{{ $principal->name }}"
                                         class="w-full h-full object-cover rounded-full ring-4 ring-white/30 shadow-lg">
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-indigo-700 ring-4 ring-white/30 shadow-lg flex items-center justify-center text-white text-3xl font-extrabold">
                                        {{ substr($principal->name ?? 'R', 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-amber-400 text-slate-900 rounded-full flex items-center justify-center text-xs font-bold ring-2 ring-slate-900 shadow-xs" title="Puncak Hierarki">
                                    <i class="fas fa-star text-[10px]"></i>
                                </div>
                            </div>

                            {{-- Label & Name --}}
                            <span class="text-xs font-semibold uppercase tracking-wider text-blue-200 block mb-1">Kepala Sekolah</span>
                            <h3 class="text-lg md:text-xl font-bold text-white tracking-tight">{{ $principal->name ?? 'Rosidah, S.Pd' }}</h3>
                            
                            {{-- Task Description --}}
                            <p class="text-xs text-blue-100/85 mt-2.5 pt-2.5 border-t border-white/15 max-w-sm mx-auto leading-relaxed">
                                Penanggung jawab utama penyelenggaraan pendidikan, kepemimpinan manajerial, supervisi guru & tenaga kependidikan, serta pengembangan mutu sekolah.
                            </p>

                            {{-- Bottom Connector Node on Card --}}
                            <div class="hidden md:block absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white shadow-2xs z-10"></div>
                        </div>
                    </div>

                    {{-- ===== CONNECTOR: LEVEL 1 -> LEVEL 2 ===== --}}
                    {{-- Desktop & Tablet Tree Branch --}}
                    <div class="hidden md:block">
                        {{-- Vertical stem from bottom center of Kepala Sekolah --}}
                        <div class="w-0.5 h-6 bg-blue-500 mx-auto"></div>

                        {{-- 2-Column Grid for exact pixel-perfect alignment with cards below --}}
                        <div class="grid grid-cols-2 gap-6 relative">
                            {{-- Left Arm (to Column 1) --}}
                            <div class="relative h-6">
                                {{-- Horizontal bar from center of Col 1 (50%) to right edge (-12px into center gap) --}}
                                <div class="absolute left-1/2 right-[-12px] top-0 h-0.5 bg-blue-500"></div>
                                {{-- Vertical drop line into Column 1 top center --}}
                                <div class="absolute left-1/2 top-0 w-0.5 h-full bg-blue-500 -translate-x-1/2"></div>
                                {{-- Small connection node on card top --}}
                                <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10 shadow-2xs"></div>
                            </div>

                            {{-- Right Arm (to Column 2) --}}
                            <div class="relative h-6">
                                {{-- Horizontal bar from left edge (-12px from center gap) to center of Col 2 (50%) --}}
                                <div class="absolute left-[-12px] right-1/2 top-0 h-0.5 bg-blue-500"></div>
                                {{-- Vertical drop line into Column 2 top center --}}
                                <div class="absolute left-1/2 top-0 w-0.5 h-full bg-blue-500 -translate-x-1/2"></div>
                                {{-- Small connection node on card top --}}
                                <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10 shadow-2xs"></div>
                            </div>

                            {{-- Center Main Junction Node --}}
                            <div class="absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 rounded-full bg-blue-600 border-2 border-white shadow-xs z-20"></div>
                        </div>
                    </div>

                    {{-- Mobile Connector Level 1 -> Level 2 --}}
                    <div class="block md:hidden relative">
                        <div class="w-0.5 h-6 bg-blue-500 mx-auto"></div>
                        <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10"></div>
                    </div>

                    {{-- ===== LEVEL 2: KOMITE & PENGAWAS SEKOLAH & TATA USAHA (EQUAL HEIGHT) ===== --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                        
                        {{-- BOX 1: KOMITE & PENGAWAS SEKOLAH --}}
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-200 shadow-xs flex flex-col justify-between h-full hover:border-blue-200 transition-colors">
                            <div>
                                {{-- Header Section --}}
                                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-gray-100">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm shrink-0">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm md:text-base leading-tight">Komite & Pengawas Sekolah</h4>
                                        <span class="text-[11px] text-gray-500 block">Unsur Pertimbangan, Dukungan & Pengawasan</span>
                                    </div>
                                </div>

                                {{-- Cards Inside --}}
                                <div class="space-y-3.5">
                                    {{-- Card Komite --}}
                                    <div class="bg-gray-50/90 hover:bg-blue-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                        <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-800 border border-amber-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Nazzarudin">
                                            N
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                                <span class="text-xs font-semibold text-blue-700 tracking-wide">Komite Sekolah</span>
                                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Mitra Sekolah</span>
                                            </div>
                                            <h5 class="text-sm font-bold text-gray-900 leading-snug">Nazzarudin</h5>
                                            <p class="text-xs text-gray-500 mt-1 leading-normal">Memberikan pertimbangan, arahan, dan penunjang fasilitas serta kemitraan masyarakat.</p>
                                        </div>
                                    </div>

                                    {{-- Card Pengawas --}}
                                    <div class="bg-gray-50/90 hover:bg-blue-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                        <div class="w-11 h-11 rounded-full bg-teal-100 text-teal-800 border border-teal-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Zahid, S.Pd">
                                            Z
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                                <span class="text-xs font-semibold text-blue-700 tracking-wide">Pengawas Sekolah</span>
                                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Pembina & Pengawas</span>
                                            </div>
                                            <h5 class="text-sm font-bold text-gray-900 leading-snug">Zahid, S.Pd</h5>
                                            <p class="text-xs text-gray-500 mt-1 leading-normal">Melaksanakan supervisi manajerial, pembinaan mutu akademik, dan pemantauan standar pendidikan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BOX 2: TATA USAHA (TU) --}}
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-200 shadow-xs flex flex-col justify-between h-full hover:border-indigo-200 transition-colors">
                            <div>
                                {{-- Header Section --}}
                                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-gray-100">
                                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-sm shrink-0">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm md:text-base leading-tight">Tata Usaha (TU)</h4>
                                        <span class="text-[11px] text-gray-500 block">Pelayanan Administrasi, Kepegawaian & Umum</span>
                                    </div>
                                </div>

                                {{-- Cards Inside --}}
                                <div class="space-y-3.5">
                                    {{-- Card Koordinator TU --}}
                                    <div class="bg-gray-50/90 hover:bg-indigo-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                        <div class="w-11 h-11 rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Irsan A Rani, SH">
                                            I
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                                <span class="text-xs font-semibold text-indigo-700 tracking-wide">Koordinator Tata Usaha</span>
                                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Kepala Urusan TU</span>
                                            </div>
                                            <h5 class="text-sm font-bold text-gray-900 leading-snug">Irsan A Rani, SH</h5>
                                            <p class="text-xs text-gray-500 mt-1 leading-normal">Memimpin dan mengkoordinasikan pelayanan administrasi umum, kepegawaian, dan persuratan.</p>
                                        </div>
                                    </div>

                                    {{-- Card Staf & Layanan TU (Equal-Height Balancing Card) --}}
                                    <div class="bg-gray-50/90 p-4 rounded-xl border border-gray-100 flex items-start gap-3.5">
                                        <div class="w-11 h-11 rounded-full bg-blue-100 text-blue-800 border border-blue-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Tim Staf Tata Usaha">
                                            <i class="fas fa-id-card-clip text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                                <span class="text-xs font-semibold text-blue-700 tracking-wide">Staf Administrasi & Teknis</span>
                                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-blue-700 border border-blue-200 shadow-2xs">6 Personel Staf</span>
                                            </div>
                                            <h5 class="text-sm font-bold text-gray-900 leading-snug">Staf Ketatausahaan & Pelayanan</h5>
                                            <p class="text-xs text-gray-500 mt-1 leading-normal">Mendukung administrasi kesiswaan, persuratan, operator data, kebersihan, dan operasional sekolah.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ===== CONNECTOR: LEVEL 2 -> LEVEL 3 ===== --}}
                    {{-- Desktop & Tablet Tree Merge --}}
                    <div class="hidden md:block">
                        {{-- 2-Column Grid for exact pixel-perfect alignment with cards above --}}
                        <div class="grid grid-cols-2 gap-6 relative">
                            {{-- Left Column Exit (from Column 1 bottom center) --}}
                            <div class="relative h-6">
                                {{-- Small connection node on card bottom --}}
                                <div class="absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10 shadow-2xs"></div>
                                {{-- Vertical line coming down from Column 1 --}}
                                <div class="absolute left-1/2 top-0 w-0.5 h-full bg-blue-500 -translate-x-1/2"></div>
                                {{-- Horizontal bar from center of Col 1 (50%) to right edge (-12px into center gap) --}}
                                <div class="absolute left-1/2 right-[-12px] bottom-0 h-0.5 bg-blue-500"></div>
                            </div>

                            {{-- Right Column Exit (from Column 2 bottom center) --}}
                            <div class="relative h-6">
                                {{-- Small connection node on card bottom --}}
                                <div class="absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10 shadow-2xs"></div>
                                {{-- Vertical line coming down from Column 2 --}}
                                <div class="absolute left-1/2 top-0 w-0.5 h-full bg-blue-500 -translate-x-1/2"></div>
                                {{-- Horizontal bar from left edge (-12px from center gap) to center of Col 2 (50%) --}}
                                <div class="absolute left-[-12px] right-1/2 bottom-0 h-0.5 bg-blue-500"></div>
                            </div>

                            {{-- Center Main Junction Node --}}
                            <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-3.5 h-3.5 rounded-full bg-blue-600 border-2 border-white shadow-xs z-20"></div>
                        </div>

                        {{-- Vertical stem dropping straight down into Level 3 --}}
                        <div class="relative">
                            <div class="w-0.5 h-6 bg-blue-500 mx-auto"></div>
                            {{-- Small connection node on Level 3 top --}}
                            <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10 shadow-2xs"></div>
                        </div>
                    </div>

                    {{-- Mobile Connector Level 2 -> Level 3 --}}
                    <div class="block md:hidden relative">
                        <div class="w-0.5 h-6 bg-blue-500 mx-auto"></div>
                        <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-2.5 h-2.5 rounded-full bg-blue-500 border-2 border-white z-10"></div>
                    </div>

                    {{-- ===== LEVEL 3: WAKIL KEPALA SEKOLAH & URUSAN BIDANG ===== --}}
                    <div class="bg-white rounded-2xl p-5 sm:p-7 border border-gray-200 shadow-xs hover:border-blue-200 transition-colors">
                        {{-- Header Section --}}
                        <div class="flex items-center gap-3 mb-5 pb-3.5 border-b border-gray-100">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-sm shrink-0">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm md:text-base leading-tight">Wakil Kepala Sekolah & Urusan Bidang</h4>
                                <span class="text-[11px] text-gray-500 block">Pelaksana Teknis & Operasional Penyelenggaraan Pendidikan</span>
                            </div>
                        </div>

                        {{-- 4 Grid Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            {{-- 1. Wakil Kurikulum --}}
                            <div class="bg-gray-50/90 hover:bg-blue-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-blue-100 text-blue-800 border border-blue-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Yuniartika, S.Pd">
                                    Y
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                        <span class="text-xs font-semibold text-blue-700 tracking-wide">Wakil Kurikulum</span>
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Bidang Akademik</span>
                                    </div>
                                    <h5 class="text-sm font-bold text-gray-900 leading-snug">Yuniartika, S.Pd</h5>
                                    <p class="text-xs text-gray-500 mt-1 leading-normal">Pengelolaan proses pembelajaran, jadwal KBM, evaluasi penilaian, dan kalender akademik.</p>
                                </div>
                            </div>

                            {{-- 2. Wakil Kesiswaan --}}
                            <div class="bg-gray-50/90 hover:bg-emerald-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Fara Mustikawati, S.Pd">
                                    F
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                        <span class="text-xs font-semibold text-emerald-700 tracking-wide">Wakil Kesiswaan</span>
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Bidang Kesiswaan</span>
                                    </div>
                                    <h5 class="text-sm font-bold text-gray-900 leading-snug">Fara Mustikawati, S.Pd</h5>
                                    <p class="text-xs text-gray-500 mt-1 leading-normal">Pembinaan karakter murid, kedisiplinan, OSIS, dan pengembangan kegiatan ekstrakurikuler.</p>
                                </div>
                            </div>

                            {{-- 3. Wakil Sapras & Bendahara --}}
                            <div class="bg-gray-50/90 hover:bg-purple-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-purple-100 text-purple-800 border border-purple-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Muhammad Erwin, S.Pd">
                                    M
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                        <span class="text-xs font-semibold text-purple-700 tracking-wide">Wakil Sapras & Bendahara</span>
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Sarpras & Keuangan</span>
                                    </div>
                                    <h5 class="text-sm font-bold text-gray-900 leading-snug">Muhammad Erwin, S.Pd</h5>
                                    <p class="text-xs text-gray-500 mt-1 leading-normal">Pengadaan, pemeliharaan sarana prasarana sekolah, serta akuntabilitas tata kelola anggaran.</p>
                                </div>
                            </div>

                            {{-- 4. Wakil Humas & K. Lab IPA --}}
                            <div class="bg-gray-50/90 hover:bg-cyan-50/40 p-4 rounded-xl border border-gray-100 transition-colors flex items-start gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-cyan-100 text-cyan-800 border border-cyan-200 font-bold text-base flex items-center justify-center shrink-0 shadow-2xs" aria-label="Avatar Emilia Rusda, S.Pd">
                                    E
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1">
                                        <span class="text-xs font-semibold text-cyan-700 tracking-wide">Wakil Humas & K. Lab IPA</span>
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-white text-gray-700 border border-gray-200 shadow-2xs">Humas & Lab</span>
                                    </div>
                                    <h5 class="text-sm font-bold text-gray-900 leading-snug">Emilia Rusda, S.Pd</h5>
                                    <p class="text-xs text-gray-500 mt-1 leading-normal">Pengembangan kemitraan masyarakat / wali murid dan optimalisasi sarana laboratorium IPA.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>
@endsection
