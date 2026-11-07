<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesan Laundry</h2></x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('client.orders.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="service_id" value="Layanan" />
                        <select id="service_id" name="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">— Pilih layanan —</option>
                            @foreach ($services as $s)
                                <option value="{{ $s->id }}" @selected(old('service_id') == $s->id)>
                                    {{ $s->name }} — Rp {{ number_format($s->price, 0, ',', '.') }}/{{ $s->unit }} (±{{ $s->estimated_days }} hari)
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="weight" value="Perkiraan berat (kg) / jumlah (pcs)" />
                        <x-text-input id="weight" name="weight" type="number" step="0.1" min="0.1" class="mt-1 block w-full" :value="old('weight')" required />
                        <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan / alamat jemput" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Kirim Pesanan</x-primary-button>
                        <a href="{{ route('client.orders.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>