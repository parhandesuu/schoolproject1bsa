@extends('layouts.admin')

@section('page-title', 'Pemberitahuan Sistem')

@section('breadcrumb')
    <span class="text-gray-400">Admin</span> / <span class="text-gray-600">Notifikasi</span>
@endsection

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-bell text-yellow-300"></i> Notifikasi Masuk
            </h2>
            <p class="text-indigo-100 text-sm mt-1">Pemberitahuan persetujuan konten, komentar baru, dan pesan masuk.</p>
        </div>
        <div>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Notification List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100 overflow-hidden">
        @forelse($notifications as $notif)
            @php
                $isUnread = is_null($notif->read_at);
                $type = $notif->data['type'] ?? 'info';
                $iconClass = match($type) {
                    'post_approved', 'page_approved' => 'fa-check-circle text-green-500 bg-green-50',
                    'post_rejected', 'page_rejected' => 'fa-times-circle text-red-500 bg-red-50',
                    'post_pending', 'page_pending' => 'fa-clock text-amber-500 bg-amber-50',
                    default => 'fa-bell text-blue-500 bg-blue-50'
                };
            @endphp
            <div class="p-5 flex items-start gap-4 hover:bg-gray-50/75 transition-colors {{ $isUnread ? 'bg-indigo-50/20' : '' }}">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-lg {{ $iconClass }}">
                    <i class="fas {{ explode(' ', $iconClass)[0] }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            {{ $notif->data['title'] ?? 'Pemberitahuan' }}
                            @if($isUnread)
                                <span class="w-2 h-2 bg-indigo-600 rounded-full inline-block"></span>
                            @endif
                        </h4>
                        <span class="text-[11px] text-gray-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ $notif->data['message'] ?? '' }}</p>
                    
                    @if(!empty($notif->data['rejection_note']))
                        <div class="mt-2.5 p-3 bg-red-50 border-l-4 border-red-400 text-red-800 text-xs rounded-r-lg">
                            <span class="font-bold">Catatan Penolakan:</span> {{ $notif->data['rejection_note'] }}
                        </div>
                    @endif

                    <div class="mt-3 flex items-center gap-3">
                        @if(!empty($notif->data['action_url']))
                            <a href="{{ $notif->data['action_url'] }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                Lihat Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        @endif

                        @if($isUnread)
                            <form action="{{ route('admin.notifications.mark-as-read', $notif->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1">
                                    <i class="fas fa-check"></i> Tandai dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-gray-400">
                <i class="fas fa-bell-slash text-4xl text-gray-300 mb-3"></i>
                <p class="text-sm font-medium text-gray-600">Tidak ada notifikasi saat ini.</p>
                <p class="text-xs text-gray-400 mt-1">Anda akan menerima update di sini saat ada aktivitas terkait akun Anda.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection
