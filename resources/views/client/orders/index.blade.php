<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Pesanan Saya</h1>
                <p class="text-sm text-slate-500">Riwayat dan status cucian Anda.</p>
            </div>
            <x-btn :href="route('client.orders.create')">+ Pesan Laundry</x-btn>
        </div>
    </x-slot>

    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Kode</th>
                        <th class="px-5 py-3 text-left">Layanan</th>
                        <th class="px-5 py-3 text-right">Berat</th>
                        <th class="px-5 py-3 text-right">Total</th>
                        <th class="px-5 py-3 text-left">Estimasi selesai</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Bayar</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $o)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $o->code }}</td>
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $o->service->name }}</td>
                            <td class="px-5 py-4 text-right text-slate-600 whitespace-nowrap">{{ rtrim(rtrim($o->weight, '0'), '.') }} {{ $o->service->unit }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-slate-900 whitespace-nowrap">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-slate-600 whitespace-nowrap">{{ $o->due_at?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$o->status" /></td>
                            <td class="px-5 py-4">
                                @if ($o->payment_status === 'paid')
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Lunas</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Belum</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if ($o->status->value === 'pending')
                                    <form action="{{ route('client.orders.cancel', $o) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                                        @csrf @method('PATCH')
                                        <button class="text-xs font-semibold text-rose-600 hover:underline">Batalkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-12 text-center text-slate-400">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{ $orders->links() }}

    <p class="text-xs text-slate-500">Berat dan total pada pesanan baru masih estimasi. Nilai final dihitung setelah cucian ditimbang.</p>
</x-app-layout>