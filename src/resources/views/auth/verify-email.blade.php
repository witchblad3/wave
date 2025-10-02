<x-guest-layout>
    <div class="rounded-2xl p-8 shadow-xl/50 backdrop-blur-xl bg-white/5 ring-1 ring-white/10">
        <div class="mb-4 text-sm text-slate-300/85">
            Спасибо за регистрацию! Пожалуйста, подтвердите email по ссылке из письма. Не пришло? Отправим ещё раз.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-emerald-400">
                Новая ссылка подтверждения отправлена на ваш email.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}" class="js-preload-on-submit">
                @csrf
                <button class="group relative overflow-hidden rounded-xl bg-indigo-500 px-4 py-3 font-medium text-white transition hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/60">
                    <span class="relative z-10">Отправить письмо ещё раз</span>
                    <span class="pointer-events-none absolute inset-0 -translate-y-full bg-gradient-to-b from-white/20 to-transparent opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100"></span>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="js-preload-on-submit">
                @csrf
                <button type="submit" class="underline text-sm text-indigo-300 hover:text-indigo-200">
                    Выйти
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
