<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Buat akun baru</h1>
        <p class="mt-1 text-sm text-slate-500">Daftar gratis dan mulai pesan laundry dalam hitungan menit.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nama lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Nama Anda"
                   class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                   placeholder="nama@email.com"
                   class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
            <x-password-input id="password" name="password" autocomplete="new-password" required placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Konfirmasi password</label>
            <x-password-input id="password_confirmation" name="password_confirmation" autocomplete="new-password" required placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button class="w-full rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-sky-600 hover:underline">Masuk</a>
    </p>
</x-guest-layout>