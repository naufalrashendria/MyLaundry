<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Proses Transaksi {{ $transaction->code }}</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-sm grid grid-cols-2 gap-2">
                <div class="text-gray-500">Pelanggan</div><div>{{ $transaction->customer_name }} {{ $transaction->customer_phone ? '('.$transaction->customer_phone.')' : '' }}</div>
                <div class="text-gray-500">Layanan</div><div>{{ $transaction->service->name }} @ Rp {{ number_format($transaction->price, 0, ',', '.') }}/{{ $transaction->service->unit }}</div>
                <div class="text-gray-500">Sumber</div><div>{{ $transaction->source === 'online' ? 'Pesanan online' : 'Walk-in' }}</div>
                <div class="text-gray-500">Estimasi selesai</div><div>{{ $transaction->due_at?->translatedFormat('d M Y') }}</div>
                <div class="text-gray-500">Total saat ini</div><div class="font-semibold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.transactions.update', $transaction) }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @foreach ($statuses as $s)
                                    <option value="{{ $s->value }}" @selected(old('status', $transaction->status->value) === $s->value)>{{ $s->label() }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="payment_status" value="Pembayaran" />
                            <select id="payment_status" name="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="unpaid" @selected(old('payment_status', $transaction->payment_status) === 'unpaid')>Belum bayar</option>
                                <option value="paid" @selected(old('payment_status', $transaction->payment_status) === 'paid')>Lunas</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_status')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="weight" value="Berat / Jumlah hasil timbang" />
                        <x-text-input id="weight" name="weight" type="number" step="0.1" min="0" class="mt-1 block w-full" :value="old('weight', $transaction->weight)" required />
                        <p class="mt-1 text-xs text-gray-500">Total akan dihitung ulang otomatis.</p>
                        <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $transaction->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                        <a href="{{ route('admin.transactions.index') }}" class="text-sm text-gray-600 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>