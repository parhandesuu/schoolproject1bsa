@php 
    $logo1 = \App\Models\Setting::get('school_logo'); 
    $logo2 = \App\Models\Setting::get('school_logo_2'); 
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center space-x-2 shrink-0']) }}>
    @if($logo1)
        <img src="{{ asset('storage/'.$logo1) }}" alt="Logo 1" class="h-full w-auto max-h-16 object-contain">
    @else
        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center font-bold text-white text-sm">S1</div>
    @endif

    @if($logo2)
        <img src="{{ asset('storage/'.$logo2) }}" alt="Logo 2" class="h-full w-auto max-h-16 object-contain">
    @endif
</div>
