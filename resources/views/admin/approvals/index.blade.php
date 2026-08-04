@extends('layouts.admin')

@section('page-title', 'Pusat Persetujuan (Approval)')

@section('breadcrumb')
    <span class="text-gray-400">Admin</span> / <span class="text-gray-600">Approval</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ tab: 'posts' }">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Pusat Persetujuan Konten</h2>
            <p class="text-blue-100 text-sm mt-1">Tinjau draft yang diajukan oleh Staff sebelum diterbitkan ke website publik.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-clock text-yellow-300"></i>
                <span>{{ $pendingPosts->total() + $pendingPages->total() }} Menunggu Review</span>
            </span>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex border-b border-gray-200 bg-white rounded-xl p-1 shadow-sm">
        <button @click="tab = 'posts'" 
                :class="tab === 'posts' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                class="flex-1 py-2.5 px-4 text-sm font-medium rounded-lg transition-all flex items-center justify-center gap-2">
            <i class="fas fa-newspaper"></i>
            <span>Berita & Artikel</span>
            @if($pendingPosts->total() > 0)
                <span :class="tab === 'posts' ? 'bg-white text-blue-600' : 'bg-red-500 text-white'" class="text-xs px-2 py-0.5 rounded-full font-bold">
                    {{ $pendingPosts->total() }}
                </span>
            @endif
        </button>
        <button @click="tab = 'pages'" 
                :class="tab === 'pages' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                class="flex-1 py-2.5 px-4 text-sm font-medium rounded-lg transition-all flex items-center justify-center gap-2">
            <i class="fas fa-file-alt"></i>
            <span>Halaman Statis</span>
            @if($pendingPages->total() > 0)
                <span :class="tab === 'pages' ? 'bg-white text-blue-600' : 'bg-red-500 text-white'" class="text-xs px-2 py-0.5 rounded-full font-bold">
                    {{ $pendingPages->total() }}
                </span>
            @endif
        </button>
    </div>

    <!-- TAB 1: PENDING POSTS -->
    <div x-show="tab === 'posts'" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
                <i class="fas fa-newspaper text-blue-600"></i>
                Daftar Berita Menunggu Persetujuan
            </h3>
            <span class="text-xs text-gray-500">Total: {{ $pendingPosts->total() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5">Judul Berita</th>
                        <th class="px-5 py-3.5">Penulis</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Tanggal Dibuat</th>
                        <th class="px-5 py-3.5 text-center">Aksi Review</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendingPosts as $post)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-900 line-clamp-1">{{ $post->title }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ Str::limit(strip_tags($post->body), 80) }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs">
                                    {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800 text-xs">{{ $post->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[11px] text-gray-400">{{ ucfirst($post->user->roles->first()->name ?? 'Staff') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $post->category->name ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-500">
                            {{ $post->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2" x-data="{ showRejectModal: false }">
                                <a href="{{ route('admin.posts.show', $post) }}" target="_blank" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('berita.publish')
                                <!-- Approve Form -->
                                <form action="{{ route('admin.approvals.posts.approve', $post) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dan menerbitkan berita ini?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 transition-all shadow-sm">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <button type="button" @click="showRejectModal = true" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 transition-all shadow-sm">
                                    <i class="fas fa-times"></i> Tolak
                                </button>

                                <!-- Reject Modal -->
                                <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showRejectModal = false"></div>
                                    <div class="relative min-h-screen flex items-center justify-center p-4">
                                        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl text-left" @click.outside="showRejectModal = false">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Tolak Draft Berita</h4>
                                            <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan agar pembuat berita dapat melakukan revisi yang diperlukan.</p>
                                            
                                            <form action="{{ route('admin.approvals.posts.reject', $post) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Alasan Penolakan</label>
                                                    <textarea name="rejection_note" rows="4" required class="w-full text-sm rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Tuliskan catatan perbaikan di sini..."></textarea>
                                                </div>
                                                <div class="flex items-center justify-end gap-2">
                                                    <button type="button" @click="showRejectModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all shadow-md">
                                                        Konfirmasi Penolakan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            <i class="fas fa-check-circle text-4xl text-green-400 mb-3"></i>
                            <p class="text-sm font-medium text-gray-600">Tidak ada berita yang menunggu persetujuan.</p>
                            <p class="text-xs text-gray-400 mt-1">Semua konten berita saat ini sudah ditinjau.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendingPosts->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $pendingPosts->links() }}
        </div>
        @endif
    </div>

    <!-- TAB 2: PENDING PAGES -->
    <div x-show="tab === 'pages'" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" style="display: none;">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
                <i class="fas fa-file-alt text-blue-600"></i>
                Daftar Halaman Statis Menunggu Persetujuan
            </h3>
            <span class="text-xs text-gray-500">Total: {{ $pendingPages->total() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5">Judul Halaman</th>
                        <th class="px-5 py-3.5">Slug</th>
                        <th class="px-5 py-3.5">Terakhir Diperbarui</th>
                        <th class="px-5 py-3.5 text-center">Aksi Review</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendingPages as $page)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-900">{{ $page->title }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ Str::limit(strip_tags($page->body), 80) }}</div>
                        </td>
                        <td class="px-5 py-4 text-xs font-mono text-gray-500">
                            /{{ $page->slug }}
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-500">
                            {{ $page->updated_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2" x-data="{ showRejectModal: false }">
                                <a href="{{ route('admin.pages.show', $page) }}" target="_blank" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('halaman.publish')
                                <!-- Approve Form -->
                                <form action="{{ route('admin.approvals.pages.approve', $page) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dan menerbitkan halaman ini?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 transition-all shadow-sm">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <button type="button" @click="showRejectModal = true" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium flex items-center gap-1.5 transition-all shadow-sm">
                                    <i class="fas fa-times"></i> Tolak
                                </button>

                                <!-- Reject Modal -->
                                <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showRejectModal = false"></div>
                                    <div class="relative min-h-screen flex items-center justify-center p-4">
                                        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl text-left" @click.outside="showRejectModal = false">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Tolak Draft Halaman</h4>
                                            <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan agar pembuat halaman dapat melakukan revisi yang diperlukan.</p>
                                            
                                            <form action="{{ route('admin.approvals.pages.reject', $page) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Alasan Penolakan</label>
                                                    <textarea name="rejection_note" rows="4" required class="w-full text-sm rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Tuliskan catatan perbaikan di sini..."></textarea>
                                                </div>
                                                <div class="flex items-center justify-end gap-2">
                                                    <button type="button" @click="showRejectModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 text-sm font-semibold bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all shadow-md">
                                                        Konfirmasi Penolakan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-gray-400">
                            <i class="fas fa-check-circle text-4xl text-green-400 mb-3"></i>
                            <p class="text-sm font-medium text-gray-600">Tidak ada halaman yang menunggu persetujuan.</p>
                            <p class="text-xs text-gray-400 mt-1">Semua konten halaman saat ini sudah ditinjau.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendingPages->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $pendingPages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
