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
                <!-- Search & Filters -->
                <div class="hidden md:block relative" x-data="{ filtersOpen: false }">
                    <form action="{{ route('store.index') }}" method="GET" class="flex items-center">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative">
                            <input type="text" name="search" placeholder="Buscar joya..." value="{{ request('search') }}"
                                class="pl-8 pr-10 py-1.5 bg-gray-100 border-none rounded-full text-sm focus:ring-1 focus:ring-brand-charcoal dark:bg-white/10 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 w-48 transition-all hover:w-64 focus:w-64 z-10">
                            <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            
                            <!-- Toggle Filters Button (inside input) -->
                            <button type="button" @click="filtersOpen = !filtersOpen" class="absolute right-2 top-1.5 text-gray-400 hover:text-brand-charcoal dark:hover:text-white transition-colors" title="Filtros Avanzados">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Panel -->
                        <div x-show="filtersOpen" 
                             style="display: none;"
                             @click.away="filtersOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 top-12 w-72 bg-white dark:bg-brand-gray shadow-2xl border border-gray-100 dark:border-white/5 rounded-xl p-5 z-50">
                            
                            <h3 class="text-xs uppercase tracking-widest font-bold text-brand-charcoal dark:text-gray-300 mb-4 border-b border-gray-100 dark:border-white/5 pb-2">Filtros Avanzados</h3>
                            
                            <!-- Price Range -->
                            <div class="mb-5">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Rango de Precio</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="min_price" placeholder="Min €" value="{{ request('min_price') }}" class="w-full text-xs py-2 px-3 border border-gray-200 dark:border-white/10 rounded bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:outline-none">
                                    <span class="text-gray-400">-</span>
                                    <input type="number" name="max_price" placeholder="Max €" value="{{ request('max_price') }}" class="w-full text-xs py-2 px-3 border border-gray-200 dark:border-white/10 rounded bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:outline-none">
                                </div>
                            </div>

                            <!-- Sort By -->
                            <div class="mb-6">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Ordenar Por</label>
                                <select name="sort" class="w-full text-xs py-2 px-3 border border-gray-200 dark:border-white/10 rounded bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:outline-none cursor-pointer">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-brand-charcoal text-white text-[10px] font-bold tracking-[0.2em] uppercase hover:bg-black transition-colors rounded">
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>

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
