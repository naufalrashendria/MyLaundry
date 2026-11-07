<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MyLaundry') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
@php
    $user = auth()->user();
    $home = 'M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25';
    $doc  = 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z';
    $tag  = 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z';
    $bag  = 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z';

    $menu = $user->isClient()
        ? [
            ['Dashboard', 'dashboard', 'dashboard', $home],
            ['Pesanan Saya', 'client.orders.index', 'client.orders.*', $bag],
        ]
        : [
            ['Dashboard', 'dashboard', 'dashboard', $home],
            ['Transaksi', 'admin.transactions.index', 'admin.transactions.*', $doc],
            ['Layanan', 'admin.services.index', 'admin.services.*', $tag],
        ];
@endphp

<div x-data="{ open: false }" class="min-h-screen lg:flex">
    <div x-show="open" x-cloak x-transition.opacity @click="open = false"
         class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"></div>

    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col bg-slate-900 text-slate-300 transition-transform lg:sticky lg:top-0 lg:h-screen lg:translate-x-0">
        <div class="flex h-16 items-center gap-2 px-6 border-b border-slate-800">
            <span class="flex size-9 items-center justify-center rounded-xl bg-sky-500 text-lg">🧺</span>
            <span class="text-lg font-bold text-white">MyLaundry</span>
        </div>

        <nav class="flex-1 space-y-1 px-3 py-4">
            @foreach ($menu as [$label, $route, $pattern, $icon])
                @php $active = request()->routeIs($pattern); @endphp
                <a href="{{ route($route) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $active ? 'bg-sky-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="border-t border-slate-800 p-4">
            <div class="flex items-center gap-3">
                <span class="flex size-9 items-center justify-center rounded-full bg-sky-600 text-sm font-bold text-white">
                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $user->role->label() }}</p>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <a href="{{ route('profile.edit') }}" class="flex-1 rounded-lg bg-slate-800 px-3 py-2 text-center text-xs font-medium text-slate-200 hover:bg-slate-700">Profil</a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button class="w-full rounded-lg bg-slate-800 px-3 py-2 text-xs font-medium text-slate-200 hover:bg-rose-600 hover:text-white">Keluar</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="min-w-0 flex-1">
        <div class="sticky top-0 z-20 flex h-14 items-center gap-3 border-b border-slate-200 bg-white px-4 lg:hidden">
            <button @click="open = true" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100" aria-label="Menu">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <span class="font-bold text-slate-900">MyLaundry</span>
        </div>

        @isset($header)
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto max-w-6xl px-4 py-5 sm:px-8">{{ $header }}</div>
            </header>
        @endisset

        <main class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-8">
            <x-flash />
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>