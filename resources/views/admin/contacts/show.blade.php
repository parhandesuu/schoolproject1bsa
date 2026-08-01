@extends('layouts.admin')
@section('page-title','Detail Pesan')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a>
        <h2 class="text-xl font-bold text-gray-900">Detail Pesan</h2>
    </div>
    <div class="admin-card">
        <div class="grid grid-cols-2 gap-4 mb-5 pb-5 border-b border-gray-100">
            @foreach([['Pengirim',$contact->name],['Email',$contact->email],['Telepon',$contact->phone ?: '-'],['Subjek',$contact->subject],['Tanggal',$contact->created_at->format('d F Y, H:i')],['Status',$contact->is_read ? 'Sudah dibaca' : 'Belum dibaca']] as [$l,$v])
            <div>
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $l }}</div>
                <div class="text-sm text-gray-800">{{ $v }}</div>
            </div>
            @endforeach
        </div>
        <div>
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pesan</div>
            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</div>
        </div>
        <div class="mt-5 flex gap-3">
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn-primary"><i class="fas fa-reply"></i> Balas via Email</a>
            <a href="{{ route('admin.contacts.index') }}" class="btn-outline">Kembali</a>
        </div>
    </div>
</div>
@endsection
