<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">🏠 Головна</x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">📖 Про нас</x-nav-link>
                    <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.index')">📰 Новини</x-nav-link>
                    <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')">🧴 Послуги</x-nav-link>
                    <x-nav-link :href="route('masters.index')" :active="request()->routeIs('masters.index')">👩‍🎤 Майстри</x-nav-link>
                    @auth
                        <x-nav-link :href="route('appointments.my')" :active="request()->routeIs('appointments.my')">📅 Мої записи</x-nav-link>
                    @endauth
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">📞 Контакти</x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">👤 Профіль</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">🚪 Вийти</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600">Увійти</a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-indigo-600">Реєстрація</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 🔧 Адмін-панель -->
    @auth
        @if (auth()->user()->role === 'admin')
            <div class="bg-pink-50 border-t border-pink-200 px-6 py-3 text-sm text-pink-800 shadow-inner">
                <strong>🔧 Адмін-панель:</strong>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li><a href="{{ route('admin.about.edit', 'note') }}" class="underline hover:text-pink-600">✏️ Примітка "Про нас"</a></li>
                    <li><a href="{{ route('admin.about.edit', 'info') }}" class="underline hover:text-pink-600">✏️ Інфо "Про нас"</a></li>
                    <li><a href="{{ route('admin.news.create') }}" class="underline hover:text-pink-600">➕ Створити новину</a></li>
                    <li><a href="{{ route('admin.news.index') }}" class="underline hover:text-pink-600">📝 Всі новини</a></li>
                    <li><a href="{{ route('admin.services.create') }}" class="underline hover:text-pink-600">➕ Нова послуга</a></li>
                    <li><a href="{{ route('admin.services.index') }}" class="underline hover:text-pink-600">🧼 Всі послуги</a></li> <!-- ✅ ДОДАНО -->
                    <li><a href="{{ route('admin.masters.create') }}" class="underline hover:text-pink-600">➕ Новий майстер</a></li>
                    <li><a href="{{ route('admin.masters.index') }}" class="underline hover:text-pink-600">🧑‍🔧 Всі майстри</a></li>
                    <li><a href="{{ route('appointments.create') }}" class="underline hover:text-pink-600">➕ Створити запис</a></li>
                    <li><a href="{{ route('appointments.index') }}" class="underline hover:text-pink-600">📋 Всі записи</a></li>
                </ul>
            </div>
        @endif
    @endauth
</nav>
