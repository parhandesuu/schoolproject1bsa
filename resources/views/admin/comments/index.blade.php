@extends('layouts.admin')
@section('page-title','Komentar')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Moderasi Komentar</h2>
</div>

{{-- Filter Tabs --}}
<div class="flex gap-2 mb-5 flex-wrap">
    @php
        $allCount = \App\Models\Comment::count();
        $pendingCount = \App\Models\Comment::where('status','pending')->count();
        $approvedCount = \App\Models\Comment::where('status','approved')->count();
        $rejectedCount = \App\Models\Comment::where('status','rejected')->count();
    @endphp
    @foreach([['','Semua',$allCount],['pending','Pending',$pendingCount],['approved','Disetujui',$approvedCount],['rejected','Ditolak',$rejectedCount]] as [$val,$label,$count])
    <a href="{{ route('admin.comments.index', $val ? ['status'=>$val] : []) }}"
       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === $val || (!request('status') && !$val) ? 'bg-blue-700 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
        {{ $label }}
        <span class="text-xs px-1.5 py-0.5 rounded-full {{ request('status') === $val || (!request('status') && !$val) ? 'bg-white/20' : 'bg-gray-100' }}">{{ $count }}</span>
    </a>
    @endforeach
</div>

<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Berita</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Komentar</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tanggal</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($comments as $comment)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3.5 max-w-xs">
                        <div class="font-medium text-gray-800 text-xs line-clamp-2">{{ $comment->post?->title }}</div>
                    </td>
                    <td class="px-5 py-3.5 max-w-sm">
                        <div class="font-semibold text-gray-900 text-sm">{{ $comment->name }}</div>
                        <div class="text-xs text-gray-400">{{ $comment->email }}</div>
                        <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $comment->content }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $comment->status === 'approved' ? 'bg-green-100 text-green-700' :
                               ($comment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($comment->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $comment->created_at->format('d M Y H:i') }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-center gap-2">
                            @if($comment->status !== 'approved')
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-600 hover:text-white text-xs font-medium rounded-lg transition-colors" title="Setujui"><i class="fas fa-check"></i></button>
                            </form>
                            @endif
                            @if($comment->status !== 'rejected')
                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-600 hover:text-white text-xs font-medium rounded-lg transition-colors" title="Tolak"><i class="fas fa-times"></i></button>
                            </form>
                            @endif
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn-red" onclick="return confirm('Hapus komentar ini?')" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400"><i class="fas fa-comments text-4xl mb-3 block"></i>Tidak ada komentar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($comments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $comments->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
