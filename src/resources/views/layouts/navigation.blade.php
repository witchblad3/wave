{{-- resources/views/layouts/navigation.blade.php --}}
<nav
    x-data="{ open:false, createOpen:false, isPrivate:false }"
    class="sticky top-0 z-40 border-b border-white/10 bg-black/30 backdrop-blur-md"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            {{-- Лого/бренд --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                    <span class="text-sm font-semibold tracking-wide text-white">
                        {{ config('app.name','App') }}
                    </span>
                </a>

                {{-- Десктопные ссылки --}}
                <div class="hidden sm:ml-8 sm:flex sm:items-center sm:gap-1">
                    <a href="{{ route('home') }}"
                       class="px-3 py-2 text-sm font-medium rounded-lg
                              {{ request()->routeIs('home') ? 'bg-white/10 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Главная
                    </a>

                    <a href="{{ route('rooms.index') }}"
                       class="px-3 py-2 text-sm font-medium rounded-lg
                              {{ request()->routeIs('rooms.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Комнаты
                    </a>

                    {{-- Кнопка создания комнаты --}}
                    <button type="button"
                            @click="createOpen = true"
                            class="ml-2 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v14M5 12h14"/>
                        </svg>
                        Создать
                    </button>
                </div>
            </div>

            {{-- Правый блок: профиль --}}
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm font-medium text-slate-200 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20">
                            <div class="truncate max-w-[160px]">{{ Auth::user()->name }}</div>
                            <svg class="h-4 w-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M5.8 7.2a1 1 0 0 1 1.4 0L10 10l2.8-2.8a1 1 0 1 1 1.4 1.4l-3.5 3.5a1 1 0 0 1-1.4 0L5.8 8.6a1 1 0 0 1 0-1.4z"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Профиль
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                Выйти
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Бургер для мобилы --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-300 hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/20">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Мобильное меню --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-white/10 bg-black/50 backdrop-blur-md">
        <div class="space-y-1 px-4 py-3">
            <a href="{{ route('home') }}"
               class="block rounded-lg px-3 py-2 text-sm font-medium
                      {{ request()->routeIs('home') ? 'bg-white/10 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                Главная
            </a>
            <a href="{{ route('rooms.index') }}"
               class="block rounded-lg px-3 py-2 text-sm font-medium
                      {{ request()->routeIs('rooms.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                Комнаты
            </a>
            <button type="button"
                    @click="createOpen = true; open = false"
                    class="block w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-indigo-300 hover:text-white hover:bg-indigo-500/10">
                + Создать комнату
            </button>
        </div>

        <div class="border-t border-white/10 px-4 py-3">
            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
            <div class="text-xs text-slate-400">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="block rounded-lg px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-white/5">
                    Профиль
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-300 hover:text-white hover:bg-white/5">
                        Выйти
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Модалка создания комнаты (тёмная, стекло) --}}
    <div x-cloak x-show="createOpen" x-transition.opacity
         class="fixed inset-0 z-50 grid place-items-center p-4">
        <div class="absolute inset-0 bg-black/60" @click="createOpen=false"></div>

        <div x-trap.noscroll.inert="createOpen"
             class="relative z-10 w-full max-w-xl rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Создать комнату</h2>
                <button @click="createOpen=false"
                        class="rounded-lg px-2 py-1 text-slate-300 hover:bg-white/10 hover:text-white">&times;</button>
            </div>

            <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-slate-300">Название</label>
                    <input name="name" required
                           class="mt-1 w-full rounded-xl border-0 bg-white/5 px-3 py-2 text-slate-100 ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-400/70"/>
                </div>

                <div>
                    <label class="block text-sm text-slate-300">Описание</label>
                    <textarea name="description" rows="3"
                              class="mt-1 w-full rounded-xl border-0 bg-white/5 px-3 py-2 text-slate-100 ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-400/70"></textarea>
                </div>

                <label class="inline-flex select-none items-center gap-2">
                    <input type="checkbox" id="nav_is_private" name="is_private" value="1" x-model="isPrivate"
                           class="h-4 w-4 rounded border-white/20 bg-white/5 text-indigo-400 focus:ring-indigo-400/70">
                    <span class="text-sm text-slate-300">Приватная комната (вход по паролю)</span>
                </label>

                <div x-show="isPrivate" x-transition>
                    <div class="mt-2">
                        <label class="block text-sm text-slate-300">Пароль</label>
                        <input type="password" name="password"
                               class="mt-1 w-full rounded-xl border-0 bg-white/5 px-3 py-2 text-slate-100 ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-400/70">
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm text-slate-300">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation"
                               class="mt-1 w-full rounded-xl border-0 bg-white/5 px-3 py-2 text-slate-100 ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-indigo-400/70">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-300">Обложка</label>
                    <input type="file" name="image" accept="image/*" class="mt-1 text-slate-200">
                    <p class="mt-1 text-xs text-slate-400">JPG/PNG до 2 МБ</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button"
                            @click="createOpen=false"
                            class="rounded-xl border border-white/10 bg-white/0 px-4 py-2 text-slate-300 hover:bg-white/10">
                        Отмена
                    </button>
                    <button
                        class="rounded-xl bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400/60">
                        Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>
