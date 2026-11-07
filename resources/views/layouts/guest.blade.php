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
<body class="font-sans antialiased text-slate-800">
<div class="min-h-screen lg:grid lg:grid-cols-2">

    {{-- Panel brand (hanya tampil di layar besar) --}}
    <div class="relative hidden overflow-hidden bg-gradient-to-br from-sky-600 via-sky-700 to-indigo-800 p-12 text-white lg:flex lg:flex-col lg:justify-between">
        <div class="absolute -right-24 -top-24 size-80 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-32 -left-20 size-96 rounded-full bg-white/10"></div>

        <a href="/" class="relative flex items-center gap-3">
            <span class="flex size-11 items-center justify-center rounded-xl bg-white/20 text-2xl backdrop-blur">🧺</span>
            <span class="text-2xl font-bold">MyLaundry</span>
        </a>

        <div class="relative">
            <h2 class="text-4xl font-bold leading-tight">Cucian bersih,<br>hidup lebih ringan.</h2>
            <p class="mt-4 max-w-md text-sky-100">Pesan laundry online, pantau status cucian secara real-time, dan ambil saat sudah wangi dan rapi.</p>

            <ul class="mt-8 space-y-3 text-sm text-sky-50">
                <li class="flex items-center gap-3"><span class="flex size-6 items-center justify-center rounded-full bg-white/20">✓</span>Pesan dari rumah, tanpa antre</li>
                <li class="flex items-center gap-3"><span class="flex size-6 items-center justify-center rounded-full bg-white/20">✓</span>Status cucian terpantau langsung</li>
                <li class="flex items-center gap-3"><span class="flex size-6 items-center justify-center rounded-full bg-white/20">✓</span>Harga transparan per kilo</li>
            </ul>
        </div>

        <p class="relative text-xs text-sky-200">© {{ date('Y') }} MyLaundry</p>
    </div>

    {{-- Area form --}}
    <div class="flex min-h-screen flex-col justify-center bg-slate-50 px-6 py-10 sm:px-12 lg:min-h-0">
        <div class="mx-auto w-full max-w-md">
            <a href="/" class="mb-8 flex items-center justify-center gap-2 lg:hidden">
                <span class="flex size-10 items-center justify-center rounded-xl bg-sky-500 text-xl">🧺</span>
                <span class="text-xl font-bold text-slate-900">MyLaundry</span>
            </a>

            <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
</body>
</html>