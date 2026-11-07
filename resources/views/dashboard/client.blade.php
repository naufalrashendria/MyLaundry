<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-slate-900">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-slate-500">Pantau cucian Anda di sini.</p>
    </x-slot>

    <div class="flex flex-col gap-4 rounded-2xl bg-gradient-to-r from-sky-600 to-indigo-600 p-6 text-white shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-sky-100">Pesanan yang sedang berjalan</p>
            <p class="mt-1 text-4xl font-bold">{{ $active }}</p>
        </div>
        <x-btn :href="route('client.orders.create')" variant="ghost" class="!text-sky-700">+ Pesan Laundry</x-btn>
    </div>

    <x-card>
        <div class="flex items-center justify-between px-5 py-4">
            <h2 class="font-semibold text-slate-900">Pesanan terbaru</h2>
            <a href="{{ route('client.orders.index') }}" class="text-sm font-medium text-sky-600 hover:underline">Lihat semua →</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse ($orders as $o)
                <li class="flex items-center justify-between gap-4 px-5 py-4">
                    <div>
                        <p class="font-medium text-slate-900">{{ $o->service->name }}</p>
                        <p class="font-mono text-xs text-slate-500">{{ $o->code }}</p>
                    </div>
                    <x-status-badge :status="$o->status" />
                </li>
            @empty
                <li class="px-5 py-10 text-center text-slate-400">Belum ada pesanan. Yuk pesan laundry pertama Anda!</li>
            @endforelse
        </ul>
    </x-card>
</x-app-layout>