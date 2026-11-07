@csrf
<div class="space-y-4">
    <div>
        <x-input-label for="name" value="Nama Layanan" />
        <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $service->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="unit" value="Satuan" />
            <select id="unit" name="unit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach (['kg' => 'Kilogram (kg)', 'pcs' => 'Satuan (pcs)'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('unit', $service->unit) === $val)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="price" value="Harga (Rp)" />
            <x-text-input id="price" name="price" type="number" min="0" class="mt-1 block w-full" :value="old('price', $service->price)" required />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="estimated_days" value="Estimasi (hari)" />
            <x-text-input id="estimated_days" name="estimated_days" type="number" min="0" class="mt-1 block w-full" :value="old('estimated_days', $service->estimated_days)" required />
            <x-input-error :messages="$errors->get('estimated_days')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="description" value="Deskripsi" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $service->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <label class="inline-flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $service->is_active))>
        <span class="text-sm text-gray-700">Layanan aktif</span>
    </label>

    <div class="flex items-center gap-3">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('admin.services.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
    </div>
</div>