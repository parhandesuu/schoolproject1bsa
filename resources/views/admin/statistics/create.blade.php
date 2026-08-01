@extends('layouts.admin')
@section('page-title', isset($statistic) ? 'Edit Statistik' : 'Tambah Statistik')
@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6"><a href="{{ route('admin.statistics.index') }}" class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg"><i class="fas fa-arrow-left text-gray-600"></i></a><h2 class="text-xl font-bold text-gray-900">{{ isset($statistic) ? 'Edit' : 'Tambah' }} Statistik</h2></div>
    <form action="{{ isset($statistic) ? route('admin.statistics.update', $statistic) : route('admin.statistics.store') }}" method="POST" class="admin-card space-y-5">
        @csrf @if(isset($statistic)) @method('PUT') @endif
        <div><label class="form-label">Label <span class="text-red-500">*</span></label><input type="text" name="label" value="{{ old('label', $statistic->label ?? '') }}" class="input-field" required placeholder="Contoh: Total Siswa">@error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Nilai <span class="text-red-500">*</span></label><input type="text" name="value" value="{{ old('value', $statistic->value ?? '') }}" class="input-field" required placeholder="Contoh: 500+">@error('value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Icon (Font Awesome)</label><input type="text" name="icon" value="{{ old('icon', $statistic->icon ?? 'fas fa-chart-bar') }}" class="input-field" placeholder="fas fa-users"></div>
            <div><label class="form-label">Warna</label><input type="color" name="color" value="{{ old('color', $statistic->color ?? '#3b82f6') }}" class="h-10 w-20 rounded-lg border border-gray-300 p-1"></div>
        </div>
        <div><label class="form-label">Urutan</label><input type="number" name="order" value="{{ old('order', $statistic->order ?? 0) }}" class="input-field" min="0"></div>
        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $statistic->is_active ?? true) ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan</span></label>
        <div class="flex gap-3 pt-2 border-t border-gray-100"><button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button><a href="{{ route('admin.statistics.index') }}" class="btn-outline">Batal</a></div>
    </form>
</div>
@endsection
