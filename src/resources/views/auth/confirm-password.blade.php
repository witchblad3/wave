<x-guest-layout>
    <div class="rounded-2xl p-8 shadow-xl/50 backdrop-blur-xl bg-white/5 ring-1 ring-white/10">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-white">Подтвердите пароль</h1>
            <p class="mt-1 text-sm text-slate-300/85">
                Это защищённая зона. Подтвердите пароль, чтобы продолжить.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6 js-preload-on-submit">
            @csrf
            <div>
                <x-input-label for="password" :value="__('Пароль')" class="text-slate-200"/>
                <x-text-input id="password" type="password" name="password" required
                              autocomplete="current-password"
                              class="mt-1 block w-full rounded-xl border-0 bg-white/5 px-4 py-3 text-slate-100 shadow-inner ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-400/70"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400"/>
            </div>

            <div class="flex justify-end">
                <button class="group relative overflow-hidden rounded-xl bg-indigo-500 px-4 py-3 font-medium text-white transition hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/60">
                    <span class="relative z-10">Подтвердить</span>
                    <span class="pointer-events-none absolute inset-0 -translate-y-full bg-gradient-to-b from-white/20 to-transparent opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100"></span>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
