@extends('layouts.admin')
@section('page-title','Pesan Masuk')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold text-gray-900">Pesan Masuk</h2>
</div>
{{-- Filter --}}
<div class="flex gap-2 mb-5">
    @foreach([['','Semua'],['unread','Belum Dibaca'],['read','Sudah Dibaca']] as [$v,$l])
    <a href="{{ route('admin.contacts.index', $v ? ['status'=>$v] : []) }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === $v || (!request('status') && !$v) ? 'bg-blue-700 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">{{ $l }}</a>
    @endforeach
</div>
<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 bg-gray-50/50">
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Pengirim</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Subjek</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Status</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Tanggal</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50/50 transition-colors {{ !$contact->is_read ? 'bg-blue-50/30' : '' }}">
                    <td class="px-5 py-3.5">
                        <div class="font-semibold text-gray-900 flex items-center gap-2">
                            @if(!$contact->is_read)<span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>@endif
                            {{ $contact->name }}
                        </div>
                        <div class="text-xs text-gray-400">{{ $contact->email }}</div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-700">{{ $contact->subject }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $contact->is_read ? 'bg-gray-100 text-gray-500' : 'bg-blue-100 text-blue-700' }}">
                            {{ $contact->is_read ? 'Dibaca' : 'Baru' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $contact->created_at->format('d M Y H:i') }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="icon-btn-blue" title="Baca"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn-red"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-gray-400"><i class="fas fa-envelope-open text-4xl mb-3 block"></i>Tidak ada pesan masuk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($contacts->hasPages())<div class="px-5 py-4 border-t border-gray-100">{{ $contacts->withQueryString()->links() }}</div>@endif
</div>
@endsection
