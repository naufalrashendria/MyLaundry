<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyLaundry - Laundry Online</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <header class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
        <div class="flex items-center gap-2">
            <span class="flex size-10 items-center justify-center rounded-xl bg-sky-500 text-xl">🧺</span>
            <span class="text-xl font-bold text-slate-900">MyLaundry</span>
        </div>
        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Daftar</a>
            @endauth
        </nav>
    </header>

    <main>
        <section class="mx-auto max-w-6xl px-6 py-16 text-center sm:py-24">
            <span class="inline-block rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">Laundry online praktis</span>
            <h1 class="mx-auto mt-5 max-w-3xl text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-6xl">
                Cucian bersih, wangi, dan <span class="text-sky-600">tanpa ribet</span>
            </h1>
            <p class="mx-auto mt-5 max-w-xl text-lg text-slate-600">Pesan dari rumah, pantau status cucian secara langsung, dan ambil saat sudah rapi.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('register') }}" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-sky-700">Mulai Pesan</a>
                <a href="{{ route('login') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-slate-700 ring-1 ring-slate-300 hover:bg-slate-50">Masuk</a>
            </div>
        </section>

        <section class="mx-auto grid max-w-6xl gap-4 px-6 pb-20 sm:grid-cols-3">
            @foreach ([
                ['📱', 'Pesan online', 'Pilih layanan dan kirim pesanan kapan saja.'],
                ['🔎', 'Pantau status', 'Lihat cucian Anda sedang dicuci, disetrika, atau siap diambil.'],
                ['💸', 'Harga jelas', 'Total dihitung otomatis dari berat hasil timbang.'],
            ] as [$icon, $title, $text])
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="text-3xl">{{ $icon }}</div>
                    <h3 class="mt-3 font-semibold text-slate-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ $text }}</p>
                </div>
            @endforeach
        </section>
    </main>

    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500">© {{ date('Y') }} MyLaundry</footer>
</body>
</html>