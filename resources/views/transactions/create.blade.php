<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Baru</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.transactions.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="customer_id" value="Pelanggan terdaftar (opsional)" />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">— Pelanggan walk-in —</option>
                            @foreach ($clients as $c)
                                <option value="{{ $c->id }}" @selected(old('customer_id') == $c->id)>{{ $c->name }} ({{ $c->email }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="customer_name" value="Nama pelanggan (jika walk-in)" />
                            <x-text-input id="customer_name" name="customer_name" class="mt-1 block w-full" :value="old('customer_name')" />
                            <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="customer_phone" value="No. HP" />
                            <x-text-input id="customer_phone" name="customer_phone" class="mt-1 block w-full" :value="old('customer_phone')" />
                            <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="service_id" value="Layanan" />
                            <select id="service_id" name="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">— Pilih layanan —</option>
                                @foreach ($services as $s)
                                    <option value="{{ $s->id }}" @selected(old('service_id') == $s->id)>
                                        {{ $s->name }} — Rp {{ number_format($s->price, 0, ',', '.') }}/{{ $s->unit }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="weight" value="Berat / Jumlah" />
                            <x-text-input id="weight" name="weight" type="number" step="0.1" min="0.1" class="mt-1 block w-full" :value="old('weight')" required />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.transactions.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>