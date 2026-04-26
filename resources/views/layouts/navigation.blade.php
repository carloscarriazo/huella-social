<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Brand -->
                <a href="{{ route('casos.index') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-teal-600 group-hover:bg-teal-700 rounded-xl flex items-center justify-center transition shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <span class="block font-bold text-gray-800 text-sm">Trabajo Social</span>
                        <span class="block text-[10px] text-gray-400 font-medium tracking-wide uppercase">Gestión de Casos</span>
                    </div>
                </a>

                <!-- Nav links -->
                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('casos.index') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('casos.*') || request()->routeIs('graficos.*')
                                 ? 'bg-teal-50 text-teal-700 font-semibold'
                                 : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Casos
                    </a>
                </div>
            </div>

            <!-- User dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="w-9 h-9 rounded-full bg-teal-100 hover:bg-teal-200 flex items-center justify-center text-teal-700 font-bold text-sm transition">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('casos.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Casos</a>
        </div>
        <div class="pt-3 pb-2 border-t border-gray-100 px-4">
            <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500 mb-2">{{ Auth::user()->email }}</div>
            <a href="{{ route('profile.edit') }}" class="block py-1.5 text-sm text-gray-600 hover:text-gray-900">Perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="py-1.5 text-sm text-gray-600 hover:text-gray-900">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>
