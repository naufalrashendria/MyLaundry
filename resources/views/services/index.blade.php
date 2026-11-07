<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Layanan</h1>
                <p class="text-sm text-slate-500">Daftar layanan dan harga.</p>
            </div>
            <x-btn :href="route('admin.services.create')">+ Tambah Layanan</x-btn>
        </div>
    </x-slot>

    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">Harga</th>
                        <th class="px-5 py-3 text-left">Estimasi</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($services as $service)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $service->name }}</td>
                            <td class="px-5 py-4 text-slate-600">Rp {{ number_format($service->price, 0, ',', '.') }} <span class="text-slate-400">/ {{ $service->unit }}</span></td>
                            <td class="px-5 py-4 text-slate-600">{{ $service->estimated_days }} hari</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $service->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="rounded-lg bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 hover:bg-sky-100">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs font-semibold text-rose-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-400">Belum ada layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{ $services->links() }}
</x-app-layout>