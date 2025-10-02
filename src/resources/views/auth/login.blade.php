{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div @class([
        'w-full max-w-md mx-auto rounded-2xl p-8 shadow-xl/50 backdrop-blur-xl',
        'bg-white/5 ring-1 ring-white/10',
        $errors->any() ? 'animate-[shake_.36s_ease-in-out]' : '',
    ])>
        {{-- Заголовок --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 h-12 w-12 rounded-2xl bg-indigo-500/20 ring-1 ring-indigo-400/30 grid place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v18m9-9H3" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold tracking-tight text-white">Вход в аккаунт</h1>
            <p class="mt-1 text-sm text-slate-300/80">Рады видеть вас снова 👋</p>
        </div>

        {{-- Статус (например, после сброса пароля) --}}
        <x-auth-session-status class="mb-4 text-emerald-400" :status="session('status')" />

        {{-- Форма --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6 js-preload-on-submit">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-200">Email</label>
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                              class="mt-1 block w-full rounded-xl border-0 bg-white/5 px-4 py-3 text-slate-100 shadow-inner ring-1 ring-inset ring-white/10 placeholder-slate-400/60 focus:ring-2 focus:ring-indigo-400/70 transition"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            {{-- Пароль --}}
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium text-slate-200">Пароль</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-indigo-300 hover:text-indigo-200 transition">
                            Забыли пароль?
                        </a>
                    @endif
                </div>
                <div class="relative mt-1">
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                                  class="peer block w-full rounded-xl border-0 bg-white/5 px-4 py-3 pr-12 text-slate-100 shadow-inner ring-1 ring-inset ring-white/10 placeholder-slate-400/60 focus:ring-2 focus:ring-indigo-400/70 transition"/>
                    <button type="button"
                            onclick="(function(){const i=document.getElementById('password'); i.type = i.type==='password'?'text':'password';})();"
                            class="absolute inset-y-0 right-0 my-1 mr-1 grid h-9 w-9 place-items-center rounded-lg text-slate-300/70 hover:text-slate-100 hover:bg-white/5 transition"
                            aria-label="Показать пароль">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                            <circle cx="12" cy="12" r="3.75" stroke-width="1.5" stroke="currentColor" fill="none"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            {{-- Запомнить меня --}}
            <label class="inline-flex items-center gap-2 select-none">
                <input id="remember_me" type="checkbox" name="remember"
                       class="h-4 w-4 rounded border-white/20 bg-white/5 text-indigo-400 focus:ring-indigo-400/70">
                <span class="text-sm text-slate-300">Запомнить меня</span>
            </label>

            {{-- Кнопка входа --}}
            <div class="pt-2">
                <button class="group relative w-full overflow-hidden rounded-xl bg-indigo-500 px-4 py-3 text-center font-medium text-white transition hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/60">
                    <span class="relative z-10">Войти</span>
                    <span class="pointer-events-none absolute inset-0 -translate-y-full bg-gradient-to-b from-white/20 to-transparent opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100"></span>
                </button>
            </div>
        </form>

        {{-- Низ карточки --}}
        <div class="mt-6 text-center text-sm text-slate-400/80">
            Нет аккаунта? <a href="{{ route('register') }}" class="text-indigo-300 hover:text-indigo-200 transition">Зарегистрируйтесь</a>
        </div>
    </div>

    <style>
        @keyframes shake {
            10%, 90% { transform: translateX(-1px) }
            20%, 80% { transform: translateX(2px) }
            30%, 50%, 70% { transform: translateX(-4px) }
            40%, 60% { transform: translateX(4px) }
        }
        .shadow-xl\/50 { box-shadow: 0 25px 50px -12px rgba(0,0,0,.5); }
    </style>
</x-guest-layout>
