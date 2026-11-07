<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Transaksi</h1>
                <p class="text-sm text-slate-500">Kelola semua pesanan laundry.</p>
            </div>
            <x-btn :href="route('admin.transactions.create')">+ Transaksi Baru</x-btn>
        </div>
    </x-slot>

    <form method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode / nama pelanggan..."
               class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:w-72">
        <select name="status" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
            <option value="">Semua status</option>
            @foreach ($statuses as $s)
                <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
            @endforeach
        </select>
        <x-btn variant="ghost">Filter</x-btn>
    </form>

    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Kode</th>
                        <th class="px-5 py-3 text-left">Pelanggan</th>
                        <th class="px-5 py-3 text-left">Layanan</th>
                        <th class="px-5 py-3 text-right">Berat</th>
                        <th class="px-5 py-3 text-right">Total</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Bayar</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $t)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="font-mono text-xs text-slate-600">{{ $t->code }}</span>
                                @if ($t->source === 'online')
                                    <span class="ml-1 rounded bg-sky-100 px-1.5 py-0.5 text-[10px] font-bold uppercase text-sky-700">Online</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-900">{{ $t->customer_name }}</p>
                                @if ($t->customer_phone)<p class="text-xs text-slate-500">{{ $t->customer_phone }}</p>@endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $t->service->name }}</td>
                            <td class="px-5 py-4 text-right text-slate-600 whitespace-nowrap">{{ rtrim(rtrim($t->weight, '0'), '.') }} {{ $t->service->unit }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-slate-900 whitespace-nowrap">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$t->status" /></td>
                            <td class="px-5 py-4">
                                @if ($t->payment_status === 'paid')
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Lunas</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Belum</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.transactions.edit', $t) }}" class="rounded-lg bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 hover:bg-sky-100">Proses</a>
                                    @if (auth()->user()->isAdmin())
                                        <form action="{{ route('admin.transactions.destroy', $t) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-xs font-semibold text-rose-600 hover:underline">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-12 text-center text-slate-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{ $transactions->links() }}
</x-app-layout>