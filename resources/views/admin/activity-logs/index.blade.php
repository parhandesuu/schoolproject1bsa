@extends('layouts.admin')

@section('page-title', 'Log Aktivitas (Audit Trail)')

@section('breadcrumb')
    <span class="text-gray-400">Admin</span> / <span class="text-gray-600">Log Aktivitas</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-gray-900 to-slate-800 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-history text-blue-400"></i> Audit Trail & Riwayat Aktivitas
            </h2>
            <p class="text-gray-300 text-sm mt-1">Pantau seluruh aktivitas pembuatan, perubahan, penghapusan, dan persetujuan data di sistem.</p>
        </div>
        <div>
            <span class="bg-white/10 px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-database text-green-400"></i>
                Total {{ $logs->total() }} Log Tercatat
            </span>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Pengguna</label>
                <select name="user_id" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tipe Aksi / Event</label>
                <select name="event" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Aksi</option>
                    <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created (Dibuat)</option>
                    <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated (Diperbarui)</option>
                    <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted (Dihapus)</option>
                    <option value="approved" {{ request('event') == 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                    <option value="rejected" {{ request('event') == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-xl text-xs flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-2 px-3 rounded-xl text-xs transition-colors" title="Reset Filter">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Activity Log Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5">Waktu</th>
                        <th class="px-5 py-3.5">Pengguna</th>
                        <th class="px-5 py-3.5">Aksi / Deskripsi</th>
                        <th class="px-5 py-3.5">Target Subjek</th>
                        <th class="px-5 py-3.5 text-center">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors" x-data="{ openDetail: false }">
                        <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                            <div>{{ $log->created_at->translatedFormat('d M Y') }}</div>
                            <div class="font-mono text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="px-5 py-4">
                            @if($log->causer)
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs">
                                    {{ strtoupper(substr($log->causer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 text-xs">{{ $log->causer->name }}</div>
                                    <div class="text-[11px] text-gray-400">{{ ucfirst($log->causer->role ?? 'User') }}</div>
                                </div>
                            </div>
                            @else
                            <span class="text-xs text-gray-400 italic">Sistem Otomatis</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $badgeColor = match($log->event ?? $log->description) {
                                    'created' => 'bg-green-100 text-green-700 border-green-200',
                                    'updated' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'deleted' => 'bg-red-100 text-red-700 border-red-200',
                                    'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    'rejected' => 'bg-rose-100 text-rose-800 border-rose-300',
                                    default => 'bg-gray-100 text-gray-700 border-gray-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $badgeColor }} mr-1.5 uppercase">
                                {{ $log->event ?? 'event' }}
                            </span>
                            <span class="text-xs font-medium text-gray-800">{{ $log->description }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-600">
                            @if($log->subject_type)
                                <span class="font-semibold text-gray-700">{{ class_basename($log->subject_type) }}</span>
                                <span class="font-mono text-gray-400">#{{ $log->subject_id }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($log->properties && $log->properties->count() > 0)
                            <button @click="openDetail = !openDetail" class="px-2.5 py-1 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors inline-flex items-center gap-1 font-medium">
                                <i class="fas fa-code text-gray-500"></i>
                                <span x-text="openDetail ? 'Tutup' : 'Lihat Data'"></span>
                            </button>

                            <!-- Modal / Drawer for JSON properties -->
                            <div x-show="openDetail" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="openDetail = false"></div>
                                <div class="relative min-h-screen flex items-center justify-center p-4">
                                    <div class="relative bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl text-left" @click.outside="openDetail = false">
                                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                                            <h4 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                                <i class="fas fa-info-circle text-blue-600"></i> Detail Log Properties #{{ $log->id }}
                                            </h4>
                                            <button @click="openDetail = false" class="text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="mt-4 bg-gray-900 text-green-400 p-4 rounded-xl font-mono text-xs overflow-x-auto max-h-96">
                                            <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </div>

                                        <div class="mt-4 flex justify-end">
                                            <button type="button" @click="openDetail = false" class="px-4 py-2 text-xs font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            <i class="fas fa-history text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm font-medium text-gray-600">Belum ada riwayat aktivitas yang tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
