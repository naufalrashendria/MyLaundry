@props(['href' => null, 'variant' => 'primary'])
@php
    $color = match ($variant) {
        'ghost'  => 'bg-white text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700',
        default  => 'bg-sky-600 text-white hover:bg-sky-700',
    };
    $class = "inline-flex items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-sm font-semibold shadow-sm transition $color";
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $class]) }}>{{ $slot }}</button>
@endif