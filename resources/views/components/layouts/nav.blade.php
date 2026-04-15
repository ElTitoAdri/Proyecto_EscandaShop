@props(['categories'])

<nav class="sticky top-0 z-50 sticky-nav border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-2xl font-serif tracking-widest text-brand-charcoal uppercase">EscandaShop</a>
            </div>
            
            <div class="hidden md:flex space-x-8 items-center" x-data="{ open: false }">
                <a href="{{ route('home') }}" class="text-sm font-medium hover:text-brand-charcoal transition dark:text-gray-400 dark:hover:text-white {{ Route::is('home') ? 'font-bold underline' : '' }}">Sobre nosotros</a>
                
                <!-- Dropdown de Categorías -->
                <div class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center text-sm font-medium hover:text-brand-charcoal transition dark:text-gray-400 dark:hover:text-white {{ request('category') || Route::is('store.index') ? 'font-bold underline' : '' }}"
                            @click="window.location.href = '{{ route('store.index') }}'">
                        <span>Colecciones</span>
                        <svg class="ml-1 h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 mt-0 w-48 bg-white dark:bg-brand-gray shadow-2xl border border-gray-100 dark:border-white/5 py-2 z-50">
                        <a href="{{ route('store.index') }}" 
                           class="block px-4 py-3 text-xs uppercase tracking-widest font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-brand-charcoal transition border-b border-gray-100 dark:border-white/5">
                            Ver Todo
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('store.index', ['category' => $category->slug]) }}" 
                               class="block px-4 py-3 text-xs uppercase tracking-widest font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-brand-charcoal transition">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('home') }}" class="text-sm font-medium hover:text-brand-charcoal transition dark:text-gray-400 dark:hover:text-white">Contáctanos</a>
            </div>

            <div class="flex items-center space-x-4 md:space-x-6">
                <!-- Search Bar -->
                <form action="{{ route('home') }}" method="GET" class="hidden md:block relative">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" placeholder="Buscar joya..." value="{{ request('search') }}"
                        class="pl-8 pr-3 py-1.5 bg-gray-100 border-none rounded-full text-sm focus:ring-1 focus:ring-brand-charcoal dark:bg-white/10 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 w-48 transition-all hover:w-64 focus:w-64 z-10">
                    <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-brand-charcoal dark:text-gray-300">Mi Cuenta</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-brand-charcoal dark:text-gray-300">Acceder</a>
                    @endauth
                @endif
                
                <a href="{{ route('cart.index') }}" class="relative p-2 text-brand-charcoal dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span id="cart-count" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-brand-charcoal rounded-full transform translate-x-1/2 -translate-y-1/2">
                        {{ count(session()->get('cart', [])) }}
                    </span>
                </a>

                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" 
                        class="p-2 text-brand-charcoal dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 rounded-full transition-colors duration-300"
                        title="Cambiar modo">
                    <template x-if="!darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </template>
                    <template x-if="darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                        </svg>
                    </template>
                </button>
            </div>
        </div>
    </div>
</nav>
