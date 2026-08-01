@extends('layouts.admin')
@section('page-title', isset($agenda) ? 'Edit Agenda' : 'Tambah Agenda')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.agendas.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($agenda) ? 'Edit' : 'Tambah' }} Agenda</h2></div>
    <form action="{{ isset($agenda) ? route('admin.agendas.update', $agenda) : route('admin.agendas.store') }}" method="POST" class="admin-card space-y-5">
        @csrf @if(isset($agenda)) @method('PUT') @endif
        <div><label class="form-label">Judul <span class="text-red-500">*</span></label><input type="text" name="title" value="{{ old('title', $agenda->title ?? '') }}" class="input-field" required>@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Deskripsi</label><textarea name="description" rows="4" class="input-field">{{ old('description', $agenda->description ?? '') }}</textarea></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="form-label">Tanggal Mulai <span class="text-red-500">*</span></label><input type="datetime-local" name="start_date" value="{{ old('start_date', isset($agenda) ? $agenda->start_date->format('Y-m-d\TH:i') : '') }}" class="input-field" required></div>
            <div><label class="form-label">Tanggal Selesai</label><input type="datetime-local" name="end_date" value="{{ old('end_date', isset($agenda) && $agenda->end_date ? $agenda->end_date->format('Y-m-d\TH:i') : '') }}" class="input-field"></div>
            <div><label class="form-label">Lokasi</label><input type="text" name="location" value="{{ old('location', $agenda->location ?? '') }}" class="input-field"></div>
            <div><label class="form-label">Warna</label><input type="color" name="color" value="{{ old('color', $agenda->color ?? '#3b82f6') }}" class="h-10 w-20 rounded-lg border border-gray-300 p-1"></div>
        </div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $agenda->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Tampilkan Agenda</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.agendas.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
