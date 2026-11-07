@props(['label', 'value', 'color' => 'sky'])
@php
    $bar = ['amber' => 'bg-amber-500', 'sky' => 'bg-sky-500', 'emerald' => 'bg-emerald-500', 'violet' => 'bg-violet-500'][$color] ?? 'bg-sky-500';
@endphp
<div class="relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
    <span class="absolute inset-y-0 left-0 w-1 {{ $bar }}"></span>
    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $value }}</p>
</div>