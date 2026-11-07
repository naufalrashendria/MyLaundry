<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-sm text-slate-500">Ringkasan operasional MyLaundry · {{ now()->translatedFormat('l, d F Y') }}</p>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat label="Menunggu konfirmasi" :value="$stats['pending']" color="amber" />
        <x-stat label="Sedang diproses" :value="$stats['in_progress']" color="sky" />
        <x-stat label="Siap diambil" :value="$stats['ready']" color="emerald" />
        <x-stat label="Pendapatan bulan ini" :value="'Rp '.number_format($stats['revenue'], 0, ',', '.')" color="violet" />
    </div>

    <x-card>
        <div class="flex items-center justify-between px-5 py-4">
            <h2 class="font-semibold text-slate-900">Transaksi terbaru</h2>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm font-medium text-sky-600 hover:underline">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Kode</th>
                        <th class="px-5 py-3 text-left">Pelanggan</th>
                        <th class="px-5 py-3 text-left">Layanan</th>
                        <th class="px-5 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($latest as $t)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $t->code }}</td>
                            <td class="px-5 py-3.5 font-medium text-slate-900">{{ $t->customer_name }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $t->service->name }}</td>
                            <td class="px-5 py-3.5"><x-status-badge :status="$t->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-10 text-center text-slate-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-app-layout>