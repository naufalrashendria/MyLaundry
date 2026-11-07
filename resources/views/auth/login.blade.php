<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Selamat datang kembali 👋</h1>
        <p class="mt-1 text-sm text-slate-500">Masuk untuk mengelola atau memantau cucian Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="nama@email.com"
                   class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="mb-1 flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-sky-600 hover:underline">Lupa password?</a>
                @endif
            </div>
            <x-password-input id="password" name="password" autocomplete="current-password" required placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
            <span class="text-sm text-slate-600">Ingat saya</span>
        </label>

        <button class="w-full rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
            Masuk
        </button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-sky-600 hover:underline">Daftar sekarang</a>
        </p>
    @endif
</x-guest-layout>