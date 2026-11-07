@props(['status'])
@php
    $style = match ($status->value) {
        'pending'   => ['bg-amber-50 text-amber-700 ring-amber-600/20', 'bg-amber-500'],
        'received'  => ['bg-sky-50 text-sky-700 ring-sky-600/20', 'bg-sky-500'],
        'washing'   => ['bg-indigo-50 text-indigo-700 ring-indigo-600/20', 'bg-indigo-500'],
        'ironing'   => ['bg-violet-50 text-violet-700 ring-violet-600/20', 'bg-violet-500'],
        'ready'     => ['bg-emerald-50 text-emerald-700 ring-emerald-600/20', 'bg-emerald-500'],
        'done'      => ['bg-slate-100 text-slate-600 ring-slate-500/20', 'bg-slate-400'],
        'cancelled' => ['bg-rose-50 text-rose-700 ring-rose-600/20', 'bg-rose-500'],
    };
@endphp
<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $style[0] }}">
    <span class="size-1.5 rounded-full {{ $style[1] }}"></span>{{ $status->label() }}
</span>