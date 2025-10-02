<nav x-data="{ open: false, createOpen: false, isPrivate: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- NEW: Комнаты --}}
                    <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')">
                        {{ __('Комнаты') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- NEW: Кнопка создания комнаты --}}
{{--                <button--}}
{{--                    type="button"--}}
{{--                    @click="createOpen = true"--}}
{{--                    class="me-4 inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none transition"--}}
{{--                >--}}
{{--                    + {{ __('Создать комнату') }}--}}
{{--                </button>--}}

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- NEW: Комнаты (mobile) --}}
            <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index')">
                {{ __('Комнаты') }}
            </x-responsive-nav-link>

            {{-- NEW: Создать комнату (mobile) --}}
            <button
                type="button"
                @click="createOpen = true; open = false"
                class="w-full text-left px-4 py-2 text-sm text-indigo-700"
            >+ {{ __('Создать комнату') }}</button>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== NEW: Модалка создания комнаты ===== --}}
    <div
        x-cloak
        x-show="createOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center"
        aria-modal="true" role="dialog"
    >
        <!-- backdrop -->
        <div class="absolute inset-0 bg-black/40" @click="createOpen = false"></div>

        <!-- dialog -->
        <div
            x-trap.noscroll.inert="createOpen"
            class="relative z-10 w-full max-w-lg rounded-xl bg-white shadow-lg p-6"
        >
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Создать комнату</h2>
                <button class="text-gray-400 hover:text-gray-600" @click="createOpen = false">&times;</button>
            </div>

            <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Название</label>
                    <input name="name" required class="mt-1 w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Описание</label>
                    <textarea name="description" rows="3" class="mt-1 w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="nav_is_private" name="is_private" value="1" x-model="isPrivate">
                    <label for="nav_is_private">Приватная комната (вход по паролю)</label>
                </div>

                <div x-show="isPrivate" x-transition>
                    <div class="mt-2">
                        <label class="block text-sm font-medium">Пароль</label>
                        <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Обложка</label>
                    <input type="file" name="image" accept="image/*" class="mt-1">
                    <p class="text-xs text-gray-500 mt-1">JPG/PNG до 2 МБ</p>
                </div>

                {{-- owner_id перезапишется на сервере текущим пользователем; поле не обязательно --}}
                {{-- <input type="hidden" name="owner_id" value="{{ auth()->id() }}"> --}}

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="createOpen = false" class="px-4 py-2 rounded border text-gray-700">
                        Отмена
                    </button>
                    <button class="px-4 py-2 rounded bg-indigo-600 text-white">
                        Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>
